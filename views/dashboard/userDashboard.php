<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản - Admin Dashboard</title>
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
                    <h1>Quản lý tài khoản</h1>
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
                <div class="page-header">
                    <h2>Danh sách tài khoản</h2>
                    <a href="?act=add-user" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Thêm tài khoản
                    </a>
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên đăng nhập</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Ảnh đại diện</th>
                                <th>Vai trò</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listUsers as $user) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['user_id']) ?></td>
                                    <td><?= htmlspecialchars($user['user_name']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['phone_number']) ?></td>
                                    <td>
                                        <?php $avatar = !empty($user['avatar']) && file_exists($user['avatar']) ? htmlspecialchars($user['avatar']) : 'img/User.svg'; ?>
                                        <img src="<?= $avatar ?>" alt="Avatar" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    </td>
                                    <td>
                                        <?php
                                        $role = htmlspecialchars($user['role']);
                                        $roleText = ($role == 'admin') ? 'Quản trị' : 'Người dùng';
                                        $roleClass = ($role == 'admin') ? 'role-admin' : 'role-user';
                                        ?>
                                        <span class="status-badge <?= $roleClass ?>"><?= $roleText ?></span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="?act=view-user&id=<?= htmlspecialchars($user['user_id']) ?>" class="btn btn-sm btn-info" title="Xem">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="?act=delete-user&id=<?= htmlspecialchars($user['user_id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>