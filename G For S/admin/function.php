<?php 
class Database {
   
    private  $host="localhost";
    private $username = "root";
    private $password ="";
    private $dbname ="demo_xshop";

    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        mysqli_set_charset($this->conn, 'utf8');
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}

class CategoryDao {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Khởi tạo đối tượng kết nối đến cơ sở dữ liệu
    }

    public function getAllCategories() {
        $query = "SELECT category_id, category_name FROM categories";
        $result = $this->db->conn->query($query);
        $categories = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }

        return $categories;
    
    }


    public function getCategoryById($categoryId) {
       // Viết truy vấn SQL để lấy danh mục bằng ID
    $query = "SELECT category_id, category_name FROM categories WHERE category_id = $categoryId";

    // Thực hiện truy vấn và trả về kết quả
    $result = $this->db->conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Lấy dòng dữ liệu duy nhất
        return $row;
    } else {
        return null; // Trả về null nếu không tìm thấy danh mục
    }
    }

    public function addCategory($categoryName) {
        $categoryName = $this->db->conn->real_escape_string($categoryName);
        $query = "INSERT INTO categories (category_name) VALUES ('$categoryName')";

    if ($this->db->conn->query($query)) {
        return true; // Trả về true nếu thêm thành công
    } else {
        return false; // Trả về false nếu có lỗi khi thêm
    }
    return $categories;
    }

    public function updateCategory($categoryId, $categoryName) {
        $categoryId = (int)$categoryId; // Ép kiểu về số nguyên để tránh lỗ hổng SQL injection
        $categoryName = $this->db->conn->real_escape_string($categoryName);
        $query = "UPDATE categories SET category_name = '$categoryName' WHERE category_id = $categoryId";
    
        if ($this->db->conn->query($query)) {
            return true; // Trả về true nếu cập nhật thành công
        } else {
            return false; // Trả về false nếu có lỗi khi cập nhật
        }
    }

    public function deleteCategory($categoryId) {
        $categoryId = (int)$categoryId; // Ép kiểu về số nguyên để tránh lỗ hổng SQL injection
        $query = "DELETE FROM categories WHERE category_id = $categoryId";
    
        if ($this->db->conn->query($query)) {
            return true; // Trả về true nếu xóa thành công
        } else {
            return false; // Trả về false nếu có lỗi khi xóa
        }
    }
    public function deleteCategoryWithProducts($categoryId) {
        // Trước tiên, tìm các sản phẩm thuộc danh mục cần xóa
        $query = "SELECT product_id FROM products WHERE category_id = $categoryId";
        $result = $this->db->conn->query($query);

        if ($result->num_rows > 0) {
            // Lặp qua danh sách sản phẩm và xóa chúng
            while ($row = $result->fetch_assoc()) {
                $productId = $row['product_id'];
                // Thực hiện truy vấn SQL để xóa sản phẩm dựa trên $productId
                $deleteProductQuery = "DELETE FROM products WHERE product_id = $productId";
                $this->db->conn->query($deleteProductQuery);
            }
        }

        // Sau khi xóa sản phẩm liên quan, xóa danh mục
        $deleteCategoryQuery = "DELETE FROM categories WHERE category_id = $categoryId";
        if ($this->db->conn->query($deleteCategoryQuery)) {
            return true; // Trả về true nếu xóa thành công
        } else {
            return false; // Trả về false nếu có lỗi khi xóa
        }
    }

    

    // product 
    public function addProduct($productName, $description, $productDetails, $price, $stockQuantity, $categoryID, $manufacturer, $productImages) {
        // Kiểm tra các giá trị đầu vào
        if (empty($productName) || empty($description) || empty($productDetails) || empty($price) || empty($stockQuantity) || empty($categoryID) || empty($manufacturer) || empty($productImages)) {
            return false; // Trả về false nếu có giá trị rỗng
        }
    
        // Kết nối đến cơ sở dữ liệu
        $db = $this->db->conn;
    
        // Sử dụng prepared statement
        $stmt = $db->prepare("INSERT INTO products (product_name, description, product_details, price, stock_quantity, category_id, manufacturer, addedDate) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    
        // Kiểm tra sự chuẩn bị của prepared statement
        if ($stmt === false) {
            return false;
        }
    
        // Binding các tham số
        $stmt->bind_param("sssdiss", $productName, $description, $productDetails, $price, $stockQuantity, $categoryID, $manufacturer);
    
        // Thực hiện truy vấn
        if ($stmt->execute()) {
            $productID = $db->insert_id;
    
            // Xử lý tải lên nhiều ảnh và lưu vào bảng ProductImages
            if (!empty($productImages['name'][0])) {
                $imagePaths = [];
    
                foreach ($productImages['tmp_name'] as $key => $tmp_name) {
                    $imageName = $db->real_escape_string($productImages['name'][$key]);
                    $targetPath = "uploads/product/" . $imageName;
    
                    if (move_uploaded_file($tmp_name, $targetPath)) {
                        $imagePaths[] = $targetPath;
                    } else {
                        echo "Failed to move file.";
                    }
                }
    
                foreach ($imagePaths as $imagePath) {
                    $imagePath = $db->real_escape_string($imagePath);
                    $imageQuery = "INSERT INTO productimages (product_id, image_path) VALUES ($productID, '$imagePath')";
                    $db->query($imageQuery);
                }
            }
    
            return true; // Trả về true nếu thêm sản phẩm thành công
        } else {
            return false; // Trả về false nếu có lỗi khi thêm sản phẩm
        }
        
    }
    
    public function updateProduct($productId, $productName, $description, $productDetails, $price, $stockQuantity, $categoryID, $manufacturer) {
        $db = new Database();
    
        $productId = (int)$productId;
        $productName = $db->conn->real_escape_string($productName);
        $description = $db->conn->real_escape_string($description);
        $productDetails = $db->conn->real_escape_string($productDetails);
        $price = floatval($price);
        $stockQuantity = intval($stockQuantity);
        $categoryID = intval($categoryID);
        $manufacturer = $db->conn->real_escape_string($manufacturer);
    
        $query = "UPDATE products SET ProductName = '$productName', Description = '$description', product_details = '$productDetails', Price = $price, StockQuantity = $stockQuantity, CategoryID = $categoryID, Manufacturer = '$manufacturer' WHERE ProductID = $productId";
    
        if ($db->conn->query($query)) {
            return true;
        } else {
            return false;
        }
    }
    public function updateProductWithImages($productId, $newProductName, $newDescription, $newPrice, $newStockQuantity, $productImages) {
        // Kiểm tra các giá trị đầu vào
        if (empty($productId) || empty($newProductName) || empty($newDescription) || empty($newPrice) || empty($newStockQuantity)) {
            return false; // Trả về false nếu có giá trị rỗng
        }
    
        // Kết nối đến cơ sở dữ liệu
        $db = $this->db->conn;
    
        // Sử dụng prepared statement để cập nhật thông tin sản phẩm
        $stmt = $db->prepare("UPDATE products SET product_name=?, description=?, price=?, stock_quantity=? WHERE product_id=?");
    
        if ($stmt === false) {
            return false; // Trả về false nếu không thể chuẩn bị prepared statement
        }
    
        // Binding các tham số
        $stmt->bind_param("ssdii", $newProductName, $newDescription, $newPrice, $newStockQuantity, $productId);
    
        // Thực hiện truy vấn
        if ($stmt->execute()) {
            // Xử lý tải lên ảnh mới và cập nhật vào bảng ProductImages
            if (!empty($productImages['name'][0])) {
                $imagePaths = [];
    
                foreach ($productImages['tmp_name'] as $key => $tmp_name) {
                    $imageName = $db->real_escape_string($productImages['name'][$key]);
                    $targetPath = "uploads/product/" . $imageName;
    
                    if (move_uploaded_file($tmp_name, $targetPath)) {
                        $imagePaths[] = $targetPath;
                    } else {
                        echo "Failed to move file.";
                    }
                }
    
                // Xóa toàn bộ ảnh cũ của sản phẩm
                $db->query("DELETE FROM productimages WHERE product_id=$productId");
    
                // Cập nhật ảnh mới vào bảng ProductImages
                foreach ($imagePaths as $imagePath) {
                    $imagePath = $db->real_escape_string($imagePath);
                    $imageQuery = "INSERT INTO productimages (product_id, image_path) VALUES ($productId, '$imagePath')";
                    $db->query($imageQuery);
                }
            }
    
            return true; // Trả về true nếu cập nhật thành công
        } else {
            return false; // Trả về false nếu có lỗi khi cập nhật
        }
    }
    
    public function deleteProduct($productId) {
        $db = new Database();
    
        $productId = (int)$productId;
    
        // Xóa sản phẩm khỏi bảng Products
        $deleteProductQuery = "DELETE FROM products WHERE product_id = $productId";
    
        if ($db->conn->query($deleteProductQuery)) {
            // Xóa tất cả ảnh sản phẩm trong bảng ProductImages (nếu cần)
            $deleteImagesQuery = "DELETE FROM productimages WHERE product_id = $productId";
            $db->conn->query($deleteImagesQuery);
    
            return true;
        } else {
            return false;
        }
    }
    public function getProductById($productId) {
        $productId = (int)$productId; // Ép kiểu về số nguyên để tránh lỗ hổng SQL injection
        $query = "SELECT p.product_id , p.product_name, p.description, p.price, p.stock_quantity, p.manufacturer,p.product_details, c.category_name
                  FROM products p
                  INNER JOIN categories c ON p.category_id = c.category_id
                  WHERE p.product_id = $productId";
    
        $result = $this->db->conn->query($query);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return null;
        }
    }
    public function getAllProducts() {
        // Viết truy vấn SQL để lấy tất cả sản phẩm
        $query = "SELECT * FROM Products";
        
        // Thực hiện truy vấn và trả về kết quả
        $result = $this->db->conn->query($query);
        $products = [];
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
    
        return $products;
    }
    public function getFirstProductImageAndCategoryName() {
        // Viết truy vấn SQL để lấy ảnh đầu tiên của sản phẩm và tên danh mục của sản phẩm
        $query = "SELECT p.*, c.category_name AS category_name, MIN(i.image_path) AS product_image
                  FROM products p
                  LEFT JOIN categories c ON p.category_id = c.category_id
                  LEFT JOIN productimages i ON p.product_id = i.product_id 
                  GROUP BY p.product_id, c.category_name";
        
        // Sử dụng prepared statement để tránh tình trạng SQL injection
        $result = $this->db->conn->query($query);
        $products = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        
        return $products;
    }
    
    public function getProductsByCategoryId($categoryId) {
        // Viết truy vấn SQL để lấy sản phẩm theo category_id
        $query = "SELECT * FROM products WHERE category_id = ?";
        
        // Sử dụng prepared statement để tránh tấn công SQL injection
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        
        // Lấy kết quả
        $result = $stmt->get_result();
        $products = [];
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
    
        return $products;
    }
    
    // lấy 4 sản phẩm theo id
    public function getFirstFourProductsByCategoryId($categoryId) {
        // Viết truy vấn SQL để lấy 4 sản phẩm đầu tiên của danh mục dựa trên category_id và lấy ảnh có image_id nhỏ nhất
        $query = "
            SELECT p.*, i.image_path
            FROM products AS p
            JOIN (
                SELECT product_id, MIN(image_id) AS min_image_id
                FROM productimages
                GROUP BY product_id
            ) AS m ON p.product_id = m.product_id
            JOIN productimages AS i ON m.product_id = i.product_id AND m.min_image_id = i.image_id
            WHERE p.category_id = ?
            LIMIT 4
        ";
        
        // Sử dụng prepared statement để tránh tấn công SQL injection
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        
        // Lấy kết quả
        $result = $stmt->get_result();
        $products = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        
        return $products;
    }
    // lấy all sản phẩm theo id 
    public function getAllProductsByCategoryId($categoryId) {
        // Viết truy vấn SQL để lấy 4 sản phẩm đầu tiên của danh mục dựa trên category_id và lấy ảnh có image_id nhỏ nhất
        $query = "
        SELECT p.*, i.image_path
        FROM products AS p
        JOIN (
            SELECT product_id, MIN(image_id) AS min_image_id
            FROM productimages
            GROUP BY product_id
        ) AS m ON p.product_id = m.product_id
        JOIN productimages AS i ON m.product_id = i.product_id AND m.min_image_id = i.image_id
        WHERE p.category_id = ?
        
        ";
        
        // Sử dụng prepared statement để tránh tấn công SQL injection
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        
        // Lấy kết quả
        $result = $stmt->get_result();
        $products = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        
        return $products;
    }
    public function countTotalCategories() {
        $sql = "SELECT COUNT(*) AS total_categories FROM categories";
        $result = $this->db->conn->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total_categories'];
        } else {
            return 0; // Trả về 0 nếu không có danh mục nào
        }
    }
    
    public function getProductImagesByProductId($productId) {
        // Viết truy vấn SQL để lấy các ảnh của sản phẩm dựa trên product_id
        $query = "SELECT * FROM productimages WHERE product_id = ?";
        
        // Sử dụng prepared statement để tránh tấn công SQL injection
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        
        // Lấy kết quả
        $result = $stmt->get_result();
        $productImages = [];
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productImages[] = $row;
            }
        }
    
        return $productImages;
    }
    public function calculateTotalQuantity() {
        $sql = "SELECT COUNT(*) AS total_quantity FROM products";
        $result = $this->db->conn->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            $totalQuantity = $row['total_quantity'];
            return $totalQuantity;
        } 
    }
    
    
    
    
    
    
        
    
}
function checklogin(){
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] == "admin") {
        return true;
    } else {
        return false;
    }
}
function checklogin2(){
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] == "user") {
        return true;
    } else {
        return false;
    }
}


