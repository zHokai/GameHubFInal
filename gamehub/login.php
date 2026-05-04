<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = trim($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($identifier)) {
        $error = "Le champ identifiant est requis.";
    } elseif (empty($password)) {
        $error = "Le champ mot de passe est requis.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id, login, password FROM users WHERE login = ? OR email = ?");
            $stmt->execute([$identifier, $identifier]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['login'] = $user['login'];
                header("Location: index.php");
                exit;
            } else {
                $error = "Identifiant ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            $error = "Erreur lors de la connexion : " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameHub - Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-secondary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">GameHub</a>
            <div class="ms-auto">
                <a href="index.php" class="btn btn-outline-light btn-sm me-2">Accueil</a>
                <a href="register.html" class="btn btn-primary btn-sm">Inscription</a>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h1 class="h3 mb-4 text-center">Connexion</h1>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>

                        <form action="login.php" method="post">
                            <div class="mb-3">
                                <label for="identifier" class="form-label">Login ou adresse email</label>
                                <input type="text" class="form-control" id="identifier" name="identifier" required>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Se connecter</button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <p class="text-center mb-0">
                            Pas encore de compte ?
                            <a href="register.html">Inscrivez-vous ici</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-center py-3">
        <p class="mb-0">GameHub - Connexion utilisateur</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
