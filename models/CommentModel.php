<?php
class CommentModel
{
    public $connection;

    public function __construct()
    {
        $this->connection = connectDB();
    }

    public function countComments()
    {
        $sql = "SELECT COUNT(*) FROM `comments`";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getAllComments()
    {
        $sql = "SELECT 
                    c.comment_id, c.content, c.date, c.status,
                    p.product_id, p.product_name,
                    u.user_id, u.user_name
                FROM comments c
                JOIN products p ON c.product_id = p.product_id
                JOIN users u ON c.user_id = u.user_id
                ORDER BY c.date DESC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteComment($comment_id)
    {
        $sql = "DELETE FROM comments WHERE comment_id = :comment_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function insertComment($product_id, $user_id, $content)
    {
        $sql = "INSERT INTO comments (product_id, user_id, content, date, status) 
                VALUES (:product_id, :user_id, :content, NOW(), 0)";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->execute();
        return $this->connection->lastInsertId();
    }

    // Cập nhật trạng thái bình luận 
    public function updateCommentStatus($comment_id, $status)
    {
        $sql = "UPDATE comments SET status = :status WHERE comment_id = :comment_id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Lấy các bình luận đã được duyệt của một sản phẩm
    public function getCommentsByProductId($product_id)
    {
        $sql = "SELECT c.*, u.user_name, u.avatar 
                FROM `comments` c
                JOIN `users` u ON c.user_id = u.user_id
                WHERE c.product_id = :product_id AND c.status = 1
                ORDER BY c.date DESC";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
