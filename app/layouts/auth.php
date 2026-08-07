<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title ?? 'ITAMS Enterprise') ?></title>

    <!-- Bootstrap -->
    <link
        href="/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        href="/css/bootstrap-icons.css"
        rel="stylesheet">

    <!-- Global Theme -->
    <link
        href="/css/app.css"
        rel="stylesheet">

    <!-- Login Theme -->
    <link
        href="/css/login.css"
        rel="stylesheet">

</head>

<body class="login-page">

<?= $content ?>

<script src="/js/bootstrap.bundle.min.js"></script>

<script src="/js/login.js"></script>

</body>

</html>