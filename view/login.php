<?php
$title = 'Авторизация';
require_once "blocks/header.php";
?>

<div class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-30 m-auto">
        <h1 class="h3 mb-3 fw-normal">Войдите в аккаунт</h1>
        <form method="post" action="../controller/AuthorizationController.php">
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="floatingInput" name="username" placeholder="Имя пользователя" required>
                <label for="floatingInput">Имя пользователя</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Пароль" required>
                <label for="floatingPassword">Пароль</label>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Войти</button>
        </form>
    </main>
</div>

<?php
require_once "blocks/footer.php";

?>
