<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$host = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base = "salon";

try {
    $dsn = "mysql:host=$host;dbname=$base;charset=utf8mb4";
    $pdo = new PDO($dsn, $utilisateur, $motdepasse);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["succes" => false, "erreur" => "Connexion échouée"]);
    exit;
}

$action = $_GET['action'] ?? '';

if ($action == "getClients") {
    $stmt = $pdo->query("SELECT * FROM clients");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

if ($action == "ajouterClient") {
    
    $sql = "INSERT INTO clients (firstname, lastname, email, phone, civility, password, is_admin)
            VALUES (:prenom, :nom, :email, :tel, :civ, :pass, 0)";
    $hashedpassword =password_hash($_POST['password'],PASSWORD_DEFAULT);
    $nomclient = htmlspecialchars($_POST['nom']);
    $prenomclient = htmlspecialchars($_POST['prenom']);
    $telClient = htmlspecialchars($_POST['telephone']);
    $civclient = htmlspecialchars($_POST['civilite']);
    $emailclient =htmlspecialchars($_POST['email']);
    $stmt = $pdo->prepare($sql);
    $params = [
        ':prenom' => $prenomclient,
        ':nom'    => $nomclient,
        ':email'   => $emailclient,
        ':tel'     => $telClient,
        ':civ'     => $civclient,
        ':pass'    => $hashedpassword
    ];
    if ($stmt->execute($params)) {
        echo json_encode(["succes" => true]);
    } else {
        echo json_encode(["succes" => false, "erreur" => $stmt->errorInfo()[2]]);
    }
}

if ($action == "getServices") {
    $stmt = $pdo->query("SELECT * FROM services");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

if ($action == "ajouterService") {
    $sql = "INSERT INTO services (name, description, duration_minutes, price) 
            VALUES (:nom, :desc, :duree, :prix)";
    $nomservice = htmlspecialchars($_POST['nom']);
    $descservice = htmlspecialchars($_POST['description']);
    $dureeservice = htmlspecialchars($_POST['duree']);
    $prixservice = htmlspecialchars($_POST['prix']);
    $stmt = $pdo->prepare($sql);
    
    $success = $stmt->execute([
        ':nom'   => $nomservice ,
        ':desc'  => $descservice,
        ':duree' => $dureeservice,
        ':prix'  => $prixservice
    ]);

    if ($success) {
        echo json_encode(["succes" => true]);
    } else {
        echo json_encode(["succes" => false, "erreur" => $stmt->errorInfo()[2]]);
    }
}

if ($action == "supprimerService") {
    $id = $_GET['id'] ?? null;
    
    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM services WHERE Id_services = :id");
        if ($stmt->execute([':id' => $id])) {
            echo json_encode(["succes" => true]);
        } else {
            echo json_encode(["succes" => false, "erreur" => $stmt->errorInfo()[2]]);
        }
    } else {
        echo json_encode(["succes" => false, "erreur" => "ID manquant"]);
    }
}


if ($action == "getDisponibilites") {
    $stmt = $pdo->query("SELECT * FROM disponibilites");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

if ($action == "ajouterDisponibilite") {
    $sql = "INSERT INTO disponibilites (date_start, active) VALUES (:date, :actif)";
    $date_dispo = htmlspecialchars($_POST['date']);
    $actif_dispo = htmlspecialchars($_POST['actif']);
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([':date' => $date_dispo, ':actif' => $actif_dispo])) {
        echo json_encode(["succes" => true]);
    } else {
        echo json_encode(["succes" => false, "erreur" => $stmt->errorInfo()[2]]);
    }
}

if ($action == "supprimerDisponibilite") {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM disponibilites WHERE Id_disponibilites = :id");
    if ($stmt->execute([':id' => $id])) {
        echo json_encode(["succes" => true]);
    } else {
        echo json_encode(["succes" => false, "erreur" => $stmt->errorInfo()[2]]);
    }
}

if ($action == "getReservations") {
    $sql = "SELECT r.Id_reservations, r.status, c.firstname, c.lastname, s.name AS service_name, d.date_start
            FROM reservations r
            JOIN clients c ON r.Id_clients = c.Id_clients
            JOIN services s ON r.Id_services = s.Id_services
            JOIN disponibilites d ON r.Id_disponibilites = d.Id_disponibilites";
    $stmt = $pdo->query($sql);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

if ($action == "ajouterReservation") {
    $sql = "INSERT INTO reservations (Id_clients, Id_services, Id_disponibilites, status)
            VALUES (:idC, :idS, :idD, :statut)";
    $id_reservation_client =  $_POST['id_client'];
    $id_reservation_service =  $_POST['id_service'];
    $id_reservation_disponibilites = $_POST['id_dispo'];
    $id_reservation_statut = $_POST['statut'];
    

    $stmt = $pdo->prepare($sql);
    $params = [
        ':idC'    => $id_reservation_client,
        ':idS'    => $id_reservation_service,
        ':idD'    => $id_reservation_disponibilites,
        ':statut' => $id_reservation_statut
    ];
    if ($stmt->execute($params)) {
        echo json_encode(["succes" => true]);
    } else {
        echo json_encode(["succes" => false, "erreur" => $stmt->errorInfo()[2]]);
    }
}

if ($action == "supprimerReservation") {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM reservations WHERE Id_reservations = :id");
    if ($stmt->execute([':id' => $id])) {
        echo json_encode(["succes" => true]);
    } else {
        echo json_encode(["succes" => false, "erreur" => $stmt->errorInfo()[2]]);
    }
}

$pdo = null;
?>
