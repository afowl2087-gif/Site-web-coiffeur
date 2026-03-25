<?php
session_start();

// Fonction anti XSS
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$message = "";

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password'] ?? '');

    if (!$email || !$password) {
        $message = "<div class='alert alert-danger'>Champs obligatoires</div>";
    } else {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=salon;charset=utf8", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT * FROM clients WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Créer la session
                $_SESSION['user_id'] = $user['Id_clients'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['is_admin'] = $user['is_admin'];

                // Redirection selon rôle
                if ($user['is_admin'] == 1) {
                    header("Location: /admin/admin.html");
                } else {
                    header("Location: accueil.php");
                }
                exit;
            } else {
                $message = "<div class='alert alert-danger'>Email ou mot de passe incorrect</div>";
            }
        } catch (PDOException $e) {
            $message = "<div class='alert alert-danger'>Erreur : " . e($e->getMessage()) . "</div>";
        }
    }
}

// Est connecté ?
$connected = isset($_SESSION['user_id']);
$firstname = $connected ? $_SESSION['firstname'] : null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Login - Golden Salon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f5f7;
        }

        .navbar {
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-radius: 0 0 20px 20px;
        }

        .btn-custom {
            background-color: #1f2937;
            color: white;
            border-radius: 25px;
            padding: 8px 25px;
            transition: 0.3s;
        }

        .navbar .btn-custom:hover {
            background-color: #111827;
        }

        .contact-card {
            width: 400px;
            margin: 80px auto;
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }

        .contact-title {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        .contact-btn {
            width: 100%;
            background-color: #1f2937;
            color: #fff;
            border-radius: 50px;
            padding: 10px;
        }

        .contact-btn:hover {
            background-color: #111827;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg py-3 mb-5">
    <div class="container">
        <a href="accueil.php"><img src="./assets/img/logo.png" width="120" alt="Golden Salon"></a>
        <div class="ms-auto d-flex align-items-center">
            <a href="prendre_rdv.php" class="btn btn-custom me-2">PRENDRE RDV</a>
            <a href="contact.php" class="btn btn-custom me-2">CONTACT</a>
            <?php if($connected): ?>
                <a href="profile.php" class="text-dark fs-2 ms-3"><i class="bi bi-person-circle"></i></a>
            <?php else: ?>
                <a href="login.php" class="btn btn-custom me-2">Se connecter</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="contact-card">
    <h2 class="contact-title">LOGIN</h2>
    <?php echo $message; ?>

    <form method="post">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
        <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
        <button type="submit" class="btn contact-btn"><i class="bi bi-box-arrow-in-right"></i> Se connecter</button>
    </form>

    <p class="text-center mt-3">Pas encore inscrit ? <a href="inscription.php">S'inscrire</a></p>
</div>

<footer class="bg-dark text-white text-center py-4 mt-5">
    <div class="container">
        <h5>Golden Salon</h5>
        <p>Votre salon de coiffure à Amiens ✂️</p>
        <p>55 rue Sully, Amiens</p>
        <p>+33 712345678</p>
        <hr class="bg-light">
        <p>© 2026 Golden Salon</p>
    </div>
</footer>

</body>
</html>