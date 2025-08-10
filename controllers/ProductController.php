<?php
require_once './models/ProductModel.php';
require_once './models/CategoryModel.php';
// có class chứa các function thực thi xử lý logic 
class ProductController
{
    // ... (các thuộc tính khác)
    public $modelProduct;
    public $modelCategory;

    public $modelComment;

    public function __construct()
    {
        $this->modelProduct = new ProductModel();
        $this->modelCategory = new CategoryModel();
        $this->modelComment = new CommentModel();
    }

    public function home()
    {
        $listProducts  = $this->modelProduct->getAllProduct();
        $hot = true; // Giả sử ta muốn lấy sản phẩm hot
        // Lấy danh sách sản phẩm hot
        $hotListProducts  = $this->modelProduct->getProductByHot($hot);

        require_once './views/home.php';
    }
    public function detailProduct()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?act=/');
            exit;
        }
        $detailProduct = $this->modelProduct->getProductById($id);
        if (!$detailProduct) {
            header('Location: ?act=/');
            exit;
        }

        // Lấy danh sách bình luận của sản phẩm
        $listComment = $this->modelComment->getCommentsByProductId($id);
        require_once './views/detail.php';
    }


    public function category()
    {
        // Lấy category_id từ URL, ví dụ: ?act=category&id=1
        $categoryId = $_GET['id'] ?? null;

        // Lấy tất cả danh mục để hiển thị menu
        $listCategories = $this->modelCategory->getAllCategories();

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
        // Gọi view để hiển thị danh sách sản phẩm theo danh mục
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
