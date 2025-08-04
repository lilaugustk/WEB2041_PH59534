<?php
require_once './models/ProductModel.php';
require_once './models/CategoryModel.php';
require_once './models/UserModel.php';


class DashboardController
{
    public $modelProduct;
    public $modelCategory;
    public $modelUser;
    public function __construct()
    {
        $this->modelProduct = new ProductModel();
        $this->modelCategory = new CategoryModel();
        $this->modelUser = new UserModel();
    }
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $userModel = new UserModel();

        $totalProducts = $productModel->countProducts();
        $totalCategories = $categoryModel->countCategories();
        $totalUsers = $userModel->countUsers();

        $totalData = [
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalUsers' => $totalUsers,
        ];
        require_once './views/dashboard/dashboard.php';
    }

    public function productDashboard()
    {
        $listProducts  = $this->modelProduct->getAllProduct();
        require_once './views/dashboard/productDashboard.php';
    }

    public function categoryDashboard()
    {
        $listCategories = $this->modelCategory->getAllCategories();
        require_once './views/dashboard/categoryDashboard.php';
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
