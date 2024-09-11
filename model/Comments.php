<?php
class Comments
{
    private $conn;
    private $table_name = "comments";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addComment($text, $message_idMessage, $users_idUsers)
    {
        $query = "INSERT INTO " . $this->table_name . " (text, message_idMessage, users_idUsers) 
                  VALUES (:text, :message_idMessage, :users_idUsers)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':message_idMessage', $message_idMessage);
        $stmt->bindParam(':users_idUsers', $users_idUsers);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getCommentsByMessage($message_idMessage)
    {
        $query = "SELECT comments.*, users.username 
                  FROM " . $this->table_name . " 
                  JOIN users ON comments.users_idUsers = users.idUsers 
                  WHERE comments.message_idMessage = :message_idMessage";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':message_idMessage', $message_idMessage);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
