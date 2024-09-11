<?php

require_once '../model/Users.php';
require_once '../model/db.php';
class RegisterController
{
    private $userModel;

    public function __construct(){
        $database = new Database();
        $db = $database->getConnection();
        $this->userModel = new Users($db);
    }

    public function registerUser($username, $password){
        if(empty($username) || empty($password)) {
            echo "Имя пользователя и пароль не могут быть пустыми.";
            return false;
        }
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        if($this->userModel->register($username, $hashedPassword)) {
            echo "Пользователь успешно зарегистрирован.";
            header('Location: /view/login.php');
        } else {
            echo "Ошибка регистрации пользователя.";
            header('Location: /view/register.php');
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $registerController = new RegisterController();
    $registerController->registerUser($username, $password);
}