<?php
session_start();
if (isset($_COOKIE['auth'])) {
    setcookie('auth', '', time() - 100, '/');
    setcookie('id', '', time() - 100, '/');
    setcookie('status', '', time() - 100, '/');

    $_SESSION['message'] = "<span class = 'logout_success'>Вы успешно вышли из аккаунта</span>";

    header('Location: /') or die();
} else {
    $_SESSION['message'] = "<span class = 'logout_error'>Даже не пытайся</span>";

    header('Location: /') or die();
}