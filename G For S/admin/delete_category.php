<?php
include 'function.php';



if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    $categoryDao = new CategoryDao();

    // Gọi phương thức deleteCategoryWithProducts để xóa danh mục và sản phẩm liên quan
    if ($categoryDao->deleteCategoryWithProducts($categoryId)) {
        echo "<script>alert('Xóa danh mục và các sản phẩm liên quan thành công.');</script>";
        // Chuyển hướng người dùng trở lại trang trước đó sau một khoảng thời gian ngắn
        echo "<script>window.location.href = 'show_categoris.php';</script>";
        exit;

    } else {
        echo "Xóa danh mục và các sản phẩm liên quan không thành công.";
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}

?>