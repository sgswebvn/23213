<?php
include "header.php";

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="./css/main.css">

</head>

<body>
    <h1>Danh sách sản phẩm</h1>

    <?php
    

    // Khởi tạo đối tượng CategoryDao
    $categoryDao = new CategoryDao();

    // Lấy danh sách tất cả sản phẩm
    $products = $categoryDao->getFirstProductImageAndCategoryName();

   
            if (!empty($products)) {
                echo '<table 
        >
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Số lượng tồn kho</th>
                    <th>Danh mục</th>
                    <th>Hình ảnh</th>
                    <th>Thao tác</th>
                </tr>';
                foreach ($products as $product) {
            echo '<tr>
            <td>' . $product['product_id'] . '</td>
            <td>' . $product['product_name'] . '</td>
            <td class="edittd"><p>' . $product['description'] . '</p></td>
            <td>' . $product['price'] . '</td>
            <td>' . $product['stock_quantity'] . '</td>
            <td>' . $product['category_name'] . '</td>
            <td><img src="' . $product['product_image'] . '"width="100px"></td>
            <td>
                <a href="edit_product.php?product_id=' . $product['product_id'] . '"><img class="imgedit" src="./icon/chinhsua.png"></a>
                <a href="delete_product.php?product_id=' . $product['product_id'] . '" onclick="return confirm(\'Bạn có chắc chắn muốn xóa sản phẩm này không?\')"><img class="imgedit" src="./icon/removeicon.png"></a>
            </td>
        </tr>';
    
        }

        echo '</table>';
    } else {
        echo '<p>Không có sản phẩm nào.</p>';
    }
    ?>


</body>

</html>