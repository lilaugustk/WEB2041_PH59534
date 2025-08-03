
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
    }
