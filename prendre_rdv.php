<?php
session_start();

// Vérifier si connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$pdo = new PDO("mysql:host=localhost;dbname=salon;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id_client = $_SESSION['user_id'];
$firstname = $_SESSION['firstname'];

// Messages
$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['service']) || empty($_POST['creneau'])) {
        $error = "<div class='alert alert-danger'>Choisir un service et un créneau !</div>";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO reservations (status, Id_services, Id_clients, Id_disponibilites) VALUES (1, ?, ?, ?)");
            $stmt->execute([$_POST['service'], $id_client, $_POST['creneau']]);
            $_SESSION['success_rdv'] = "✅ Rendez-vous confirmé !";
            header("Location: prendre_rdv.php");
            exit;
        } catch (PDOException $e) {
            $error = "<div class='alert alert-danger'>Erreur : " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    }
}

if (isset($_SESSION['success_rdv'])) {
    $success = "<div class='alert alert-success'>" . $_SESSION['success_rdv'] . "</div>";
    unset($_SESSION['success_rdv']);
}

// Récupérer services
$services = $pdo->query("SELECT * FROM services")->fetchAll(PDO::FETCH_ASSOC);

// Récupérer créneaux disponibles
$creneaux = $pdo->query("
    SELECT * FROM disponibilites
    WHERE active = 1
    AND Id_disponibilites NOT IN (SELECT Id_disponibilites FROM reservations)
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Prendre RDV - Golden Salon</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f4f5f7;
    color: #333;
}
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
    transition: 0.3s;
}
.btn-custom:hover {
    background-color: #111827;
}
.container h2 {
    margin-bottom: 30px;
    font-weight: 600;
    color: #111827;
}
.card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill,minmax(200px,1fr));
    gap: 20px;
}
.service, .creneau {
    background: #fff;
    border-radius: 20px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
}
.service:hover, .creneau:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.12);
}
.selected {
    border: 2px solid #1f2937;
    background-color: #1f2937;
    color: white !important;
}
button.btn-dark {
    background-color: #1f2937;
    border-radius: 25px;
    padding: 12px 0;
    font-size: 16px;
    font-weight: 500;
}
button.btn-dark:hover {
    background-color: #111827;
}
.alert {
    border-radius: 15px;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg py-3 mb-5">
  <div class="container">
    <a href="dashboard3.php"><img src="./assets/img/logo.png" width="120"></a>
    <div class="ms-auto d-flex align-items-center">
      
      <a href="contact.php" class="btn btn-custom me-2">CONTACT</a>
      <a href="profile.php" class="text-dark fs-2 ms-3"><i class="bi bi-person-circle"></i></a>
        &nbsp;&nbsp;&nbsp;
      <a href="javascript:history.back()" class="btn btn-outline-dark rounded-circle"> <i class="bi bi-arrow-left"></i> </a>
    </div>
  </div>
</nav>

<div class="container">

<h2>Prendre un rendez-vous</h2>
<?= $success ?>
<?= $error ?>

<form method="POST">

<h4>Services</h4>
<div class="card-grid mb-4">
<?php foreach ($services as $s): ?>
    <div class="service" onclick="selectService(this, <?= $s['Id_services'] ?>)">
        <h5><?= htmlspecialchars($s['name']) ?></h5>
        <p><?= htmlspecialchars($s['price']) ?> €</p>
        <small><?= htmlspecialchars($s['description']) ?></small>
    </div>
<?php endforeach; ?>
</div>
<input type="hidden" name="service" id="serviceInput">

<h4>Créneaux disponibles</h4>
<div class="card-grid mb-4">
<?php foreach ($creneaux as $c): ?>
    <div class="creneau" onclick="selectCreneau(this, <?= $c['Id_disponibilites'] ?>)">
        <?= date("d/m H:i", strtotime($c['date_start'])) ?>
    </div>
<?php endforeach; ?>
</div>
<input type="hidden" name="creneau" id="creneauInput">

<button class="btn btn-dark w-100">Confirmer le rendez-vous</button>
</form>
</div>

<script>
function selectService(el, id){
    document.querySelectorAll('.service').forEach(e=>e.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById("serviceInput").value = id;
}

function selectCreneau(el, id){
    document.querySelectorAll('.creneau').forEach(e=>e.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById("creneauInput").value = id;
}
</script>

</body>
</html>