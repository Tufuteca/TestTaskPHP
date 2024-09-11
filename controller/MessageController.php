<?php
require_once '../model/Message.php';
require_once '../model/db.php';
class MessageController {
    private $messageModel;
    private $messagesPerPage = 5;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->messageModel = new Message($db);
    }

    public function getMessages($page = 1) {
        $offset = ($page - 1) * $this->messagesPerPage;
        $stmt = $this->messageModel->getMessagesByPage($offset, $this->messagesPerPage);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalMessages() {
        return $this->messageModel->getTotalMessages();
    }

    public function getTotalPages() {
        $totalMessages = $this->getTotalMessages();
        return ceil($totalMessages / $this->messagesPerPage);
    }
    public function getMessageById($id) {
        $stmt = $this->messageModel->getMessageById($id);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function addMassage($title,$summary,$fullcontent,$idUser) {
        echo $title." ". $summary . " ". $fullcontent. " ". $idUser;
        if(!empty($title) && !empty($summary) && !empty($fullcontent) && !empty($idUser)) {
            $this->messageModel->addMessage($title,$summary,$fullcontent,$idUser);
            header('Location: /view');
        }
    }
    public function updateMessage($idMessage, $title, $summary, $fullcontent)
    {
        $this->messageModel->updateMessage($idMessage, $title, $summary, $fullcontent);
        header('Location: /view/message-details.php?id='.$idMessage);
    }
}
?>
