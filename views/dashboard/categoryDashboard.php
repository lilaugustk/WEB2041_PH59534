<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý danh mục - Admin Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
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
                    <li class="nav-item active">
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
                    <li class="nav-item">
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
                    <h1>Quản lý danh mục</h1>
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
                    <h2>Danh sách danh mục</h2>
                    <a href="?act=add-category" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Thêm danh mục
                    </a>
                </div>

                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên danh mục</th>
                                <!-- <th>Mô tả</th>
                                <th>Số sản phẩm</th> -->
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <?php foreach ($listCategories as $category) { ?>
                            <tr>
                                <tbody>
                                    <tr>
                                        <td><?= htmlspecialchars($category['category_id']) ?></td>
                                        <td><?= htmlspecialchars($category['category_name']) ?></td>
                                        <!-- <td>Sofa và bàn ghế phòng khách</td>
                                <td>8</td> -->
                                        <td>
                                            <div class="action-buttons">
                                                <a href="?act=edit-category&id=<?= htmlspecialchars($category['category_id']) ?>" class="btn btn-sm btn-success">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="?act=delete-category&id=<?= htmlspecialchars($category['category_id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>