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
    'dashboard' => (new DashboardController())->index(),
    
    // Dashboard routes
    'products' => (new DashboardController())->products(),
    'categories' => (new DashboardController())->categories(),
    'add-product' => (new DashboardController())->addProduct(),
    'add-category' => (new DashboardController())->addCategory(),
    'edit-product' => (new DashboardController())->editProduct(),
    'edit-category' => (new DashboardController())->editCategory(),
    'save-product' => (new DashboardController())->saveProduct(),
    'save-category' => (new DashboardController())->saveCategory(),
    'delete-product' => (new DashboardController())->deleteProduct(),
    'delete-category' => (new DashboardController())->deleteCategory(),
    
    // Trang danh mục sản phẩm
    'category' => (new ProductController())->category(),
    'bedroom' => (new ProductController())->category(),
    'diningroom' => (new ProductController())->category(),
    'workingroom' => (new ProductController())->category(),
    'livingroom' => (new ProductController())->category(),
    'kitchen' => (new ProductController())->category(),
    'mmeetingroom' => (new ProductController())->category(),
    'bathroom' => (new ProductController())->category(),
    
    // Trang đăng ký
    'register' => (new AuthController())->register(),
    // Trang đăng nhập
    'login' => (new AuthController())->login(),
    // Trang đăng xuất
    'logout' => (new AuthController())->logout(),
    
    // Mặc định nếu không có action nào khớp thì sẽ gọi trang chủ
    default => (new ProductController())->home(),
};
