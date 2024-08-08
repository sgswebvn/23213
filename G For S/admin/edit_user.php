<?php
include "connect.php"; // Kết nối đến cơ sở dữ liệu
// include "header.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $userId = $_GET['id']; // Nhận thông tin user_id từ URL

    // Truy vấn để lấy thông tin người dùng dựa trên user_id
    $sql = "SELECT * FROM user WHERE user_id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy người dùng.";
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xử lý dữ liệu khi form được gửi đi sau khi chỉnh sửa
    $userId = $_POST['user_id'];
    $newUsername = $_POST['new_username']; // Dữ liệu mới từ form
    $newRole = $_POST['new_role'];

    // Cập nhật thông tin người dùng
    $sql = "UPDATE user SET user_username = '$newUsername', role = '$newRole' WHERE user_id = $userId";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert(' cập nhật người dùng thành công .');</script>";
        // Chuyển hướng người dùng trở lại trang trước đó sau một khoảng thời gian ngắn
        echo "<script>window.location.href = 'show_user.php';</script>";
        // header("Location: show_user.php"); // Chuyển hướng về trang danh sách người dùng sau khi chỉnh sửa thành công
        // exit;
    } else {
        echo "Lỗi khi cập nhật người dùng: " . $conn->error;
    }
}
?>
<?php include "header.php"; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Chỉnh Sửa Người Dùng</title>
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <h2>Chỉnh Sửa Người Dùng</h2>
    <form method="POST">
        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
        <label for="new_username">Tên Người Dùng Mới:</label>
        <input type="text" id="new_username" name="new_username" class="addcmt"
            value="<?php echo $row['user_username']; ?>"><br><br>
        <label for="new_role">Quyền Mới:</label>
        <select id="new_role" name="new_role" class="addcmt">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>

        <input type="submit" class="addsend" value="Lưu">
    </form>
</body>

</html>