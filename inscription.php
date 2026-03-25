<?php
session_start();
$message = "";

function e($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nom = trim($_POST['lastname'] ?? '');
  $prenom = trim($_POST['firstname'] ?? '');
  $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
  $password = trim($_POST['password'] ?? '');
  $confirm = trim($_POST['confirm_password'] ?? '');
  $telephone = trim($_POST['phone'] ?? '');
  $civility = $_POST['civility'] ?? '';

  if (!$nom || !$prenom || !$email || !$password || !$confirm) {
    $message = "<div class='alert alert-danger'>Tous les champs sont obligatoires</div>";
  } elseif ($password !== $confirm) {
    $message = "<div class='alert alert-danger'>Les mots de passe ne correspondent pas</div>";
  } else {
    try {
      $pdo = new PDO("mysql:host=localhost;dbname=salon;charset=utf8", "root", "");
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $pdo->prepare("SELECT email FROM clients WHERE email = ?");
      $stmt->execute([$email]);

      if ($stmt->rowCount() > 0) {
        $message = "<div class='alert alert-danger'>Email déjà utilisé</div>";
      } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO clients (lastname, firstname, email, phone, password, civility) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $email, $telephone, $hashedPassword, $civility]);

        $message = "<div class='alert alert-success'>Inscription réussie ✅</div>";
      }
    } catch (PDOException $e) {
      $message = "<div class='alert alert-danger'>Erreur : " . e($e->getMessage()) . "</div>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Inscription</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f5f7;
    }

    /* NAVBAR */
    .navbar {
      background: #fff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      border-radius: 0 0 20px 20px;
    }

    .btn-custom {
      background-color: #1f2937;
      color: white;
      border-radius: 25px;
      padding: 8px 25px;
    }
    .navbar .btn-custom:hover {
    background-color: #111827; /* même hover que login */
}

    /* CARD */
    .contact-card {
      width: 400px;
      margin: 80px auto;
      background: #fff;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .contact-title {
      text-align: center;
      margin-bottom: 20px;
      font-weight: bold;
    }

    /* INPUTS IDENTIQUES */
    .form-control,
    select {
      width: 100%;
      border-radius: 12px;
      padding: 12px;
      margin-bottom: 15px;
      box-sizing: border-box;
    }

    /* FIX SELECT */
    select.form-control {
      height: 48px;
    }

    .contact-btn {
      width: 100%;
      background-color: #1f2937;
      color: white;
      border-radius: 50px;
      padding: 10px;
    }
  </style>
</head>

<body>

  <!-- NAVBAR EXACTE -->
  <nav class="navbar navbar-expand-lg py-3 mb-5">
    <div class="container">
      <a href="dashboard3.php">
        <img src="./assets/img/logo.png" width="120">
      </a>

      <div class="ms-auto d-flex align-items-center">
        <a href="prendre_rdv.php" class="btn btn-custom me-2">PRENDRE RDV</a>
        <a href="contact.php" class="btn btn-custom me-2">CONTACT</a>
        <a href="profile.php" class="text-dark fs-2 ms-3">
          <i class="bi bi-person-circle"></i>
        </a>
      </div>
    </div>
  </nav>

  <div class="contact-card">

    <h2 class="contact-title">INSCRIPTION</h2>
    <?php echo $message; ?>

    <form method="post">

      <input type="text" name="firstname" class="form-control" placeholder="Prénom" required>
      <input type="text" name="lastname" class="form-control" placeholder="Nom" required>
      <input type="email" name="email" class="form-control" placeholder="Email" required>
      <input type="text" name="phone" class="form-control" placeholder="Téléphone">

      <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
      <input type="password" name="confirm_password" class="form-control" placeholder="Confirmer mot de passe" required>

      <select name="civility" class="form-control">
        <option disabled selected>Choisir civilité</option>
        <option value="M">Monsieur</option>
        <option value="Mme">Madame</option>
      </select>

      <button type="submit" class="btn contact-btn">
        <i class="bi bi-person-plus"></i> S'inscrire
      </button>

    </form>

    <p class="text-center mt-3">
      Déjà inscrit ? <a href="login.php">Se connecter</a>
    </p>

  </div>
  <footer class="bg-dark text-white text-center py-4">
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