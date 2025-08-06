<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
</head>

<body>

    <?php include 'views/layouts/header.php'; ?>
    <div class="form-main-box">
        <div class="form-left-box">
            <img src="img/Banner 2nd.jpg" alt="">
        </div>
        <div class="form-right-box">
            <form action="?act=register" method="POST">
                <h2>Đăng Ký</h2>

                <!-- Hiển thị lỗi -->
                <?php include 'views/layouts/errors.php' ?>

                <!-- <label for="user_name">Tên đăng nhập:</label> -->
                <input type="text" id="user_name" name="user_name" placeholder="Vui lòng nhập tên đăng nhập">

                <!-- <label for="password">Mật khẩu:</label> -->
                <input type="password" id="password" name="password" placeholder="Vui lòng nhập mật khẩu">

                <!-- <label for="email">Email:</label> -->
                <input type="email" id="email" name="email" placeholder="Vui lòng nhập email">

                <!-- <label for="phone_number">Số điện thoại:</label> -->
                <input type="number" id="phone_number" name="phone_number" placeholder="Vui lòng nhập số điện thoại">

                <button class="submit-button" type="submit">Đăng Ký</button>
            </form>
        </div>
    </div>

    <?php include 'views/layouts/footer.php'; ?>

</body>

</html>