<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? "$page_title | " . APP_NAME : APP_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/assets/css/style.css">
    <link rel="icon" href="<?php echo APP_URL; ?>/assets/images/monas-logo.png">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <img src="<?php echo APP_URL; ?>/assets/images/monas-logo.png" alt="Logo Monas" width="50">
                <h1><?php echo APP_NAME; ?></h1>
            </div>
            <nav class="main-nav">
                <ul>
                    <li><a href="<?php echo APP_URL; ?>/index.php">Beranda</a></li>
                    <li><a href="<?php echo APP_URL; ?>/articles/">Artikel</a></li>
                    <li><a href="<?php echo APP_URL; ?>/facilities/">Fasilitas</a></li>
                    <?php if(is_logged_in()): ?>
                        <li><a href="<?php echo APP_URL; ?>/user/profile.php">Profil</a></li>
                        <li><a href="<?php echo APP_URL; ?>/auth/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo APP_URL; ?>/auth/login.php">Login</a></li>
                        <li><a href="<?php echo APP_URL; ?>/auth/register.php">Daftar</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">