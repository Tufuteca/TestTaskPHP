<?php
class Message {
    private $conn;
    private $table_name = "message";

    public function __construct($db) {
        $this->conn = $db;
    }
    public function getMessagesByPage($offset, $limit) {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY idMessage DESC LIMIT :offset, :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function getTotalMessages() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getMessageById($idMessage) {
        $query = "SELECT * FROM message JOIN users ON users.idUsers = message.users_idUsers WHERE idMessage = :idMessage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idMessage', $idMessage, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    public function addMessage($title, $summary, $fullcontent, $idUser) {
        $query = "INSERT INTO " . $this->table_name . " (title, summary, fullcontent, users_idUsers) VALUES (:title, :summary, :fullcontent, :idUser)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':summary', $summary, PDO::PARAM_STR);
        $stmt->bindParam(':fullcontent', $fullcontent, PDO::PARAM_STR);
        $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "Запрос выполнен успешно";
        } else {
            echo "Ошибка выполнения запроса: " . implode(", ", $stmt->errorInfo());
        }
    }


    public function updateMessage($idMessage, $title, $summary, $fullcontent) {
        $query = "UPDATE " . $this->table_name . " SET title = :title, summary = :summary, fullcontent = :fullcontent WHERE idMessage = :idMessage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idMessage', $idMessage, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':summary', $summary, PDO::PARAM_STR);
        $stmt->bindParam(':fullcontent', $fullcontent, PDO::PARAM_STR);
        return $stmt->execute();
    }

}
