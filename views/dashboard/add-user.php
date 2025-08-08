<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm tài khoản - Admin Dashboard</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/error.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-cog"></i>Tiny Room</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li class="nav-item">
                        <a href="?act=dashboard">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?act=productDashboard">
                            <i class="fas fa-box"></i>
                            <span>Sản phẩm</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?act=categoryDashboard">
                            <i class="fas fa-tags"></i>
                            <span>Danh mục</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="?act=commentDashboard">
                            <i class="fas fa-comments"></i>
                            <span>Bình luận</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="?act=userDashboard">
                            <i class="fas fa-users"></i>
                            <span>Tài khoản</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <a href="?act=logoutDB" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Đăng xuất</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="content-header">
                <div class="header-left">
                    <h1>Thêm tài khoản mới</h1>
                </div>
                <div class="header-right">
                    <div class="admin-info">
                        <?php
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        } ?>
                        <?php if (isset($_SESSION['user'])) { ?>
                            <span>Xin chào, <?php echo htmlspecialchars($_SESSION['user']['user_name']); ?></span>
                        <?php } ?>
                        <img src="img/User.svg" alt="Admin" class="admin-avatar">
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <div class="form-container">
                    <form action="?act=save-user" method="POST" enctype="multipart/form-data" class="admin-form">

                        <?php include 'views/layouts/errors.php' ?>

                        <div class="form-group">
                            <label for="user_name">Tên đăng nhập</label>
                            <input type="text" id="user_name" name="user_name">
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input type="password" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Số điện thoại</label>
                            <input type="tel" id="phone_number" name="phone_number">
                        </div>
                        <div class="form-group">
                            <label for="avatar">Ảnh đại diện</label>
                            <input type="file" id="avatar" name="avatar">
                        </div>
                        <div class="form-group">
                            <label for="role">Vai trò</label>
                            <select id="role" name="role">
                                <option value="user">Người dùng</option>
                                <option value="admin">Quản trị</option>
                            </select>
                        </div>
                </div>
                <div class=" form-actions">
                    <a href="?act=userDashboard" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Lưu tài khoản
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>