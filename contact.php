<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact - Golden Salon</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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

    /* CONTACT CARD */
    .contact-card {
      width: 400px;
      margin: 80px auto;
      background: #fff;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
      text-align: center;
    }

    .contact-title {
      text-align: center;
      margin-bottom: 30px;
      font-weight: bold;
    }

    .contact-info p {
      margin: 10px 0;
      font-size: 16px;
    }

    .contact-info i {
      margin-right: 8px;
      color: #1f2937;
    }
  </style>

</head>

<body>

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

  <!-- CONTACT CARD -->
  <div class="contact-card">
    <h2 class="contact-title">NOUS CONTACTER</h2>

    <div class="contact-info">
      <p><i class="bi bi-geo-alt"></i> 55 rue Sully, 80000 Amiens, France</p>
      <p><i class="bi bi-telephone"></i> +33 712345678</p>
      <p><i class="bi bi-envelope"></i> contact@goldensalon.com</p>
      <p><i class="bi bi-clock"></i> Lundi - Samedi : 10h - 20h</p>
    </div>
  </div>

  <footer class="bg-dark text-white text-center py-4 mt-5">
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