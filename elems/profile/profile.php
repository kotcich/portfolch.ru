<?php
if (empty($_COOKIE['auth']) or isset($_COOKIE['auth']) and $_COOKIE['status'] != 0) {
    require($_SERVER['DOCUMENT_ROOT'].'/elems/bd.php');
    require($_SERVER['DOCUMENT_ROOT'].'/elems/header.php');
    $title = trim($_GET['p'], '?');
    $profile = trim($_GET['p'], '?');
//    $status = mysqli_fetch_assoc(mysqli_query($link, $query))['status'];
    session_start();

    if (isset($_SESSION['message'])) {  // Вывод флеш сообщения и последующее удаление оного
        echo $_SESSION['message'];
        $_SESSION['message'] = null;
    }

    $query = "SELECT `id`, `login`, `email`, `date_birth`, `date_registration`, `status` FROM users WHERE `login` = '$title'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    for ($user = []; $row = mysqli_fetch_assoc($result); $user[] = $row);

    $id = $user[0]['id'];
    $login = $user[0]['login'];
    $email = $user[0]['email'];
    $age = explode('-', $user[0]['date_birth']);
    $query = "SELECT TIMESTAMPDIFF(YEAR,'$age[0]-$age[1]-$age[2]',NOW()) AS age";
    $age = mysqli_fetch_assoc(mysqli_query($link, $query))['age'];
    $date_registration = explode('-', $user[0]['date_registration']);
    $date_registration = date('d.m.Y', mktime(0, 0, 0, $date_registration[1], $date_registration[2], $date_registration[0]));
    switch ($user[0]['status']) {
        case 1:
            $status = 'Пользователь';
        break;
        case 0:
            $status = 'Забанен';
        break;
        case 2:
            $status = 'Модератор';
        break;
        case 3:
            $status = 'Админ';
        break;
    }

    if (trim($_GET['p'], '?') == $profile) {
        $header .= "<div class = 'addPost'><a href = '/elems/profile/changePassword.php?id=$id'>Сменить пароль</a></div>";
        $header .= "<a href = '/elems/profile/changeAbout.php?id=$id&p=$profile' class = 'profile_edit'>Редактировать \"о себе\"</a>";
    }
    if (isset($_COOKIE['status']) and $_COOKIE['status'] >= 2 and $_GET['p'] != $profile) {
        $header .= "<div class = 'profile_ban'><form method = 'POST'><input type = 'submit' name = 'ban' value = 'забанить'></form></div>";

        function banProfile($link, $id, $title) {  // Бан пользователя через его профиль модером или админом
            if (isset($_POST['ban'])) {
                $query = "UPDATE users SET `status` = 0 WHERE `id` = $id";
                mysqli_query($link, $query);

                $_SESSION['message'] = "<span class = 'profile_success'>Пользователь успешно забанен</span>";

                header('Location: /elems/profile/profile.php?p='.$title) or die();
            }
        }
        banProfile($link, $id, $title);
    }

    $main = "<div class = 'profile_data'>
    <p>Логин: <span class = ''>$login</span></p>
    <p>Почта: <span class = ''>$email</span></p>
    <p>Возраст: <span class = ''>$age</span></p>
    <p>Дата регистрации: <span class = ''>$date_registration</span></p>
    <p>Статус: <span class = ''>$status</span></p>
    </div>";

    include($_SERVER['DOCUMENT_ROOT'].'/elems/profile/about.php');  // Добавление формы "о себе" или самого текста

    $query = "SELECT `id`, `name` FROM posts WHERE `user_id` = $id ORDER BY id DESC";
    $result = mysqli_query($link, $query);
    for ($posts = []; $row = mysqli_fetch_assoc($result); $posts[] = $row);

    $count = count($posts);  // Проверка на то есть ли посты вообще
    if ($count > 0) {
        $footer = "<div class = 'profile_posts'><span class = 'profile_posts_grid'>Посты $title</span>";
        foreach ($posts as $post) {
            $footer .= "<p>$count) <a href = '/elems/posts/post.php?id={$post['id']}'>{$post['name']}</a></p>";
            $count--;
        }
        $footer .= "</div>";
    } else {
        $footer = "<div class = 'profile_posts'><span class = 'profile_posts_grid'>У пользователя нет постов</span></div>";
    }

    if (isset($_COOKIE['auth']) and $_COOKIE['id'] == $id) {  // Вывод последних ответов пользователю с возможностью перехода к ответу
        $query = "SELECT posts.id as post_id, posts.name, messages.id as message_id, users.login, messages.text FROM messages LEFT JOIN users ON messages.user_id = users.id
        LEFT JOIN posts ON messages.post_id = posts.id WHERE messages.answer_user_id = $id AND messages.date >= NOW() - INTERVAL 14 DAY ORDER BY messages.id DESC";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

        if (isset($data)) {
            $post_check = '';

            for ($i = 0; $i < count($data); $i++) {

                if ($post_check != $data[$i]['name']) {
                    $post_check = $data[$i]['name'];
                    $links[$i] = $data[$i];

                } elseif ($post_check == $data[$i]['name'] and $data[$i]['login'] != $data[$i - 1]['login']) {
                    $links[$i] = $data[$i];
                }
            }
        }

        if (isset($links)) {
            $name = '';
            $footer .= "<div class = 'profile_notes'><span class = 'profile_answers'>Ответы</span>";
            foreach ($links as $link) {
                $login_note = $link['login'];
                $post_id = $link['post_id'];
                $message_id = $link['message_id'];
                $message_text = $link['text'];

                if ($name != $link['name']) {
                    $name = $link['name'];
                    $footer .= "<a class = 'profile_note_name' href = '/elems/posts/post.php?id=$post_id'>$name</a>";
                }
                $footer .= "$login_note<br><a class = 'profile_note_message' href = '/elems/posts/post.php?id=$post_id#$message_id'>$message_text</a>";
            }
            $footer .= "</div>";
        }
    }

    include($_SERVER['DOCUMENT_ROOT'].'/elems/layout.php');
} else {
    session_start();
    $_SESSION['message'] = "<span class = 'post_error_stop'>Даже не думай</span>";

    header('Location: /');
}