class UserDao {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Khởi tạo đối tượng kết nối đến cơ sở dữ liệu
    }
    // ... Các phương thức khác

    public function getUserById($userId) {
        // Kiểm tra nếu $userId không phải là số nguyên
        if (!is_numeric($userId)) {
            return null;
        }
    
        // Kết nối đến cơ sở dữ liệu ở đây
        $query = "SELECT * FROM user WHERE user_id = ?";
    
        // Sử dụng prepared statement để tránh SQL injection
        $stmt = $this->db->conn->prepare($query);
    
        // Kiểm tra nếu prepared statement không thành công
        if (!$stmt) {
            return null;
        }
    
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Kiểm tra nếu truy vấn SQL không thành công
        if (!$result) {
            return null;
        }
    
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return $user;
        } else {
            return null; // Trả về null nếu không tìm thấy người dùng
        }
    }
    public function updatePassword($userId, $newPassword) {
        // Kiểm tra nếu $userId không phải là số nguyên
        if (!is_numeric($userId)) {
            return false;
        }

        // Băm mật khẩu mới trước khi cập nhật
       

        // Sử dụng prepared statement để cập nhật mật khẩu
        $query = "UPDATE user SET user_password = ? WHERE user_id = ?";
        $stmt = $this->db->conn->prepare($query);

        // Kiểm tra nếu prepared statement không thành công
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("si", $newPassword, $userId);

        // Thực hiện truy vấn
        if ($stmt->execute()) {
            return true; // Trả về true nếu cập nhật mật khẩu thành công
        } else {
            return false; // Trả về false nếu có lỗi khi cập nhật mật khẩu
        }
    }    
    public function updateUser($userId, $userName, $userUsername, $profileImage) {
        try {
            $query = "UPDATE user SET user_name = ?, user_username = ?";
            $params = [$userName, $userUsername];
    
            // Nếu $profileImage được truyền vào, thêm trường cập nhật ảnh đại diện
            if ($profileImage !== null) {
                $query .= ", profile_image = ?";
                $params[] = $profileImage;
            }
    
            $query .= " WHERE user_id = ?";
            $params[] = $userId;
    
            $stmt = $this->db->conn->prepare($query);
    
            if (!$stmt) {
                throw new Exception("Lỗi khi chuẩn bị truy vấn.");
            }
    
            // Binding các tham số
            $paramTypes = str_repeat('s', count($params)); // Chuỗi kiểu dữ liệu (string)
            $stmt->bind_param($paramTypes, ...$params);
    
            // Thực hiện truy vấn
            $result = $stmt->execute();
    
            if (!$result) {
                throw new Exception("Lỗi khi cập nhật thông tin người dùng.");
            }
    
            return true;
        } catch (Exception $e) {
            echo "Có lỗi xảy ra: " . $e->getMessage();
            return false;
        }
    }
       // Hàm lấy tổng số lượng người dùng
       public function getTotalUsers() {
        $sql = "SELECT COUNT(*) as total_users FROM user WHERE role = 'user'";
        $result = $this->db->conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalUsers = $row["total_users"];
            return $totalUsers;
        } else {
            return 0;
        }
    }
    
    
}
class PostDao {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Khởi tạo đối tượng kết nối đến cơ sở dữ liệu
    }

    // Thêm bài viết
    // Thêm bài viết
