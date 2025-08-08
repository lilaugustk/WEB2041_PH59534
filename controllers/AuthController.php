<?php
require_once './models/UserModel.php';

class AuthController
{
    // public $userModel;
    public $modelUser;


    public function __construct()
    {
        $this->modelUser = new UserModel();
    }

    //Xử lý đăng ký
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_name = trim($_POST['user_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $phone_number = trim($_POST['phone_number'] ?? '');
            $errors = [];

            // Validate đầu vào
            if (empty($user_name)) $errors[] = "Tên không được để trống";
            if (empty($email)) $errors[] = "Email không được để trống";
            if (empty($password)) $errors[] = "Mật khẩu không được để trống";
            if (empty($phone_number)) $errors[] = "Số điện thoại không được để trống";

            // Validate email format
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không đúng định dạng";
            }

            // Kiểm tra email đã tồn tại chưa
            if (!empty($email) && $this->modelUser->emailExists(email: $email)) {
                $errors[] = "Email đã tồn tại trong hệ thống";
            }

            // Validate password strength
            if (!empty($password) && strlen($password) < 6) {
                $errors[] = "Mật khẩu phải có ít nhất 6 ký tự";
            }

            // Validate phone number
            if (!empty($phone_number) && !preg_match('/^[0-9]{10,11}$/', $phone_number)) {
                $errors[] = "Số điện thoại không đúng định dạng";
            }

            if (empty($errors)) {
                $result = $this->modelUser->createUser($user_name, $email, $password, $phone_number);
                if ($result) { // $result ở đây là user_id mới được tạo
                    // Lấy lại thông tin người dùng vừa tạo để đăng nhập
                    $newUser = $this->modelUser->getUserById($result);
                    if ($newUser) {
                        // Thiết lập session cho người dùng mới
                        $this->setUserSession($newUser);
                        // Chuyển hướng về trang chủ
                        header('Location: ?act=/');
                        exit;
                    }
                    // Nếu không lấy được user thì vẫn về trang login như cũ
                    header('Location: ?act=login');
                    exit;
                } else {
                    $errors[] = "Đăng ký không thành công. Vui lòng thử lại.";
                }
            }
        }
        require_once './views/register.php';
    }
    // Xử lý đăng nhập
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $errors = [];

            // Validate đầu vào
            if (empty($email)) $errors[] = "Email không được để trống";
            if (empty($password)) $errors[] = "Mật khẩu không được để trống";

            // Validate email format
            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không đúng định dạng";
            }

            if (empty($errors)) {
                $user = $this->modelUser->checkLogin($email, $password);

                if ($user) {
                    $this->setUserSession($user);

                    // Kiểm tra vai trò và chuyển hướng phù hợp
                    if ($user['role'] === 'admin') {
                        header('Location: ?act=dashboard'); // Chuyển hướng admin đến trang dashboard
                    } else {
                        header('Location: ?act=/'); // Chuyển hướng người dùng thường về trang chủ
                    }
                    exit;
                } else {
                    $errors[] = "Email hoặc mật khẩu không đúng";
                }
            }
        }
        require_once './views/login.php';
    }

    // Đăng xuất
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ?act=/');
        exit;
    }

    public function logoutDB()
    {
        session_start();
        session_destroy();
        header('Location: ?act=login');
        exit;
    }


    // Kiểm tra đã đăng nhập hay chưa
    public function isLoggedIn()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return isset($_SESSION['user']) && !empty($_SESSION['user']['user_id']);
    }

    // Lưu thông tin user vào session
    private function setUserSession($user)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $_SESSION['user'] = [
            'user_id' => $user['user_id'],
            'user_name' => $user['user_name'],
            'email' => $user['email'],
            'phone_number' => $user['phone_number'] ?? null,
            'role' => $user['role'] ?? 'user' // Thêm role nếu có
        ];
    }

    // Trả về thông tin user hiện tại
    public function getCurrentUser()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return $_SESSION['user'] ?? null;
    }

    // Bắt buộc phải đăng nhập mới vào được
    public function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            header('Location: ?act=login');
            exit;
        }
    }

    // Bắt buộc phải là admin
    public function requireAdmin()
    {
        // Đầu tiên, kiểm tra xem người dùng đã đăng nhập chưa.
        // Nếu chưa, hàm này sẽ tự động chuyển hướng đến trang login.
        $this->requireLogin();

        $user = $this->getCurrentUser();
        if ($user['role'] !== 'admin') {
            echo "Bạn không có quyền truy cập trang này.";
            exit;
        }
    }
}
