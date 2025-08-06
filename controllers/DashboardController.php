<?php
require_once './models/ProductModel.php';
require_once './models/CategoryModel.php';
require_once './models/UserModel.php';
require_once './controllers/AuthController.php';


class DashboardController
{
    public $modelProduct;
    public $modelCategory;
    public $modelUser;
    public $authController;
    public function __construct()
    {
        $this->authController = new AuthController();
        $this->authController->requireAdmin(); // Bắt buộc phải là admin để truy cập

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

    public function saveProduct()
    {
        // TODO: Thêm validation cho các trường dữ liệu
        $productName = trim($_POST['product_name'] ?? '');
        $productPrice = trim($_POST['price'] ?? '');
        $productQuantity = trim($_POST['quantity'] ?? '');
        $productDescription = trim($_POST['description'] ?? '');
        $productCategory = $_POST['category_id'] ?? '';
        $hot = isset($_POST['hot']) ? 1 : 0;
        $imageFile = $_FILES['image'] ?? null;

        // Basic validation
        if (empty($productName) || empty($productPrice) || empty($productQuantity) || empty($productCategory) || !$imageFile || $imageFile['error'] != UPLOAD_ERR_OK) {
            // Nếu có lỗi, bạn có thể lưu lỗi vào session và hiển thị lại form
            // Hoặc đơn giản là báo lỗi và dừng lại
            echo "Vui lòng điền đầy đủ thông tin và tải lên hình ảnh hợp lệ.";
            // Tốt hơn là redirect về form add-product với thông báo lỗi
            // header('Location: ?act=add-product&error=validation');
            exit;
        }

        $productImage = uploadFile($imageFile, 'imgproduct');

        if ($productImage) {
            $this->modelProduct->insertProduct($productName, $productPrice, $productQuantity, $productDescription, $productImage, $productCategory, $hot);
            header('Location: ?act=productDashboard');
            exit;
        }
    }
    public function addCategory()
    {
        require_once './views/dashboard/add-category.php';
    }

    public function saveCategory()
    {
        // Xử lý lưu danh mục
        $categoryName = $_POST['category_name'];
        $this->modelCategory->insertCategory($categoryName);
        header('Location: ?act=categoryDashboard');
        exit;
    }
    public function editProduct()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?act=productDashboard');
            exit;
        }
        $editProduct = $this->modelProduct->getProductById($id);
        $listCategories = $this->modelCategory->getAllCategories(); // Lấy danh sách danh mục

        if (!$editProduct) {
            // Xử lý trường hợp không tìm thấy sản phẩm
            echo "Sản phẩm không tồn tại!";
            exit;
        }

        require_once './views/dashboard/edit-product.php';
    }

    public function updateProduct()
    {
        $id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $description = $_POST['description'];
        $category_id = $_POST['category_id'];
        $hot = isset($_POST['hot']) ? 1 : 0;

        $image = $_POST['current_image']; // Giữ ảnh cũ làm mặc định

        // Xử lý nếu có ảnh mới được tải lên
        $newImageFile = $_FILES['image'] ?? null;
        if ($newImageFile && $newImageFile['error'] == UPLOAD_ERR_OK) {
            // Upload ảnh mới
            $newImagePath = uploadFile($newImageFile, 'imgproduct');

            // Nếu upload thành công và có ảnh cũ, hãy xóa ảnh cũ đi
            if ($newImagePath && !empty($image) && file_exists($image)) {
                unlink($image);
            }
            $image = $newImagePath; // Cập nhật đường dẫn ảnh để lưu vào DB
        }
        // Cập nhật thông tin sản phẩm
        $this->modelProduct->updateProduct($id, $product_name, $price, $quantity, $description, $image, $category_id, $hot);
        header('Location: ?act=productDashboard');
        exit;
    }
    public function editCategory()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?act=categoryDashboard');
            exit;
        }
        $editCategory = $this->modelCategory->getCategoryById($id);
        if (!$editCategory) {
            // Xử lý trường hợp không tìm thấy danh mục
            echo "Danh mục không tồn tại!";
            exit;
        }
        require_once './views/dashboard/edit-category.php';
    }

    public function updateCategory()
    {
        $id = $_POST['category_id'];
        $category_name = $_POST['category_name'];
        $this->modelCategory->updateCategory($id, $category_name);
        header('Location: ?act=categoryDashboard');
        exit;
    }

    public function deleteProduct()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            // Lấy thông tin sản phẩm để có đường dẫn ảnh
            $product = $this->modelProduct->getProductById($id);

            if ($product) {
                // Lấy đường dẫn ảnh
                $imagePath = $product['image'];

                // Xóa sản phẩm khỏi CSDL
                $this->modelProduct->deleteProduct($id);

                // Nếu có ảnh và file tồn tại, thì xóa file ảnh
                if (!empty($imagePath) && file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
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
