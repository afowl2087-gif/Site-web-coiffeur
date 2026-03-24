<?php
session_start();
?>
<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sécurisation basique
    $userMessage = htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8');

    if (!empty($userMessage)) {

        $to = "coiffeur@email.com"; // ⚠️ remplace par ton vrai email
        $subject = "Nouveau message client - Golden Salon";

        $body = "Message client :\n\n" . $userMessage;

        $headers = "From: noreply@goldensalon.com";

        if (mail($to, $subject, $body, $headers)) {
            $message = "<div class='alert alert-success'>Message envoyé ✅</div>";
        } else {
            $message = "<div class='alert alert-danger'>Erreur lors de l'envoi ❌</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Veuillez écrire un message</div>";
    }
}
?>

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
  <link rel="stylesheet" href="./assets/css/login.css">
</head>

<body>

  <!-- TOP BAR -->
  <div class="container top-bar d-flex justify-content-between align-items-center">
    <a href="dashboard3.php">
    <img src="./assets/img/logo.png" width="80">
    </a>
    <div>
      <a href="#" class="btn btn-custom me-2">PRENDRE RDV</a>
      <?php if (isset($_SESSION['user_id'])): ?>
    <a href="logout.php" class="btn btn-danger me-2">LOGOUT</a>
<?php else: ?>
    <a href="formulaire-connexion3.php" class="btn btn-custom me-2">LOGIN</a>
<?php endif; ?>
      <a href="javascript:history.back()" class="btn btn-outline-dark rounded-circle">
        <i class="bi bi-arrow-left"></i>
      </a>
    </div>
  </div>

  <!-- CARD -->
  <div class="login-card">

    <h2 class="login-title">CONTACT US</h2>

    <?php echo $message; ?>

    <form method="post">
      <div class="input-group mb-3">
        <!-- 🔥 textarea plus grande -->
        <textarea 
          name="message" 
          class="form-control" 
          rows="6" 
          placeholder="Votre message..."
          required
        ></textarea>
      </div>

      <button type="submit" class="btn login-btn w-100">SEND</button>
    </form>

  </div>

</body>

</html>