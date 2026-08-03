<?php $viewer = current_user(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'CryptoPips') ?></title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="/">Crypto<span>Pips</span></a>
    <nav>
        <?php if ($viewer): ?>
            <a href="/dashboard.php">Dashboard</a>
            <?php if ($viewer['role'] === 'admin'): ?><a href="/admin/index.php">Admin</a><?php endif; ?>
            <form class="inline" action="/logout.php" method="post"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><button class="link-button">Log out</button></form>
        <?php else: ?>
            <a href="/login.php">Log in</a><a class="button small" href="/register.php">Create account</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">

