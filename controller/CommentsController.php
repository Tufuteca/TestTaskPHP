<?php
require_once '../model/Comments.php';
require_once '../model/db.php';

class CommentsController
{
    private $commentsModel;

    public function __construct(){
        $database = new Database();
        $db = $database->getConnection();
        $this->commentsModel = new Comments($db);
    }

    public function getCommentsByMessage($message_id){
        $stmt = $this->commentsModel->getCommentsByMessage($message_id);
        return $stmt;
    }
    public function addComment($text,$message_idMessage,$users_idUsers,){
        $stmt = $this->commentsModel->addComment($text,$message_idMessage,$users_idUsers);
        header('Location: /view/message-details.php?id='.$message_idMessage);
    }


}