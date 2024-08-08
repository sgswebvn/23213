<?php
session_start();
 include "./admin/function.php"; ?>
<?php include 'dataweb.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Goods For Sale</title>
    <link rel="icon" type="image" href="Goods_for_sale__1_-removebg-preview.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/aa64dc9752.js" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />
    <link rel="stylesheet" href="sstyle.css" />
    <link rel="stylesheet" href="./admin/css/main.css" />

</head>

<body>

    <div class="menu-btn">
        <i class="fas fa-bars fa-2x"></i>
    </div>

    <div class="container">
        <?php
if (checklogin() == true) {
    echo '<button onclick="location.href=\'admin/user_details.php\'" style="position: fixed; right: 10px; " class="addsend">ADMIN</button>';
}
?>


        <!-- Nav -->
        <nav class="main-nav">
            <img src="/Goods_for_sale__1_-removebg-preview.png" alt="Goods for sale" class="logo" />

            <ul class="main-menu">
                <li><a href="index.php">TRANG CHỦ </a></li>
                <li><a href="products.php?category_id=8">SẢN PHẨM</a></li>
                <li><a href="https://www.facebook.com/Tuphuongbatbai2502">LIÊN HỆ</a></li>
                <li><a href="list_posts.php">BÀI VIẾT</a></li>
                <li><a href="user_details.php">NGƯỜI DÙNG</a></li>

            </ul>

            <ul class="right-menu">
                <?php
    if (isset($_SESSION['user_id'])) {
        // Nếu đã đăng nhập, hiển thị thông tin người dùng
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];
        $user_image = $_SESSION['profile_image'];
    

               echo '
                
                <li>
                <i style="color: #d68e10;">Xin chào,  '.$user_name.'</i>
                   
                </li>
                <li><i><img src="./admin/'.$user_image.'" alt="Ảnh đại diện của bạn" style="width: 20px;
                height: 20px;
                border-radius: 100%;"></i></li>
                <li>
                <a href="#">
                    <i class="fas fa-search"></i>
                </a>
            </li>
            <li>
                <a href="giohang.php">
                    <i class="fas fa-shopping-cart"></i>
                </a>
            </li>
                <li>
                    <a href="./admin/logout.php">
                        <i class="fa-solid fa-right-to-bracket" style="color: #666;"></i>
                    </a>
                </li>';
                } else { ?>

                <li>
                    <a href="#">
                        <i class="fas fa-search"></i>
                    </a>
                </li>
                <li>
                    <a href="giohang.php">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </li>
                <?php echo ' <li>
                    <a href="./admin/login.php">
                        <i class="fa-solid fa-right-to-bracket" style="color: #666;"></i>
                    </a>
                </li>';
                ?>
                <?php } ?>
            </ul>

        </nav>

        <!-- Showcase -->
        <header class="showcase">
            <h2>Surface Deals</h2>
            <p>Select Surfaces are on sale now - save while supplies last</p>
            <a href="#" class="btn">
                Shop Now <i class="fas fa-chevron-right"></i>
            </a>
        </header>

        <!-- Home cards 1 -->

        <section>
            <div id="carouselExampleControls" class="carousel carousel-dark slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="home-cards">
                            <!-- phan hien thi san pham  -->
                            <?php 
                                $categoryDao = new CategoryDao();
                                $categoryId = 8; // Thay đổi thành ID của danh mục bạn muốn lấy

                                $firstFourProducts = $categoryDao->getFirstFourProductsByCategoryId($categoryId);

                                // Lấy thông tin danh mục dựa trên category_id
                                $category = $categoryDao->getCategoryById($categoryId);
                                $categoryName = ($category) ? $category['category_name'] : "Danh mục không tồn tại";

                                foreach ($firstFourProducts as $product) :
                                    htmlproduct2($product, $categoryName);
                                endforeach;
                                ?>


                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="home-cards">
                            <?php 
                                $categoryDao = new CategoryDao();
                                $categoryId = 10; // Thay đổi thành ID của danh mục bạn muốn lấy

                                $firstFourProducts = $categoryDao->getFirstFourProductsByCategoryId($categoryId);

                                // Lấy thông tin danh mục dựa trên category_id
                                $category = $categoryDao->getCategoryById($categoryId);
                                $categoryName = ($category) ? $category['category_name'] : "Danh mục không tồn tại";

                                foreach ($firstFourProducts as $product) :
                                    htmlproduct2($product, $categoryName);
                                endforeach;
                                ?>

                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="home-cards">
                            <?php 
                                $categoryDao = new CategoryDao();
                                $categoryId = 11; // Thay đổi thành ID của danh mục bạn muốn lấy

                                $firstFourProducts = $categoryDao->getFirstFourProductsByCategoryId($categoryId);

                                // Lấy thông tin danh mục dựa trên category_id
                                $category = $categoryDao->getCategoryById($categoryId);
                                $categoryName = ($category) ? $category['category_name'] : "Danh mục không tồn tại";

                                foreach ($firstFourProducts as $product) :
                                    htmlproduct2($product, $categoryName);
                                endforeach;
                                ?>
                        </div>
                    </div>

                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

        <!-- Carbon -->
        <section class="carbon dark">
            <div class="content">
                <h2>Welcome to G for S shop!</h2>
                <p>
                    Message the shop owner to receive a discount code !
                </p>
                <a href="https://www.facebook.com/Tuphuongbatbai2502" class="btn">

                    Receive code <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </section>

        <!-- Follow -->
        <section class="follow">
            <p>Follow Microsoft</p>
            <a href="https://facebook.com">
                <img src="https://i.ibb.co/LrVMXNR/social-fb.png" alt="Facebook" />
            </a>
            <a href="https://twitter.com">
                <img src="https://i.ibb.co/vJvbLwm/social-twitter.png" alt="Twitter" />
            </a>
            <a href="https://linkedin.com">
                <img src="https://i.ibb.co/b30HMhR/social-linkedin.png" alt="Linkedin" />
            </a>
        </section>
        <!-- Home cards 2 -->
        <section>

            <div class="home-cards">
                <?php
