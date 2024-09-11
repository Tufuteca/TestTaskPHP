<?php

require_once '../model/Users.php';
require_once '../model/db.php';
session_start();
class AuthorizationController
{
    private $userModel;

    public function __construct(){
        $database = new Database();
        $db = $database->getConnection();
        $this->userModel = new Users($db);
    }

    public function authorization($username, $password){
        if (empty($username) || empty($password)) {
            echo "Имя пользователя и пароль не могут быть пустыми.";
            return false;
        }
        $user = $this->userModel->getUserByUsername($username);
        if ($user) {
            if (password_verify($password, $user['password'])) {
                echo "Успешная авторизация.";
                $_SESSION['auth'] = true;
                $_SESSION['idUser'] = $user['idUsers'];
                header('Location: /view');
            } else {
                echo "Неверный пароль.";
            }
        } else {
            echo "Пользователь не найден.";
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $authorizationController = new AuthorizationController();
    $authorizationController->authorization($username, $password);
}