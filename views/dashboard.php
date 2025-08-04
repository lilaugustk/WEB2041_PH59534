<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
                    <li class="nav-item active" data-page="dashboard">
                        <a href="#dashboard">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item" data-page="products">
                        <a href="#products">
                            <i class="fas fa-box"></i>
                            <span>Sản phẩm</span>
                        </a>
                    </li>
                    <li class="nav-item" data-page="categories">
                        <a href="#categories">
                            <i class="fas fa-tags"></i>
                            <span>Danh mục</span>
                        </a>
                    </li>
                    <li class="nav-item" data-page="posts">
                        <a href="#posts">
                            <i class="fas fa-newspaper"></i>
                            <span>Bài viết</span>
                        </a>
                    </li>
                    <li class="nav-item" data-page="comments">
                        <a href="#comments">
                            <i class="fas fa-comments"></i>
                            <span>Bình luận</span>
                        </a>
                    </li>
                    <li class="nav-item" data-page="users">
                        <a href="#users">
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
                    <button class="sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 id="page-title">Dashboard</h1>
                </div>
                <div class="header-right">
                    <div class="admin-info">
                        <span>Xin chào, <?php echo htmlspecialchars($_SESSION['user']['user_name']); ?></span>
                        <img src="img/User.svg" alt="Admin" class="admin-avatar">
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Dashboard Overview -->
                <div id="dashboard-page" class="page-content active">
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="stat-info">
                                <h3 id="total-products">0</h3>
                                <p>Sản phẩm</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="stat-info">
                                <h3 id="total-categories">0</h3>
                                <p>Danh mục</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <div class="stat-info">
                                <h3 id="total-posts">0</h3>
                                <p>Bài viết</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-info">
                                <h3 id="total-users">0</h3>
                                <p>Người dùng</p>
                            </div>
                        </div>
                    </div>

                    <div class="recent-activity">
                        <h2>Hoạt động gần đây</h2>
                        <div class="activity-list" id="recent-activities">
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="activity-content">
                                    <p>Sản phẩm mới được thêm</p>
                                    <span class="activity-time">2 giờ trước</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Management -->
                <div id="products-page" class="page-content">
                    <div class="page-header">
                        <h2>Quản lý sản phẩm</h2>
                        <button class="btn btn-primary" onclick="openModal('add-product-modal')">
                            <i class="fas fa-plus"></i> Thêm sản phẩm
                        </button>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Danh mục</th>
                                    <th>Giá</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="products-table-body">
                                <tr>
                                    <td colspan="7" class="loading">Đang tải...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Categories Management -->
                <div id="categories-page" class="page-content">
                    <div class="page-header">
                        <h2>Quản lý danh mục</h2>
                        <button class="btn btn-primary" onclick="openModal('add-category-modal')">
                            <i class="fas fa-plus"></i> Thêm danh mục
                        </button>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên danh mục</th>
                                    <th>Mô tả</th>
                                    <th>Số sản phẩm</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="categories-table-body">
                                <tr>
                                    <td colspan="6" class="loading">Đang tải...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Posts Management -->
                <div id="posts-page" class="page-content">
                    <div class="page-header">
                        <h2>Quản lý bài viết</h2>
                        <button class="btn btn-primary" onclick="openModal('add-post-modal')">
                            <i class="fas fa-plus"></i> Thêm bài viết
                        </button>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tiêu đề</th>
                                    <th>Tác giả</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="posts-table-body">
                                <tr>
                                    <td colspan="6" class="loading">Đang tải...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Comments Management -->
                <div id="comments-page" class="page-content">
                    <div class="page-header">
                        <h2>Quản lý bình luận</h2>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nội dung</th>
                                    <th>Người bình luận</th>
                                    <th>Bài viết</th>
                                    <th>Ngày bình luận</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="comments-table-body">
                                <tr>
                                    <td colspan="7" class="loading">Đang tải...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Users Management -->
                <div id="users-page" class="page-content">
                    <div class="page-header">
                        <h2>Quản lý tài khoản</h2>
                        <button class="btn btn-primary" onclick="openModal('add-user-modal')">
                            <i class="fas fa-plus"></i> Thêm tài khoản
                        </button>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên người dùng</th>
                                    <th>Email</th>
                                    <th>Vai trò</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="users-table-body">
                                <tr>
                                    <td colspan="7" class="loading">Đang tải...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Add Product Modal -->
    <div id="add-product-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Thêm sản phẩm mới</h3>
                <span class="close" onclick="closeModal('add-product-modal')">&times;</span>
            </div>
            <form class="modal-form" id="add-product-form">
                <div class="form-group">
                    <label for="product-name">Tên sản phẩm *</label>
                    <input type="text" id="product-name" name="product_name" required>
                </div>
                <div class="form-group">
                    <label for="product-category">Danh mục *</label>
                    <select id="product-category" name="category_id" required>
                        <option value="">Chọn danh mục</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="product-price">Giá *</label>
                    <input type="number" id="product-price" name="price" min="0" step="1000" required>
                </div>
                <div class="form-group">
                    <label for="product-description">Mô tả</label>
                    <textarea id="product-description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="product-image">Hình ảnh</label>
                    <input type="file" id="product-image" name="image" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="product-status">Trạng thái</label>
                    <select id="product-status" name="status">
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Không hoạt động</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('add-product-modal')">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div id="add-category-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Thêm danh mục mới</h3>
                <span class="close" onclick="closeModal('add-category-modal')">&times;</span>
            </div>
            <form class="modal-form" id="add-category-form">
                <div class="form-group">
                    <label for="category-name">Tên danh mục *</label>
                    <input type="text" id="category-name" name="category_name" required>
                </div>
                <div class="form-group">
                    <label for="category-description">Mô tả</label>
                    <textarea id="category-description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="category-status">Trạng thái</label>
                    <select id="category-status" name="status">
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Không hoạt động</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('add-category-modal')">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm danh mục</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Post Modal -->
    <div id="add-post-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Thêm bài viết mới</h3>
                <span class="close" onclick="closeModal('add-post-modal')">&times;</span>
            </div>
            <form class="modal-form" id="add-post-form">
                <div class="form-group">
                    <label for="post-title">Tiêu đề *</label>
                    <input type="text" id="post-title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="post-content">Nội dung *</label>
                    <textarea id="post-content" name="content" rows="6" required></textarea>
                </div>
                <div class="form-group">
                    <label for="post-image">Hình ảnh</label>
                    <input type="file" id="post-image" name="image" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="post-status">Trạng thái</label>
                    <select id="post-status" name="status">
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Không hoạt động</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('add-post-modal')">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm bài viết</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="add-user-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Thêm tài khoản mới</h3>
                <span class="close" onclick="closeModal('add-user-modal')">&times;</span>
            </div>
            <form class="modal-form" id="add-user-form">
                <div class="form-group">
                    <label for="user-name">Tên người dùng *</label>
                    <input type="text" id="user-name" name="user_name" required>
                </div>
                <div class="form-group">
                    <label for="user-email">Email *</label>
                    <input type="email" id="user-email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="user-password">Mật khẩu *</label>
                    <input type="password" id="user-password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="user-role">Vai trò</label>
                    <select id="user-role" name="role">
                        <option value="user">Người dùng</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="user-status">Trạng thái</label>
                    <select id="user-status" name="status">
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Không hoạt động</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('add-user-modal')">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm tài khoản</button>
                </div>
            </form>
        </div>
    </div>

    <script src="js/dashboard.js"></script>
</body>
</html>
