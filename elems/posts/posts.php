<?
if (isset($_GET['sub'])) {  // Запрещаю вход без имени саб категории
    session_start();
    include($_SERVER['DOCUMENT_ROOT'].'/elems/bd.php');

    $sub_category = trim(ruslit($_GET['sub']), '?');
    $title = $sub_category;
    $query = "SELECT `id` FROM sub_categories WHERE name = '$sub_category'";
    $sub_category_id = mysqli_fetch_assoc(mysqli_query($link, $query))['id'];

    // Header

    $header = "<h1><a href = \"/\">Портфоляч</a></h1>";

    if (!empty($_COOKIE['auth'])) {
        $id = $_COOKIE['id'];
        $query = "SELECT `login`, `status` FROM users WHERE id = $id";
        $profile = mysqli_fetch_assoc(mysqli_query($link, $query))['login'];
        $status = mysqli_fetch_assoc(mysqli_query($link, $query))['status'];
        $sub = trim($_GET['sub'], '?');

        if ($_COOKIE['status'] != $status) {  // Проверяю изменили ли админ статус пользователя и затем меняю его
            $_COOKIE['status'] = $status;
        }

        if ($_COOKIE['status'] != 0) {  // Проверка пользователя на бан
            $header .= "<div id = \"logout\"><a href = \"/elems/auth/logout.php\">Выход</a></div>
            <div id = \"auth\"><span>Профиль:</span><a href = \"/elems/profile/profile.php?p=$profile\">$profile</a></div>
            <div class = 'addPost'><a href = '/elems/posts/addPost.php?sub=$sub'>Сделать пост</a></div>";
        } else {
            $_SESSION['message'] = "<span class = 'posts_error_stop'>Ты забанен</span>";

            header('Location: /') or die();
        }
    } else {
        $header .= "<div id = \"auth\"><a href = \"/registration\">Sign up</a><a href = \"/login\">Sign in</a></div>";
    }

    // ...

    if (isset($_SESSION['message'])) {  // Вывод флеш сообщения и последующее удаление оного
        echo $_SESSION['message'];
        $_SESSION['message'] = null;
    }

    // Main

    $query = "SELECT `id`, `name`, `text`, `img` FROM posts WHERE `sub_category_id` = $sub_category_id ORDER BY `id` DESC";
    $result = mysqli_query($link, $query);
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

    $main = "<div class = 'wrapper_posts_grid'>";
    foreach ($data as $post) {
        $post_id = $post['id'];
        $name = $post['name'];
        $text = $post['text'];
        $img = '/elems/img/'.$post['img'];

        $main .= "<a href = '/elems/posts/post.php?id=$post_id' class = 'link_post_grid'><div class = 'post_grid'>
        <img src = '$img' class = 'img_post_grid'>
        <div>$name</div>
        <p>$text</p>
        </div></a>";
    }
    $main .= '</div>';

    // ...

    include($_SERVER['DOCUMENT_ROOT'].'/elems/layout.php');
} else {
    session_start();
    $_SESSION['message'] = "<span class = 'posts_error_stop'>Даже не думай</span>";

    header('Location: /');
}