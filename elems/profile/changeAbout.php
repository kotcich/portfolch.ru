<?php
if (isset($_COOKIE['auth']) and isset($_GET['id']) and isset($_GET['p'])) {
    session_start();
    include($_SERVER['DOCUMENT_ROOT'].'/elems/bd.php');
    $title = 'О себе';
    $p = trim($_GET['p'], '?');
    $id = trim($_GET['id'], '?');
    include($_SERVER['DOCUMENT_ROOT'].'/elems/header.php');

    $main = "<div class = 'profile_change_about'><form method = 'POST'>
    <textarea name = 'text' maxlength = '500' rows = '5' placeholder = 'От 30 до 500 символов'></textarea>
    <input type = 'submit' value = 'Поменять'>
    </form></div>";

    function changeAbout($link, $id, $p) {
        if (isset($_POST['text'])) {
            $text = mysqli_real_escape_string($link, $_POST['text']);

            if (strlen($text) >= 30) {
                $query = "UPDATE about SET `text` = '$text' WHERE `user_id` = $id";
                mysqli_query($link, $query);

                $_SESSION['message'] = "<span class = 'profile_success'>Вы успешно изменили \"о себе\"</span>";

                header('Location: /elems/profile/profile.php?p='.$p);
            }
        }
    }
    changeAbout($link, $id, $p);

    include($_SERVER['DOCUMENT_ROOT'].'/elems/layout.php');
} else {
    session_start();
    $_SESSION['message'] = "<span class = 'post_error_stop'>Даже не думай</span>";

    header('Location: /');
}