<?php
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli("localhost", "root", "", "salon_coiffure");

    if ($conn->connect_error) {
        die("Erreur connexion");
    }

    // Vérifier si l'utilisateur existe
    $stmt = $conn->prepare("SELECT id, firstname, password FROM clients WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Vérification du mot de passe
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['firstname'] = $user['firstname'];

            $message = "<div class='alert alert-success'>Connexion réussie ✅</div>";
            // header("Location: dashboard.php"); // redirection possible
        } else {
            $message = "<div class='alert alert-danger'>Mot de passe incorrect</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Utilisateur non trouvé</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2>Connexion</h2>

    <!-- Message -->
    <?php echo $message; ?>

    <form method="post">
        <input type="email" name="email" placeholder="Email" class="form-control mb-2" required>
        <input type="password" name="password" placeholder="Mot de passe" class="form-control mb-3" required>

        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>

</body>
</html>