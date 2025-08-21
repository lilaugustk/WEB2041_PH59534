<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <header>
        <div class="header-bar">
            <div class="logo"><a href="?act=/"><img src="img/Logo.png" alt="notfound"></a></div>
            <ul>
                <li>
                    <a href="?act=/">Trang Chủ</a>
                </li>
                <li>
                    <a href="?act=category">Sản Phẩm</a>
                </li>
                <li>
                    <a href="">Giới Thiệu</a>
                </li>
                <li>
                    <a href="">Liên Hệ</a>
                </li>
            </ul>
            <div class="SCU">
                <a href=""> <img src="img/Search.svg" alt="notfound">
                </a>
                <a href="?act=cart" class="cart-icon">
                    <img src="img/Cart.svg" alt="notfound">
                                    <?php
                // Đảm bảo session đã được bắt đầu
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                if ($cartCount > 0) : ?>
                    <span class="cart-count"><?= $cartCount ?></span>
                <?php endif; ?>
                </a>
                <?php
                // Không cần session_start() lại vì đã gọi ở trên
                ?>
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="user-section">
                        <div class="account">
                            <span>Xin chào, <?php echo htmlspecialchars($_SESSION['user']['user_name']); ?></span>
                            <img src="img/User.svg" alt="notfound">
                        </div>
                        <a href="?act=logout" class="logout-icon" title="Đăng xuất">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9" stroke="#07484a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M16 17L21 12L16 7" stroke="#07484a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M21 12H9" stroke="#07484a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                <?php else: ?>
                    <a href="?act=login" class="account">
                        Đăng Nhập
                        <img src="img/User.svg" alt="notfound">
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>
</body>

</html>