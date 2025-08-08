<?php
require_once './models/ProductModel.php';
require_once './models/CategoryModel.php';
// có class chứa các function thực thi xử lý logic 
class ProductController
{
    public $modelProduct;
    public $modelCategory;

    public function __construct()
    {
        $this->modelProduct = new ProductModel();
        $this->modelCategory = new CategoryModel();
    }

    public function home()
    {
        $listProducts  = $this->modelProduct->getAllProduct();
        $hot = true; // Giả sử ta muốn lấy sản phẩm hot
        // Lấy danh sách sản phẩm hot
        $hotListProducts  = $this->modelProduct->getProductByHot($hot);

        require_once './views/home.php';
    }
    public function detail()
    {
        require_once './views/detail.php';
    }


    public function category()
    {
        // Lấy category_id từ URL, ví dụ: ?act=category&id=1
        $categoryId = $_GET['id'] ?? null;

        if ($categoryId) {
            // Lấy sản phẩm theo category id
            $listProducts = $this->modelProduct->getProductsByCategory($categoryId);
            // Lấy thông tin của category để hiển thị tên
            $currentCategory = $this->modelCategory->getCategoryById($categoryId);
            $categoryName = $currentCategory ? $currentCategory['category_name'] : 'Danh mục không tồn tại';
        } else {
            // Nếu không có id, lấy tất cả sản phẩm
            $listProducts = $this->modelProduct->getAllProduct();
            $categoryName = 'Tất cả sản phẩm';
        }
        // Truyền biến danh sách sản phẩm và tên danh mục vào view
        $data = [
            'listProducts' => $listProducts,
            'categoryName' => $categoryName,
        ];
        // Gọi view để hiển thị danh sách sản phẩm theo danh mục
        // Truyền biến vào view
        require './views/category.php';
    }
    public function register()
    {
        require_once './views/register.php';
    }
    public function login()
    {
        require_once './views/login.php';
    }
}
