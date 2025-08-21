<?php

class UserModel
{
    public $connection; // Biến kết nối CSDL
    public function __construct()
    {
        $this->connection = connectDB();
    }
    // Kiểm tra đăng nhập
    public function checkLogin($email, $password)
    {
        try {
            $sql = 'SELECT * FROM users WHERE email = :email LIMIT 1';
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Gán 'user' nếu không có role
                $user['role'] = $user['role'] ?? 'user';
                return $user;
            }
            return false;
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return false;
        }
    }

    // Lấy thông tin người dùng theo ID
    public function getUserById($user_id)
    {
        try {
            $sql = 'SELECT * FROM users WHERE user_id = :user_id';
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':user_id' => $user_id]);
            $user = $stmt->fetch();
            $user['role'] = $user['role'] ?? 'user';
            return $user;
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return false;
        }
    }

    // Thêm người dùng mới
    public function createUser($user_name, $email, $password, $phone_number, $role = 'user')
    {
        try {
            // Hash password trước khi lưu
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users (user_name, email, password, phone_number, role) VALUES (:user_name, :email, :password, :phone_number, :role)';
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                ':user_name' => $user_name,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':phone_number' => $phone_number,
                ':role' => $role
            ]);
            return $this->connection->lastInsertId();
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return false;
        }
    }

    //Kiểm tra email đã tồn tại chưa
    public function emailExists($email)
    {
        try {
            $sql = 'SELECT COUNT(*) FROM users WHERE email = :email';
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':email' => $email]);
            return $stmt->fetchColumn() > 0; // Trả về true nếu email đã tồn tại
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return false;
        }
    }
    //Kiểm tra số điện thoại đã tồn tại chưa
    public function phoneNumberExists($phone_number)
    {
        try {
            $sql = 'SELECT COUNT(*) FROM users WHERE email = :email';
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':phone_number' => $phone_number]);
            return $stmt->fetchColumn() > 0; // Trả về true nếu số điện thoại đã tồn tại
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return false;
        }
    }

    public function countUsers()
    {
        $sql = "SELECT COUNT(*) FROM `users`";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM `users`";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertUser($user_name, $email, $password, $phone_number, $avatarPath, $role)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash password trước khi lưu
            $sql = "INSERT INTO `users` (`user_name`, `email`, `password`, `phone_number`, `avatar`, `role`) VALUES (:user_name, :email, :password, :phone_number, :avatar, :role)";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([
                ':user_name' => $user_name,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':phone_number' => $phone_number,
                ':avatar' => $avatarPath,
                ':role' => $role
            ]);
            return $this->connection->lastInsertId();
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return false;
        }
    }

    public function updateUser($id, $user_name, $email, $password, $phone_number, $avatarPath, $role)
    {
        try {
            // Bắt đầu câu lệnh SQL
            $sql = "UPDATE `users` SET `user_name` = :user_name, `email` = :email, `phone_number` = :phone_number, `role` = :role";
            $params = [
                ':id' => $id,
                ':user_name' => $user_name,
                ':email' => $email,
                ':phone_number' => $phone_number,
                ':role' => $role
            ];

            // Chỉ cập nhật mật khẩu nếu nó không rỗng và băm nó
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql .= ", `password` = :password";
                $params[':password'] = $hashedPassword;
            }

            // Chỉ cập nhật avatar nếu có đường dẫn mới (khác null)
            if ($avatarPath !== null) {
                $sql .= ", `avatar` = :avatar";
                $params[':avatar'] = $avatarPath;
            }

            $sql .= " WHERE `user_id` = :id";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return false;
        }
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM `users` WHERE `user_id` = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
