<?php
require_once './models/ProductModel.php';
require_once './models/CategoryModel.php';
require_once './models/UserModel.php';

class DashboardController
{
    public function index()
    {
        require_once './views/dashboard.php';
    }

    public function products()
    {
        require_once './views/products.php';
    }

    public function categories()
    {
        require_once './views/categories.php';
    }

    public function addProduct()
    {
        require_once './views/add-product.php';
    }

    public function addCategory()
    {
        require_once './views/add-category.php';
    }

    public function editProduct()
    {
        require_once './views/edit-product.php';
    }

    public function editCategory()
    {
        require_once './views/edit-category.php';
    }

    public function saveProduct()
    {
        // Xử lý lưu sản phẩm
        // Bạn có thể thêm logic database ở đây
        header('Location: ?act=products');
        exit;
    }

    public function saveCategory()
    {
        // Xử lý lưu danh mục
        // Bạn có thể thêm logic database ở đây
        header('Location: ?act=categories');
        exit;
    }

    public function deleteProduct()
    {
        // Xử lý xóa sản phẩm
        // Bạn có thể thêm logic database ở đây
        header('Location: ?act=products');
        exit;
    }

    public function deleteCategory()
    {
        // Xử lý xóa danh mục
        // Bạn có thể thêm logic database ở đây
        header('Location: ?act=categories');
        exit;
    }
}
