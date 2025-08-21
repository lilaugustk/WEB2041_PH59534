<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm - Admin Dashboard</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="stylesheet" href="styles/error.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="js/script.js" defer></script>
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
                    <li class="nav-item active">
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
                    <li class="nav-item">
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
                    <h1>Sửa sản phẩm</h1>
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
                    <form action="?act=update-product" method="POST" enctype="multipart/form-data" class="admin-form">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($editProduct['product_id'] ?? '') ?>">
                        <input type="hidden" name="current_image" value="<?= htmlspecialchars($editProduct['image'] ?? '') ?>">
                        <div class="form-group">
                            <label for="product_name">Tên sản phẩm</label>
                            <input type="text" id="product_name" name="product_name" value="<?= htmlspecialchars($editProduct['product_name'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea id="description" name="description" rows="4"><?= htmlspecialchars($editProduct['description'] ?? '') ?></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="price">Giá</label>
                                <input type="number" id="price" name="price" value="<?= htmlspecialchars($editProduct['price'] ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Số lượng</label>
                                <input type="number" id="quantity" name="quantity" value="<?= htmlspecialchars($editProduct['quantity'] ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Danh mục</label>
                                <select id="category_id" name="category_id" required>
                                    <option value="">Chọn Danh Mục</option>
                                    <?php foreach ($listCategories as $category) : ?>
                                        <option value="<?= htmlspecialchars($category['category_id']) ?>" <?= ($editProduct['category_id'] == $category['category_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['category_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group"> <label for="hot">Sản phẩm hot</label>
                                <input type="checkbox" id="hot" name="hot" class="hot-product-checkbox" value="1" <?= ($editProduct['hot'] == 1) ? 'checked' : '' ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image">Hình ảnh mới (để trống nếu không muốn thay đổi)</label>
                            <input type="file" id="image" name="image" accept="image/*">
                            <?php if (!empty($editProduct['image'])) : ?>
                                <p>Ảnh hiện tại: <img src="<?= htmlspecialchars($editProduct['image']) ?>" alt="Current Image" style="width: 100px; height: auto; margin-top: 10px;"></p>
                            <?php endif; ?>
                        </div>
                </div>
                <div class=" form-actions">
                    <a href="?act=productDashboard" class="btn btn-secondary">
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