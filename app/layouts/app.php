<!DOCTYPE html>

<html lang="en">

<head>

    <?php require '../app/partials/head.php'; ?>

</head>

<body>

<?php require '../app/partials/sidebar.php'; ?>

<div class="main-wrapper">

    <?php require '../app/partials/header.php'; ?>

    <main class="content">

        <?= $content ?>

    </main>

    <?php require '../app/partials/footer.php'; ?>

</div>

</body>

</html>