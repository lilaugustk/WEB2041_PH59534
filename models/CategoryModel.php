<?php
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
class CategoryModel {
    public $connection; // Biến kết nối CSDL
    public function __construct()
    {
        $this->connection = connectDB();
    }
    public function countCategories()
    {
        $sql = "SELECT COUNT(*) FROM `categories`";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    public function getAllCategories()
    {
        $sql = "SELECT * FROM `categories`";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
