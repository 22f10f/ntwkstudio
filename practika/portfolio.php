<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="scss/portfolio.css" />
    <title>Nettowaku</title>
</head>

<body>

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
        <hr class="hr-menu">
    </header>

    <div class="container">
        <div class="div-header-section">
            <div class="div-header">
                <h1 class="div-info fade-in">портфолио</h1>
                <div class="div-header-block ">
                    <?php
                    // Подключение к базе данных и получение данных портфолио
                    $conn = new mysqli("localhost", "root", "root", "nettowaku");
                    if ($conn->connect_error) {
                        die("Ошибка подключения к базе данных: " . $conn->connect_error);
                    }

                    $sql = "SELECT title, image FROM portfolio";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="header-portfolio fade-in" style="background-color: none;border:1px solid; background-image: url(' . $row['image'] . ')">';
                            echo '<h2>' . $row['title'] . '</h2>';
                            echo '</div>';
                        }
                    } else {
                        echo "Нет данных в портфолио.";
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="js/main.js"></script>

</html>