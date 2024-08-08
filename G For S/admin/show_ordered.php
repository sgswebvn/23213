<?php
// Kết nối đến cơ sở dữ liệu
include "header.php";
include "connect.php";

// Tạo truy vấn SQL để lấy tất cả đơn hàng
$sql = "SELECT * FROM cart_table";

// Thực hiện truy vấn
$result = $conn->query($sql);

// Kiểm tra xem có dữ liệu trả về không
if ($result->num_rows > 0) {
    echo '<link rel="stylesheet" href="./css/main.css">'; 
    echo "<table>";
    echo "<tr><th>ID Đơn hàng</th><th>ID Tài Khoản</th><th>Tên sản phẩm</th><th>Số lượng</th><th>Giá</th><th>Trạng thái</th><th colspan='2'>Hành động</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['namesp'] . "</td>";
        echo "<td>" . $row['quantity_sp'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        if ($row['order_status'] == 0) {
            echo "<td>Chưa gửi</td>";
        } elseif ($row['order_status'] == 1) {
            echo "<td colspan='3' style='color: red;'>Đã hủy</td>";
        } elseif ($row['order_status'] == 3) {
            echo "<td  colspan='3' style='color: green;'>Đã gửi</td>";
        }
        if ($row['order_status'] == 0) {
            // Nếu đơn hàng chưa gửi, hiển thị nút "Hủy đơn hàng" và "Xác nhận đã gửi"
            echo "<td><a href='delete_ordered.php?id=" . $row['id'] . "'><i class='fa-solid fa-xmark fa-2xl'></i></a></td>";
            echo "<td><a href='oke_ordered.php?id=" . $row['id'] . "'><i class='fa-solid fa-check fa-2xl'></i></a></td>";
        } else if ($row['order_status'] == 1) {
            // Nếu đơn hàng đã bị hủy, hiển thị thông báo "Đã hủy"
            
        } else if ($row['order_status'] == 3) {
            // Nếu đơn hàng đã gửi, hiển thị nút "Đã gửi"
        
        }
        
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Không có đơn hàng nào.";
}

// Đóng kết nối đến cơ sở dữ liệu
$conn->close();
?>