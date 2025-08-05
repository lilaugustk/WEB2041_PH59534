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
        $totalProducts = $this->modelProduct->countProducts();
        $totalCategories = $this->modelCategory->countCategories();
        $totalUsers = $this->modelUser->countUsers();

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
        $listProducts  = $this->modelProduct->getAllProduct();
        $listCategories = $this->modelCategory->getAllCategories();

        require_once './views/dashboard/add-product.php';
    }

    public function addCategory()
    {
        require_once './views/dashboard/add-category.php';
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
        $productName = $_POST['product_name'];
        $productPrice = $_POST['price'];
        $productQuantity = $_POST['quantity'];
        $productDescription = $_POST['description'];
        $productImage = uploadFile($_FILES['image'], 'imgproduct');
        $productCategory = $_POST['category_id'];
        $hot = isset($_POST['hot']) ? 1 : 0;

        $this->modelProduct->insertProduct($productName, $productPrice, $productQuantity, $productDescription, $productImage, $productCategory, $hot);
        header('Location: ?act=productDashboard');
        exit;
    }

    public function saveCategory()
    {
        // Xử lý lưu danh mục
        $categoryName = $_POST['category_name'];
        $this->modelCategory->insertCategory($categoryName);
        header('Location: ?act=categoryDashboard');
        exit;
    }

    public function deleteProduct()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelProduct->deleteProduct($id);
        }
        header('Location: ?act=productDashboard');
        exit;
    }

    public function deleteCategory()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelCategory->deleteCategory($id);
        }
        header('Location: ?act=categoryDashboard');
        exit;
    }
}
