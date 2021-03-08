<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><? if (isset($title)) echo $title ?></title>
    <link rel="stylesheet" href="/elems/css/reset.css?v=1">
    <link rel="stylesheet" href="/elems/css/style.css?v=1">
    <link rel="stylesheet" href="/elems/css/auth.css?v=5">
    <link rel="stylesheet" href="/elems/css/admin.css?v=2">
    <link rel="stylesheet" href="/elems/css/posts.css?v=3">
    <link rel="stylesheet" href="/elems/css/messages.css?v=1">
    <link rel="stylesheet" href="/elems/css/profile.css?v=2">
</head>
<body>
    <header><? if (isset($header)) echo $header ?></header>
    <main><? if (isset($main)) echo $main ?></main>
    <footer><? if (isset($footer)) echo $footer ?></footer>
</body>
</html>