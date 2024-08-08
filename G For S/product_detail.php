<?php
session_start();
include "./admin/function.php";
include "./admin/connect.php";
include "dataweb.php";
$categoryDao = new CategoryDao();


// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = null;
}

 // Import DAO

// Kết nối CSDL và lấy thông tin sản phẩm từ CSDL (thay thế bằng mã thực tế)
$product_id = $_GET['product_id'];
// echo $product_id;


// Lưu bình luận vào CSDL nếu có dữ liệu được gửi từ biểu mẫu

// Lưu bình luận vào CSDL nếu có dữ liệu được gửi từ biểu mẫu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment_text']) && $user_id) {
    $comment_text = $_POST['comment_text'];
    // hoặc "post" tùy theo trường hợp
    // echo $object_type;

    $sql = "INSERT INTO product_comment (product_id, user_id, comment_text)
    VALUES ($product_id,  $user_id, '$comment_text')";


    if ($conn->query($sql) === TRUE) {
        // Bình luận đã được thêm thành công
    } else {
        $error_message = "Không thể thêm bình luận: " . $conn->error;
    }
}


// Lấy danh sách bình luận cho sản phẩm từ CSDL
// Lấy danh sách bình luận cho sản phẩm từ CSDL
$comments = [];
if (!empty($product_id)) {
    $sql = "SELECT pc.*, u.user_name
            FROM product_comment pc
            LEFT JOIN user u ON pc.user_id = u.user_id
            WHERE pc.product_id = $product_id 
            ORDER BY pc.created_at DESC
            LIMIT 10";

    $result = $conn->query($sql);

    if ($result === false) {
        $error_message = "Lỗi truy vấn CSDL: " . $conn->error;
    } else {
        // Kiểm tra xem truy vấn đã trả về dữ liệu hay không
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $comments[] = $row;
            }
        }
    }
}

// Đoạn mã HTML để hiển thị trang chi tiết sản phẩm
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
    <?php css();?>
</head>






<body>

    <div class="menu-btn">
        <i class="fas fa-bars fa-2x"></i>
    </div>

    <div class="container">
        <?php nav();?>
        <?php 
        $categories = $categoryDao->getAllCategories();

// Kiểm tra nếu có danh mục
if (!empty($categories)) {
echo '<ul class="list-category">';
    foreach ($categories as $category) {
    echo '<li><a href="products.php?category_id=' . $category['category_id'] . '">' . $category['category_name'] . '</a>
    </li>';
    }
    echo '</ul>';
}?>

        <main>
            <div class="section section-gray">
                <div class="section-content">
                    <?php if (isset($_GET['product_id'])) {
                $productDao = new CategoryDao();
                $productId = $_GET['product_id'];

                // Truy vấn cơ sở dữ liệu để lấy thông tin sản phẩm
                $product = $productDao->getProductById($productId);

                if ($product) {
                    ?>
                    <!-- <p>Images are broken, RIP</p> -->
                    <div class="product-details">
                        <ul class="product-images">
                            <li class="preview">
                                <?php
                                $productImages = $productDao->getProductImagesByProductId($productId);
                                if (!empty($productImages)) {
                                    // Hiển thị ảnh đầu tiên trong li.preview
                                    echo ' <li class="preview">
                                    <img src="./admin/' . $productImages[0]['image_path'] . '" alt="' . $product['product_name'] . '" /></li>
                                    ';
                                    // Hiển thị các ảnh còn lại trong các li khác
                                    for ($i = 1; $i < count($productImages); $i++) {
                                        echo '<li><a href="javascript:void(0)"><img src="./admin/' . $productImages[$i]['image_path'] . '" alt="' . $product['product_name'] . '" /></a></li>';
                                    }
                                }
                                ?>

                        </ul>
                        <ul class="product-info">
                            <li class="product-name"><?php echo $product['product_name']; ?></li>
                            <li class="product-price">
                                <span><?php echo number_format($product['price'], 0, ',', '.') ?>
                                    VNĐ</span>
                            </li>
                            <li class="product-attributes">
                                <ul class="fields">
                                    <li>
                                        <div class="field-name">Color:</div>
                                        <label> <input type="radio" name="color" /> Gray </label>
                                        <label> <input type="radio" name="color" /> Black </label>
                                    </li>
                                    <li>
                                        <div class="field-name">Size:</div>
                                        <label> <input type="radio" name="size" /> Kids </label>
                                        <label> <input type="radio" name="size" /> Adults </label>
                                    </li>
                                </ul>
                            </li>
                            <li class="product-addtocart">
                                <form action="giohang.php" method="post">
                                    <input type="hidden" name="soluongsp" min="1" max="10" value="1">
                                    <input type="hidden" name="tensp" value="<?php echo $product['product_name']; ?>">
                                    <input type="hidden" name="giasp" value="<?php echo $product['price']; ?>">
                                    <input type="hidden" name="idsanpham" value="<?php echo $product['product_id']; ?>">
                                    <input type="hidden" name="hinhsp"
                                        value="./admin/<?php  echo $productImages[0]['image_path'] ;?>">
                                    <input name="addgiohang" type="submit"
                                        style="  width: 100%; cursor: pointer; background: #000;  color: #fff; display: block; border: none; outline: none; padding: 10px;"
                                        value="Add To Cart">
                                </form>

                            </li>
                            <li class="product-description">
                                <p>
                                    <?php echo $product['product_details']; ?>
                                </p>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="section">
                <div class="section-title">
                    <h2>Check Out More Hats</h2>
                </div>
                <div class="section-content">
                    <p><?php echo $product['description']; ?></p>

                </div>
            </div>
            <?php 
                } else {
                    echo 'Không tìm thấy sản phẩm.';
                }
            } else {
                echo 'Thiếu thông tin sản phẩm.';
            }
            ?>
        </main>
        <h2>Bình luận</h2>

        <ul style="padding-bottom: 20px;">
            <?php if (isset($error_message)): ?>
            <p><?php echo $error_message; ?></p>
            <?php endif; ?>
            <?php foreach ($comments as $comment): ?>
            <li>
                <strong><?php echo $comment['user_name']; ?>:</strong>
                <?php echo $comment['comment_text']; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <!-- Biểu mẫu viết bình luận -->
        <?php if ($user_id): ?>
        <form method="POST" style="padding-bottom:20px;">
            <input class="addcmt" name="comment_text" placeholder="Viết bình luận"></input>
            <input class="addsend" type="submit" value=Gửi>
            </input>
        </form>
        <?php else: ?>
        <p>Vui lòng <a href="./admin/login.php">đăng nhập</a> để viết bình luận.</p>
        <?php endif; ?>

        <!-- Hiển thị danh sách bình luận -->

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-inner">
                <div><i class="fas fa-globe fa-2x"></i> English (United States)</div>
                <ul>
                    <li><a href="#">Sitemap</a></li>
                    <li><a href="#">Contact Microsoft</a></li>
                    <li><a href="#">Privacy & cookies</a></li>
                    <li><a href="#">Terms of use</a></li>
                    <li><a href="#">Trademarks</a></li>
                    <li><a href="#">Safety & eco</a></li>
                    <li><a href="#">About our ads</a></li>
                    <li><a href="#">&copy; Microsoft 2020</a></li>
                </ul>
            </div>
        </footer>
    </div>
    <!-- partial -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="script copy.js"></script>

</body>


</html>