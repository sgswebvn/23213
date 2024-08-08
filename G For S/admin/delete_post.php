<?php
include "header.php";

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $postDao = new PostDao();

    if ($postDao->deletePost($postId)) {
        echo "<script>alert('xóa bài viết thành công .');</script>";
        // Chuyển hướng người dùng trở lại trang trước đó sau một khoảng thời gian ngắn
        echo "<script>window.location.href = 'show_post.php';</script>";
    } else {
        echo "Có lỗi khi xóa bài viết.";
    }
}
?>