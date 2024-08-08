<?php
    session_start();
    // include "./admin/function.php";
include "./admin/connect.php";
include "dataweb.php";
?>
<?php   if (!isset($_SESSION['user_id'])) {
     
        // Người dùng chưa đăng nhập, hiển thị thông báo và không xử lý biểu mẫu
        echo "<script>alert('vui lòng đăng nhập để đặt hàng .');</script>";
        echo "<script>window.location.href = 'index.php';</script>";

    exit;
    } else {
        $user_id = $_SESSION['user_id']; 
        $order_status = 0;
        ?>
<?php
    if(!isset($_SESSION['giohang'])) $_SESSION['giohang']=[];
    // if(isset($_GET['xoagiohang'])&&($_GET['xoagiohang']==1))unset($_SESSION['giohang']);
    // lấy dữ liệu từ form
    if(isset($_POST['addgiohang'])&&($_POST['addgiohang'])){
        $hinh=$_POST['hinhsp'];
        $tensp=$_POST['tensp'];
        $giasp=$_POST['giasp'];
        $soluong=$_POST['soluongsp'];
        $id=$_POST['idsanpham'];
        //  kiem tra sp co trong gi hang ?
        $fl=0;  //kiem tra sp cos trung hay k tac dung cua bien neu k trung thi them moi
        for ($i=0; $i <sizeof($_SESSION['giohang']) ; $i++) { 
           if($_SESSION['giohang'][$i][4]==$id){
            $fl=1;
            $soluongmoi=$soluong+$_SESSION['giohang'][$i][3];
            $_SESSION['giohang'][$i][3]=$soluongmoi;
            break;
           }
        }
        if($fl==0){

        
        
        // them moi san pham
        
        $sp=[$hinh,$tensp,$giasp,$soluong,$id,$user_id];
        $_SESSION['giohang'][]=$sp;
        // var_dump($_SESSION['giohang']);
        }
    }
            // Xóa một sản phẩm khỏi giỏ hàng
        if (isset($_GET['xoasanpham']) && $_GET['xoasanpham'] != '') {
            $id_xoa = $_GET['xoasanpham'];
            for ($i = 0; $i < sizeof($_SESSION['giohang']); $i++) {
                if ($_SESSION['giohang'][$i][4] == $id_xoa) {
                    unset($_SESSION['giohang'][$i]);
                    break;
                }
            }
            $_SESSION['giohang'] = array_values($_SESSION['giohang']);
        }

            // Cập nhật số lượng của một sản phẩm trong giỏ hàng
        if (isset($_POST['capnhatsoluong']) && isset($_POST['soluongsp'])) {
            $tensp_can_capnhat = $_POST['tensp'];
            $soluong_moi = intval($_POST['soluongsp']); // Chuyển đổi giá trị thành số nguyên không âm
            if ($soluong_moi > 0) {
                for ($i = 0; $i < sizeof($_SESSION['giohang']); $i++) {
                    if ($_SESSION['giohang'][$i][1] == $tensp_can_capnhat) {
                        $_SESSION['giohang'][$i][3] = $soluong_moi;
                        break;
                    }
                }
            }
        }
          // Tính tổng giá sản phẩm
    $tonggiasp = 0;
    if (isset($_SESSION['giohang']) && (is_array($_SESSION['giohang']))) {
        for ($i = 0; $i < sizeof($_SESSION['giohang']); $i++) {
            $tinhtoan = $_SESSION['giohang'][$i][2] * $_SESSION['giohang'][$i][3];
            $tonggiasp += $tinhtoan;
        }
    }
    function hienthigiohang(){
        if(isset($_SESSION['giohang'])&&(is_array($_SESSION['giohang']))){
           
            for ($i = 0; $i < sizeof($_SESSION['giohang']); $i++) {
                
               
                echo '<tr>';
                echo '<td class="td-1"><img class="hinhsp" src="' . $_SESSION['giohang'][$i][0] . '" alt=""><span class="edit"><p>' . $_SESSION['giohang'][$i][1] . '</p></span></td>';
                echo '<td>' . number_format($_SESSION['giohang'][$i][2] , 0, ',', '.'). '</td>';
                echo '<td><form method="post">';
                echo '<input type="hidden" name="tensp" value="' . $_SESSION['giohang'][$i][1] . '">';
                echo '<input  type="number" name="soluongsp" min="1" value="' . $_SESSION['giohang'][$i][3] . '">';
                echo '<input type="submit" name="capnhatsoluong" class="bt2" value="Cập nhật">';
                echo '</form></td>';
                echo '<td style="text-align: end;"><a href="giohang.php?xoasanpham=' . $_SESSION['giohang'][$i][4] . '"><img src="./admin/icon/removeicon.png" alt="" width="30px" height="30px"></a></td>';
                echo '<td style="text-align: end;color: red;font-weight: bold;">' .  number_format(($_SESSION['giohang'][$i][2] * $_SESSION['giohang'][$i][3]), 0, ',', '.'). ' </td>';
                echo '</tr>';
            }
        }
    }
  
   // Lưu thông tin đơn hàng vào cơ sở dữ liệu
$arrLoi = array();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dathang'])) {
            $tenkhachhang = $_POST['tenkhachhang'];
            $diachi = $_POST['diachi'];
            $sodienthoai = $_POST['sodienthoai'];

            if ($tenkhachhang === "") {
                $arrLoi["err_loi1"] = "Nhập họ tên đi bro";
            }
            if ($diachi === "") {
                $arrLoi["err_loi2"] = "Nhập địa chỉ đi bro";
            }
            if ($sodienthoai === "") {
                $arrLoi["err_loi3"] = "Nhập số điện thoại đi bro";
            }

    if (count($arrLoi) === 0) {
        // Tiến hành lưu thông tin đơn hàng vào cơ sở dữ liệu
        $sql = "INSERT INTO `cart_table` (`user_id`, `namesp`, `quantity_sp`, `price`, `name`, `Address`, `phone_number`,`order_status`)
        VALUES (?, ?, ?, ?, ?, ?, ?,?);
        ";
                
$stmt = $conn->prepare($sql);

        // Bind parameters
        foreach ($_SESSION['giohang'] as $item) {
            $tensp = $item[1];
            $soluong = $item[3];
            $tinhtoan = $item[2] * $item[3];

            $stmt->bind_param("ssissssi", $user_id, $tensp, $soluong, $tinhtoan, $tenkhachhang, $diachi, $sodienthoai,$order_status);


            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>alert('Đặt hàng thành công , cảm ơn bạn đã ủng hộ !.');</script>";
                // Chuyển hướng người dùng trở lại trang trước đó sau một khoảng thời gian ngắn
                unset($_SESSION['giohang']);
                echo "<script>window.location.href = 'giohang.php';</script>";

            } else {
                echo " lỗi {$sql}" . $conn->error;
            }
        }

        

        // Xóa giỏ hàng sau khi đã đặt đơn thành công
         // Chuyển hướng về trang giỏ hàng
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Giỏ Hàng </title>
    <link rel="icon" type="image" href="Goods_for_sale__1_-removebg-preview.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />

    <link rel="stylesheet" href="sstyle.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />
</head>

<body?>
    <div class="menu-btn">
        <i class="fas fa-bars fa-2x"></i>
    </div>

    <div class="container">
        <?php nav();?>
        <!-- muc gio hang  -->
        <div class="giohangsp">

            <!-- gio hang -->
            <div class="container-giohang-1">
                <!-- <h1> Giỏ Hàng </h1> -->
                <table style="border-bottom: 1px solid black;">
                    <tr style="border-bottom: 1px solid black;">
                        <!-- <th>STT</th> -->
                        <th style="text-align:left;">sản phẩm</th>
                        <th>giá</th>
                        <th>số lượng</th>
                        <th style=" width: 50px;"></th>
                        <th style="text-align: end;"> tổng </th>

                    </tr>
                    <?php
                        hienthigiohang();
                        ?>


                </table>
                <div class="dieuhuonggiohang">
                    <a href="products.php?category_id=8"><button class="bt2"> TIẾP TỤC ĐẶT HÀNG </button></a>


                </div>

                <div class="thanhtoan">
                    <h3> THÔNG TIN THANH TOÁN </h3>
                    <form method="post">
                        <input type="text" name="tenkhachhang" value="<?php echo   $_SESSION['user_name']; ?>"
                            required><span
                            style="color: red;"><?php echo isset($arrLoi["err_loi1"]) ? $arrLoi["err_loi1"] : "" ?></span><br>
                        <input type="text" name="diachi" placeholder="ĐỊA CHỈ"><span
                            style="color: red;"><?php echo isset($arrLoi["err_loi2"]) ? $arrLoi["err_loi2"] : "" ?></span><br>
                        <input type="tel" name="sodienthoai" placeholder="SỐ ĐIỆN THOẠI"><span
                            style="color: red;"><?php echo isset($arrLoi["err_loi3"]) ? $arrLoi["err_loi3"] : "" ?></span><br>
                        <span> SÔ TIỀN PHẢI THANH TOÁN LÀ
                            <?php echo  '<span style="color: red;font-weight: bold; "> '. number_format($tonggiasp, 0, ',', '.').' VNĐ</span> '  ; ?></span><br>
                        <input style="margin-top:20px;" type="submit" value="ĐẶT ĐƠN" name="dathang" class="bt2">

                    </form>
                </div>
            </div>

        </div>
    </div>
    </body>

</html>
</body>

</html>
<?php }?>