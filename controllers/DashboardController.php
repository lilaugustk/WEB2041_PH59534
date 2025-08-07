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

    public function userDashboard()
    {
        $listUsers = $this->modelUser->getAllUsers();
        require_once './views/dashboard/userDashboard.php';
    }

    public function addProduct()
    {
        $listProducts  = $this->modelProduct->getAllProduct();
        $listCategories = $this->modelCategory->getAllCategories();

        require_once './views/dashboard/add-product.php';
    }

    public function saveProduct()
    {
        $productName = trim($_POST['product_name'] ?? '');
        $productPrice = trim($_POST['price'] ?? '');
        $productQuantity = trim($_POST['quantity'] ?? '');
        $productDescription = trim($_POST['description'] ?? '');
        $productCategory = $_POST['category_id'] ?? '';
        $hot = isset($_POST['hot']) ? 1 : 0;
        $imageFile = $_FILES['image'] ?? null;
        $errors = [];

        // Thực hiện validation
        if (empty($productName)) $errors[] = "Vui lòng nhập tên sản phẩm";
        if (empty($productPrice)) $errors[] = "Vui lòng nhập giá sản phẩm";
        if (empty($productQuantity)) $errors[] = "Vui lòng nhập số lượng sản phẩm";
        if (empty($productCategory)) $errors[] = "Vui lòng chọn danh mục sản phẩm";
        if (!$imageFile || $imageFile['error'] != UPLOAD_ERR_OK) $errors[] = "Vui lòng chọn hình ảnh";

        // Nếu không có lỗi, tiến hành upload file và lưu vào CSDL
        if (empty($errors)) {
            $productImage = uploadFile($imageFile, 'uploads/imgproduct/');
            $this->modelProduct->insertProduct($productName, $productPrice, $productQuantity, $productDescription, $productImage, $productCategory, $hot);
            header('Location: ?act=productDashboard');
            exit;
        } else {
            // Nếu có lỗi, cần tải lại danh sách danh mục và hiển thị lại form với lỗi
            $listCategories = $this->modelCategory->getAllCategories();
            require_once './views/dashboard/add-product.php';
        }
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
    public function addCategory()
    {
        require_once './views/dashboard/add-category.php';
    }

    public function saveCategory()
    {
        // Xử lý lưu danh mục
        $categoryName = trim($_POST['category_name']);
        $errors = [];

        if (empty($categoryName)) $errors[] = "Vui lòng nhập tên danh mục";

        if (empty($errors)) {
            $this->modelCategory->insertCategory($categoryName);
            header('Location: ?act=categoryDashboard');
            exit;
        } else {

            require_once './views/dashboard/add-category.php';
        }
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

    public function deleteCategory()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->modelCategory->deleteCategory($id);
        }
        header('Location: ?act=categoryDashboard');
        exit;
    }
    public function addUser()
    {

        require_once './views/dashboard/add-user.php';
    }

    public function saveUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_name = trim($_POST['user_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $phone_number = trim($_POST['phone_number'] ?? '');
            $role = $_POST['role'] ?? 'user';
            $avatarFile = $_FILES['avatar'] ?? null;
            $errors = [];

            if (empty($user_name)) $errors[] = "Tên đăng nhập không được để trống.";
            if (empty($email)) $errors[] = "Email không được để trống.";
            if (empty($password)) $errors[] = "Mật khẩu không được để trống.";
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email không đúng định dạng.";
            if ($this->modelUser->emailExists($email)) $errors[] = "Email đã tồn tại trong hệ thống.";
            if (!empty($password) && strlen($password) < 6) $errors[] = "Mật khẩu phải có ít nhất 6 ký tự.";

            if (empty($errors)) {
                $avatarPath = null;
                if ($avatarFile && $avatarFile['error'] == UPLOAD_ERR_OK) {
                    // Giả sử bạn có một thư mục 'img/avatars' để lưu ảnh đại diện
                    $avatarPath = uploadFile($avatarFile, 'uploads/avatar/');
                    $this->modelUser->insertUser($user_name, $email, $password, $phone_number, $avatarPath, $role);
                    header('Location: ?act=userDashboard');
                    exit;
                }
            } else {
                require_once './views/dashboard/add-user.php';
            }
        }
    }

    public function editUser()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?act=userDashboard');
            exit;
        }
        $editUser = $this->modelUser->getUserById($id);

        if (!$editUser) {
            // Xử lý trường hợp không tìm thấy sản phẩm
            echo "Tài khoản không tồn tại!";
            exit;
        }

        require_once './views/dashboard/edit-product.php';
    }

    public function updateUser() {
    }

    public function deleteUser()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?act=userDashboard');
            exit;
        }
        $deleteUser = $this->modelUser->deleteUser($id);
    }
}
