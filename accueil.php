<?php
session_start();

// if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] == 1) {
//     header("Location: login.php");
//     exit;
// }


// Fonction anti XSS
function e($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// Est connecté ?
$connected = isset($_SESSION['user_id']);
$firstname = $connected ? $_SESSION['firstname'] : null;

// Connexion PDO
$pdo = new PDO("mysql:host=localhost;dbname=salon;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer les services depuis la base
$services = $pdo->query("SELECT * FROM services")->fetchAll(PDO::FETCH_ASSOC);
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

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f5f7;
      color: #333;
    }

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
    transition: 0.3s; /* pour une transition douce */
}

.navbar .btn-custom:hover {
    background-color: #111827; /* même hover que login */
}
    .hero {
      padding: 40px 0;
      background: linear-gradient(135deg, #f8fafc, #e2e8f0);
      border-radius: 20px;
      margin: 20px 0;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    }

    .card-services {
      background: #fff;
      border-radius: 20px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .card-services:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
    }

    .info {
      background: #fff;
      padding: 15px;
      border-radius: 15px;
      margin-bottom: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
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
        <?php if ($connected): ?>
          <a href="profile.php" class="text-dark fs-2 ms-3"><i class="bi bi-person-circle"></i></a>

        <?php else: ?>
          <a href="login.php" class="btn btn-custom me-2">Se connecter</a>
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
            Venez nous rendre visite !<br><br>
            Découvrez nos offres exclusives chaque semaine et profitez de conseils personnalisés.<br>
            Nos coiffeurs experts utilisent uniquement des produits de qualité supérieure pour prendre soin de vos cheveux.<br>
            Réservez dès maintenant votre rendez-vous et vivez une expérience unique chez GOLDEN SALON.<br>
          </p>
        </div>
        <div class="col-md-6 text-center">
          <img src="./assets/img/salon-franklin.jpeg" class="homme" style="width: 450px; margin-left: 25%;">
        </div>
      </div>
    </div>
  </section>

  <!-- SERVICES DYNAMIQUES -->
  <section class="services my-5">
    <div class="container">
      <h1 class="mb-4">Nos services</h1>
      <div class="row g-4">
        <?php foreach ($services as $s): ?>
          <div class="col-md-3">
            <div class="card-services">
              <h5><?= e($s['name']) ?></h5>
              <p><?= e($s['description']) ?></p>
              <p><strong><?= $s['duration_minutes'] ?> min – <?= $s['price'] ?> €</strong></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <br>
      <div class="col-md-6">
        <h2 class="mb-4">Adresse et infos pratiques</h2>
        <div class="info"><i class="bi bi-geo-alt"></i> 55 rue Sully, Amiens 80000</div>
        <div class="info"><i class="bi bi-clock"></i> Du lundi au samedi, 10h - 20h</div>
        <div class="info"><i class="bi bi-telephone"></i> +33 712345678</div>
        <div class="info mt-3">
          <iframe src="https://maps.google.com/maps?q=amiens&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="250" style="border-radius:15px;"></iframe>
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