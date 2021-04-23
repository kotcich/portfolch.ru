<?php
session_start();
if (isset($_SESSION['message'])) {  // Проверка наличия флеш сообщения
    echo $_SESSION['message'];
    $_SESSION['message'] = null;
}

include($_SERVER['DOCUMENT_ROOT'].'/elems/bd.php');
$title = 'Портфоляч';
include($_SERVER['DOCUMENT_ROOT'].'/elems/header.php');  // Header
$header .= "<div class = 'about'>Портфоляч это место с усторевшим дизайном, так как ваш покорный слуга не прирожденный верстальщик/дизайнер женского пола с чувством вкуса.
А так же имеет темы и сообщения взятые с реддита/два(плагиатор какой то)ча. Да и вообще, мне делать что ли нечего с самим собой общаться тут,
у меня для этого есть php manual.</div>";

$main = "<img src = '/elems/img/main.jpg' class = 'img_main'>"; // Main

// Footer

$query = "SELECT categories.name, sub_categories.name as sub_name FROM categories LEFT JOIN sub_categories ON sub_categories.category_id = categories.id";
$result = mysqli_query($link, $query) or die(mysqli_error($link));
for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

$name = '';
$footer = "<div class = 'names'>";
foreach ($data as $data) {
    $sub = translit($data['sub_name']);
    if ($name != $data['name']) {
        $name = $data['name'];
        $footer .= "<span id = 'name'><b>$name</b></span>";
    }

    $footer .= "<span><a href = '/elems/posts/posts.php?sub=$sub'>{$data['sub_name']}</a></span>";
}
$footer .= "</div>";

if (isset($_COOKIE['auth']) and $_COOKIE['status'] == 3) {
    $footer .= "<div class = 'authority'><a href = '/admin'>админка</a></div>";
}

// ...

include($_SERVER['DOCUMENT_ROOT'].'/elems/layout.php');