<?php
session_start();

// Connexion à la base
$pdo = new PDO("mysql:host=localhost;dbname=salon;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérifier si connecté
if (!isset($_SESSION['user_id'])) {
  header("Location: formulaire-connexion3.php");
  exit;
}

// Récupérer les infos depuis la DB
$stmt = $pdo->prepare("SELECT * FROM clients WHERE Id_clients = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier que l'utilisateur existe
if (!$user) {
  echo "Utilisateur introuvable.";
  exit;
}

$message = "";

// Traitement formulaire POST pour mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $lastname = trim($_POST['lastname']);
  $firstname = trim($_POST['firstname']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);

  if (!$lastname || !$firstname || !$email) {
    $message = "<div class='alert alert-danger'>Veuillez remplir tous les champs requis.</div>";
  } else {
    try {
      $stmt = $pdo->prepare("UPDATE clients SET lastname = ?, firstname = ?, email = ?, phone = ? WHERE Id_clients = ?");
      $stmt->execute([$lastname, $firstname, $email, $phone, $_SESSION['user_id']]);
      $message = "<div class='alert alert-success'>Profil mis à jour avec succès ✅</div>";
      $_SESSION['firstname'] = $firstname;
      $user['lastname'] = $lastname;
      $user['firstname'] = $firstname;
      $user['email'] = $email;
      $user['phone'] = $phone;
    } catch (PDOException $e) {
      $message = "<div class='alert alert-danger'>Erreur base de données : " . htmlspecialchars($e->getMessage()) . "</div>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil - Golden Salon</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f5f7;
    }

    .navbar {
      background: #fff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      border-radius: 0 0 20px 20px;
    }

    /* Top bar / Navbar */
    .top-bar {
      background: #fff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      border-radius: 0 0 20px 20px;
      padding: 1rem 0;
      margin-bottom: 20px;
    }

    .btn-custom {
      background-color: #1f2937;
      color: white;
      border-radius: 25px;
      padding: 8px 25px;
      transition: 0.3s;
    }

    .btn-custom:hover {
      background-color: #111827;
    }

    /* Profile cards */
    .profile-card {
      background: #fff;
      border-radius: 20px;
      padding: 30px;
      text-align: center;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .profile-card .profile-icon {
      font-size: 60px;
      color: #1f2937;
      margin-bottom: 15px;
    }

    .profile-card h5 {
      margin-top: 10px;
    }

    /* Form container */
    .form-container {
      background: #fff;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .form-container input {
      border-radius: 12px;
      margin-bottom: 15px;
      padding: 12px;
    }

    .btn-save {
      background-color: #1f2937;
      color: #fff;
      border-radius: 50px;
      padding: 10px 25px;
      font-weight: 500;
      transition: 0.3s;
    }

    .btn-save:hover {
      background-color: #111827;
    }
  </style>
</head>

<body>

  <!-- TOP BAR -->

  <nav class="navbar navbar-expand-lg py-3 mb-5">
    <div class="container">

      <!-- Logo -->
      <a href="dashboard3.php">
        <img src="./assets/img/logo.png" width="120" alt="Golden Salon">
      </a>

      <!-- Menu -->
      <div class="ms-auto d-flex align-items-center">

        <a href="prendre_rdv.php" class="btn btn-custom me-2">PRENDRE RDV</a>
        <a href="contact.php" class="btn btn-custom me-2">CONTACT</a>

        <!-- lougout icon -->
        <a href="logout.php" class="btn btn-danger me-2">LOGOUT</a>

        <!-- Bouton retour -->
        <a href="javascript:history.back()" class="btn btn-outline-dark rounded-circle">
          <i class="bi bi-arrow-left"></i>
        </a>

      </div>
    </div>
  </nav>

  <!-- MAIN -->
  <div class="container mt-4">
    <div class="row g-4">

      <!-- LEFT PROFILE -->
      <div class="col-md-4">
        <div class="profile-card">
          <div class="profile-icon">
            <i class="bi bi-person"></i>
          </div>
          <h5><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></h5>
          <p><?= htmlspecialchars($user['email']) ?></p>
          <p><?= htmlspecialchars($user['phone']) ?></p>
        </div>
      </div>

      <!-- RIGHT FORM -->
      <div class="col-md-8">
        <div class="form-container">
          <?= $message ?>
          <h5 class="mb-4">Modifier vos informations</h5>
          <form method="POST">
            <input type="text" class="form-control" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>" placeholder="Nom" required>
            <input type="text" class="form-control" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>" placeholder="Prénom" required>
            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder="Email" required>
            <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" placeholder="Téléphone">
            <button type="submit" class="btn-save mt-2"><i class="bi bi-save"></i> Sauvegarder</button>
          </form>
        </div>
      </div>

    </div>
  </div>

  <footer class="bg-dark text-white text-center py-4 mt-5">
    <div class="container">
      <h5>Golden Salon</h5>
      <p>Votre salon de coiffure à Amiens ✂️</p>
      <p><i class="bi bi-geo-alt"></i> 55 rue Sully, Amiens</p>
      <p><i class="bi bi-telephone"></i> +33 712345678</p>
      <hr class="bg-light">
      <p>© 2026 Golden Salon</p>
    </div>
  </footer>

</body>

</html>