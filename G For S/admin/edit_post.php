<?php
include "function.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postId = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $description = $_POST['description'];

    $postDao = new PostDao();

    if ($postDao->updatePost($postId, $title, $content)) {
     
        echo "<script>alert('Bài viết đã được cập nhật thành công .');</script>";
        // Chuyển hướng người dùng trở lại trang trước đó sau một khoảng thời gian ngắn
        echo "<script>window.location.href = 'show_post.php';</script>";
    } else {
        echo "Có lỗi khi cập nhật bài viết.";
    }
}

if (isset($_GET['id'])) {
    $postId = $_GET['id'];
    $postDao = new PostDao();
    $post = $postDao->getPostById($postId);
}

?>
<?php include "header.php";?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa Bài Viết</title>
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <h1>Sửa Bài Viết</h1>
    <form method="POST">
        <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
        <label for="title">Tiêu đề:</label>
        <input type="text" id="title" name="title" value="<?php echo $post['title']; ?>" class="addcmt"
            required><br><br>
        <label for="description">Mieu ta:</label>
        <textarea id="description" name="description" class="addcmt"
            required><?php echo $post['description']; ?></textarea><br><br>
        <label for="content">Nội dung:</label>
        <textarea id="editor" name="content" class="addcmt"><?php echo $post['content']; ?></textarea><br><br>

        <button type="submit" class="addsend">Cập Nhật Bài Viết</button>
    </form>
    <br>
</body>
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

<script>
ClassicEditor.create(document.querySelector("#editor")).catch((error) => {
    console.error(error);
});
</script>

</html>