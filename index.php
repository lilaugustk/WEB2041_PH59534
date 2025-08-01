<?php
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/ProductController.php';

// Require toàn bộ file Models

require_once './models/ProductModel.php';


// Route
$action = $_GET['act'] ?? '/';


// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($action) {
    // Trang chủ
    '/' => (new ProductController())->home(),
    // Trang danh mục sản phẩm
    'category' => (new ProductController())->category(),

    // Trang đăng ký
    'register' => (new ProductController())->register(),
    // Trang đăng nhập
    'login' => (new ProductController())->register(), // Giả sử đăng nhập cũng 'register' view
    // Mặc định nếu không có action nào khớp thì sẽ gọi trang chủ
};
