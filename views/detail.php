<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiny Room</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include 'views/layouts/header.php'; ?>
    <div class="detail-box">
        <div class="detail-left">
            <img src="img/Banner.jpg" alt="notfound">
        </div>
        <div class="detail-right">
            <p class="detail-title">Tên sản phẩm</p>
            <div class="detail-price">
                <p>Giá: </p>
                <p class="price-value"></p>
            </div>
            <div class="detail-quantity">
                <p>Số lượng: </p>
                <p> sản phẩm</p>
            </div>
            <div class="detail-description">Mô tả: </div>
            <button class="add-cart-btn">Thêm vào giỏ hàng</button>
        </div>
    </div>





    <?php include 'views/layouts/footer.php'; ?>
</body>

</html>