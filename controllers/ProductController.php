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

    public function category()
    {
        $cat = $_GET['cat'] ?? null;
        $map = [
            'bedroom' => ['id' => 1, 'name' => 'Phòng Ngủ'],
            'diningroom' => ['id' => 2, 'name' => 'Phòng Ăn'],
            'workingroom' => ['id' => 3, 'name' => 'Phòng Làm Việc'],
            'livingroom' => ['id' => 4, 'name' => 'Phòng Khách'],
            'kitchen' => ['id' => 5, 'name' => 'Phòng Bếp'],
            'meetingroom' => ['id' => 6, 'name' => 'Phòng Họp'],
            'bathroom' => ['id' => 7, 'name' => 'Phòng Tắm'],
        ];
        if ($cat && isset($map[$cat])) {
            $listProducts = $this->modelProduct->getProductsByCategory($map[$cat]['id']);
            $categoryName = $map[$cat]['name'];
        } else {
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
