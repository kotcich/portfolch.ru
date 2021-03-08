<?
if (isset($_COOKIE['auth']) and isset($_GET['id']) and ($_COOKIE['id'] == trim($_GET['id'], '?')) ) {  // Запрещаю вход неавторизованным и айди подбирателям
    session_start();
    include($_SERVER['DOCUMENT_ROOT'].'/elems/bd.php');
    $id = trim($_GET['id'], '?');
    $title = "Смена пароля";
    $header = "<h1><a href = \"/\">Портфоляч</a></h1>";

    if (isset($_SESSION['message'])) {  // Вывод флеш сообщения и последующее удаление оного
        echo $_SESSION['message'];
        $_SESSION['message'] = null;
    }

    $main = "<div class = 'registration'><form method = 'POST'>
    <span>Старый пароль</span><input type = 'password' maxlength= '20' name = 'oldPassword' placeholder = 'от 8 до 20 символов'>
    <span>Новый пароль</span><input type = 'password' maxlength= '20' name = 'newPassword' placeholder = 'от 8 до 20 символов'>
    <span>Повторите пароль</span><input type = 'password' maxlength= '20' name = 'copyPassword' placeholder = 'от 8 до 20 символов'>
    <input type = 'submit' class = 'in' name = 'submit' value = 'Сменить'>
    </form></div>";

    if (isset($_POST['submit'])) {
        if (!empty($_POST['oldPassword']) and !empty($_POST['newPassword']) and !empty($_POST['copyPassword'])) {
            $oldPassword = $_POST['oldPassword'];
            $newPassword = $_POST['newPassword'];

            if ((strlen($oldPassword) and strlen($newPassword)) >= 5) {  // Длина пароля
                $query = "SELECT `password` FROM users WHERE `id` = $id";
                $hash = mysqli_fetch_assoc(mysqli_query($link, $query))['password'];

                if (password_verify($oldPassword, $hash)) {  // Проверка верности старого пароля

                    if ($newPassword == $_POST['copyPassword']) {  // Проверка на совпадение нового пароля
                        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
                        $query = "UPDATE users SET `password` = '$hash' WHERE `id` = $id";
                        mysqli_query($link, $query);

                        $_SESSION['message'] = "<span class = 'login_success'>Пароль успешно изменен</span>";

                        header('Location: /');
                    } else {
                        $_SESSION['message'] = "<span class = 'profile_password_error'>Неверно повторили пароль</span>";

                        header('Location: /elems/profile/changePassword.php?id='.$id) or die();
                    }
                } else {
                    $_SESSION['message'] = "<span class = 'profile_password_error'>Неверный пароль</span>";

                    header('Location: /elems/profile/changePassword.php?id='.$id) or die();
                }
            } else {
                $_SESSION['message'] = "<span class = 'profile_password_error'>Неккоректная длина пароля</span>";

                header('Location: /elems/profile/changePassword.php?id='.$id) or die();
            }
        } else {
            $_SESSION['message'] = "<span class = 'profile_password_error'>Не все поля заполнены</span>";

            header('Location: /elems/profile/changePassword.php?id='.$id) or die();
        }
    }

    include($_SERVER['DOCUMENT_ROOT'].'/elems/layout.php');
} else {
    session_start();
    $_SESSION['message'] = "<span class = 'post_error_stop'>Даже не думай</span>";

    header('Location: /');
}