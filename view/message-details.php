<?php
session_start();
$id = 0;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
require_once 'blocks/header.php';
require_once '../controller/MessageController.php';
require_once '../controller/CommentsController.php';

$controller = new MessageController();
$message = $controller->getMessageById($id);

$commentsController = new CommentsController();
$comments = $commentsController->getCommentsByMessage($id);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateMessage'])) {
    $messageTitle = $_POST['messageTitle'];
    $messageContent = $_POST['messageContent'];
    $summary = $_POST['summary'];
    $controller->updateMessage($id, $messageTitle, $messageContent, $summary);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addComments'])) {
    $users_idUsers = $_POST['users_idUsers'];
    $message_idMessage = $_POST['message_idMessage'];
    $text = $_POST['text'];
    $commentsController->addComment($text,$message_idMessage,$users_idUsers);
}

?>

<div class="container my-5 py-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12 col-lg-10">
            <div class="card text-body">
                <div class="card-body p-4">
                    <h4 class="mb-0">Сообщение</h4>
                    <?php if(!empty($_SESSION)){
                    if($_SESSION['idUser'] == $message['users_idUsers']){
                    echo '<a href="#" data-bs-toggle="modal" data-bs-target="#editMessageModal">Изменить сообщение</a>';
                    }}?>
                    <div class="card mb-2 mt-2">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $message['title']; ?></h5>
                            <p class="card-text"><?php echo $message['fullcontent']; ?></p>
                            <p class="card-text">Автор: <?php echo $message['username']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <h4 class="mb-0">Комментарии</h4>
                    <div class="mb-4">
                        <!-- Форма добавления комментария -->
                        <?php if(!empty($_SESSION['idUser'])){ ?>
                        <form action="" method="POST">
                            <div class="form-group">
                                <textarea class="form-control" name="text" rows="3" placeholder="Ваш комментарий..."></textarea>
                            </div>
                            <input type="hidden" name="message_idMessage" value="<?php echo $id; ?>">
                            <input type="hidden" name="users_idUsers" value="<?php echo $_SESSION['idUser']; ?>">
                            <button type="submit" name="addComments" class="btn btn-primary mt-2">Добавить комментарий</button>
                        </form>
                        <?php }?>
                    </div>

                    <!-- Отображение комментариев -->
                    <?php foreach ($comments as $comment): ?>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-1"><?php echo $comment['username']; ?></h6>
                            <p class="mb-0"><?php echo $comment['text']; ?></p>
                        </div>
                        <hr class="my-0" />
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Модальное окно для изменения сообщения -->
<div class="modal fade" id="editMessageModal" tabindex="-1" aria-labelledby="editMessageLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMessageLabel">Изменить сообщение</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="messageId" value="<?php echo $message['idMessage']; ?>" />
                    <div class="mb-3">
                        <label for="messageTitle" class="form-label">Заголовок</label>
                        <input type="text" class="form-control" id="messageTitle" name="messageTitle" value="<?php echo $message['title']; ?>" required />
                    </div>
                    <div class="mb-3">
                        <label for="summary" class="form-label">Краткое описание</label>
                        <textarea class="form-control" id="summary" name="summary" maxlength="100" oninput="updateCharCount()" required><?php echo $message['summary']; ?></textarea>
                        <small id="charCount"></small>
                    </div>
                    <div class="mb-3">
                        <label for="messageContent" class="form-label">Сообщение</label>
                        <textarea class="form-control" id="messageContent" name="messageContent" rows="4" required><?php echo $message['fullcontent']; ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" name="updateMessage" class="btn btn-primary">Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>
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
require_once 'blocks/footer.php';
?>
