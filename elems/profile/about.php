<?
$query = "SELECT COUNT(*) as count FROM about WHERE `user_id` = $id"; // Проверяю заполнено поле "о себе"
$count = mysqli_fetch_assoc(mysqli_query($link, $query))['count'];

if ($count) {  // Вывод "о себе"
    $query = "SELECT `text` FROM about WHERE `user_id` = $id";
    $text = mysqli_fetch_assoc(mysqli_query($link, $query))['text'];
    $main .= "<div class = 'profile_about_text'>$text</div>";
} elseif (!$count and $_GET['p'] == $profile) { // Вывод формы для заполнения "о себе"
    $main .= "<div class = 'profile_about_form'>Расскажите о себе
    <form method = 'POST'>
    <textarea name = 'text' maxlength = '500' rows = '5' placeholder = 'от 30 до 500 символов'></textarea>
    <input type = 'submit'>
    </form></div>";
}

function postAbout($link, $id, $title) {  // Добавляю информацию о пользователе если он ее ввел
    if (isset($_POST['text']) and strlen($_POST['text']) >= 30) {
        $text = mysqli_real_escape_string($link, $_POST['text']);
        $query = "INSERT INTO about SET `text` = '$text', `user_id` = $id";
        mysqli_query($link, $query);

        $_SESSION['message'] = "<span class = 'profile_success'>Вы успешно заполнили \"о себе\"</span>";

        header('Location: /elems/profile/profile.php?p='.$title);
    }
}
postAbout($link, $id, $title);