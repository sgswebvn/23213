<?php
session_start();

require_once "./function.php";
if (checklogin()==false){  header('Location: login.php'); exit(); }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>CodePen - User Card</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" />
    <link rel="stylesheet" href="./css/style3.css" />
</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="Modal UserModal">
        <aside class="Modal-box">
            <header class="UserModal-header">
                <div class="UserModal-edit">
                    <button>Q</button>
                </div>
                <div class="UserModal-thumb">
                    <img src="<?php echo $_SESSION['profile_image'];?>" alt="" />
                </div>
                <div class="UserModal-delete">
                    <button>C</button>
                </div>
            </header>
            <section class="UserModal-info">
                <h1 class="UserModal-name">
                    <!-- tên người dùng -->
                    <?php echo $_SESSION['user_name']?>

                </h1>
                <span class="UserModal-status">
                    <!-- role -->
                    ADMIN
                </span>
                <span class="UserModal-field"> CHỨC NĂNG </span><br />
                <a href="bd.php" class="thea"> TRANG QUẢN TRỊ </a>
                <a href="edit_password.php" class="thea"> ĐỔI MẬT KHẨU </a>
                <a href="show_detailsuser.php" class="thea" style="text-direction: none;"> THÔNG TIN </a>

                <a href="logout.php" class="thea"> ĐĂNG XUẤT </a>
            </section>
        </aside>
    </div>
    <!-- partial -->
</body>

</html>