<?php
$host = 'localhost';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS gamehub");
    $pdo->exec("USE gamehub");

    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        login VARCHAR(20) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS games (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(100) NOT NULL,
        genre VARCHAR(50) NOT NULL,
        description TEXT NOT NULL,
        image VARCHAR(100) NOT NULL,
        user_id INT NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )");

    echo "Base de données et tables créées avec succès !";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
