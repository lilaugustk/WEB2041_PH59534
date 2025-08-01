<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiny Room</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="js/script.js"></script>
</head>

<body>
    <div class="container">
        <?php include 'views/header.php'; ?>
        <div class="box-banner">
            <img src="img/Banner.jpg" alt="" class="banner">
            <div class="head-line">
                <p class="title-banner">Kiến Tạo Không Gian Sống Của Bạn</p>
                <p class="slogan">Hãy để chúng tôi biến căn phòng trong mơ của bạn thành hiện thực</p>
                <div class="button-banner"><a href="about.php">Tìm Hiểu Ngay</a></div>
            </div>
        </div>
        <article>
            <div class="content-title">Tên Danh Mục</div>
            <script>
                var categoryProducts = <?php echo json_encode($listProducts, JSON_UNESCAPED_UNICODE); ?>;
            </script>
            <div class="product-box product-box-tiny" id="category-list"></div>
            <div class="button-more-box" id="category-pagination" style="gap:8px;display:flex;justify-content:center;align-items:center;"></div>
            <div class="button-more-box"><button class="button-more">Khám Phá</button>
            </div>
    </div>
    </article>
    <?php include 'views/footer.php'; ?>
    </div>
</body>


</html>