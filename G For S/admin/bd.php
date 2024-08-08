<?php include "header.php";
 ?>

<script src="https://kit.fontawesome.com/aa64dc9752.js" crossorigin="anonymous"></script>

<section class="wrapper">
    <!--state overview start-->
    <div class="row state-overview">
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol terques">
                    <i class="fa fa-user"></i>
                </div>
                <div class="value">
                    <h1 class="count">
                        <?php 
                        $userDao = new UserDao();
                        $totalUsers = $userDao->getTotalUsers(); 
                        echo  $totalUsers;?>
                    </h1>
                    <p>Users</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol red">
                    <i class="fa fa-tags"></i>
                </div>
                <div class="value">
                    <h1 class="count2"><?php 
                    $productDAO = new CategoryDao();
                    $totalQuantity = $productDAO->calculateTotalQuantity();
                    echo   $totalQuantity;
                    ?></h1>
                    <p>All product</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol yellow">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="value">
                    <h1 class="count3"><?php 
                    $orderDao = new OrderDao();
                    $sentOrdersCount = $orderDao->getTotalSentOrders();
                    echo $sentOrdersCount;
                    ?></h1>
                    <p>ALL Order</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol blue">
                    <i class="fa-solid fa-comment" style="color: #ffffff;"></i>
                </div>
                <div class="value">
                    <h1 class="count3"><?php 
                    $commentDAO = new CommentDAO();
                    
$total_comments =  $commentDAO->countTotalCommentsForAllProducts();
                    echo $total_comments;
                    ?></h1>
                    <p>ALL Comment</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol blue">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="value">
                    <h1 class="count4">0</h1>
                    <p>Total Profit</p>
                </div>
            </section>

        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol terques">
                    <i class="fa-solid fa-filter " style="color: #ffffff;"></i>
                </div>
                <div class="value">
                    <h1 class="count">
                        <?php 
                        $categoryDAO = new CategoryDAO();

                        $totalCategories = $categoryDAO->countTotalCategories();
                        echo  $totalCategories;
                        ?>
                    </h1>
                    <p>Category</p>
                </div>
            </section>
        </div>
        <!--state overview end-->

        <div class="row">
            <div class="col-lg-8">
                <!--custom chart start-->
                <div class="border-head">

                </div>

                <!--custom chart end-->
            </div>

            <!--user info table end-->
        </div>
        <div class="col-lg-8">
            <!--work progress start-->
            <section class="panel">
                <div class="panel-body progress-panel">
                    <div class="task-progress">
                        <h1>list user</h1>
                        <p>Anjelina Joli</p>
                    </div>

                </div>
                <table class="table table-hover personal-task">
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Lê Phước Nguyên</td>
                            <td>
                                <span class="badge bg-important">75%</span>
                            </td>
                            <td>
                                <div id="work-progress1"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Nguyễn Quang Cường</td>
                            <td>
                                <span class="badge bg-success">43%</span>
                            </td>
                            <td>
                                <div id="work-progress2"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Payment Collection</td>
                            <td>
                                <span class="badge bg-info">67%</span>
                            </td>
                            <td>
                                <div id="work-progress3"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Work Progress</td>
                            <td>
                                <span class="badge bg-warning">30%</span>
                            </td>
                            <td>
                                <div id="work-progress4"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Delivery Pending</td>
                            <td>
                                <span class="badge bg-primary">15%</span>
                            </td>
                            <td>
                                <div id="work-progress5"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </section>
            <!--work progress end-->

        </div>

    </div>


</section>
<!--main content end-->

<!-- Right Slidebar start -->