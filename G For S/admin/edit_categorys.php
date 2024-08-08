<?php

include "function.php";


$categoryId = null;
$categoryDao = new CategoryDao();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
$categoryId = $_GET['id'];
$category = $categoryDao->getCategoryById($categoryId);

if ($category) {
// Hiển thị biểu mẫu sửa danh mục
?>
<?php include "header.php";?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa danh mục</title>
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <h1>Sửa danh mục</h1>
    <form method="POST">
        <input type="hidden" name="categoryId" value="<?php echo $category['category_id']; ?>">
        <label for="categoryName">Tên danh mục:</label>
        <input type="text" id="categoryName" name="categoryName" class="addcmt"
            value="<?php echo $category['category_name']; ?>" required> <br>
        <button type="submit" class="addsend">Lưu thay đổi</button>
    </form>
</body>

</html>
<?php
    } else {
        echo "Không tìm thấy danh mục.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['categoryId'])) {
    // Kiểm tra nếu là phương thức POST và có categoryId trong POST
    $categoryId = $_POST['categoryId'];
    $newCategoryName = $_POST['categoryName'];
    
    // Gọi phương thức updateCategory từ lớp CategoryDao
    if ($categoryDao->updateCategory($categoryId, $newCategoryName)) {
        echo "Cập nhật danh mục thành công.";
        header("Location: show_categoris.php");
        // Điều hướng hoặc hiển thị thông báo thành công
    } else {
        echo "Cập nhật danh mục không thành công.";
        // Chuyển hướng về trang danh sách người dùng sau khi chỉnh sửa thành công
        exit;
        // Hiển thị thông báo lỗi nếu cần
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>