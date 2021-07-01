<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="/public/css/style.css">
    <title><?= $meta['title'] ?></title>
    <meta name="description" content="<?= $meta['desc'] ?>">
    <meta name="keywords" content="<?= $meta['keywords'] ?>">
</head>
<body>
<h1>Default</h1>
<div class="container">
    <?php if (!empty($menu)): ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <ul class="navbar-nav">
                <?php foreach ($menu as $item): ?>
                    <li class="nav-item">
                        <a href="category/<?= $item['id'] ?>"><?= $item['title'] ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    <?php endif; ?>
    <h1>TEST TEXT</h1>
    <?= $content; ?>
    <? //= debug(\core\Db::$countSql) ?>
    <? //= debug(\core\Db::$queries) ?>
</div>
<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
        crossorigin="anonymous"></script>

<?php
foreach ($scripts as $script) {
    echo $script;
}
?>

</body>
</html>