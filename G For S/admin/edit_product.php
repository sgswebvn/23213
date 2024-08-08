<?php
include "header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin sản phẩm từ biểu mẫu sửa
    $productId = $_POST['productId'];
    $newProductName = $_POST['productName'];
    $newDescription = $_POST['description'];
    $newPrice = $_POST['price'];
    $newStockQuantity = $_POST['stockQuantity'];

    // Xử lý việc tải lên ảnh mới và cập nhật vào cơ sở dữ liệu
    $categoryDao = new CategoryDao();

    if ($categoryDao->updateProductWithImages($productId, $newProductName, $newDescription, $newPrice, $newStockQuantity, $_FILES["productImages"])) {
        echo "Cập nhật sản phẩm thành công.";
    } else {
        echo "Cập nhật sản phẩm không thành công.";
    }
}

if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
    $categoryDao = new CategoryDao();
    $product = $categoryDao->getProductById($productId);

    if (!$product) {
        echo "Không tìm thấy sản phẩm.";
        exit;
    }
} else {
    echo "Thiếu thông tin sản phẩm.";
    exit;
}
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm</title>
    <link rel="stylesheet" href="./css/main.css">

</head>

<body>
    <h1>Sửa sản phẩm</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="productId" value="<?php echo $product['product_id']; ?>">
        <label for="productName">Tên sản phẩm:</label>
        <input type="text" id="productName" name="productName" class="addcmt"
            value="<?php echo $product['product_name']; ?>" required><br><br>
        <label for="description">Mô tả sản phẩm:</label>
        <textarea id="description" name="description" class="addcmt"
            required><?php echo $product['description']; ?></textarea><br><br>
        <label for="price">Giá sản phẩm:</label>
        <input type="text" id="price" name="price" value="<?php echo $product['price']; ?>" class="addcmt"
            required><br><br>
        <label for="stockQuantity">Số lượng tồn kho:</label>
        <input type="number" id="stockQuantity" name="stockQuantity" class="addcmt"
            value="<?php echo $product['stock_quantity']; ?>" required><br><br>
        <label for="productImages">Thư viện ảnh (chọn nhiều ảnh mới):</label>
        <input type="file" id="productImages" name="productImages[]" class="addcmt" multiple><br><br>
        <button type="submit" class="addsend">Lưu thay đổi</button>
    </form>
</body>

</html>