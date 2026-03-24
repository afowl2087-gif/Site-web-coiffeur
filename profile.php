<?php
session_start();

// Connexion à la base
$pdo = new PDO("mysql:host=localhost;dbname=salon_coiffure;charset=utf8", "root", "");
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
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil - Golden Salon</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="./assets/css/profile.css">
</head>

<body>

  <!-- TOP BAR -->
  <div class="container top-bar d-flex justify-content-between align-items-center">
    <a href="dashboard3.php">
    <img src="./assets/img/logo.png" width="80">
    </a>
    <div>
      <a href="#" class="btn btn-custom me-2">PRENDRE RDV</a>
      <a href="contact.php" class="btn btn-custom me-2">CONTACT</a>
      <a href="javascript:history.back()" class="btn btn-outline-dark rounded-circle">
        <i class="bi bi-arrow-left"></i>
      </a>
    </div>
  </div>

  <!-- MAIN -->
  <div class="container mt-4">
    <div class="row g-4">

      <!-- LEFT PROFILE -->
      <div class="col-md-4">
        <div class="profile-card">
          <div class="profile-icon">
            <i class="bi bi-person"></i>
          </div>
          <h5>USERNAME</h5>
        </div>
      </div>

      <!-- RIGHT -->
      <div class="col-md-8">

        <div class="title-box">
          <h5>
            <?= isset($user['firstname']) ? htmlspecialchars($user['firstname']) : 'Utilisateur' ?>
          </h5>
        </div>

        <div class="form-container">

          <input type="text"
            class="form-control input-custom"
            value="<?= htmlspecialchars($user['lastname'] ?? '') ?>"
            placeholder="LASTNAME">

          <input type="text"
            class="form-control input-custom"
            value="<?= htmlspecialchars($user['firstname'] ?? '') ?>"
            placeholder="FIRSTNAME">

          <input type="email"
            class="form-control input-custom"
            value="<?= htmlspecialchars($user['email'] ?? '') ?>"
            placeholder="username@gmail.com">

          <input type="text"
            class="form-control input-custom"
            value="<?= htmlspecialchars($user['phone'] ?? '') ?>"
            placeholder="+33 123456789">

        </div>

      </div>

    </div>
  </div>
  <br>
  <footer class="bg-dark text-white text-center py-4">
    <div class="container">

      <h5>Golden Salon</h5>
      <p>Votre salon de coiffure à Amiens ✂️</p>

      <p><i class="bi bi-geo-alt"></i> 55 rue Sully, Amiens</p>
      <p><i class="bi bi-telephone"></i> +33 712345678</p>

      <div class="mb-3">
        <i class="bi bi-facebook me-3"></i>
        <i class="bi bi-instagram me-3"></i>
        <i class="bi bi-whatsapp"></i>
      </div>

      <hr class="bg-light">

      <p>© 2026 Golden Salon</p>

    </div>
  </footer>

</body>

</html>