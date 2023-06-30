<?php
// Проверка, авторизован ли админ
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: aut.php");
    exit();
}

// Обработка выхода из аккаунта
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: aut.php");
    exit();
}

// Обработка добавления новых данных портфолио
if (isset($_POST['add_portfolio'])) {
    // Подключение к базе данных и выполнение операций с данными портфолио
    $conn = new mysqli("localhost", "root", "root", "nettowaku");
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    $title = $_POST['title'];
    $image = $_FILES['image'];

    // Загрузка файла изображения
    $target_dir = "/Applications/MAMP/htdocs/practika/images/";
    $target_file = $target_dir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($image["tmp_name"], $target_file)) {
        // Файл изображения успешно загружен
        // Добавление новых данных в таблицу портфолио
        $stmt = $conn->prepare("INSERT INTO portfolio (title, image) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $target_file);
        $stmt->execute();
        $stmt->close();
    } else {
        // Ошибка загрузки файла изображения
        $error = "Ошибка при загрузке файла изображения.";
    }

    $conn->close();
}

// Обработка удаления данных портфолио
if (isset($_GET['delete_portfolio'])) {
    // Подключение к базе данных и выполнение операций с данными портфолио
    $conn = new mysqli("localhost", "root", "root", "nettowaku");
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    $portfolioId = $_GET['delete_portfolio'];

    // Получение информации о файле изображения
    $stmt = $conn->prepare("SELECT image FROM portfolio WHERE portfolio_id = ?");
    $stmt->bind_param("i", $portfolioId);
    $stmt->execute();
    $stmt->bind_result($imagePath);
    $stmt->fetch();
    $stmt->close();

    // Удаление данных из таблицы портфолио
    $stmt = $conn->prepare("DELETE FROM portfolio WHERE portfolio_id = ?");
    $stmt->bind_param("i", $portfolioId);
    $stmt->execute();
    $stmt->close();

    // Удаление файла изображения
    if ($imagePath) {
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $conn->close();
}
// Обработка добавления нового пользователя
if (isset($_POST['add_user'])) {
    // Подключение к базе данных и выполнение операций с данными пользователей
    $conn = new mysqli("localhost", "root", "root", "nettowaku");
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    $password = $_POST['password'];
    $mail = $_POST['mail'];

    // Добавление нового пользователя в таблицу
    $stmt = $conn->prepare("INSERT INTO clients (password, mail) VALUES (?, ?)");
    $stmt->bind_param("ss", $password, $mail);
    $stmt->execute();
    $stmt->close();

    $conn->close();
}

// Обработка удаления пользователя
if (isset($_GET['delete_user'])) {
    // Подключение к базе данных и выполнение операций с данными пользователей
    $conn = new mysqli("localhost", "root", "root", "nettowaku");
    if ($conn->connect_error) {
        die("Ошибка подключения к базе данных: " . $conn->connect_error);
    }

    $userId = $_GET['delete_user'];

    // Удаление пользователя из таблицы
    $stmt = $conn->prepare("DELETE FROM clients WHERE client_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="scss/admin.css">
    <title>Админ панель</title>
</head>

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

<body>
    <div class="container">
        <div class="add-block">
            <h1>Добавить новые данные портфолио</h1>
            <form method="post" action="" enctype="multipart/form-data">
                <div>
                    <label for="title">Заголовок:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div>
                    <label for="image">Фото:</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                </div>
                <button type="submit" name="add_portfolio">Добавить</button>
            </form>
            </div. <div class="exit">
            <form method="post" action="" enctype="multipart/form-data">
                <button type="submit" name="logout">Выход</button>
            </form>
        </div>
        <h1>Удалить данные портфолио</h1>
        <ul>
            <?php
            // Подключение к базе данных и получение данных портфолио
            $conn = new mysqli("localhost", "root", "root", "nettowaku");
            if ($conn->connect_error) {
                die("Ошибка подключения к базе данных: " . $conn->connect_error);
            }

            $sql = "SELECT portfolio_id, title FROM portfolio";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<li>';
                    echo '<br>';
                    echo '<span class="portfolio-title">'  . $row['title'] . '</span>';
                    echo '<form method="GET" onsubmit="return confirm(\'Вы уверены, что хотите удалить этот элемент портфолио?\');">';
                    echo '<input type="hidden" name="delete_portfolio" value="' . $row['portfolio_id'] . '">';
                    echo '<button type="submit">Удалить</button>';
                    echo '</form>';
                    echo '</li>';
                }
            } else {
                echo "Нет данных в портфолио.";
            }

            $conn->close();
            ?>

        </ul>ч

    </div>
    <div class="container">

    
    <div class="add-block">
        <h1>Добавить нового пользователя</h1>
        <form method="post" action="">
            <div>
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <label for="mail">E-mail:</label>
                <input type="email" id="mail" name="mail" required>
            </div>
            <button type="submit" name="add_user">Добавить</button>
        </form>
    </div>
    <div class="exit">
        <form method="post" action="" enctype="multipart/form-data">
            <button type="submit" name="logout">Выход</button>
        </form>
    </div>
    <h1>Удалить пользователя</h1>
    <ul>
        <?php
        // Подключение к базе данных и получение данных пользователей
        $conn = new mysqli("localhost", "root", "root", "nettowaku");
        if ($conn->connect_error) {
            die("Ошибка подключения к базе данных: " . $conn->connect_error);
        }

        $sql = "SELECT client_id, password, mail FROM clients";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<li>';
                echo '<br>';
                echo 'ID: ' . $row['client_id'] . ', ';
                echo 'Пароль: ' . $row['password'] . ', ';
                echo 'E-mail: ' . $row['mail'];
                echo '<form method="GET" onsubmit="return confirm(\'Вы уверены, что хотите удалить этого пользователя?\');">';
                echo '<input type="hidden" name="delete_user" value="' . $row['client_id'] . '">';
                echo '<button type="submit">Удалить</button>';
                echo '</form>';
                echo '</li>';
            }
        } else {
            echo "Нет данных о пользователях.";
        }

        $conn->close();
        ?>
    </ul>
    </div>

    <script src="js/main.js"></script>

</body>

</html>