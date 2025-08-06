<?php
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
class CategoryModel
{
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

    public function insertCategory($category_name)
    {
        $sql = "INSERT INTO `categories` (`category_name`) VALUES (:category_name)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':category_name', $category_name);
        $stmt->execute();
    }

    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM `categories` WHERE `category_id` = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function updateCategory($id, $category_name)
    {
        $sql = "UPDATE `categories` SET `category_name` = :category_name WHERE `category_id` = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':category_name', $category_name);
        $stmt->execute();
    }
    public function deleteCategory($id)
    {
        $sql = "DELETE FROM `categories` WHERE `category_id` = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
