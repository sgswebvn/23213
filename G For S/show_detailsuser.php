<?php
session_start();
include "./admin/function.php"; ?>
<?php include 'dataweb.php';

if (checkLogin2() == false) {
    header('Location: login.php');
    exit();
}

$userDao = new UserDao();
$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST['user_name'];
    $userUsername = $_POST['user_username'];
    $profileImage = $_FILES['profile_image']; // Lấy thông tin tệp ảnh mới

    // Kiểm tra xem người dùng đã nhập đủ thông tin hay chưa
    if (empty($userName) || empty($userUsername)) {
        echo "Vui lòng điền đầy đủ thông tin.";
    } else {
        // Xử lý tệp ảnh mới
        if (!empty($profileImage['tmp_name'])) {
            // Đường dẫn đến thư mục lưu trữ ảnh
            $uploadDirectory = 'uploads/';

            // Tạo tên tệp ảnh mới
            $newFileName = $userId . '_' . time() . '_' . $profileImage['name'];

            // Đường dẫn đến tệp ảnh mới
            $newFilePath = $uploadDirectory . $newFileName;

            // Upload tệp ảnh mới
            if (move_uploaded_file($profileImage['tmp_name'], $newFilePath)) {
                // Xóa ảnh cũ nếu tồn tại
                if (!empty($user['profile_image'])) {
                    unlink($user['profile_image']);
                }

                // Cập nhật thông tin người dùng trong cơ sở dữ liệu
                if ($userDao->updateUser($userId, $userName, $userUsername, $newFilePath)) {
                    echo "<script>alert('Thông tin người dùng đã được cập nhật thành công.');</script>";
                    // Chuyển hướng người dùng trở lại trang trước đó sau một khoảng thời gian ngắn
                    echo "<script>window.location.href = 'user_details.php';</script>";
                } else {
                    echo "Có lỗi khi cập nhật thông tin người dùng.";
                }
            } else {
                echo "Có lỗi khi tải lên tệp ảnh mới.";
            }
        } else {
            // Nếu người dùng không tải lên tệp ảnh mới, chỉ cập nhật thông tin khác
            if ($userDao->updateUser($userId, $userName, $userUsername, null)) {
                echo "<script>alert('Thông tin người dùng đã được cập nhật thành công.');</script>";
                // Chuyển hướng người dùng trở lại trang trước đó sau một khoảng thời gian ngắn
                echo "<script>window.location.href = 'user_details.php';</script>";
            } else {
                echo "Có lỗi khi cập nhật thông tin người dùng.";
            }
        }
    }
}

$user = $userDao->getUserById($userId);

if (!$user) {
    echo "Không tìm thấy thông tin người dùng.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa thông tin người dùng</title>
    <link rel="stylesheet" href="./admin/css/main.css">
    <style>

    </style>
</head>

<body>
    <div class="menu-btn">
        <i class="fas fa-bars fa-2x"></i>
    </div>

    <div class="container">
        <?php nav();?>
        <div class="editform">
            <h1>Chỉnh sửa thông tin người dùng</h1>
            <form method="POST" enctype="multipart/form-data">
                <!-- Đặt enctype để cho phép tải lên tệp ảnh -->
                <label for="user_name">Tên người dùng:</label>
                <input type="text" id="user_name" name="user_name" value="<?php echo $user['user_name']; ?>"
                    class="addcmt" required><br><br>


                <input type="hidden" id="user_username" name="user_username"
                    value="<?php echo $user['user_username']; ?>" class="addcmt" required>

                <label for="profile_image">Ảnh đại diện mới:</label>
                <input type="file" id="profile_image" name="profile_image"><br><br>

                <button type="submit" class="addsend">Lưu thay đổi</button>
            </form>
            <br>
            <a href="user_details.php">Quay lại </a>
        </div>
    </div>
</body>

</html>