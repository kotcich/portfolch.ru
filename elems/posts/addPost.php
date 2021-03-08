<?
if (isset($_GET['sub']) and isset($_COOKIE['auth']) and $_COOKIE['status'] != 0) {
    session_start();
    include($_SERVER['DOCUMENT_ROOT'].'/elems/bd.php');
    $title = 'Добавление поста';

    // Header

    $header = "<h1><a href = \"/\">Портфоляч</a></h1>";

    $id = $_COOKIE['id'];
    $sub_category = trim(ruslit($_GET['sub']), '?');
    $query = "SELECT `id` FROM sub_categories WHERE `name` = '$sub_category'";
    $sub_category_id = mysqli_fetch_assoc(mysqli_query($link, $query))['id'];
    $sub = trim($_GET['sub'], '?');

    $query = "SELECT `login`, `status` FROM users WHERE id = $id";
    $profile = mysqli_fetch_assoc(mysqli_query($link, $query))['login'];
    $status = mysqli_fetch_assoc(mysqli_query($link, $query))['status'];

    if ($_COOKIE['status'] != $status) {  // Проверяю изменили ли админ статус пользователя и затем меняю его
        $_COOKIE['status'] = $status;
    }

    $header .= "<div id = \"logout\"><a href = \"/elems/auth/logout.php\">Выход</a></div>
    <div id = \"auth\"><span>Профиль:</span><a href = \"/elems/profile/profile.php?p=$profile\">$profile</a></div>";

    // ...

    // Main

    $main ="<div class = 'flex'><form method = 'POST' enctype = 'multipart/form-data'>
    Название<br><textarea name = 'name' rows = '3' maxlength = '150' placeholder = '20 символов мин. 150 символов макс.'></textarea>
    Текс<br><textarea name = 'text' rows = '15' maxlength = '2000' placeholder = '2000 символов макс.'></textarea>
    <input type = 'file' name = 'img'>
    <input type = 'submit' value = 'Опубликовать'>
    </form></div>";

    if (isset($_SESSION['message'])) {  // Вывод флеш сообщения и последующее удаление оного
        echo $_SESSION['message'];
        $_SESSION['message'] = null;
    }

    // ...

    function addPost($link, $sub_category_id, $sub, $id) {
        if (isset($_POST['name']) and isset($_POST['text'])) {
            $name = mysqli_real_escape_string($link, $_POST['name']);
            $text = mysqli_real_escape_string($link, $_POST['text']);
            $date_add = date('Y-m-d H:i:s', time());
            $targer = '../img/'.$_FILES['img']['name'];  // Путь по которому я передам загруженный файл
            if (move_uploaded_file($_FILES['img']['tmp_name'], $targer)) {  // Получаю загруженный файл в нужную мне папку
                $img = $_FILES['img']['name'];
            } else {
                $img = 'gray.png';
            }

            if (strlen($name) >= 20) {
                $query = "INSERT INTO posts SET `name` = '$name', `text` = '$text', `sub_category_id` = $sub_category_id, `date_add` = '$date_add', `user_id` = $id,
                `img` = '$img'";
                mysqli_query($link, $query);

                $_SESSION['message'] = "<span class = 'addPost_success'>Пост успешно опубликован</span>";

                header('Location: /elems/posts/posts.php?sub='.$sub) or die();
            } else {
                $_SESSION['message'] = "<span class = 'addPost_error'>Слишком короткое название</span>";

                header('Location: /elems/posts/addPost.php?sub='.$sub) or die();
            }
        }
    }
    addPost($link, $sub_category_id, $sub, $id);

    include($_SERVER['DOCUMENT_ROOT'].'/elems/layout.php');
} else {
    session_start();
    $_SESSION['message'] = "<span class = 'addPost_error_stop'>Даже не думай</span>";

    header('Location: /');
}