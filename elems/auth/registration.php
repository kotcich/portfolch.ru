<?
if (empty($_COOKIE['auth'])) {  // Запрещаю вход на страницу уже авторизованным пользователям
    session_start();
    include($_SERVER['DOCUMENT_ROOT'].'/elems/bd.php');
    $title = "Регистрация";
    $header = "<h1><a href = \"/\">Портфоляч</a></h1>";

    $main = "<div class = 'registration'><form method = 'POST'>
    <span>Логин</span><input name = 'login' maxlength = '20' placeholder = 'от 5 до 20 символов'>
    <span>Пароль</span><input type = 'password' maxlength= '20' name = 'password' placeholder = 'от 8 до 20 символов'>
    <span>Повторите пароль</span><input type = 'password' maxlength= '20' name = 'copyPassword' placeholder = 'от 8 до 20 символов'>
    <span>Почта</span><input name = 'email' placeholder = 'example@mail.ru'>
    <span>Дата рождения</span><input name = 'date_birth' placeholder = 'дд.мм.гггг'>
    <input type = 'submit' name = 'submit' value = 'Зарегистрироваться'>
    </form></div>";

    if (isset($_SESSION['message'])) {  // Вывод флеш сообщения и последующее удаление оного
        echo $_SESSION['message'];
        $_SESSION['message'] = null;
    }

    if (isset($_POST['submit'])) {
        if (!empty($_POST['login']) and !empty($_POST['password']) and !empty($_POST['copyPassword']) and !empty($_POST['email']) and !empty($_POST['date_birth'])) {
            $login = mysqli_real_escape_string($link, $_POST['login']);
            $password = mysqli_real_escape_string($link, $_POST['password']);
            $email = mysqli_real_escape_string($link, $_POST['email']);
            $birth = mysqli_real_escape_string($link, $_POST['date_birth']);
            $regBirth = preg_match('#^\d{2}\.\d{2}\.\d{4}$#', $birth);

            if (strlen($login) >= 5 and strlen($login) <= 20) {  // Длина логина
                $query = "SELECT COUNT(*) as count FROM users WHERE login = '$login'";
                $count = mysqli_fetch_assoc(mysqli_query($link, $query))['count'];

                if ($count == 0) {  // Поиск такого же логина
                    
                    if ($_POST['password'] == $_POST['copyPassword']) {  // Равны ли введенные пароли

                        if (strlen($password) >= 8 and strlen($password) <= 20) {  // Длина пароля
                            $hash = password_hash($password, PASSWORD_BCRYPT);

                            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {  // Валидация почты
                                $query = "SELECT COUNT(*) as count FROM users WHERE `email` = '$email'";
                                $count = mysqli_fetch_assoc(mysqli_query($link, $query))['count'];

                                if ($count == 0) {  // Проверка занятости почты

                                    if ($regBirth) {  // Проверка формата введенной даты
                                        $arr = date_parse($birth);

                                        if (checkdate($arr['month'], $arr['day'], $arr['year'])) {  // Если человек вообще родился лол
                                            $arr = array_slice($arr, 0, 3);
                                            $date_birth = implode('-', $arr);
                                            $date_registration = date('Y-m-d', time());

                                            $query = "INSERT INTO users SET `login` = '$login', `password` = '$hash', `email` = '$email', `date_birth` = '$date_birth',
                                            `date_registration` = '$date_registration'";
                                            mysqli_query($link, $query);

                                            $id = mysqli_insert_id($link);
                                            setcookie('auth', true, time() + 60*60*24*30, '/');
                                            setcookie('id', $id, time() + 60*60*24*30, '/');
                                            setcookie('status', 1, time() + 60*60*24*30, '/');

                                            $_SESSION['message'] = "<span class = 'registr_success'>Вы успешно зарегистрировались</span>";

                                            header('Location: /') or die();
                                        } else {
                                            $_SESSION['message'] = "<span class = 'registr_error'>Родись сначала</span>";

                                            header('Location: /elems/auth/registration.php') or die();
                                        }
                                    } else {
                                        $_SESSION['message'] = "<span class = 'registr_error'>Дата рождения введина неккоректно</span>";

                                        header('Location: /elems/auth/registration.php') or die();
                                    }
                                } else {
                                    $_SESSION['message'] = "<span class = 'registr_error'>Такая почта уже существует</span>";

                                    header('Location: /elems/auth/registration.php') or die();
                                }
                            } else {
                                $_SESSION['message'] = "<span class = 'registr_error'>Почта введина неккоректно</span>";

                                header('Location: /elems/auth/registration.php') or die();
                            }
                        } else {
                            $_SESSION['message'] = "<span class = 'registr_error'>Неккоректная длина пароля</span>";

                            header('Location: /elems/auth/registration.php') or die();
                        }
                    } else {
                        $_SESSION['message'] = "<span class = 'registr_error'>Пароли не совпадают</span>";

                        header('Location: /elems/auth/registration.php') or die();
                    }
                } else {
                    $_SESSION['message'] = "<span class = 'registr_error'>Логин уже занят</span>";

                    header('Location: /elems/auth/registration.php') or die();
                }
            } else {
                $_SESSION['message'] = "<span class = 'registr_error'>Неккоректная длина логина</span>";

                header('Location: /elems/auth/registration.php') or die();
            }
        } else {
            $_SESSION['message'] = "<span class = 'registr_error'>Не все поля заполнены</span>";

            header('Location: /elems/auth/registration.php') or die();
        }
    }

    include($_SERVER['DOCUMENT_ROOT'].'/elems/layout.php');
} else {
    session_start();
    $_SESSION['message'] = "<span class = 'registr_error_stop'>Даже не думай</span>";

    header('Location: /');
}