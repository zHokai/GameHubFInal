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

    if (!empty($password) && !empty($confirm_password) && $password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    if (empty($errors)) {
        $success = true;
        $_SESSION['user_login'] = $login;
        $_SESSION['user_email'] = $email;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameHub - Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-secondary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">GameHub</a>
            <div class="ms-auto">
                <a href="index.php" class="btn btn-outline-light btn-sm me-2">Accueil</a>
                <a href="login.html" class="btn btn-primary btn-sm">Connexion</a>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h1 class="h3 mb-4 text-center">Créer un compte</h1>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php foreach ($errors as $error): ?>
                                    <p class="mb-1">• <?php echo htmlspecialchars($error); ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($success): ?>
                            <div class="alert alert-success" role="alert">
                                <p class="mb-0">Inscription réussie ! Vous pouvez maintenant vous connecter.</p>
                            </div>
                        <?php endif; ?>

                        <form action="register.php" method="post">
                            <div class="mb-3">
                                <label for="login" class="form-label">Login</label>
                                <input type="text" class="form-control" id="login" name="login" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="form-text">
                                    Minimum 8 caractères, avec au moins une majuscule et un chiffre.
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">S'inscrire</button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <p class="text-center mb-0">
                            Déjà inscrit ?
                            <a href="login.html">Connectez-vous ici</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center py-3">
        <p class="mb-0">GameHub - Inscription utilisateur</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

