<?php
session_start();
$title = 'Главная страница';
require_once "blocks/header.php";
include_once '../controller/MessageController.php';
$controller = new MessageController();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$title = $_POST['title'];
$summary = $_POST['summary'];
$fullcontent = $_POST['fullcontent'];
$idUser = $_SESSION['idUser'];
$controller = new MessageController();
$controller->addMassage($title, $summary, $fullcontent,$idUser);
}

// Определение текущей страницы
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalPages = $controller->getTotalPages();
$messages = $controller->getMessages($page);
?>


<div class="container">

    <!-- Добавление сообщения -->
    <?php if (!empty($_SESSION)) { ?>
        <h5>Оставить свое сообщение</h5>
        <form class="w-30 mb-3" method="post" action="">
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="title" name="title">
                <label for="title">Введите заголовок сообщения</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="summary" name="summary" maxlength="100" oninput="updateCharCount()">
                <label for="summary">Введите краткое содержание сообщения</label>
                <small id="charCount"></small>
            </div>
            <div class="form-floating mb-2">
                <textarea class="form-control" name="fullcontent" id="fullcontent" style="height: 150px;"></textarea>
                <label for="fullcontent">Введите полное содержание сообщения</label>
            </div>
            <input type="submit" class="btn btn-primary">
        </form>
    <?php } else { ?>
        <h5 class="text-center mb-4">Для того чтобы оставлять сообщения и комментарии необходимо войти в профиль</h5>
    <?php } ?>


    <?php foreach ($messages as $message): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?php echo $message['title']; ?></h5>
                <p class="card-text text-truncate"><?php echo $message['summary']; ?></p>
                <a href="<?php echo '/view/message-details.php?id=' .  $message['idMessage'];?>" class="btn btn-primary float-end">Подробнее</a>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Навигация по страницам -->
    <nav aria-label="Page navigation" class="d-flex justify-content-center">
        <ul class="pagination">
            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo max($page - 1, 1); ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo min($page + 1, $totalPages); ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

</div>
<script>
    function updateCharCount() {
        const maxLength = 100;
        const inputField = document.getElementById('summary');
        const charCountDisplay = document.getElementById('charCount');
        const remainingChars = maxLength - inputField.value.length;
        if (remainingChars<20) {
            charCountDisplay.textContent = `${remainingChars}`;
        }else{
            charCountDisplay.textContent = '';
        }
    }
</script>
<?php
require_once "blocks/footer.php";
?>
