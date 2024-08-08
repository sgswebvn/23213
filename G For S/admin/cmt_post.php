<?php
include "header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Comments</title>
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <h1>Danh sách bình luận</h1>
    <?php
    // Khởi tạo đối tượng CommentDAO
    $commentDAO = new CommentDAO();

    // Lấy danh sách tất cả các bình luận
    $comments = $commentDAO->getAllCommentspost();

    // Hiển thị danh sách bình luận trong bảng
    if (!empty($comments)) {
        echo "<table>";
        echo "<tr><th>ID</th><th>ID PRODUCT</th><th>Nội dung</th><th>Xóa</th></tr>";
        foreach ($comments as $comment) {
            echo "<tr>";
            echo "<td>" . $comment['comment_id'] . "</td>";
            echo "<td>" . $comment['post_id'] . "</td>";
            echo "<td>" . $comment['comment_text'] . "</td>";
            echo "<td><a onclick=\"deleteComment(" . $comment['comment_id'] . ")\"><img class='imgedit' src='./icon/removeicon.png'></a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Không có bình luận nào.</p>";
    }

    // Đóng kết nối cơ sở dữ liệu
    ?>

    <script>
    // Hàm JavaScript để xóa bình luận thông qua AJAX
    function deleteComment(commentId) {
        if (confirm("Bạn có chắc chắn muốn xóa bình luận này không?")) {
            // Gửi yêu cầu AJAX để xóa bình luận
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_cmtpost.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Xử lý kết quả sau khi xóa thành công
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Xóa thành công, cập nhật giao diện
                        alert(response.message);
                        location.reload(); // Tải lại trang để cập nhật danh sách bình luận
                    } else {
                        // Xóa thất bại
                        alert(response.message);
                    }
                }
            };
            xhr.send("commentId=" + commentId);
        }
    }
    </script>
</body>

</html>