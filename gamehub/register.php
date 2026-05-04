<?php
session_start();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = trim($_POST['login'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($login)) {
        $errors[] = "Le champ login est requis.";
    }
    if (empty($email)) {
        $errors[] = "Le champ email est requis.";
    }
    if (empty($password)) {
        $errors[] = "Le champ mot de passe est requis.";
    }
    if (empty($confirm_password)) {
        $errors[] = "Le champ confirmation du mot de passe est requis.";
    }

    if (!empty($login) && !preg_match('/^[a-zA-Z0-9]{3,20}$/', $login)) {
        $errors[] = "Le login doit contenir uniquement des lettres et des chiffres, et avoir entre 3 et 20 caractères.";
    }

    if (!empty($email) && !preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email)) {
        $errors[] = "L'adresse email n'est pas valide.";
    }

    if (!empty($password) && !preg_match('/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    if (empty($errors)) {
        $success = true;
        $_SESSION['user_login'] = $login;
        $_SESSION['user_email'] = $email;
    }
}
?>

