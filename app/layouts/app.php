<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title><?= $title ?></title>

</head>

<body>

<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<?php require dirname(__DIR__) . '/partials/sidebar.php'; ?>

<main>

<?= $content ?>

</main>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>

</body>

</html>