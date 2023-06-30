<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: aut.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Получение данных из формы
  $title = $_POST["title"];
  $image_url = $_POST["image_url"];

  // Подключение к базе данных
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "nettowaku";
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Проверка соединения с базой данных
  if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
  }

  // Подготовка и выполнение SQL-запроса для добавления данных в таблицу портфолио
  $stmt = $conn->prepare("INSERT INTO portfolio (title, image_url) VALUES (?, ?)");
  $stmt->bind_param("sss", $title, $image_url);
  $stmt->execute();

  // Закрытие соединения с базой данных
  $stmt->close();
  $conn->close();

  // Перенаправление на страницу администратора после успешного добавления
  header("Location: admin.php");
  exit();
}
?>