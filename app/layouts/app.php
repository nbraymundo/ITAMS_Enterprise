<?php

declare(strict_types=1);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <?php require dirname(__DIR__) . '/partials/head.php'; ?>

</head>


<body class="app-body">


    <!-- =====================================================
         APPLICATION SIDEBAR
         ====================================================== -->

    <?php require dirname(__DIR__) . '/partials/sidebar.php'; ?>


    <!-- =====================================================
         APPLICATION WRAPPER
         ====================================================== -->

    <div class="main-wrapper">


        <!-- Header -->

        <?php require dirname(__DIR__) . '/partials/header.php'; ?>


        <!-- Main Content -->

        <main class="content">

            <?= $content ?>

        </main>


        <!-- Footer -->

        <?php require dirname(__DIR__) . '/partials/footer.php'; ?>

    </div>


    <!-- =====================================================
         APPLICATION JAVASCRIPT
         ====================================================== -->

    <script src="/js/app.js"></script>


</body>

</html>