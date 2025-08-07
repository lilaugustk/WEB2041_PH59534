<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa tài khoản - Admin Dashboard</title>
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
                <a href="?act=logout" class="logout-btn">
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
                    <h1>Sửa sản phẩm</h1>
                </div>
                <div class="header-right">
                    <div class="admin-info">
                        <span>Xin chào, Admin</span>
                        <img src="img/User.svg" alt="Admin" class="admin-avatar">
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <!-- Content Area -->
            <div class="content-area">
                <div class="form-container">
                    <form action="?act=update-user" method="POST" enctype="multipart/form-data" class="admin-form">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id'] ?? '') ?>">
                        <input type="hidden" name="current_avatar" value="<?= htmlspecialchars($user['avatar'] ?? '') ?>">

                        <div class="form-group">
                            <label for="user_name">Tên đăng nhập</label>
                            <input type="text" id="user_name" name="user_name" value="<?= htmlspecialchars($user['user_name'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="phone_number">Số điện thoại</label>
                            <input type="tel" id="phone_number" name="phone_number" value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label for="new_password">Mật khẩu mới (để trống nếu không muốn thay đổi)</label>
                            <input type="password" id="new_password" name="new_password" placeholder="Nhập mật khẩu mới">
                        </div>

                        <div class="form-group">
                            <label for="role">Vai trò</label>
                            <select id="role" name="role" required>
                                <option value="user" <?= (isset($user['role']) && $user['role'] == 'user') ? 'selected' : '' ?>>Người dùng</option>
                                <option value="admin" <?= (isset($user['role']) && $user['role'] == 'admin') ? 'selected' : '' ?>>Quản trị</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="avatar">Ảnh đại diện mới (để trống nếu không muốn thay đổi)</label>
                            <input type="file" id="avatar" name="avatar" accept="image/*">
                            <?php
                            $current_avatar = 'img/User.svg'; // Avatar mặc định
                            if (!empty($user['avatar']) && file_exists($user['avatar'])) {
                                $current_avatar = $user['avatar'];
                            }
                            ?>
                            <?php if (!empty($current_avatar)) : ?>
                                <p>Ảnh hiện tại: <img src="<?= htmlspecialchars($current_avatar) ?>" alt="Current Avatar" style="width: 100px; height: auto; margin-top: 10px;"></p>
                            <?php endif; ?>
                        </div>
                </div>
                <div class=" form-actions">
                    <a href="?act=userDashboard" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Lưu thay đổi
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>