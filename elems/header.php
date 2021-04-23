<?php
$header = "<h1><a href = '/'>Портфоляч</a></h1>";
if (isset($_COOKIE['auth'])) {
    $id = $_COOKIE['id'];
    $query = "SELECT `login`, `status` FROM users WHERE id = $id";
    $profile = mysqli_fetch_assoc(mysqli_query($link, $query))['login'];
    $status = mysqli_fetch_assoc(mysqli_query($link, $query))['status'];

    if ($_COOKIE['status'] != $status) {  // Проверяю изменили ли админ статус пользователя и затем меняю его
        $_COOKIE['status'] = $status;
    }

    $header .= "<div id = 'logout'><a href = '/elems/auth/logout.php'>Выход</a></div>
    <div id = 'auth'><span>Профиль:</span><a href = '/elems/profile/profile.php?p=$profile'>$profile</a></div>";
} else {
    $header .= "<div id = 'auth'><a href = '/registration'>Sign up</a><a href = '/login'>Sign in</a></div>";
}