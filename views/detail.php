<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($detailProduct['product_name']) ?> - Tiny Room</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include 'views/layouts/header.php'; ?>
    <div class="detail-box">
        <div class="detail-left">
            <img src="<?= htmlspecialchars(!empty($detailProduct['image']) ? $detailProduct['image'] : 'img/placeholder.jpg') ?>" alt="<?= htmlspecialchars($detailProduct['product_name']) ?>">
        </div>
        <div class="detail-right">
            <p class="detail-title"><?= htmlspecialchars($detailProduct['product_name']) ?></p>
            <div class="detail-price">
                <p>Giá:</p>
                <p class="price-value"><?= number_format($detailProduct['price']) ?> VNĐ</p>
            </div>
            <div class="detail-quantity">
                <p>Số lượng còn lại:</p>
                <p> <?= htmlspecialchars($detailProduct['quantity']) ?> sản phẩm</p>
            </div>
            <div class="detail-description">
                <strong>Mô tả:</strong>
                <p><?= nl2br(htmlspecialchars($detailProduct['description'])) ?></p>
            </div>
            <button class="add-cart-btn">Thêm vào giỏ hàng</button>
        </div>
    </div>

    <div class="comment-section">
        <h3>Bình luận & Đánh giá</h3>

        <!-- Form to add a new comment -->
        <div class="add-comment-box">
            <?php if (isset($_SESSION['user'])) : ?>
                <form action="?act=add-comment" method="POST">
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
                            <p class="comment-author"><?= htmlspecialchars($comment['user_name']) ?></p>
                            <p class="comment-date"><?= date('H:i, d/m/Y', strtotime($comment['date'])) ?></p>
                            <p class="comment-text"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else : ?>
                <li style="text-align: center; color: #6c757d; list-style: none; padding: 20px;">Chưa có bình luận nào cho sản phẩm này. Hãy là người đầu tiên!</li>
            <?php endif; ?>
        </ul>
    </div>


    <?php include 'views/layouts/footer.php'; ?>
</body>

</html>