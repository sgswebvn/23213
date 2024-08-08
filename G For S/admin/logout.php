<?php 
session_start();
session_unset();
session_destroy();


// Chuyển hướng người dùng về trang đăng nhập hoặc trang chính tùy ý
header("Location: /index.php"); // Thay thế bằng URL của trang đăng nhập hoặc trang chính
exit(); // Đảm bảo không có mã PHP nào thực thi sau khi chuyển hướng
?>?>