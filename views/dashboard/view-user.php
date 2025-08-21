<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem chi tiết tài khoản - Admin Dashboard</title>
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
                    <h1>Thông tin tài khoản</h1>
                </div>
                <div class="header-right">
                    <div class="admin-info">
                        <?php if (isset($_SESSION['user'])) : ?>
                            <span>Xin chào, <?php echo htmlspecialchars($_SESSION['user']['user_name']); ?></span>
                        <?php endif; ?>
                        <img src="img/User.svg" alt="Admin" class="admin-avatar">
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <div class="form-container">
                    <div class="admin-form">
                        <div class="form-group">
                            <label for="user_name">Tên đăng nhập</label>
                            <input type="text" id="user_name" value="<?= htmlspecialchars($user['user_name'] ?? '') ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="phone_number">Số điện thoại</label>
                            <input type="tel" id="phone_number" value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="role">Vai trò</label>
                            <input type="text" id="role" value="<?= ($user['role'] == 'admin') ? 'Quản trị' : 'Người dùng' ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label>Ảnh đại diện</label>
                            <?php
                            $current_avatar = 'img/User.svg'; // Avatar mặc định
                            if (!empty($user['avatar']) && file_exists($user['avatar'])) {
                                $current_avatar = $user['avatar'];
                            }
                            ?>
                            <p><img src="<?= htmlspecialchars($current_avatar) ?>" alt="Current Avatar" style="width: 100px; height: auto; margin-top: 10px; border-radius: 4px;"></p>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <a href="?act=userDashboard" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>