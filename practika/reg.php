<?php
// Проверка, была ли отправлена форма авторизации
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение введенных пользователем данных
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Подключение к базе данных
    $servername = "localhost";
    $usernameDB = "root";
    $passwordDB = "root";
    $dbname = "Nettowaku";
    $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

    // Проверка соединения с базой данных
    if ($conn->connect_error) {
        die("Ошибка соединения: " . $conn->connect_error);
    }

    // Проверка, существует ли пользователь с таким же email
    $checkEmailQuery = "SELECT * FROM clients WHERE mail = '$username'";
    $checkEmailResult = $conn->query($checkEmailQuery);

    if ($checkEmailResult->num_rows > 0) {
        $error = "Пользователь с таким email уже существует.";
    } else {
        // Проверка требований к паролю и email
        if (strlen($password) < 4) {
            $error = "Пароль должен быть не менее 4 символов.";
        } elseif (!filter_var($username, FILTER_VALIDATE_EMAIL) || !strpos($username, '@mail.ru')) {
            $error = "Неправильный формат email. Введите действительный email от mail.ru.";
        } else {
            // Вставка нового пользователя в базу данных
            $insertQuery = "INSERT INTO clients (client_id, mail, password) VALUES (NULL, '$username', '$password')";
            if ($conn->query($insertQuery) === TRUE) {
                header("Location: aut.php");
                exit();
            } else {
                $error = "Ошибка при регистрации: " . $conn->error;
            }
        }
    }

    // Закрытие соединения с базой данных
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="scss/aut.css" />
    <title>Регистрация</title>
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
                    <h1 class="div-info fade-in">Регистрация</h1>
                    <form id="loginForm" class="login-form" method="POST" action="">
                        <div class="form-group">
                            <input type="text" id="username" name="username" placeholder="Введите маил" required>
                        </div>
                        <div class="form-group">
                            <input type="password" id="password" name="password" placeholder="Пароль" required>
                        </div>

                        <?php
                        // Вывод ошибки, если есть
                        if (isset($error)) {
                            echo '<div class="error-message">' . $error . '</div>';
                        }
                        ?>

                        <button type="submit">Зарегистрироваться</button>
                        <button class="registr"> <a href="aut.php">Войти в аккаунт</a> </button>

                    </form>
                </div>
            </div>

        </div>

        <script src="js/main.js"></script>

</body>

</html>