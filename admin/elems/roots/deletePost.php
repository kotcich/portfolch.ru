<?php
if ($_COOKIE['status'] == 3 and isset($_GET['id'])) {
    session_start();
    include($_SERVER['DOCUMENT_ROOT'].'/elems/bd.php');
    $title = 'Удаление страницы';
    $id = $_GET['id'];

    $query = "DELETE FROM messages WHERE post_id = $id";
    mysqli_query($link, $query) or die(mysqli_error($link));

    $query = "DELETE FROM posts WHERE id = $id";
    mysqli_query($link, $query);

    $_SESSION['message'] = "<span class = 'admin_success'>Пост удален</span>";

    header('Location: /admin/') or die();
} else {
    session_start();
    $_SESSION['message'] = "<span class = 'post_error_stop'>Даже не думай</span>";

    header('Location: /') or die();
}