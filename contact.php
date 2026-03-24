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
    .top-bar {
      background: #fff;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      border-radius: 0 0 20px 20px;
      padding: 1rem;
      margin-top: 15px;
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
      color: #fff;
    }

    /* CARD */
    .contact-card {
      width: 400px;
      margin: 80px auto;
      background: #fff;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }

    .contact-title {
      text-align: center;
      margin-bottom: 20px;
      font-weight: bold;
    }

    .form-control {
      border-radius: 12px;
      padding: 12px;
      margin-bottom: 15px;
    }

    textarea {
      resize: none;
    }

    .contact-btn {
      width: 100%;
      background-color: #1f2937;
      color: #fff;
      border-radius: 50px;
      padding: 10px;
      transition: 0.3s;
    }

    .contact-btn:hover {
      background-color: #111827;
    }
  </style>

</head>

<body>

  <!-- TOP BAR -->
  <div class="container top-bar d-flex justify-content-between align-items-center">
    <a href="accueil.php">
      <img src="./assets/img/logo.png" width="80">
    </a>

    <div>
      <a href="prendre_rdv.php" class="btn btn-custom me-2">PRENDRE RDV</a>
      <a href="login.php" class="btn btn-custom me-2">LOGIN</a>
      <a href="javascript:history.back()" class="btn btn-outline-dark rounded-circle">
        <i class="bi bi-arrow-left"></i>
      </a>
    </div>
  </div>

  <!-- CONTACT CARD -->
  <div class="contact-card">

    <h2 class="contact-title">CONTACT US</h2>

    <form>

      <input type="text" class="form-control" placeholder="Votre nom">

      <input type="email" class="form-control" placeholder="Votre email">

      <textarea class="form-control" rows="4" placeholder="Votre message..."></textarea>

      <button class="btn contact-btn">
        <i class="bi bi-send"></i> Envoyer
      </button>

    </form>

  </div>

</body>

</html>