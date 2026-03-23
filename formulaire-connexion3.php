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
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['Id_clients'];
                $_SESSION['firstname'] = $user['firstname'];

                header("Location: accueil.html");
                exit;
            } else {
                $message = "<div class='alert alert-danger'>Mot de passe incorrect</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Utilisateur non trouvé</div>";
        }

    } catch (PDOException $e) {
        $message = "<div class='alert alert-danger'>Erreur base de données : " . e($e->getMessage()) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Golden Salon</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>

  <!-- TOP BAR -->
  <div class="container top-bar d-flex justify-content-between align-items-center py-2">
    <img src="./assets/img/logo.png" width="80">
    <div>
      <a href="#" class="btn btn-custom me-2">PRENDRE RDV</a>
      <a href="contact.html" class="btn btn-custom me-2">CONTACT</a>
      <a href="javascript:history.back()" class="btn btn-outline-dark rounded-circle">
        <i class="bi bi-arrow-left"></i>
      </a>
    </div>
  </div>

  <!-- LOGIN CARD -->
  <div class="login-card mx-auto mt-5 p-4">

    <h2 class="login-title text-center mb-4">LOGIN</h2>

    <?php echo $message; ?>

    <form method="post">
      <div class="input-group mb-3">
        <i class="bi bi-envelope input-icon"></i>
        <input type="email" name="email" placeholder="Email" class="form-control" required>
      </div>

      <div class="input-group mb-3">
        <i class="bi bi-lock input-icon"></i>
        <input type="password" name="password" placeholder="Mot de passe" class="form-control" required>
      </div>

      <button type="submit" class="btn login-btn w-100">LOGIN</button>
    </form>

    <div class="signup mt-3 text-center">
      <p>Pas encore inscrit ? <a href="formulaire-inscription3.php">S'inscrire</a></p>
    </div>

  </div>

</body>

</html>