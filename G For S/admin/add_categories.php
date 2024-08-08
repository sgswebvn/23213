<?php include "header.php";
$addFailure = false;
$addSuccess = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem biểu mẫu đã được gửi đi hay chưa
    // include 'function.php';
    // Include lớp DAO danh mục

    $categoryName = $_POST['categoryName'];

    $categoryDao = new CategoryDao();

    if ($categoryDao->addCategory($categoryName)) {
        $addSuccess = true;
} else {
echo "Thêm danh mục không thành công.";
$addFailure = true;
}
}
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm danh mục mới</title>
    <link rel="stylesheet" href="./css/main.css">
    <!-- <link rel="stylesheet" href="style.css"> -->

</head>

<body>
    <div class="alert alert-success "
        style="background-color: #5cb85c;  width: 300px;display:<?php echo $addSuccess ? 'block' : 'none'; ?>">
        <i class=" text-white fa-solid fa-circle-check"></i>&nbsp; <strong class="text-white">Thêm thành công !</strong>
    </div>
    <div class="alert alert-success bg-danger" style="display:<?php echo $addFailure ? 'block' : 'none'; ?>">
        <i class="  text-white fa-solid fa-triangle-exclamation"></i>&nbsp; <strong class="text-white">Thêm thất
            bại !</strong>
    </div>
    <h1>Thêm danh mục mới</h1>

    <form method="POST">
        <!-- Chỉ định tên file xử lý khi submit -->
        <label for="categoryName">Tên danh mục:<br>
            <input type="text" id="categoryName" name="categoryName" class="addcmt" required></label><br>
        <input type="submit" class="addsend" value="Thêm danh mục">
    </form>
</body>

</html>