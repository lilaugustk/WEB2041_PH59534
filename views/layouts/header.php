<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
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
                <a href="">
                    <img src="img/Cart.svg" alt="notfound">
                </a>
                <?php
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                ?>
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="user-menu">
                        <a href="#" class="account">
                            Xin chào, <?php echo htmlspecialchars($_SESSION['user']['user_name']); ?>
                            <img src="img/User.svg" alt="notfound">
                        </a>
                        <div class="dropdown-menu">
                            <a href="?act=logout">Đăng xuất</a>
                        </div>
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