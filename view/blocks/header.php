<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="container">
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="/view" class="nav-link px-2 link-secondary">Главная</a></li>
    </ul>
    <?php if(!empty($_SESSION['auth'])){?>
        <a href="/controller/logout.php"><button type="button" class="btn btn-outline-primary me-2" >Выйти из аккаунта</button></a>
    <?php }else{?>
    <div class="col-md-3 text-end">
        <a href="/view/login.php"><button type="button" class="btn btn-outline-primary me-2" >Войти</button></a>
        <a href="/view/register.php"><button type="button" class="btn btn-primary">Зарегистрироваться</button></a>
    </div>
    <?php }?>
</header>
