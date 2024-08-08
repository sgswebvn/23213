<?php
include "connect.php"; // Kết nối đến cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $userId = $_GET['id']; // Nhận thông tin user_id từ URL

    // Truy vấn để xóa người dùng dựa trên user_id
    $sql = "DELETE FROM user WHERE user_id = $userId";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('xóa người dùng thành công .');</script>";
        // Chuyển hướng người dùng trở lại trang trước đó sau một khoảng thời gian ngắn
        echo "<script>window.location.href = 'show_user.php';</script>";
        exit;
    } else {
        echo "Lỗi khi xóa người dùng: " . $conn->error;
    }
}
?>