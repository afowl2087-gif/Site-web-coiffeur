<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mentions légales - Golden Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f5f7;
            margin: 0;
            padding: 0;
        }

        /* Navbar style login */
        .navbar {
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-radius: 0 0 20px 20px;
        }

        .btn-custom {
            background-color: #1f2937;
            color: #fff;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background-color: #111827;
        }

        /* Page content */
        .content-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 15px;
        }

        h1, h4 {
            color: #1f2937;
        }

        p {
            line-height: 1.6;
            color: #333;
        }

        .btn-back {
            background-color: #1f2937;
            color: #fff;
            border-radius: 50px;
            padding: 10px 25px;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #111827;
            color: #fff;
        }

        /* Responsive iframe maps */
        .map-container {
            position: relative;
            width: 100%;
            padding-bottom: 40%;
            margin-top: 20px;
        }

        .map-container iframe {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 15px;
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
            <a href="profile.php" class="text-dark fs-2 ms-3"><i class="bi bi-person-circle"></i></a>
        </div>
    </div>
</nav>

<!-- CONTENU -->
<div class="content-wrapper">
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

    <!-- Bouton retour -->
    <a href="accueil.php" class="btn-back mt-3 d-inline-block">Retour</a>
</div>

</body>
</html>