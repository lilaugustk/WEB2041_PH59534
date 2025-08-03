<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
</head>

<body>
    <?php include 'views/layouts/header.php'; ?>
    <div class="form-main-box">
        <div class="form-left-box">
            <img src="img/Banner 2nd.jpg" alt="">
        </div>
        <div class="form-right-box">
            <form action="?act=login" method="POST">
                <h2>Đăng Nhập</h2>
                
                <!-- Hiển thị lỗi -->
                <?php if (isset($errors) && !empty($errors)): ?>
                    <div class="error-messages">
                        <?php foreach ($errors as $error): ?>
                            <p class="error"><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <!-- <label for="user_name">Tên đăng nhập:</label> -->
                <input type="email" id="email" name="email" placeholder="Vui lòng nhập email" required>

                <!-- <label for="password">Mật khẩu:</label> -->
                <input type="password" id="password" name="password" placeholder="Vui lòng nhập mật khẩu" required>

                <button class="submit-button" type="submit">Đăng Nhập</button>
                <div class="under-submit-button">
                    <p>Chưa có tài khoản? <a href="?act=register">Đăng Ký</a></p>
                    <p>Quên mật khẩu</p>
                </div>
            </form>
        </div>
    </div>
    <?php include 'views/layouts/footer.php'; ?>
</body>

</html>