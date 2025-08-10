
    <?php
    // Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
    class ProductModel
    {
        public $connection; // Biến kết nối CSDL
        public function __construct()
        {
            $this->connection = connectDB();
        }

        // Viết truy vấn danh sách sản phẩm 
        public function getAllProduct()
        {
            $sql = "SELECT * FROM `products` INNER JOIN `categories` WHERE `products`.`category_id` = `categories`.`category_id`";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getProductByHot($hot)
        {
            $sql = "SELECT * FROM `products` WHERE `hot` = :hot";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':hot', $hot, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getProductsByCategory($categoryId)
        {
            $sql = "SELECT * FROM `products` WHERE `category_id` = :categoryId";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function countProducts()
        {
            $sql = "SELECT COUNT(*) FROM `products`";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        }
        public function insertProduct($product_name, $price, $quantity, $description, $image, $category_id, $hot)
        {
            $sql = "INSERT INTO `products` (`product_name`, `price`, `quantity`, `description`, `image`, `category_id`, `hot`) VALUES (:product_name, :price, :quantity, :description, :image, :category_id, :hot)";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':hot', $hot, PDO::PARAM_INT);
            $stmt->execute();
        }

        public function getProductById($id)
        {
            $sql = "SELECT * FROM `products` WHERE `product_id` = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        }

        public function updateProduct($id, $product_name, $price, $quantity, $description, $image, $category_id, $hot)
        {
            $sql = "UPDATE `products` SET `product_name` = :product_name, `price` = :price, `quantity` = :quantity, `description` = :description, `image` = :image, `category_id` = :category_id, `hot` = :hot WHERE `product_id` = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->bindParam(':hot', $hot, PDO::PARAM_INT);
            $stmt->execute();
        }

        public function deleteProduct($id)
        {
            $sql = "DELETE FROM `products` WHERE `product_id` = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }

        public function getCommentByProductId($id)
        {
            $sql = "
                SELECT c.comment_id, c.content, c.date, 
                    u.user_id, u.user_name, u.avatar
                FROM comments c
                INNER JOIN users u ON c.user_id = u.user_id
                WHERE c.product_id = :id
                ORDER BY c.date DESC
            ";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
