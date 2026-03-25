<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mentions légales - Golden Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
   <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f5f7;
    }

    /* TOP BAR (même style login) */
    .navbar {
      background: #fff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      border-radius: 0 0 20px 20px;
    }

    .btn-custom {
      background-color: #1f2937;
      color: #fff;
      border-radius: 50px;
      padding: 0.5rem 1.5rem;
      transition: 0.3s;
    }

    .navbar .btn-custom:hover {
    background-color: #111827; /* même hover que login */
}
</style>

<div class="container py-5">
     <!-- TOP BAR -->
  <nav class="navbar navbar-expand-lg py-3 mb-5">
    <div class="container">
      <a href="accueil.php"><img src="./assets/img/logo.png" width="120"></a>
      <div class="ms-auto d-flex align-items-center">
        <a href="prendre_rdv.php" class="btn btn-custom me-2">PRENDRE RDV</a>
        <a href="contact.php" class="btn btn-custom me-2">CONTACT</a>
        <a href="profile.php" class="text-dark fs-2 ms-3"><i class="bi bi-person-circle"></i></a>
      </div>
    </div>
  </nav>
    <h1 class="mb-4">Mentions légales</h1>

    <h4>Éditeur du site</h4>
    <p>
        Golden Salon<br>
        55 rue Sully, 80000 Amiens<br>
        Téléphone : +33 7 12 34 56 78<br>
        Email : contact@goldensalon.com
    </p>

    <h4>Responsable de la publication</h4>
    <p>Nom Prénom (Gérant)</p>

    <h4>Hébergement</h4>
    <p>
        Nom de l’hébergeur<br>
        Adresse de l’hébergeur
    </p>

    <h4>Propriété intellectuelle</h4>
    <p>
        Le contenu du site (textes, images, logo) est protégé. Toute reproduction est interdite.
    </p>

    <h4>Données personnelles</h4>
    <p>
        Les données collectées sont utilisées uniquement pour la gestion des rendez-vous.
        Conformément au RGPD, vous pouvez demander l’accès, la modification ou la suppression de vos données.
    </p>

    <h4>Cookies</h4>
    <p>
        Le site peut utiliser des cookies pour améliorer l’expérience utilisateur.
    </p>

    <a href="accueil.php" class="btn btn-dark mt-4">Retour</a>
</div>

</body>
</html