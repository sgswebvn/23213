<?php
 include "./admin/function.php";
 include "dataweb.php"; // Thay thế bằng tên tệp DAO thực tế của bạn
 $categoryDao = new CategoryDao(); // Thay thế YourCategoryDao bằng tên thực tế của DAO của bạn
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
} else {
echo 'Không có danh mục nào.';
}

    // Kiểm tra xem có tham số category_id được truyền qua URL không
    if (isset($_GET['category_id'])) {
    $categoryId = $_GET['category_id'];
    
    // Khởi tạo DAO
    $categoryDao = new CategoryDao(); // Thay thế YourCategoryDao bằng tên DAO thực tế của bạn
    
    // Sử dụng DAO để lấy thông tin danh mục
    $category = $categoryDao->getCategoryById($categoryId);
    
    // Kiểm tra xem danh mục có tồn tại không
    if ($category) {
    // Sử dụng DAO để lấy danh sách sản phẩm theo danh mục
    $productsDao = new CategoryDao(); // Thay thế YourProductsDao bằng tên DAO của bạn
    $products = $productsDao->getAllProductsByCategoryId($categoryId);
    $category = $categoryDao->getCategoryById($categoryId);
    $categoryName = ($category) ? $category['category_name'] : "Danh mục không tồn tại";
    
    // Hiển thị danh sách sản phẩm
    echo '<h1 style=" margin-bottom: 20px;">' . $category['category_name'] . '</h1>';
    echo '<div class="home-cards">';
    
        foreach ($products as $product) {

            htmlproduct2($product, $categoryName);
        }
        echo '</div>';
    } else {
    echo 'Danh mục không tồn tại.';
    }
    } else {
    echo 'Thiếu thông tin danh mục.';
    }
    ?>
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
</body>

</html>