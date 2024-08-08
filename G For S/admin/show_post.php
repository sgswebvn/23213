<?php
include "header.php";

$postDao = new PostDao();
$posts = $postDao->getAllPosts();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh Sách Bài Viết</title>
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <h1>Danh Sách Bài Viết</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Tiêu đề</th>
            <th>Ngày tạo</th>
            <th>Ảnh đại diện</th>
            <th>Mô tả</th>
            <th>Thao tác</th>
        </tr>
        <?php foreach ($posts as $post) : ?>
        <tr>
            <td><?php echo $post['post_id']; ?></td>
            <td><?php echo $post['title']; ?></td>
            <td><?php echo $post['created_at']; ?></td>
            <td><img src="<?php echo $post['thumbnail']; ?>" alt="Ảnh đại diện" width="100"></td>
            <td class="edittd">
                <p><?php echo $post['description']; ?></p>
            </td>
            <td>
                <a href="edit_post.php?id=<?php echo $post['post_id']; ?>"><img class='imgedit'
                        src='./icon/chinhsua.png'></a>
                <a href="delete_post.php?id=<?php echo $post['post_id']; ?>"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?')"><img class='imgedit'
                        src='./icon/removeicon.png'></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
</body>

</html>