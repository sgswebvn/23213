<?php
// Kết nối đến cơ sở dữ liệu
include "connect.php";

if (isset($_GET['id'])) {
    $orderId = $_GET['id'];
    
    // Thực hiện truy vấn để cập nhật trạng thái đơn hàng thành "Đã hủy" (1)
    $sql = "UPDATE cart_table SET order_status = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    
    if ($stmt->execute()) {
        // Chuyển người dùng trở lại trang danh sách đơn hàng sau khi hủy thành công
        header("Location: show_ordered.php");
    } else {
        echo "Có lỗi xảy ra khi hủy đơn hàng.";
    }
}

// Đóng kết nối đến cơ sở dữ liệu
$conn->close();
?>