$postDao = new PostDao();

$posts = $postDao->getFirstFourPosts();

if (!empty($posts)) {
    foreach ($posts as $post) {
        echo '<div>';
        echo '<img src="./admin/' . $post['thumbnail'] . '" alt="' . $post['title'] . ' width="50px" height="200px" />';
        echo '<h3>' . $post['title'] . '</h3>';
        
        echo '<a href="post_detail.php?post_id=' . $post['post_id'] . '">Learn More <i class="fas fa-chevron-right"></i></a>';
        echo '</div>';
        
    }
}
?>








        </section>
    </div>
    <!-- Links -->
    <section class="links">
        <div class="links-inner">
            <ul>
                <li>
                    <h3>What's New</h3>
                </li>
                <li><a href="#">Surface Pro X</a></li>
                <li><a href="#">Surface Laptop 3</a></li>
                <li><a href="#">Surface Pro 7</a></li>
                <li><a href="#">Windows 10 apps</a></li>
                <li><a href="#">Office apps</a></li>
            </ul>
            <ul>
                <li>
                    <h3>Microsoft Store</h3>
                </li>
                <li><a href="#">Account Profile</a></li>
                <li><a href="#">Download Center</a></li>
                <li><a href="#">Microsoft Store support</a></li>
                <li><a href="#">Returns</a></li>
                <li><a href="#">Older tracking</a></li>
            </ul>
            <ul>
                <li>
                    <h3>Education</h3>
                </li>
                <li><a href="#">Microsfot in education</a></li>
                <li><a href="#">Office for students</a></li>
                <li><a href="#">Office 365 for schools</a></li>
                <li><a href="#">Deals for studentss</a></li>
                <li><a href="#">Microsfot Azure</a></li>
            </ul>
            <ul>
                <li>
                    <h3>Enterprise</h3>
                </li>
                <li><a href="#">Azure</a></li>
                <li><a href="#">AppSource</a></li>
                <li><a href="#">Automotive</a></li>
                <li><a href="#">Government</a></li>
                <li><a href="#">Healthcare</a></li>
            </ul>
            <ul>
                <li>
                    <h3>Developer</h3>
                </li>
                <li><a href="#">Visual Studio</a></li>
                <li><a href="#">Windowszs Dev Center</a></li>
                <li><a href="#">Developer Network</a></li>
                <li><a href="#">TechNet</a></li>
                <li><a href="#">Microsoft Developer</a></li>
            </ul>
            <ul>
                <li>
                    <h3>Company</h3>
                </li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">About Microsoft</a></li>
                <li><a href="#">Company news</a></li>
                <li><a href="#">Privacy at Microsoft</a></li>
                <li><a href="#">Inverstors</a></li>
            </ul>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-inner">
            <div><i class="fas fa-globe fa-2x"></i> English (United States)</div>
            <ul>
                <li><a href="#">Sitemap</a></li>
                <li><a href="#">Contact Microsoft</a></li>
                <li><a href="#">Privacy & cookies</a></li>
                <li><a href="#">Terms of use</a></li>
                <li><a href="#">Trademarks</a></li>
                <li><a href="#">Safety & eco</a></li>
                <li><a href="#">About our ads</a></li>
                <li><a href="#">&copy; Microsoft 2020</a></li>
            </ul>
        </div>
    </footer>
</body>
<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
</script>

</html>