public function addPost($userId, $title, $content, $thumbnail, $description) {
    $userId = (int)$userId;
    $title = $this->db->conn->real_escape_string($title);
    $content = $this->db->conn->real_escape_string($content);
    $thumbnail = $this->db->conn->real_escape_string($thumbnail);
    $description = $this->db->conn->real_escape_string($description);

    $query = "INSERT INTO post (user_id, title, content, thumbnail, description, created_at) VALUES ($userId, '$title', '$content', '$thumbnail', '$description', NOW())";

    if ($this->db->conn->query($query)) {
        return true; // Trả về true nếu thêm thành công
    } else {
        return false; // Trả về false nếu có lỗi khi thêm
    }
}


    // Lấy bài viết theo ID
    public function getPostById($postId) {
        $postId = (int)$postId; // Ép kiểu về số nguyên để tránh lỗ hổng SQL injection
        $query = "SELECT * FROM post WHERE post_id = $postId";

        $result = $this->db->conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return null;
        }
    }

    public function getAllPosts() {
        $query = "SELECT * FROM post";
        $result = $this->db->conn->query($query);
        $posts = [];
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }
        }
    
        return $posts;
    }
    
    // Cập nhật bài viết
    public function updatePost($postId, $title, $content) {
        $postId = (int)$postId;
        $title = $this->db->conn->real_escape_string($title);
        $content = $this->db->conn->real_escape_string($content);

        $query = "UPDATE post SET title = '$title', content = '$content' WHERE post_id = $postId";

        if ($this->db->conn->query($query)) {
            return true; // Trả về true nếu cập nhật thành công
        } else {
            return false; // Trả về false nếu có lỗi khi cập nhật
        }
    }

    // Xóa bài viết
    public function deletePost($postId) {
        $postId = (int)$postId;

        $query = "DELETE FROM post WHERE post_id = $postId";

        if ($this->db->conn->query($query)) {
            return true; // Trả về true nếu xóa thành công
        } else {
            return false; // Trả về false nếu có lỗi khi xóa
        }
    }
    public function getFirstFourPosts() {
        $query = "SELECT * FROM post ORDER BY post_id DESC LIMIT 4";
        $result = $this->db->conn->query($query);
        $posts = [];
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }
        }
    
        return $posts;
    }
    
    
}


