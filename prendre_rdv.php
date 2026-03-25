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

// Initialiser variables
$success = "";
$error = "";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['service']) || empty($_POST['creneau'])) {
        $error = "<div class='alert alert-danger'>Choisir un service et un créneau !</div>";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO reservations (status, Id_services, Id_clients, Id_disponibilites) VALUES (1, ?, ?, ?)");
            $stmt->execute([$_POST['service'], $id_client, $_POST['creneau']]);
            $success = "<div class='alert alert-success'>✅ Rendez-vous confirmé !</div>";
        } catch (PDOException $e) {
            $error = "<div class='alert alert-danger'>Erreur : " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    }
}

// Récupérer les services
$services = $pdo->query("SELECT * FROM services")->fetchAll(PDO::FETCH_ASSOC) ?: [];

// Récupérer les créneaux disponibles
$creneaux = $pdo->query("
    SELECT * FROM disponibilites 
    WHERE active = 1 
    AND Id_disponibilites NOT IN (SELECT Id_disponibilites FROM reservations)
")->fetchAll(PDO::FETCH_ASSOC) ?: [];
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
}

.btn-custom:hover {
    background-color: #111827;
}

/* Cards */
.card-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.service {
    background: #fff;
    border-radius: 20px;
    padding: 15px;
    flex: 1 1 200px;
    text-align: center;
    cursor: pointer;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

.creneau {
    background: #fff;
    border-radius: 50px;
    padding: 10px 20px;
    margin: 5px;
    cursor: pointer;
    display: inline-block;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

.selected {
    background-color: #1f2937;
    color: white;
}

button {
    border-radius: 25px !important;
}
</style>
</head>

<body>
<!-- NAVBAR -->
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

<div class="container">
    <h2 class="mb-4">Prendre un rendez-vous</h2>

    <?= $success ?>
    <?= $error ?>

    <form method="POST">
        <!-- SERVICES -->
        <h4>Choisir un service</h4>
        <div class="card-grid mb-4">
            <?php foreach ($services as $s): ?>
            <div class="service" onclick="selectService(this, <?= $s['Id_services'] ?>)">
                <h5><?= htmlspecialchars($s['name']) ?></h5>
                <p><?= $s['price'] ?> €</p>
            </div>
            <?php endforeach; ?>
        </div>
        <input type="hidden" name="service" id="serviceInput">

        <!-- DATE -->
        <h4>Choisir une date</h4>
        <input type="date" id="datePicker" class="form-control mb-4">

        <!-- CRENEAUX -->
        <h4>Créneaux disponibles</h4>
        <div id="creneauxContainer"></div>
        <input type="hidden" name="creneau" id="creneauInput">

        <button class="btn btn-dark w-25 mt-4">Confirmer le rendez-vous</button>
    </form>
</div>

<br>
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

<script>
const allCreneaux = <?= json_encode($creneaux); ?>;

// Fonction pour sélectionner un service
function selectService(el, id) {
    document.querySelectorAll('.service').forEach(e => e.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById("serviceInput").value = id;
}

// Filtrer les créneaux par date
document.getElementById('datePicker').addEventListener('change', function() {
    const selectedDate = this.value;
    const container = document.getElementById('creneauxContainer');
    container.innerHTML = "";

    const filtered = allCreneaux.filter(c => c.date_start.startsWith(selectedDate));

    if (filtered.length === 0) {
        container.innerHTML = "<p>Aucun créneau disponible</p>";
        return;
    }

    filtered.forEach(c => {
        const div = document.createElement("div");
        div.classList.add("creneau");
        const date = new Date(c.date_start);
        const time = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        div.innerText = time;

        div.onclick = function() {
            document.querySelectorAll('.creneau').forEach(e => e.classList.remove('selected'));
            div.classList.add('selected');
            document.getElementById("creneauInput").value = c.Id_disponibilites;
        }

        container.appendChild(div);
    });
});
</script>

</body>
</html>