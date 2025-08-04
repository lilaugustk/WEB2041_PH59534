<?php
require_once './models/ProductModel.php';
require_once './models/CategoryModel.php';
require_once './models/UserModel.php';
// require_once './models/PostModel.php';
// require_once './models/CommentModel.php';

class DashboardController {
    public function index() {
        require_once './views/dashboard.php';
    }
}
?>
