<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiny Room</title>
</head>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
<link rel="stylesheet" href="styles/style.css">

<script src="js/script.js"></script>

<body>
    <div class="container">
        <?php include 'views/layouts/header.php'; ?>
        <!-- Banner -->
        <div class="box-banner">
            <img src="img/Banner.jpg" alt="" class="banner">
            <div class="head-line">
                <p class="title-banner">Kiến Tạo Không Gian Sống Của Bạn</p>
                <p class="slogan">Hãy để chúng tôi biến căn phòng trong mơ của bạn thành hiện thực</p>
                <div class="button-banner"><a href="about.php">Tìm Hiểu Ngay</a></div>
            </div>
        </div>
        <!-- Banner -->
        <article>
            <!-- Sản Phẩm Hot -->
            <div class="content-title">Sản Phẩm Hot</div>
            <div class="product-box" id="product-slideshow">
                <?php foreach ($hotListProducts as $index => $hotProduct) { ?>
                    <div class="content-item slide-item" data-index="<?= $index ?>">
                        <img src="img/Banner.jpg" alt="notfound">
                        <p class="name"><?= $hotProduct["product_name"] ?></p>
                        <span class="price">
                            <p>Giá:</p>
                            <p class="price-value"><?= number_format($hotProduct["price"]) ?> VNĐ</p>
                        </span>
                    </div>
                <?php } ?>
            </div>
            <div class="slider-button-box">
                <button id="slide-prev" class="button-prev btn-slide"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                        <path d="M73.4 297.4C60.9 309.9 60.9 330.2 73.4 342.7L233.4 502.7C245.9 515.2 266.2 515.2 278.7 502.7C291.2 490.2 291.2 469.9 278.7 457.4L173.3 352L544 352C561.7 352 576 337.7 576 320C576 302.3 561.7 288 544 288L173.3 288L278.7 182.6C291.2 170.1 291.2 149.8 278.7 137.3C266.2 124.8 245.9 124.8 233.4 137.3L73.4 297.3z" />
                    </svg></button>
                <button id="slide-next" class="button-next btn-slide"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                        <path d="M566.6 342.6C579.1 330.1 579.1 309.8 566.6 297.3L406.6 137.3C394.1 124.8 373.8 124.8 361.3 137.3C348.8 149.8 348.8 170.1 361.3 182.6L466.7 288L96 288C78.3 288 64 302.3 64 320C64 337.7 78.3 352 96 352L466.7 352L361.3 457.4C348.8 469.9 348.8 490.2 361.3 502.7C373.8 515.2 394.1 515.2 406.6 502.7L566.6 342.7z" />
                    </svg></button>
            </div>
            <div class="button-more-box"><a href="?act=category"><button class="button-more">Khám Phá</button></a>
            </div>
            <!-- Sản Phẩm Hot -->

            <!-- Sản Phẩm Tiny Room -->
            <div class="content-title">Sản Phẩm Tiny Room</div>
            <div class="product-box product-box-tiny">
                <?php foreach ($listProducts as $index => $product) {
                    if ($index >= 9) break; ?>
                    <div class="content-item" data-index="<?= $index ?>">
                        <img src="img/Banner.jpg" alt="notfound">
                        <p class="name"><?= $product["product_name"] ?></p>
                        <span class="price">
                            <p>Giá:</p>
                            <p class="price-value"><?= number_format($product["price"]) ?> VNĐ</p>
                        </span>
                    </div>
                <?php } ?>
            </div>
            <div class="button-more-box"><a href="?act=category"><button class="button-more">Khám Phá</button></a>
            </div>
            <!-- Sản Phẩm Tiny Room -->

        </article>
    </div>

    <?php include 'views/new-letter.php'; ?>
    <?php include 'views/layouts/footer.php'; ?>
    </div>
</body>

</html>