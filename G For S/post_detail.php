<?php 
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = null;
}

$post_id = $_GET['post_id'];
 include "./admin/function.php";
 include "./admin/connect.php";
include "dataweb.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment_text']) && $user_id) {
    $comment_text = $_POST['comment_text'];
    // hoặc "post" tùy theo trường hợp
    // echo $object_type;

    $sql = "INSERT INTO post_comment (post_id, user_id, comment_text)
    VALUES ($post_id,  $user_id, '$comment_text')";


    if ($conn->query($sql) === TRUE) {
        // Bình luận đã được thêm thành công
    } else {
        $error_message = "Không thể thêm bình luận: " . $conn->error;
    }
}


// Lấy danh sách bình luận cho sản phẩm từ CSDL
// Lấy danh sách bình luận cho sản phẩm từ CSDL
$comments = [];
if (!empty($post_id)) {
    $sql = "SELECT pc.*, u.user_name
            FROM post_comment pc
            LEFT JOIN user u ON pc.user_id = u.user_id
            WHERE pc.post_id = $post_id 
            ORDER BY pc.created_at DESC
            LIMIT 10";

    $result = $conn->query($sql);

    if ($result === false) {
        $error_message = "Lỗi truy vấn CSDL: " . $conn->error;
    } else {
        // Kiểm tra xem truy vấn đã trả về dữ liệu hay không
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $comments[] = $row;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bài viết </title>
    <link rel="icon" type="image" href="Goods_for_sale__1_-removebg-preview.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />

    <link rel="stylesheet" href="sstyle.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />
</head>

<body?>
    <div class="menu-btn">
        <i class="fas fa-bars fa-2x"></i>
    </div>

    <div class="container">
        <?php nav();
            ?>

        <?php 
$postDAO = new PostDAO();
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $post = $postDAO->getPostById($post_id);

    if ($post) {
        echo '<div style="padding-top: 15px;">';
        echo '<h1>' . $post['title'] . '</h1>';
        echo '<h5>' . $post['description'] . '</h5>';
        echo '<p>' . $post['content'] . '</p>';
        echo '</div>';

    } else {
        echo 'Không tìm thấy bài viết.';
    }
} else {
    echo 'Thiếu thông tin bài viết.';
}
?>
        <h2>Bình luận</h2>

        <ul style="padding-bottom: 20px;">
            <?php if (isset($error_message)): ?>
            <p><?php echo $error_message; ?></p>
            <?php endif; ?>
            <?php foreach ($comments as $comment): ?>
            <li>
                <strong><?php echo $comment['user_name']; ?>:</strong>
                <?php echo $comment['comment_text']; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <!-- Biểu mẫu viết bình luận -->
        <?php if ($user_id): ?>
        <form method="POST" style="padding-bottom:20px;">
            <input class="addcmt" name="comment_text" placeholder="Viết bình luận"></input>
            <input class="addsend" type="submit" value=Gửi>
            </input>
        </form>
        <?php else: ?>
        <p>Vui lòng <a href="./admin/login.php">đăng nhập</a> để viết bình luận.</p>
        <?php endif; ?>
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