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
    $dbname = "nettowaku";
    $conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

    // Проверка соединения с базой данных
    if ($conn->connect_error) {
        die("Ошибка соединения: " . $conn->connect_error);
    }

    session_start();
    if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
        // Пользователь уже авторизован как администратор
        // Перенаправление на страницу администратора
        header("Location: admin.php");
        exit();
    } elseif (isset($_SESSION['username'])) {
        // Пользователь уже авторизован
        // Перенаправление на страницу профиля
        header("Location: profile.php");
        exit();
    }

    // Подготовка SQL-запроса для проверки логина и пароля администратора
    $stmt_admin = $conn->prepare("SELECT admin_id FROM admins WHERE username = ? AND password = ?");
    $stmt_admin->bind_param("ss", $username, $password);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    // Проверка результата запроса
    if ($result_admin->num_rows == 1) {
        // Верные логин и пароль администратора
        // Сохранение информации об администраторе в сессии
        $_SESSION['admin'] = true;

        // Перенаправление на страницу администратора
        header("Location: admin.php");
        exit();
    }

    // Закрытие соединения с базой данных
    $stmt_admin->close();

    // Подготовка SQL-запроса для проверки логина и пароля
    $stmt = $conn->prepare("SELECT client_id, mail FROM clients WHERE mail = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Проверка результата запроса
    if ($result->num_rows == 1) {
        // Верные логин и пароль
        // Сохранение адреса электронной почты в сессии
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['mail'];

        // Перенаправление на страницу профиля
        header("Location: profile.php");
        exit();
    } else {
        // Неправильный логин или пароль
        $error = "Неправильно набраны пароль или почта.";
    }

    // Закрытие соединения с базой данных
    $stmt->close();
    $conn->close();
} else {
    // Если пользователь уже авторизован, перенаправление на страницу профиля
    session_start();
    if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
        // Пользователь уже авторизован как администратор
        // Перенаправление на страницу администратора
        header("Location: admin.php");
        exit();
    } elseif (isset($_SESSION['username'])) {
        // Пользователь уже авторизован
        // Перенаправление на страницу профиля
        header("Location: profile.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="scss/aut.css" />
    <title>Авторизация</title>
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
    </header>
    <div class="container">
        <div class="div-header-section">
            <div class="div-header">
                <h1 class="div-info fade-in">Авторизация</h1>
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
                    <button type="submit">Войти</button>
                    <button class="registr"> <a href="reg.php">Зарегистрироваться</a> </button>
                </form>
            </div>
        </div>
    </div>
    <script src="js/main.js"></script>
</body>

</html>