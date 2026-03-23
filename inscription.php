<?php
session_start();
$message = "";

// Fonction pour sécuriser les sorties (XSS futur)
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer et nettoyer toutes les données utilisateurs
    $nom = trim($_POST['lastname']);
    $prenom = trim($_POST['firstname']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm_password']);
    $telephone = trim($_POST['phone']);
    $civility = $_POST['civility'];

    // Validation de base
    if (!$email) {
        $message = "<div class='alert alert-danger'>Email invalide</div>";
    } elseif ($password !== $confirm) {
        $message = "<div class='alert alert-danger'>Les mots de passe ne correspondent pas</div>";
    } else {
        try {
            // Connexion PDO
            $pdo = new PDO("mysql:host=localhost;dbname=salon;charset=utf8", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Vérifier si email existe déjà
            $stmt = $pdo->prepare("SELECT email FROM clients WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                $message = "<div class='alert alert-danger'>Cet email est déjà utilisé</div>";
            } else {
                // Hash du mot de passe
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insertion en base
                $stmt = $pdo->prepare("INSERT INTO clients (lastname, firstname, email, phone, password, civility) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nom, $prenom, $email, $telephone, $hashedPassword, $civility]);

                // Échapper les données utilisateurs pour XSS futur
                $safePrenom = e($prenom);
                $safeNom = e($nom);

                $message = "<div class='alert alert-success'>Inscription réussie ✅ Bienvenue $safePrenom $safeNom !</div>";
            }
        } catch (PDOException $e) {
            $message = "<div class='alert alert-danger'>Erreur base de données : " . e($e->getMessage()) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription - Golden Salon</title>

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

    <h2 class="login-title text-center mb-4">INSCRIPTION</h2>

    <?php echo $message; ?>

    <form method="post">
      <div class="input-group mb-3">
        <i class="bi bi-person input-icon"></i>
        <input type="text" name="firstname" placeholder="Prénom" class="form-control" required>
      </div>

      <div class="input-group mb-3">
        <i class="bi bi-person input-icon"></i>
        <input type="text" name="lastname" placeholder="Nom" class="form-control" required>
      </div>

      <div class="input-group mb-3">
        <i class="bi bi-envelope input-icon"></i>
        <input type="email" name="email" placeholder="Email" class="form-control" required>
      </div>

      <div class="input-group mb-3">
        <i class="bi bi-telephone input-icon"></i>
        <input type="text" name="phone" placeholder="Téléphone" class="form-control">
      </div>

      <div class="input-group mb-3">
        <i class="bi bi-lock input-icon"></i>
        <input type="password" name="password" placeholder="Mot de passe" class="form-control" required>
      </div>

      <div class="input-group mb-3">
        <i class="bi bi-lock-fill input-icon"></i>
        <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" class="form-control" required>
      </div>

      <div class="input-group mb-3">
        <select name="civility" class="form-control">
          <option value="M">Monsieur</option>
          <option value="Mme">Madame</option>
        </select>
      </div>

      <button type="submit" class="btn login-btn w-100">S'inscrire</button>
    </form>

    <p class="mt-3 text-center">Déjà inscrit ? <a href="login.php">Se connecter</a></p>

  </div>

</body>

</html>