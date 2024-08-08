<?php
include "header.php";
// Kết nối đến cơ sở dữ liệu MySQL
include "connect.php";



// Truy vấn để lấy tất cả người dùng
$sql = "SELECT * FROM user";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Danh Sách Người Dùng</title>
    <link rel="stylesheet" href="./css/main.css">
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border-top: 1px solid black;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    .avatar {
        width: 50px;
        /* Đặt chiều rộng ảnh */
        height: 50px;
        /* Đặt chiều cao ảnh */
        border-radius: 50%;
        /* Bo tròn góc */
    }
    </style>
</head>

<body>
    <h2>Danh Sách Người Dùng</h2>
    <table>
        <tr>
            <th>Hình Ảnh Đại Diện</th>
            <th>Tên Người Dùng</th>
            <th>Username</th>

            <th>Quyền </th>
            <th></th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            $i=0;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
             
                echo  "<td><img src='" . $row["profile_image"] . "' alt='Avatar' class='avatar'></td>";
                echo "<td>" . $row["user_name"] . "</td>";
                echo "<td>" . $row["user_username"] . "</td>";
               
                echo "<td>" . $row["role"] . "</td>";
                echo "<td><a href='edit_user.php?id={$row['user_id']}'><img  class='imgedit' src='./icon/chinhsua.png'></a>  <a href='delete_user.php?id={$row['user_id']}' onclick=\"return confirm('Bạn có chắc chắn muốn xóa tài khoản  này không?')\"><img  class='imgedit' src='./icon/removeicon.png'></a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Không có người dùng nào.</td></tr>";
        }
        ?>
    </table>
</body>

</html>