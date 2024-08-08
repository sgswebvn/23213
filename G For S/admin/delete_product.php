<?php
include 'function.php';

if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
    $categoryDao = new CategoryDao();

    if ($categoryDao->deleteProduct($productId)) {
        echo "<script>alert('xóa sản phẩm thành công .');</script>";
        // Chuyển hướng người dùng trở lại trang trước đó sau một khoảng thời gian ngắn
        echo "<script>window.location.href = 'show_products.php';</script>";
    } else {
        echo "Xóa sản phẩm không thành công.";
    }
} else {
    echo "Thiếu thông tin sản phẩm.";
}
?>