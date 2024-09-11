<?php
    session_start();
    unset($_SESSION['auth']);
    unset($_SESSION['idUser']);
    session_destroy();
    header('Location: /view/login.php');