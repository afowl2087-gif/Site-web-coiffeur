<?php

$host = "localhost";
$utilisateur = "root";
$motdepasse = "";
$base = "salon";

$connexion = mysqli_connect($host, $utilisateur, $motdepasse, $base);

if (!$connexion) {
    die("Erreur de connexion : " . mysqli_connect_error());
}


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");


$action = $_GET['action'];




if ($action == "getClients") {
    $resultat = mysqli_query($connexion, "SELECT * FROM clients");
    $clients = [];
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        $clients[] = $ligne;
    }
    echo json_encode($clients);
}

if ($action == "ajouterClient") {
    $prenom    = $_POST['prenom'];
    $nom       = $_POST['nom'];
    $email     = $_POST['email'];
    $telephone = $_POST['telephone'];
    $civilite  = $_POST['civilite'];
    $password  = md5($_POST['password']);

    $sql = "INSERT INTO clients (firstname, lastname, email, phone, civility, password, is_admin)
            VALUES ('$prenom', '$nom', '$email', '$telephone', '$civilite', '$password', 0)";

    if (mysqli_query($connexion, $sql)) {
        echo json_encode(["succes" => true]);
    } else {
        echo json_encode(["succes" => false, "erreur" => mysqli_error($connexion)]);
    }
}

if ($action == "supprimerClient") {
    $id = $_GET['id'];
    $sql = "DELETE FROM clients WHERE Id_clients = $id";
    if (mysqli_query($connexion, $sql)) {
        echo json_encode(["succes" => true]);
    } else {
        echo json_encode(["succes" => false, "erreur" => mysqli_error($connexion)]);
    }
}




if ($action == "getServices") {
    $resultat = mysqli_query($connexion, "SELECT * FROM services");
    $services = [];
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        $services[] = $ligne;
    }
    echo json_encode($services);
}

if ($action == "ajouterService") {
    $nom         = $_POST['nom'];
    $description = $_POST['description'];
    $duree       = $_POST['duree'];
    $prix        = $_POST['prix'];

    $sql = "INSERT INTO services (name, description, duration_minutes, price)
            VALUES ('$nom', '$description', '$duree', '$prix')";

    if (mysqli_query($connexion, $sql)) {
        echo json_encode(["succes" => true]);
    } else {
        echo json_encode(["succes" => false, "erreur" => mysqli_error($connexion)]);
    }
}

if ($action == "supprimerService") {
    $id = $_GET['id'];
    $sql = "DELETE FROM services WHERE Id_services = $id";
    if (mysqli_query($connexion, $sql)) {
        echo json_encode(["succes" => true]);
    } else {
        echo json_encode(["succes" => false, "erreur" => mysqli_error($connexion)]);
    }
}




if ($action == "getDisponibilites") {
    $resultat = mysqli_query($connexion, "SELECT * FROM disponibilites");
    $dispos = [];
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        $dispos[] = $ligne;
    }
    echo json_encode($dispos);
}

if ($action == "ajouterDisponibilite") {
    $date  = $_POST['date'];
    $actif = $_POST['actif'];

    $sql = "INSERT INTO disponibilites (date_start, active)
            VALUES ('$date', '$actif')";

    if (mysqli_query($connexion, $sql)) {
        echo json_encode(["succes" => true]);
    } else {
        echo json_encode(["succes" => false, "erreur" => mysqli_error($connexion)]);
    }
}

if ($action == "supprimerDisponibilite") {
    $id = $_GET['id'];
    $sql = "DELETE FROM disponibilites WHERE Id_disponibilites = $id";
    if (mysqli_query($connexion, $sql)) {
        echo json_encode(["succes" => true]);
    } else {
        echo json_encode(["succes" => false, "erreur" => mysqli_error($connexion)]);
    }
}




if ($action == "getReservations") {
    
    $sql = "SELECT r.Id_reservations, r.status,
                   c.firstname, c.lastname,
                   s.name AS service_name,
                   d.date_start
            FROM reservations r
            JOIN clients c ON r.Id_clients = c.Id_clients
            JOIN services s ON r.Id_services = s.Id_services
            JOIN disponibilites d ON r.Id_disponibilites = d.Id_disponibilites";

    $resultat = mysqli_query($connexion, $sql);
    $reservations = [];
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        $reservations[] = $ligne;
    }
    echo json_encode($reservations);
}

if ($action == "ajouterReservation") {
    $idClient = $_POST['id_client'];
    $idService = $_POST['id_service'];
    $idDispo   = $_POST['id_dispo'];
    $statut    = $_POST['statut'];

    $sql = "INSERT INTO reservations (Id_clients, Id_services, Id_disponibilites, status)
            VALUES ('$idClient', '$idService', '$idDispo', '$statut')";

    if (mysqli_query($connexion, $sql)) {
        echo json_encode(["succes" => true]);
    } else {
        echo json_encode(["succes" => false, "erreur" => mysqli_error($connexion)]);
    }
}

if ($action == "supprimerReservation") {
    $id = $_GET['id'];
    $sql = "DELETE FROM reservations WHERE Id_reservations = $id";
    if (mysqli_query($connexion, $sql)) {
        echo json_encode(["succes" => true]);
    } else {
        echo json_encode(["succes" => false, "erreur" => mysqli_error($connexion)]);
    }
}

mysqli_close($connexion);
?>
