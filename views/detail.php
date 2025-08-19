<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($detailProduct['product_name']) ?> - Tiny Room</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>

</head>

<body>
    <?php include 'views/layouts/header.php'; ?>
    <div class="detail-box">
        <div class="detail-left">
            <img src="<?= htmlspecialchars(!empty($detailProduct['image']) ? $detailProduct['image'] : 'img/placeholder.jpg') ?>" alt="<?= htmlspecialchars($detailProduct['product_name']) ?>">
        </div>
        <div class="detail-right">
            <p class="detail-title"><?= htmlspecialchars($detailProduct['product_name']) ?></p>
            <p class="detail-price">
                Giá: <span class="price-value"><?= number_format($detailProduct['price']) ?> VNĐ</span>
            </p>

            <div class="detail-info-group">
                <div class="detail-quantity">
                    <p><strong>Số lượng còn lại:</strong> <?= htmlspecialchars($detailProduct['quantity']) ?> sản phẩm</p>
                </div>

                <div class="detail-description">
                    <div class="detail-category">
                        <strong>Mô Tả</strong>
                        <p><?= htmlspecialchars($detailProduct['category_name']) ?></p>
                    </div>
                    <p><?= nl2br(htmlspecialchars($detailProduct['description'])) ?></p>
                </div>
            </div>

            <form action="?act=add-to-cart" method="POST" class="add-to-cart-form">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($detailProduct['product_id']) ?>">
                <input type="hidden" name="product_name" value="<?= htmlspecialchars($detailProduct['product_name']) ?>">
                <input type="hidden" name="price" value="<?= htmlspecialchars($detailProduct['price']) ?>">
                <input type="hidden" name="image" value="<?= htmlspecialchars($detailProduct['image']) ?>">

                <div class="quantity-selector">
                    <label for="quantity">Số lượng:</label>
                    <div class="quantity-stepper">
                        <button type="button" class="quantity-down">-</button>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= htmlspecialchars($detailProduct['quantity']) ?>" class="quantity-input" readonly>
                        <button type="button" class="quantity-up">+</button>
                    </div>
                </div>

                <button type="submit" class="add-cart-btn">Thêm vào giỏ hàng</button>
            </form>
        </div>
    </div>

    <div class="comment-section">
        <h3>Bình luận & Đánh giá</h3>

        <!-- Form to add a new comment -->
        <div class="add-comment-box">
            <?php if (isset($_SESSION['user'])) : ?>
                <form action="?act=post-comment" method="POST">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($detailProduct['product_id']) ?>">
                    <textarea name="content" placeholder="Viết đánh giá của bạn..." required></textarea>
                    <button type="submit">Gửi bình luận</button>
                </form>
            <?php else : ?>
                <p style="text-align: center; padding: 20px; background-color: #f8f9fa; border-radius: 8px;">
                    Vui lòng <a href="?act=login" style="color: #07484a; font-weight: bold;">đăng nhập</a> để bình luận.
                </p>
            <?php endif; ?>
        </div>

        <!-- Đổ ra danh sách bình luận và người bình luận -->
        <ul class="comment-list">
            <?php if (!empty($listComment)) : ?>
                <?php foreach ($listComment as $comment) : ?>
                    <li class="comment-item">
                        <div class="comment-avatar">
                            <img src="<?= htmlspecialchars(!empty($comment['avatar']) ? $comment['avatar'] : 'img/User.svg') ?>" alt="Avatar của <?= htmlspecialchars($comment['user_name']) ?>">
                        </div>
                        <div class="comment-content">
                            <div class="comment-header">
                                <p class="comment-author"><?= htmlspecialchars($comment['user_name']) ?></p>
                                <p class="comment-date"><?= date('H:i, d/m/Y', strtotime($comment['date'])) ?></p>
                            </div>
                            <div class="comment-text"><?= nl2br(htmlspecialchars($comment['content'])) ?></div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <li style="text-align: center; color: #6c757d; list-style: none; padding: 20px;">Chưa có bình luận nào cho sản phẩm này. Hãy là người đầu tiên!</li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Sản Phẩm Hot -->
    <div class="content-title">Sản Phẩm Hot</div>
    <div class="product-box" id="product-slideshow">
        <?php foreach ($hotListProducts as $index => $hotProduct) { ?>
            <div class="content-item slide-item" data-index="<?= $index ?>">
                <img src="<?= $hotProduct["image"] ?>" alt="notfound">
                <p class="name"><?= $hotProduct["product_name"] ?></p>
                <span class="price">
                    <p>Giá:</p>
                    <p class="price-value"><?= number_format($hotProduct["price"]) ?> VNĐ</p>
                </span>
                <a href="?act=detailProduct&id=<?= $hotProduct["product_id"] ?>" class="button-detail">Xem chi tiết</a>
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

    <?php include 'views/layouts/footer.php'; ?>
</body>

</html>