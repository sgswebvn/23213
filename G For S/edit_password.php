<?php
session_start();
require_once "./admin/function.php";

if (checkLogin2() == false) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmNewPassword = $_POST['confirm_new_password'];
    $hashedPassword = "";

    $userId = $_SESSION['user_id'];
    $userDao = new UserDao();

    $user = $userDao->getUserById($userId);

    if (!$user) {
        echo "Không tìm thấy thông tin người dùng.";
    } else {
        $hashedPassword = $user['user_password'];

        if ($currentPassword ==$hashedPassword) {
            if ($newPassword == $confirmNewPassword) {
               
                if ($userDao->updatePassword($userId, $newPassword)) {
                    echo "<script>alert('Mật khẩu đã được cập nhật thành công.');</script>";
                    // Chuyển hướng người dùng trở lại trang trước đó sau một khoảng thời gian ngắn
                    echo "<script>window.location.href = 'user_details.php';</script>";
                } else {
                    echo "Có lỗi khi cập nhật mật khẩu.";
                }
            } else {
                echo "Mật khẩu mới và xác nhận mật khẩu mới không trùng khớp.";
            }
        } else {
            echo "Mật khẩu hiện tại không đúng.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>CodePen - Login</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" />
    <link rel="stylesheet" href="./admin/css/style2.css" />
</head>

<body>
    <!-- partial:index.partial.html -->

    <body class="align">
        <div class="grid">
            <form method="POST" class="form login">
                <div class="form__field">
                    <label for="login__password"><svg class="icon">
                            <use xlink:href="#icon-lock"></use>
                        </svg><span class="hidden">current password</span></label>
                    <input type="password" id="current_password" name="current_password" class="form__input"
                        placeholder="Current Password" required />
                </div>
                <div class="form__field">
                    <label for="login__password"><svg class="icon">
                            <use xlink:href="#icon-lock"></use>
                        </svg><span class="hidden">new Password</span></label>
                    <input type="password" id="new_password" name="new_password" class="form__input"
                        placeholder="New Password" required />
                </div>
                <div class="form__field">
                    <label for="login__password"><svg class="icon">
                            <use xlink:href="#icon-lock"></use>
                        </svg><span class="hidden">Confirm New Password</span></label>
                    <input type="password" id="confirm_new_password" name="confirm_new_password" class="form__input"
                        placeholder="Confirm New Password" required />
                </div>

                <div class="form__field">
                    <input type="submit" value="Sign In" />
                </div>
            </form>

            <p class="text--center">
                Not a member? <a href="user_details.php">come back</a>
                <svg class="icon">
                    <use xlink:href="#icon-arrow-right"></use>
                </svg>
            </p>
        </div>

        <svg xmlns="http://www.w3.org/2000/svg" class="icons">
            <symbol id="icon-arrow-right" viewBox="0 0 1792 1792">
                <path
                    d="M1600 960q0 54-37 91l-651 651q-39 37-91 37-51 0-90-37l-75-75q-38-38-38-91t38-91l293-293H245q-52 0-84.5-37.5T128 1024V896q0-53 32.5-90.5T245 768h704L656 474q-38-36-38-90t38-90l75-75q38-38 90-38 53 0 91 38l651 651q37 35 37 90z" />
            </symbol>
            <symbol id="icon-lock" viewBox="0 0 1792 1792">
                <path
                    d="M640 768h512V576q0-106-75-181t-181-75-181 75-75 181v192zm832 96v576q0 40-28 68t-68 28H416q-40 0-68-28t-28-68V864q0-40 28-68t68-28h32V576q0-184 132-316t316-132 316 132 132 316v192h32q40 0 68 28t28 68z" />
            </symbol>
            <symbol id="icon-user" viewBox="0 0 1792 1792">
                <path
                    d="M1600 1405q0 120-73 189.5t-194 69.5H459q-121 0-194-69.5T192 1405q0-53 3.5-103.5t14-109T236 1084t43-97.5 62-81 85.5-53.5T538 832q9 0 42 21.5t74.5 48 108 48T896 971t133.5-21.5 108-48 74.5-48 42-21.5q61 0 111.5 20t85.5 53.5 62 81 43 97.5 26.5 108.5 14 109 3.5 103.5zm-320-893q0 159-112.5 271.5T896 896 624.5 783.5 512 512t112.5-271.5T896 128t271.5 112.5T1280 512z" />
            </symbol>
        </svg>
    </body>
    <!-- partial -->
</body>

</html>