<?php
include "header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryDao = new CategoryDao();

    // Xử lý thông tin sản phẩm và lưu vào bảng Products
    $productName = $_POST["productName"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stockQuantity = $_POST["stockQuantity"];
    $product_details = $_POST["product_details"];
    $manufacturer = $_POST["manufacturer"];

    $categoryID = $_POST["category"];

    $productImages = $_FILES["productImages"];

    if ($categoryDao->addProduct($productName, $description, $product_details, $price, $stockQuantity, $categoryID, $manufacturer, $productImages)) {
        echo "Thêm sản phẩm thành công.";
    } else {
        echo "Lỗi khi thêm sản phẩm.";
    }
}

// Lấy danh sách danh mục sản phẩm từ cơ sở dữ liệu
$categoryDao = new CategoryDao();
$categoryList = $categoryDao->getAllCategories();
?>

<style>
input {
    /* border: 1px solid rgb(174, 169, 169); */
    padding: 2px;
    width: 500px;
    height: 50px;
}



.ck-editor__editable[role="textbox"] {
    /* editing area */
    min-height: 200px;
}
</style>


<link rel="stylesheet" href="./css/main.css">


<div>
    <h1>Add Product</h1>

    <form method="POST" enctype="multipart/form-data">
        <label for="productName">Tên sản phẩm:<br>
            <input type="text" id="productName" name="productName" class="addcmt" required>
        </label>

        <label for="description">Mô tả sản phẩm:<br>
            <textarea id="description" name="description" class="addcmt" required></textarea>
        </label>
        <label for="product_details">Chi tiết sản phẩm:<br>
            <textarea id="editor" name="product_details" class="addcmt"></textarea>


        </label>
        <label for="price">Giá sản phẩm:<br>
            <input type="text" id="price" name="price" class="addcmt" required>
        </label>
        <label for="stockQuantity">Số lượng tồn kho:<br>
            <input type="number" id="stockQuantity" name="stockQuantity" class="addcmt" required>
        </label>
        <label for="category">Danh mục sản phẩm:<br>
            <select id="category" name="category" style="width:<br> 500px;" class="addcmt" required>
                <option value="" class="addcmt" disabled selected>Chọn danh mục</option>
                <?php
    $categoryDao = new CategoryDao();
    $categoryList = $categoryDao->getAllCategories();

    foreach ($categoryList as $category) {
        echo '<option style="color:<br>black;" value="' . $category['category_id'] . '">' . $category['category_name'] . '</option>';

    }
    ?>
            </select><br><br>
        </label>
        <label for="manufacturer">Nhà sản xuất:<br>
            <input type="text" id="manufacturer" name="manufacturer" class="addcmt" required>
        </label>
        <label for="productImages">Thư viện ảnh (chọn nhiều ảnh):<br>
            <input type="file" id="productImages" name="productImages[]" multiple required><br><br>
        </label>
        <input type="submit" value="Thêm sản phẩm" class="addsend">
    </form>
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

    <script>
    ClassicEditor.create(document.querySelector("#editor")).catch((error) => {
        console.error(error);
    });
    </script>


</div>