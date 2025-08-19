<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng - Tiny Room</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="js/script.js" defer></script>
</head>

<body>
    <?php include 'views/layouts/header.php'; ?>

    <div class="container cart-container">
        <h1 class="cart-title">Giỏ Hàng Của Bạn</h1>

        <?php if (empty($cart)) : ?>
            <div class="cart-empty">
                <div class="empty-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3>Giỏ hàng của bạn đang trống</h3>
                <p>Hãy khám phá các sản phẩm tuyệt vời của chúng tôi</p>
                <a href="?act=category" class="button-detail">Tiếp tục mua sắm</a>
            </div>
        <?php else : ?>
            <div class="cart-content">
                <div class="cart-items">
                    <div class="cart-header">
                        <h2><i class="fas fa-shopping-bag"></i> Sản phẩm trong giỏ hàng</h2>
                    </div>
                    
                    <form action="?act=update-cart" method="POST">
                        <div class="cart-table-wrapper">
                            <table class="cart-table">
                                <thead>
                                    <tr>
                                        <th class="product-col">Sản phẩm</th>
                                        <th class="price-col">Giá</th>
                                        <th class="quantity-col">Số lượng</th>
                                        <th class="subtotal-col">Tạm tính</th>
                                        <th class="action-col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $subtotal = 0;
                                    foreach ($cart as $productId => $item) :
                                        $item_total = $item['price'] * $item['quantity'];
                                        $subtotal += $item_total;
                                    ?>
                                        <tr class="cart-item-row">
                                            <td class="product-info">
                                                <div class="product-image">
                                                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                                                </div>
                                                <div class="product-details">
                                                    <a href="?act=detailProduct&id=<?= $productId ?>" class="product-name"><?= htmlspecialchars($item['product_name']) ?></a>
                                                    <div class="product-category">Nội thất</div>
                                                </div>
                                            </td>
                                            <td class="product-price">
                                                <span class="price-value"><?= number_format($item['price']) ?> VNĐ</span>
                                            </td>
                                            <td class="product-quantity">
                                                <div class="quantity-stepper">
                                                    <button type="button" class="quantity-btn quantity-down" data-action="decrease" data-product="<?= $productId ?>">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" name="quantity[<?= $productId ?>]" value="<?= $item['quantity'] ?>" min="1" max="<?= htmlspecialchars($item['max_quantity']) ?>" class="quantity-input" data-product="<?= $productId ?>" readonly>
                                                    <button type="button" class="quantity-btn quantity-up" data-action="increase" data-product="<?= $productId ?>">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                <?php if (isset($cartErrors[$productId])) : ?>
                                                    <small class="error-message"><?= htmlspecialchars($cartErrors[$productId]) ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="product-subtotal">
                                                <span class="subtotal-value"><?= number_format($item_total) ?> VNĐ</span>
                                            </td>
                                            <td class="product-remove">
                                                <a href="?act=remove-from-cart&id=<?= $productId ?>" class="remove-btn" title="Xóa sản phẩm" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="cart-actions">
                            <a href="?act=category" class="button-secondary">
                                <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                            </a>
                            <button type="submit" class="button-primary">
                                <i class="fas fa-sync-alt"></i> Cập nhật giỏ hàng
                            </button>
                        </div>
                    </form>
                </div>

                <div class="cart-summary">
                    <div class="summary-header">
                        <h2><i class="fas fa-calculator"></i> Tổng cộng giỏ hàng</h2>
                    </div>
                    
                    <div class="summary-content">
                        <div class="summary-item">
                            <span class="summary-label">Tạm tính</span>
                            <span class="summary-value"><?= number_format($subtotal) ?> VNĐ</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Phí vận chuyển</span>
                            <span class="summary-value">Miễn phí</span>
                        </div>
                        <div class="summary-divider"></div>
                        <div class="summary-total">
                            <span class="total-label">Tổng cộng</span>
                            <span class="total-price"><?= number_format($subtotal) ?> VNĐ</span>
                        </div>
                    </div>
                    
                    <div class="summary-actions">
                        <a href="?act=checkout" class="button-checkout">
                            <i class="fas fa-credit-card"></i> Tiến hành thanh toán
                        </a>
                        <div class="secure-checkout">
                            <i class="fas fa-shield-alt"></i>
                            <span>Thanh toán an toàn & bảo mật</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'views/layouts/footer.php'; ?>
</body>

</html>