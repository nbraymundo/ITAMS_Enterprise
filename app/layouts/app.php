<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php require dirname(__DIR__) . '/partials/head.php'; ?>

</head>

<body>

    <?php require dirname(__DIR__) . '/partials/sidebar.php'; ?>

    <div class="main-wrapper">

        <?php require dirname(__DIR__) . '/partials/header.php'; ?>

        <main class="content">

            <?= $content ?>

        </main>

        <?php require dirname(__DIR__) . '/partials/footer.php'; ?>

    </div>

</body>

</html>