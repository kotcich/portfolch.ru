<?php
if (isset($_COOKIE['auth']) and $_COOKIE['status'] == 3) {
    session_start();
    include($_SERVER['DOCUMENT_ROOT'].'/elems/bd.php');
    $title = 'Админка';
    $header = "<h1><a href = \"/\">Портфоляч</a></h1>";

    if (isset($_SESSION['message'])) {  // Вывод флеш сообщения и последующее удаление оного
        echo $_SESSION['message'];
        $_SESSION['message'] = null;
    }

    $id = $_COOKIE['id'];
    $query = "SELECT `login`, `status` FROM users WHERE id = $id";
    $profile = mysqli_fetch_assoc(mysqli_query($link, $query))['login'];

    $header .= "<div id = \"logout\"><a href = \"/elems/auth/logout.php\">Выход</a></div>
    <div id = \"auth\"><span>Профиль:</span><a href = \"/elems/profile/profile.php?p=$profile\">$profile</a></div>";

    $query = "SELECT `login`, `status` FROM users ORDER BY id DESC";  // Селекчу юзеров
    $result = mysqli_query($link, $query);
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

    $main = "<div class = 'admin'>";
    $main .= "<div class = 'users'><table><tr><th>login</th><th>status</th><th>root</th><th>ban</th><th>delete</th></tr>";
    foreach ($data as $data) {
        $login = $data['login'];
        if ($data['status'] == 1) {
            $status = 'Пользователь';
            $class = 'one';
            $i = 2;
            $text = 'Модернуть';
        } elseif ($data['status'] == 2) {
            $status = 'Модер';
            $class = 'two';
            $i = 1;
            $text = 'Понизить';
        } elseif ($data['status'] == 0) {
            $status = 'Забанен';
            $class = 'zero';
            $i = 1;
            $text = 'Разбанить';
        } else {
            $status = 'Админ';
            $class = 'three';
            $i = 2;
            $text = 'Понизить';
        }

        $main .= "<tr><td>$login</td>
        <td><span class = '$class'>$status<span></td>
        <td><a href = '/admin/elems/roots/$i.php?login=$login'>$text</a></td>
        <td><a href = '/admin/elems/roots/ban.php?login={$data['login']}'>Забанить</a></td>
        <td><a href = '/admin/elems/roots/delete.php?login={$data['login']}'>Удалить</a></td>
        </tr>";
    }
    $main .= "</table></div>";

    $query = "SELECT `id`, `name` FROM posts ORDER BY id DESC"; // Селекчу посты
    $result = mysqli_query($link, $query);
    for ($posts = []; $elem = mysqli_fetch_assoc($result); $posts[] = $elem);

    $main .= "<div class = 'posts'><table><tr><th>name</th><th>delete</th></tr>";
    foreach ($posts as $post) {
        $id = $post['id'];
        $name = $post['name'];
        $main .= "<tr>
        <td class = 'postName'>$name</td>
        <td><a href = '/admin/elems/roots/deletePost.php?id=$id'>Удалить</a></td>
        </tr>";
    }
    $main .="</table></div></div>";

    include($_SERVER['DOCUMENT_ROOT'].'/elems/layout.php');
} else {
    session_start();
    $_SESSION['message'] = "<span class = 'post_error_stop'>Даже не думай</span>";

    header('Location: /') or die();
}