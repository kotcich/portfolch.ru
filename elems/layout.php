<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/elems/css/posts.css?v=3">
    <link rel="stylesheet" href="/elems/css/messages.css?v=1">
    <link rel="stylesheet" href="/elems/css/profile.css?v=2">
    <link rel="stylesheet" href="/elems/css/reset.css?v=1">
    <link rel="stylesheet" href="/elems/css/style.css?v=1">
    <link rel="stylesheet" href="/elems/css/auth.css?v=5">
    <link rel="stylesheet" href="/elems/css/admin.css?v=2">
    <title><?php if (isset($title)) echo $title ?></title>
</head>
<body>
<header><?php if (isset($header)) echo $header ?></header>
<main><?php if (isset($main)) echo $main ?></main>
<footer><?php if (isset($footer)) echo $footer ?></footer>
</body>
</html>