class CommentDAO {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Khởi tạo đối tượng kết nối đến cơ sở dữ liệu
    }

    // Phương thức để lấy tất cả các bình luận từ bảng product_comment
    public function getAllComments() {
        $comments = array();

        $sql = "SELECT * FROM product_comment";
        $result = $this->db->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $comments[] = $row;
            }
        }

        return $comments;
    }

    public function deleteComment($commentId) {
        $result = array();

        // Thực hiện truy vấn SQL để xóa bình luận
        $sql = "DELETE FROM product_comment WHERE comment_id = ?";
        $stmt = $this->db->conn->prepare($sql); // Sử dụng $this->db->conn
        $stmt->bind_param("i", $commentId);

        if ($stmt->execute()) {
            $result["success"] = true;
            $result["message"] = "Xóa bình luận thành công.";
        } else {
            $result["success"] = false;
            $result["message"] = "Xóa bình luận thất bại: " . $stmt->error;
        }

        $stmt->close();

        return $result;
    }
    public function deleteCommentpost($commentId) {
        $result = array();

        // Thực hiện truy vấn SQL để xóa bình luận
        $sql = "DELETE FROM post_comment WHERE comment_id = ?";
        $stmt = $this->db->conn->prepare($sql); // Sử dụng $this->db->conn
        $stmt->bind_param("i", $commentId);

        if ($stmt->execute()) {
            $result["success"] = true;
            $result["message"] = "Xóa bình luận thành công.";
        } else {
            $result["success"] = false;
            $result["message"] = "Xóa bình luận thất bại: " . $stmt->error;
        }

        $stmt->close();

        return $result;
    }
    public function getAllCommentspost() {
        $comments = array();

        $sql = "SELECT * FROM post_comment";
        $result = $this->db->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $comments[] = $row;
            }
        }

        return $comments;
    }
    public function countTotalCommentsForAllProducts() {
        $sql = "SELECT SUM(total_comments) AS all_total_comments FROM (
            SELECT product_id, COUNT(*) AS total_comments FROM product_comment GROUP BY product_id
        ) AS product_comments";
        
        $result = $this->db->conn->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['all_total_comments'];
        } else {
            return 0; // Trả về 0 nếu không có bình luận nào
        }
    }
}

class OrderDao {
    private $db;


    public function __construct() {
        $this->db = new Database();
    }

    public function getTotalSentOrders() {
        $sql = "SELECT COUNT(*) as sent_orders_count FROM cart_table ";
        $result = $this->db->conn->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            $sentOrdersCount = $row['sent_orders_count'];
        }

        return $sentOrdersCount;
    }

    public function getTotalReceivedOrders() {
        $sql = "SELECT COUNT(*) as received_orders_count FROM cart_table ";
        $result = $this->db->conn->query($sql);
        $receivedOrdersCount = 0;

        if ($result) {
            $row = $result->fetch_assoc();
            $receivedOrdersCount = $row['received_orders_count'];
        }

        return $receivedOrdersCount;
    }
}
?>