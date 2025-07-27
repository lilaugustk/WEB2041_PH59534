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
        require_once './views/home.php';
    }
}
