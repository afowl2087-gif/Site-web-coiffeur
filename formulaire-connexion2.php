<?php
session_start();

// Redirection si déjà connecté
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

// Fonction pour sécuriser les sorties (XSS futur)
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    try {
        // Connexion PDO
        $pdo = new PDO("mysql:host=localhost;dbname=salon_coiffure;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer la requête pour récupérer l'utilisateur
        $stmt = $pdo->prepare("SELECT Id_clients, firstname, password FROM clients WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Vérification du mot de passe
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['Id_clients'];
                $_SESSION['firstname'] = $user['firstname'];

                header("Location: dashboard.php");
                exit;
            } else {
                $message = "<div class='alert alert-danger'>Mot de passe incorrect</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Utilisateur non trouvé</div>";
        }

    } catch (PDOException $e) {
        // Toujours sécuriser les messages d'erreur
        $message = "<div class='alert alert-danger'>Erreur base de données : " . e($e->getMessage()) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Connexion</h2>
<?php echo $message; ?>

<form method="post">
    <input type="email" name="email" placeholder="Email" class="form-control mb-2" required>
    <input type="password" name="password" placeholder="Mot de passe" class="form-control mb-3" required>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>

<p class="mt-3">Pas encore inscrit ? <a href="formulaire-inscription2.php">S'inscrire</a></p>

</body>
</html>