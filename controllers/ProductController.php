<?php
// có class chứa các function thực thi xử lý logic 
class ProductController
{
    public $modelProduct;

    public function __construct()
    {
        $this->modelProduct = new ProductModel();
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
        $listProducts  = $this->modelProduct->getAllProduct();
        require_once './views/category.php';
    }
    public function register()
    {
        require_once './views/register.php';
    }
}
