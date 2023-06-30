<?php
// Проверка, авторизован ли пользователь
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: aut.php");
    exit();
}

// Получение адреса электронной почты из сессии
$mail = $_SESSION['username'];

// Обработка выхода из аккаунта
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: aut.php");
    exit();
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="scss/profile.css" />
    <title>Nettowaku</title>
</head>

<body>
    <div>
        <header>
            <div class="main-menu">
                <nav>
                    <ul>
                        <li><a class="main-menu-a" href="index.php">главная</a></li>
                        <hr class="animated-hr">
                        <li><a class="main-menu-a" href="aboutus.php">о компании</a></li>
                        <hr class="animated-hr">
                        <li><a class="main-menu-a" href="yslygi.php">услуги</a></li>
                        <hr class="animated-hr">
                        <li><a class="main-menu-a" href="profile.php">профиль</a></li>
                        <hr class="animated-hr">
                        <li><a class="main-menu-a" href="portfolio.php">портфолио</a></li>
                        <hr class="animated-hr">

                    </ul>
                </nav>
            </div>
            <div class="menu">
                <div class="burger-menu" onclick="toggleMenu()">
                    <div class="burger-menu-line burger-menu-line-1"></div>
                    <div class="burger-menu-line burger-menu-line-2"></div>
                    <div class="burger-menu-line burger-menu-line-3"></div>
                </div>
            </div>
        </header>
        <div class="container">
            <div class="div-header-section">
                <div class="div-header">
                    <h1 class="div-info fade-in">Профиль</h1>
                </div>
            </div>



            <div class="info-block" style="margin: 0px auto;">
                <p>Адрес электронной почты: <?php echo $mail; ?></p>
                <form method="post" action="">
                    <button type="submit" name="logout">Выход</button>
                </form>
            </div>

    </div>

    <script src="js/main.js"></script>
</body>

</html>