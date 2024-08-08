<?php
include "header.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
        $categoryDao = new CategoryDao();
        $categories = $categoryDao->getAllCategories();

        foreach ($categories as $category) {
            echo "<tr>";
            echo "<td>{$category['category_id']}</td>";
            echo "<td>{$category['category_name']}</td>";
            echo "<td>
                    <a href='edit_categorys.php?id={$category['category_id']}' >
                        <img class='imgedit' src='./icon/chinhsua.png'>
                    </a>
                    <a href='delete_category.php?id={$category['category_id']}' onclick=\"return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')\">
                        <img class='imgedit' src='./icon/removeicon.png'>
                    </a>
                  </td>";
            echo "</tr>";
        }
        ?>

        </tbody>
    </table>

</body>


</html>