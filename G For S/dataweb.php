<?php
function nav(){
  echo'
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css"
/>
<script src="https://kit.fontawesome.com/aa64dc9752.js" crossorigin="anonymous"></script>
<link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
      crossorigin="anonymous"
    />

<link rel="stylesheet" href="sstyle.css" />
<div class="menu-btn">
  <i class="fas fa-bars fa-2x"></i>
</div>


  <!-- Nav -->
  <nav class="main-nav">
    <img
      src="/Goods_for_sale__1_-removebg-preview.png"
      alt="Goods for sale"
      class="logo"
    />

    <ul class="main-menu">
      <li><a href="index.php">TRANG CHỦ </a></li>
      <li><a href="products.php?category_id=8">SẢN PHẨM</a></li>
      <li><a href="https://www.facebook.com/Tuphuongbatbai2502">LIÊN HỆ</a></li>
      <li><a href="list_posts.php">BÀI VIẾT</a></li>
      <li><a href="#">NGƯỜI DÙNG</a></li>
    </ul>

    <ul class="right-menu">
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
    </li>
    </ul>
  </nav>

  <!-- <script src="script.js"></script> -->
  ';
};



function htmlproduct($product, $categoryName) {
 

  echo '
  
  <link
    rel="stylesheet"
    href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css"
  /><link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"
  />
  <link rel="stylesheet" href="style.css" />
  <div class="card">
    <div class="card-content">
      <div class="top-bar">
        <span>' . number_format($product['price'], 0, ',', '.') . ' VNĐ </span>
        <span class="float-right lnr lnr-heart"></span>
      </div>
      <div class="img" >
        <img src="./admin/' . $product['image_path'] . '" alt="' . $product['product_name'] . '" />
      </div>
    </div>
    <div class=" card-description">
      <div class="title">' . $product['product_name'] . '</div>
      <div class="cart">
        <span class="lnr lnr-cart"></span>
      </div>
    </div>
    <div class="card-footer">
      <div class="span">' . $categoryName . '</div>
      <div class="span">PHONE</div>
    <div class="span">MOBILE</div>
      
    </div>
  </div>';
}


function htmlproduct2($product, $categoryName) {
  // Xây dựng đường liên kết đến trang chi tiết sản phẩm
  $productDetailLink = 'product_detail.php?product_id=' . $product['product_id'];

  echo '
 
  <link
    rel="stylesheet"
    href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css"
  /><link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"
  />
  <link rel="stylesheet" href="style.css" />
  <div class="card">
    <div class="card-content">
      <div class="top-bar">
        <span>' . number_format($product['price'], 0, ',', '.') . ' VNĐ </span>
        <span class="float-right lnr lnr-heart"></span>
      </div>
      <div class="img">
        <a href="' . $productDetailLink . '">
          <img src="./admin/' . $product['image_path'] . '" alt="' . $product['product_name'] . '" />
        </a>
      </div>
    </div>
    <div class=" card-description">
      <div class="title">
        <a href="' . $productDetailLink . '">' . $product['product_name'] . '</a>
      </div>
      <div class="cart">
        <span class="lnr lnr-cart"></span>
      </div>
    </div>
    <div class="card-footer">
      <div class="span">' . $categoryName . '</div>
      <div class="span">PHONE</div>
      <div class="span">MOBILE</div>
    </div>
  </div>';
}
function css(){
  echo '
<link
  rel="stylesheet"
  href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css"
/><link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"
/>
<link rel="stylesheet" href="style.css" />';

};

?>