<?php
class Users
{
    private $conn;
    private $table_name = "users";

    public function __construct($db){
        $this->conn = $db;
    }

    public function register($username, $password) {
        try {
            $query = "INSERT INTO $this->table_name (username, password) VALUES (:username, :password)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $exception) {
            echo "Ошибка выполнения запроса: " . $exception->getMessage();
            return false;
        }
    }

    public function getUserByUsername($username) {
        try {
            $query = "SELECT idUsers, username, password FROM $this->table_name WHERE username = :username";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Ошибка выполнения запроса: " . $exception->getMessage();
            return false;
        }
    }
}
?>
