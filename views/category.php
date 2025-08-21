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
        <?php include 'views/layouts/header.php'; ?>
        <div class="box-banner">
            <img src="img/Banner.jpg" alt="" class="banner">
            <div class="head-line">
                <p class="title-banner">Kiến Tạo Không Gian Sống Của Bạn</p>
                <p class="slogan">Hãy để chúng tôi biến căn phòng trong mơ của bạn thành hiện thực</p>
                <div class="button-banner"><a href="about.php">Tìm Hiểu Ngay</a></div>
            </div>
        </div>
        <nav>
            <div class="category-nav">
                <ul>
                    <li>
                        <a href="?act=category#product-list" class="<?= !$categoryId ? 'active' : '' ?>">Tất Cả Sản Phẩm</a>
                    </li>
                    <?php foreach ($listCategories as $category) : ?>
                        <li>
                            <a href="?act=category&id=<?= htmlspecialchars($category['category_id']) ?>#product-list" class="<?= ($categoryId == $category['category_id']) ? 'active' : '' ?>">
                                <?= htmlspecialchars($category['category_name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
        <article id="product-list">
            <div class="content-title"> <?= htmlspecialchars($categoryName) ?> </div>
            <div class="product-box product-box-tiny">
                <?php if (!empty($listProducts)) : ?>
                    <?php foreach ($listProducts as $product) : ?>
                        <div class="content-item">
                            <img src="<?= htmlspecialchars($product["image"]) ?>" alt="<?= htmlspecialchars($product["product_name"]) ?>">
                            <p class="name"><?= htmlspecialchars($product["product_name"]) ?></p>
                            <span class="price">
                                <p>Giá:</p>
                                <p class="price-value"><?= number_format($product["price"]) ?> VNĐ</p>
                            </span>
                            <a href="?act=detailProduct&id=<?= $product["product_id"] ?>" class="button-detail">Xem chi tiết</a>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p style="text-align: center; padding: 40px; color: #6c757d;">Không có sản phẩm nào trong danh mục này.</p>
                <?php endif; ?>
            </div>
        </article>
        <?php include 'views/layouts/footer.php'; ?>
    </div>
</body>

</html>