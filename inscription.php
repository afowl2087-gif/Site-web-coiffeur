<?php
session_start();
$message = "";

// Fonction sécurité XSS
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['lastname']);
    $prenom = trim($_POST['firstname']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm_password']);
    $telephone = trim($_POST['phone']);
    $civility = $_POST['civility'];

    if (!$email) {
        $message = "<div class='alert alert-danger'>Email invalide</div>";
    } elseif ($password !== $confirm) {
        $message = "<div class='alert alert-danger'>Les mots de passe ne correspondent pas</div>";
    } else {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=salon;charset=utf8", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT email FROM clients WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->rowCount() > 0) {
                $message = "<div class='alert alert-danger'>Cet email est déjà utilisé</div>";
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription - Golden Salon</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<style>
body {
  font-family: 'Segoe UI', sans-serif;
  background-color: #f4f5f7;
}

/* NAVBAR */
.navbar {
  background: #fff;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  border-radius: 0 0 20px 20px;
}

.btn-custom {
  background-color: #1f2937;
  color: white;
  border-radius: 25px;
  padding: 8px 25px;
}

.btn-custom:hover {
  background-color: #111827;
}

/* CARD */
.login-card {
  width: 400px;
  background: #fff;
  border-radius: 20px;
  padding: 30px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

.login-title {
  font-weight: 600;
}

/* INPUT */
.form-control {
  border-radius: 12px;
  padding: 12px;
}

.login-btn {
  background-color: #1f2937;
  color: white;
  border-radius: 25px;
  padding: 10px;
}

.login-btn:hover {
  background-color: #111827;
}

.input-group {
  position: relative;
}

.input-icon {
  position: absolute;
  left: 10px;
  top: 50%;
  transform: translateY(-50%);
  color: #888;
}

.input-group input,
.input-group select {
  padding-left: 35px;
}
</style>

<body>

<!-- NAVBAR (IDENTIQUE LOGIN) -->
<nav class="navbar navbar-expand-lg py-3 mb-5">
  <div class="container">

    <a href="dashboard3.php">
      <img src="./assets/img/logo.png" width="120">
    </a>

    <div class="ms-auto d-flex align-items-center">
      <a href="prendre_rdv.php" class="btn btn-custom me-2">PRENDRE RDV</a>
      <a href="contact.php" class="btn btn-custom me-2">CONTACT</a>
    </div>

  </div>
</nav>

<!-- CARD -->
<div class="login-card mx-auto mt-5 p-4">

  <h2 class="login-title text-center mb-4">INSCRIPTION</h2>

  <?php echo $message; ?>

  <form method="post">

    <div class="input-group mb-3">
      <i class="bi bi-person input-icon"></i>
      <input type="text" name="firstname" placeholder="Prénom" class="form-control" required>
    </div>

    <div class="input-group mb-3">
      <i class="bi bi-person input-icon"></i>
      <input type="text" name="lastname" placeholder="Nom" class="form-control" required>
    </div>

    <div class="input-group mb-3">
      <i class="bi bi-envelope input-icon"></i>
      <input type="email" name="email" placeholder="Email" class="form-control" required>
    </div>

    <div class="input-group mb-3">
      <i class="bi bi-telephone input-icon"></i>
      <input type="text" name="phone" placeholder="Téléphone" class="form-control">
    </div>

    <div class="input-group mb-3">
      <i class="bi bi-lock input-icon"></i>
      <input type="password" name="password" placeholder="Mot de passe" class="form-control" required>
    </div>

    <div class="input-group mb-3">
      <i class="bi bi-lock-fill input-icon"></i>
      <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" class="form-control" required>
    </div>

    <div class="input-group mb-3">
      <i class="bi bi-person-badge input-icon"></i>
      <select name="civility" class="form-control">
        <option value="M">Monsieur</option>
        <option value="Mme">Madame</option>
      </select>
    </div>

    <button type="submit" class="btn login-btn w-100">S'inscrire</button>

  </form>

  <div class="mt-3 text-center">
    <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
  </div>

</div>

</body>
</html>