<?
if ($_COOKIE['status'] == 3 and isset($_GET['login'])) {
    session_start();
    include($_SERVER['DOCUMENT_ROOT'].'/elems/bd.php');
    $title = 'Бан';
    $login = $_GET['login'];

    $query = "UPDATE users SET `status` = 0 WHERE `login` = '$login'";
    mysqli_query($link, $query);

    $_SESSION['message'] = "<span class = 'admin_success'>Пользователь забанен</span>";

    header('Location: /admin/') or die();
} else {
    session_start();
    $_SESSION['message'] = "<span class = 'post_error_stop'>Даже не думай</span>";

    header('Location: /') or die();
}