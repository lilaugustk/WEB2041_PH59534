<?php

require_once './models/ProductModel.php';

class CartController
{
    private $modelProduct;

    public function __construct()
    {
        // Bắt đầu session ngay khi controller được khởi tạo để tránh lặp lại code
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Khởi tạo model cần thiết
        $this->modelProduct = new ProductModel();
    }

    public function showCart()
    {
        // Lấy giỏ hàng từ session
        $sessionCart = $_SESSION['cart'] ?? [];
        $cart = []; // Giỏ hàng sẽ được làm giàu với dữ liệu từ DB

        if (!empty($sessionCart)) {
            foreach ($sessionCart as $productId => $item) {
                $product = $this->modelProduct->getProductById($productId);
                if ($product) {
                    // Thêm thông tin từ DB vào giỏ hàng để hiển thị
                    $cart[$productId] = $item; // Giữ lại số lượng người dùng đã chọn
                    $cart[$productId]['max_quantity'] = $product['quantity']; // Thêm số lượng tồn kho
                }
            }
        }

        // Lấy các lỗi (nếu có) từ lần cập nhật trước đó
        $cartErrors = $_SESSION['cart_errors'] ?? [];
        // Xóa lỗi khỏi session để chúng không hiển thị lại ở lần tải trang sau
        unset($_SESSION['cart_errors']);

        // View sẽ sử dụng các biến $cart và $cartErrors để hiển thị
        require_once './views/cart.php';
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     * Lấy thông tin sản phẩm từ CSDL để đảm bảo an toàn và chính xác
     */
    public function addToCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)($_POST['product_id'] ?? 0);
            $quantity = (int)($_POST['quantity'] ?? 1);

            if ($productId <= 0 || $quantity <= 0) {
                header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '?act=/'));
                exit;
            }

            // 1. Lấy thông tin sản phẩm từ CSDL để đảm bảo an toàn
            $product = $this->modelProduct->getProductById($productId);

            // 2. Kiểm tra xem sản phẩm có tồn tại không
            if (!$product) {
                // Có thể thêm thông báo lỗi ở đây, ví dụ: $_SESSION['error'] = "Sản phẩm không tồn tại!";
                header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '?act=/'));
                exit;
            }

            // 3. Kiểm tra số lượng tồn kho
            $current_quantity_in_cart = $_SESSION['cart'][$productId]['quantity'] ?? 0;
            if (($quantity + $current_quantity_in_cart) > $product['quantity']) {
                // Có thể thêm thông báo lỗi, ví dụ: $_SESSION['error'] = "Số lượng sản phẩm trong kho không đủ!";
                header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '?act=/'));
                exit;
            }

            // 4. Khởi tạo giỏ hàng nếu chưa có
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            // 5. Thêm sản phẩm vào giỏ hàng
            if (isset($_SESSION['cart'][$productId])) {
                // Nếu có, cập nhật số lượng
                $_SESSION['cart'][$productId]['quantity'] += $quantity;
            } else {
                // Nếu chưa, thêm mới với thông tin lấy từ CSDL
                $_SESSION['cart'][$productId] = [
                    'product_name' => $product['product_name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'quantity' => $quantity
                ];
            }

            // Chuyển hướng người dùng đến trang giỏ hàng
            header('Location: ?act=cart');
            exit;
        }
    }

    public function updateCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
            $_SESSION['cart_errors'] = []; // Xóa lỗi cũ trước khi kiểm tra

            foreach ($_POST['quantity'] as $productId => $quantity) {
                $productId = (int)$productId;
                $quantity = (int)$quantity;

                if (isset($_SESSION['cart'][$productId])) {
                    if ($quantity > 0) {
                        // Lấy thông tin sản phẩm từ DB để kiểm tra tồn kho
                        $product = $this->modelProduct->getProductById($productId);
                        if ($product && $quantity > $product['quantity']) {
                            // Nếu số lượng cập nhật vượt quá tồn kho, đặt lại bằng số lượng tối đa
                            // và lưu một thông báo lỗi vào session để hiển thị cho người dùng
                            $_SESSION['cart'][$productId]['quantity'] = $product['quantity'];
                            $_SESSION['cart_errors'][$productId] = "Chỉ còn " . $product['quantity'] . " sản phẩm trong kho.";
                        } else {
                            // Nếu số lượng hợp lệ, cập nhật bình thường
                            $_SESSION['cart'][$productId]['quantity'] = $quantity;
                        }
                    } else {
                        // Xóa nếu số lượng là 0 hoặc âm
                        unset($_SESSION['cart'][$productId]);
                    }
                }
            }
        }
        header('Location: ?act=cart');
        exit;
    }

    public function removeFromCart()
    {
        $productId = $_GET['id'] ?? null;
        if ($productId && isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
            // Cũng nên xóa lỗi liên quan nếu có
            unset($_SESSION['cart_errors'][$productId]);
        }
        header('Location: ?act=cart');
        exit;
    }
}
