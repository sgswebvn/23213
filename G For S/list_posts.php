<?php include "./admin/function.php";
include "dataweb.php";?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bài viết </title>
    <link rel="icon" type="image" href="Goods_for_sale__1_-removebg-preview.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />

    <link rel="stylesheet" href="sstyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />
</head>

<body?>
    <div class="menu-btn">
        <i class="fas fa-bars fa-2x"></i>
    </div>

    <div class="container">
        <?php nav();
            ?>

        <h5 style="padding-left:10px; 
        padding-top: 30px;
    padding-bottom: 30px;"> Bài viết </h5>
        <?php 


$postDao = new PostDao();
$posts = $postDao->getAllPosts();
foreach( $posts as $post ){
    echo '
    <div class="ckpost">
    <div class="post">
            <a href="post_detail.php?post_id=' . $post['post_id'] . '">
                <img src="./admin/' . $post['thumbnail'] . '" alt="' . $post['title'] . '" width="200x" height="200px">
                
                
            </a>

            <div class="rs">
           <a href="post_detail.php?post_id=' . $post['post_id'] . '"> <h2>' . $post['title'] . '</h2></a>
            <p>' . $post['description'] . '</p>
            </div>
          </div>
          </div>'
    ;
}
?>
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
    </div>
    </body>

</html>