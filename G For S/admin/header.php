<?php
session_start();
require_once "function.php";
if (checklogin()==false){  header('Location: login.php'); exit(); }
$addFailure = false;
$addSuccess = false;
?>



<link href="./css/bootstrap.min.css" rel="stylesheet" />

<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<script src="https://kit.fontawesome.com/aa64dc9752.js" crossorigin="anonymous"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>

<link href="./css/style.css" rel="stylesheet" />
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/super-build/ckeditor.js"></script> -->

<!-- <script>
ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });
</script> -->


<body>
    <section id="container">
        <!--header start-->
        <header class="header white-bg">
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <!--logo start-->
            <a href="/index.php" class="logo">G FoR <span>S</span></a>
            <!--logo end-->

            <div class="top-nav">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="" src="<?php echo  $_SESSION['profile_image'] ;?>" width="50px" height=" 24px" />
                            <span class="username"><?php echo   $_SESSION['user_name'];?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li>
                                <a href="user_details.php"><i class="fa fa-suitcase"></i>Profile</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-cog"></i> Settings</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-bell-o"></i> Notification</a>
                            </li>
                            <li>
                                <a href="logout.php"><i class="fa fa-key"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>

                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>
        <!--header end-->
        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu" id="nav-accordion">
                    <li>
                        <a class="active" href="bd.php">
                            <i class="fa fa-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Bài viết</span>
                        </a>
                        <ul class="sub">
                            <li><a href="add_post.php">Thêm bài viết</a></li>
                            <li><a href="show_post.php">Quản lý bài viết</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-tasks"></i>
                            <span>Danh mục</span>
                        </a>
                        <ul class="sub">
                            <li><a href="add_categories.php">Thêm danh mục</a></li>
                            <li>
                                <a href="show_categoris.php">Quản lý danh mục</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-th"></i>
                            <span>Sản phẩm</span>
                        </a>
                        <ul class="sub">
                            <li><a href="add_prodcutdemo.php">Thêm sản phẩm</a></li>
                            <li><a href="show_products.php">Quản lý sản phẩm</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-envelope"></i>
                            <span>Mail</span>
                        </a>
                        <ul class="sub">
                            <li><a href="inbox.html">Inbox</a></li>
                            <li><a href="inbox_details.html">Inbox Details</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-shopping-cart"></i>
                            <span>Giỏ hàng</span>
                        </a>
                        <ul class="sub">
                            <li><a href="show_ordered.php">Danh sách đặt hàng</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-comments-o"></i>
                            <span>Bình luận</span>
                        </a>
                        <ul class="sub">
                            <li><a href="cmt_products.php"> Bình luận sản phẩm</a></li>
                            <li><a href="cmt_post.php"> Bình luận bài viết</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="show_user.php">
                            <i class="fa fa-user"></i>
                            <span>Người Dùng</span>
                        </a>
                    </li>

                    <!--multi level menu start-->

                    <!--multi level menu end-->
                </ul>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <section id="main-content">
            <section class="wrapper">
                <!--state overview start-->


                <div class="row">

                    <!--user info table start-->
                    <section class="panel">
                        <div class="panel-body">



                            <script src="./js/jquery.js"></script>
                            <script src="./js/bootstrap.min.js"></script>
                            <script class="include" type="text/javascript" src="./js/jquery.dcjqaccordion.2.7.js">
                            </script>
                            <script src="./js/jquery.scrollTo.min.js"></script>
                            >
                            <script src="./js/common-scripts.js"></script>


                            <script>
                            $(document).ready(function() {
                                $("#owl-demo").owlCarousel({
                                    navigation: true,
                                    slideSpeed: 300,
                                    paginationSpeed: 400,
                                    singleItem: true,
                                    autoPlay: true,
                                });
                            });



                            $(function() {
                                $("select.styled").customSelect();
                            });
                            </script>
</body>

<!-- Mirrored from thevectorlab.net/flatlab/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 Aug 2015 03:43:32 GMT -->

</html>