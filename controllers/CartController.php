<?php

require_once './models/ProductModel.php';

class CartController
{
    private $modelProduct;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->modelProduct = new ProductModel();
    }

    public function showCart()
    {
        $sessionCart = $_SESSION['cart'] ?? [];
        $cart = [];

        if (!empty($sessionCart)) {
            foreach ($sessionCart as $productId => $item) {
                $product = $this->modelProduct->getProductById($productId);
                if ($product) {
                    $cart[$productId] = $item;
                    $cart[$productId]['max_quantity'] = $product['quantity'];
                }
            }
        }

        $cartErrors = $_SESSION['cart_errors'] ?? [];
        unset($_SESSION['cart_errors']);

        require_once './views/cart.php';
    }

    public function addToCart()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectBack();
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);

        if ($productId <= 0 || $quantity <= 0) {
            $_SESSION['cart_error'] = "Thông tin sản phẩm không hợp lệ";
            $this->redirectBack();
        }

        $product = $this->modelProduct->getProductById($productId);
        if (!$product) {
            $_SESSION['cart_error'] = "Sản phẩm không tồn tại";
            $this->redirectBack();
        }

        // Kiểm tra số lượng tồn kho
        $currentQuantity = $_SESSION['cart'][$productId]['quantity'] ?? 0;
        if (($quantity + $currentQuantity) > $product['quantity']) {
            $_SESSION['cart_error'] = "Chỉ còn " . $product['quantity'] . " sản phẩm trong kho";
            $this->redirectBack();
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = [
                'product_name' => $product['product_name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => $quantity
            ];
        }

        header('Location: ?act=cart');
        exit;
    }

    public function updateCart()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['quantity'])) {
            $this->redirectBack();
        }

        $_SESSION['cart_errors'] = [];

        foreach ($_POST['quantity'] as $productId => $quantity) {
            $productId = (int)$productId;
            $quantity = (int)$quantity;

            if (!isset($_SESSION['cart'][$productId])) {
                continue;
            }

            if ($quantity > 0) {
                $product = $this->modelProduct->getProductById($productId);
                if ($product && $quantity > $product['quantity']) {
                    $_SESSION['cart'][$productId]['quantity'] = $product['quantity'];
                    $_SESSION['cart_errors'][$productId] = "Chỉ còn " . $product['quantity'] . " sản phẩm trong kho.";
                } else {
                    $_SESSION['cart'][$productId]['quantity'] = $quantity;
                }
            } else {
                unset($_SESSION['cart'][$productId]);
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
            unset($_SESSION['cart_errors'][$productId]);
        }
        header('Location: ?act=cart');
        exit;
    }

    private function redirectBack()
    {
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '?act=/'));
        exit;
    }
}
