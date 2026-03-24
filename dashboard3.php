<?php
session_start();

// Fonction anti XSS
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// Est connecté ?
$connected = isset($_SESSION['user_id']);
$firstname = $connected ? $_SESSION['firstname'] : null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Golden Salon</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <!-- Logo cliquable -->
    <a href="dashboard3.php">
      <img src="./assets/img/logo.png" width="120" alt="Golden Salon">
    </a>

    <div class="ms-auto d-flex align-items-center">
      <a href="#" class="btn btn-custom me-2">PRENDRE RDV</a>
      <a href="contact.php" class="btn btn-custom me-2">CONTACT</a>

      <?php if ($connected): ?>
        <a href="logout.php" class="btn btn-danger me-2">LOGOUT</a>
        <a href="profile.php" class="text-dark fs-2 ms-3">
          <i class="bi bi-person-circle"></i>
        </a>
        <span class="ms-2">Bienvenue <?= e($firstname) ?></span>
      <?php else: ?>
        <a href="formulaire-connexion3.php" class="btn btn-custom me-2">Se connecter</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-md-6">
        <h1>GOLDEN SALON</h1>
        <p>
          <?php if ($connected): ?>
            Bienvenue <?= e($firstname) ?> chez GOLDEN SALON !<br>
          <?php else: ?>
            Bienvenue chez GOLDEN SALON !<br>
          <?php endif; ?>
          Depuis 2015, nous offrons des services de coiffure de qualité.<br><br>
          Notre équipe est à votre écoute pour sublimer votre style.<br><br>
          Venez nous rendre visite !
        </p>
      </div>

      <div class="col-md-6 text-center">
        <img src="./assets/img/salon-franklin.jpeg" class="homme" style="width: 450px; margin-left: 25%;">
      </div>

    </div>
  </div>
</section>

<!-- SERVICES -->
<section class="services">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-md-6">
        <h1 class="mb-4">Nos services</h1>
        <div class="service-item">Coupe homme (30 min – 25 €)</div>
        <div class="service-item">Taille de barbe (15 min – 15 €)</div>
        <div class="service-item">Shampoing + coupe (40 min – 30 €)</div>
        <div class="service-item">Coupe + coiffage spécial (50 min – 35 €)</div>

        <h2 class="mt-5 mb-3">Adresse et infos pratiques</h2>
        <div class="info mb-2">55 rue Sully, Amiens 80000</div>
        <div class="info mb-2">Du lundi au samedi, 10h - 20h</div>
        <div class="info">+33 712345678</div>
      </div>

      <div class="col-md-6 text-center">
        <img src="./assets/img/homme.png" class="img-fluid mb-4" style="max-width: 250px; margin-left: 350px; border-radius: 20px;">
        <iframe 
          src="https://maps.google.com/maps?q=amiens&t=&z=13&ie=UTF8&iwloc=&output=embed"
          width="100%" height="250">
        </iframe>
      </div>

    </div>
  </div>
</section>

<!-- FOOTER -->
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