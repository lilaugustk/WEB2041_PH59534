<?php
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/ProductController.php';
require_once './controllers/AuthController.php'; // Controller xử lý đăng nhập, đăng ký
require_once './controllers/DashboardController.php'; // Controller xử lý đăng nhập, đăng ký


// Require toàn bộ file Models

require_once './models/ProductModel.php';
require_once './models/CategoryModel.php';
require_once './models/UserModel.php'; // Model xử lý người dùng


// Route
$action = $_GET['act'] ?? '/';


// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($action) {
    // Trang chủ
    '/' => (new ProductController())->home(),
    'detailProduct' => (new ProductController())->detailProduct(),
    'dashboard' => (new DashboardController())->dashboard(),

    // Dashboard routes
    'productDashboard' => (new DashboardController())->productDashboard(),
    'categoryDashboard' => (new DashboardController())->categoryDashboard(),
    'userDashboard' => (new DashboardController())->userDashboard(),
    'commentDashboard' => (new DashboardController())->commentDashboard(),


    // Thêm sản phẩm, danh mục
    'add-product' => (new DashboardController())->addProduct(),
    'add-category' => (new DashboardController())->addCategory(),
    'add-user' => (new DashboardController())->addUser(),



    // Chỉnh sửa sản phẩm, danh mục
    'edit-product' => (new DashboardController())->editProduct(),
    'edit-category' => (new DashboardController())->editCategory(),
    'edit-user' => (new DashboardController())->editUser(),


    // Xử lý lưu sản phẩm, danh mục
    'save-product' => (new DashboardController())->saveProduct(),
    'save-category' => (new DashboardController())->saveCategory(),
    'save-user' => (new DashboardController())->saveUser(),

    'update-product' => (new DashboardController())->updateProduct(),
    'update-category' => (new DashboardController())->updateCategory(),
    'update-user' => (new DashboardController())->updateUser(),



    // Xử lý xóa sản phẩm, danh mục
    'delete-product' => (new DashboardController())->deleteProduct(),
    'delete-category' => (new DashboardController())->deleteCategory(),
    'delete-user' => (new DashboardController())->deleteUser(),
    'delete-comment' => (new DashboardController())->deleteComment(),


    'post-comment' => (new ProductController())->postComment(),
    'update-comment-status' => (new DashboardController())->updateCommentStatus(),


    // Trang danh mục sản phẩm
    'category' => (new ProductController())->category(),

    // Trang đăng ký
    'register' => (new AuthController())->register(),
    // Trang đăng nhập
    'login' => (new AuthController())->login(),
    
    // Trang đăng xuất
    'logout' => (new AuthController())->logout(),

    'logoutDB' => (new AuthController())->logoutDB(),


    // Mặc định nếu không có action nào khớp thì sẽ gọi trang chủ
    default => (new ProductController())->home(),
};
