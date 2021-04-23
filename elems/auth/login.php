<?php
if (empty($_COOKIE['auth'])) {  // Запрещаю вход на страницу уже авторизованным пользователям
    session_start();
    include($_SERVER['DOCUMENT_ROOT'].'/elems/bd.php');
    $title = "Авторизация";
    $header = "<h1><a href = \"/\">Портфоляч</a></h1>";

    $main = "<div class = 'registration'><form method = 'POST'>
    <span>Логин</span><input name = 'login' maxlength = '20' placeholder = 'от 5 до 20 символов'>
    <span>Пароль</span><input type = 'password' maxlength= '20' name = 'password' placeholder = 'от 8 до 20 символов'>
    <input type = 'submit' class = 'in' name = 'submit' value = 'Войти'>
    </form></div>";

    if (isset($_SESSION['message'])) {  // Вывод флеш сообщения и последующее удаление оного
        echo $_SESSION['message'];
        $_SESSION['message'] = null;
    }

    if (isset($_POST['submit'])) {
        if (!empty($_POST['login']) and !empty($_POST['password'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];

            if (strlen($login) >= 5 and strlen($login) <= 20) {  // Длина логина
                $query = "SELECT COUNT(*) as count FROM users WHERE login = '$login'";
                $count = mysqli_fetch_assoc(mysqli_query($link, $query))['count'];

                if ($count) {  // Поиск такого же логина

                    if (strlen($password) >= 8 and strlen($password) <= 20) {  // Длина пароля
                        $query = "SELECT `id`, `password`, `status` FROM users WHERE `login` ='$login'";
                        $hash = mysqli_fetch_assoc(mysqli_query($link, $query))['password'];
                        $id = mysqli_fetch_assoc(mysqli_query($link, $query))['id'];
                        $status = mysqli_fetch_assoc(mysqli_query($link, $query))['status'];

                        if (password_verify($password, $hash)) {  // Верный ли пароль
                            setcookie('auth', true, time() + 60*60*24*30, '/');
                            setcookie('id', $id, time() + 60*60*24*30, '/');
                            setcookie('status', $status, time() + 60*60*24*30, '/');

                            $_SESSION['message'] = "<span class = 'login_success'>Вы успешно залогинились</span>";

                            header('Location: /') or die();

                        } else {
                            $_SESSION['message'] = "<span class = 'login_error'>Неверный логин или пароль</span>";

                            header('Location: /elems/auth/login.php') or die();
                        }
                    } else {
                        $_SESSION['message'] = "<span class = 'login_error'>Неккоректная длина пароля</span>";

                        header('Location: /elems/auth/login.php') or die();
                    }
                } else {
                    $_SESSION['message'] = "<span class = 'login_error'>Неверный логин или пароль</span>";

                    header('Location: /elems/auth/login.php') or die();
                }
            } else {
                $_SESSION['message'] = "<span class = 'login_error'>Неккоректная длина логина</span>";

                header('Location: /elems/auth/login.php') or die();
            }
        } else {
            $_SESSION['message'] = "<span class = 'login_error'>Не все поля заполнены</span>";

            header('Location: /elems/auth/login.php') or die();
        }
    }

    include($_SERVER['DOCUMENT_ROOT'].'/elems/layout.php');
} else {
    session_start();
    $_SESSION['message'] = "<span class = 'login_error_stop'>Даже не думай</span>";

    header('Location: /') or die();
}