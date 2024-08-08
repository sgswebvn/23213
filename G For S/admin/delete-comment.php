<?php
include "function.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["commentId"])) {
    // Lấy thông tin commentId từ dữ liệu POST
    $commentId = $_POST["commentId"];

    // Include file CommentDAO.php

    // Khởi tạo đối tượng CommentDAO
    $commentDAO = new CommentDAO();

    // Thực hiện xóa bình luận và trả về kết quả dưới dạng JSON
    $result = $commentDAO->deleteComment($commentId);

    // Đóng kết nối cơ sở dữ liệu

    // Trả về kết quả (thành công hoặc thất bại) dưới dạng JSON
    header("Content-Type: application/json");
    echo json_encode($result);
}
?>