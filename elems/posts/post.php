<?
if (isset($_GET['id'])) {  // Запрещаю вход без id поста
    session_start();
    include($_SERVER['DOCUMENT_ROOT'].'/elems/bd.php');
    $post_id = trim($_GET['id'], '?');

    // Header

    $header = "<h1><a href = \"/\">Портфоляч</a></h1>";

    if (isset($_COOKIE['auth'])) {
        $id = $_COOKIE['id'];
        $query = "SELECT `login`, `status` FROM users WHERE id = $id";
        $profile = mysqli_fetch_assoc(mysqli_query($link, $query))['login'];
        $status = mysqli_fetch_assoc(mysqli_query($link, $query))['status'];

        if ($_COOKIE['status'] != $status) {  // Проверяю изменили ли админ статус пользователя и затем меняю его
            $_COOKIE['status'] = $status;
        }
            
        if ($_COOKIE['status'] != 0) {  // Проверка пользователя на бан
            $header .= "<div id = \"logout\"><a href = \"/elems/auth/logout.php\">Выход</a></div>
            <div id = \"auth\"><span>Профиль:</span><a href = \"/elems/profile/profile.php?p=$profile\">$profile</a></div>";
        } else {
            $_SESSION['message'] = "<span class = 'post_error_stop'>Ты забанен</span>";

            header('Location: /');
        }
    } else {
        $header .= "<div id = \"auth\"><a href = \"/registration\">Sign up</a><a href = \"/login\">Sign in</a></div>";
    }

    // ...

    if (isset($_SESSION['message'])) {  // Вывод флеш сообщения и последующее удаление оного
        echo $_SESSION['message'];
        $_SESSION['message'] = null;
    }

    function deletePost($link, $post_id) {  // Удаление поста вместе со всеми сообщениями
        if (isset($_POST['delete_post'])) {
            $query = "DELETE FROM messages WHERE post_id = $post_id";
            mysqli_query($link, $query) or die(mysqli_error($link));

            $query = "DELETE FROM posts WHERE id = $post_id";
            mysqli_query($link, $query) or die(mysqli_error($link));

            $_SESSION['message'] = "<span class = 'posts_success_delete'>Пост успешно удален</span>";

            header('Location: /');
        }
    }

    function postMessage($link, $post_id) {  // Пост сообщения
        if (isset($_POST['text']) and $_POST['text'] != '') {
            $text = mysqli_real_escape_string($link, $_POST['text']);
            $date = date('Y-m-d H:i:s', time());
            $user_id = $_COOKIE['id'];
            if (isset($_GET['an_id'])) {
                $answer_user_id = trim($_GET['an_id'], '?');
            } else {
                $answer_user_id = 0;
            }

            $query = "INSERT INTO messages (`text`, `date`, `user_id`, `answer_user_id`, `post_id`) VALUES ('$text', '$date', $user_id, $answer_user_id, $post_id)";
            mysqli_query($link, $query);

            $_SESSION['message'] = "<span class = 'posts_success_message'>Сообщение успешно отправленно</span>";

            header('Location: /elems/posts/post.php?id='.$post_id) or die();
        }
    }

    deletePost($link, $post_id);
    postMessage($link, $post_id);

    include($_SERVER['DOCUMENT_ROOT'].'/elems/posts/messages.php');  // Вывод сообщений

    // Main

    $query = "SELECT `name`, `text`, `date_add`, `img`, users.login as `login` FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE posts.id = $post_id";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

    $title = $data[0]['name'];
    $name = $data[0]['name'];
    $text = $data[0]['text'];
    $date_add = preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$3.$2.$1 $4:$5:$6', $data[0]['date_add']);
    $img = '/elems/img/'.$data[0]['img'];
    $login = $data[0]['login'];

    $main = "<div class = 'post_wrapper'>
    <div class = 'post_header'><span class = 'post_name'>$name </span><a href = '/elems/profile/profile.php?p=$login'>$login</a> $date_add #$post_id</div> 
    <img src = '$img' class = 'post_img'>
    <span class = 'post_text'>$text</span>
    </div>";

    if (isset($_COOKIE['auth'])) {
        $main .= "<div class = 'post_form_wrapper'>";
        if (isset($_GET['an_id'])) {
            $an_id = trim($_GET['an_id'], '?');
            $query = "SELECT `login` FROM users WHERE `id` = $an_id";
            $post_answer_login = mysqli_fetch_assoc(mysqli_query($link, $query))['login'];

            $main .= '<span>Выскажи свое неуважение <a href = \'/elems/profile/profile.php?p='.$post_answer_login.'\'>'.$post_answer_login.'</a></span>';
        } else {
            $main .= '<span>Выскажи свое неуважение</span>';
        }
        $main .= "<form method = 'POST'>
        <textarea name = 'text' rows = '10' class = 'post_textarea' maxlength = '2000' placeholder = '2000 символов макс.'></textarea>
        <input type = 'submit'>";
        if (isset($_COOKIE['auth']) and $_COOKIE['status'] >= 2) {  // Вывод кнопки удаления поста только модерам и админу
            $main .= "<input type = 'submit' name ='delete_post' class = 'delete_post' value = 'Удалить пост'>";
        }
        $main .= "</form></div>";
    }

    // ...

    include($_SERVER['DOCUMENT_ROOT'].'/elems/layout.php');
} else {
    session_start();
    $_SESSION['message'] = "<span class = 'post_error_stop'>Даже не думай</span>";

    header('Location: /');
}