<?php
$query = "SELECT messages.id, `text`, `date`, `answer_user_id`, `user_id`, users.login as `login` FROM messages LEFT JOIN users ON messages.user_id = users.id
WHERE `post_id` = $post_id";
$result = mysqli_query($link, $query);
for ($messages = []; $row = mysqli_fetch_assoc($result); $messages[] = $row);

$i = 0;  // Номер сообщения в конкретном посте
$footer = "<div class = 'messages_wrapper'>";
foreach ($messages as $message) {
    $message_date_add = preg_replace('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$#', '$3.$2.$1 $4:$5:$6', $message['date']);
    $i++;

    $footer .= "<a id = '{$message['id']}'><div class = 'message_wrapper'>";

    if (isset($_COOKIE['auth']) and $_COOKIE['id'] == $message['answer_user_id']) {  // Проверка на то, какие сообщения адресованы тебе
        $answer = "<span class = 'answer'>Вам ответили</span>";
    } else {
        $answer = '';
    }

    $footer .= "<div class = 'message_header'><a href = '/elems/profile/profile.php?p={$message['login']}'>{$message['login']}</a> 
    $message_date_add #{$message['id']} $answer<span class = 'message_i'>$i</span></div>";

    if ($message['answer_user_id'] != 0) {
        $answer_user_id = $message['answer_user_id'];
        $query = "SELECT `login` FROM users WHERE id = $answer_user_id";
        $answer_login = mysqli_fetch_assoc(mysqli_query($link, $query))['login'];

        $footer .= "<span class = 'message_text'><a href = '/elems/profile/profile.php?p=$answer_login'>$answer_login, </a> {$message['text']}</span>";
    } else {
        $footer .= "<span class = 'message_text'>{$message['text']}</span>";
    }

    if (isset($_COOKIE['auth']) and $message['login'] != $profile) {  // Проверяю нужно ли выводить сылку на ответ
        $user_id = $message['user_id'];

        $footer .= "<br>
        <a href = '/elems/posts/post.php?id=$post_id&an_id=$user_id' class = 'message_answer'>Ответить</a>";
    }

    $footer .= "</div></a>";
}
$footer .= "</div>";