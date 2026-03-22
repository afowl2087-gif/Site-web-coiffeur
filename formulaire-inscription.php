<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['lastname'];
    $prenom = $_POST['firstname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $telephone = $_POST['phone'];
    $civility = $_POST['civility'];

    if ($password !== $confirm) {
        $message = "<div class='alert alert-danger'>Les mots de passe ne correspondent pas</div>";
    } else {
        $conn = new mysqli("localhost", "root", "", "salon_coiffure");

        if ($conn->connect_error) {
            die("Erreur connexion");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("
            INSERT INTO clients (lastname, firstname, email, phone, password, civility) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("ssssss", $nom, $prenom, $email, $telephone, $hashedPassword, $civility);

        $stmt->execute();

        $message = "<div class='alert alert-success'>Inscription réussie ✅</div>";

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2>Inscription</h2>

    <!-- Message -->
    <?php echo $message; ?>

    <form method="post">
        <input type="text" name="lastname" placeholder="Nom" class="form-control mb-2" required>
        <input type="text" name="firstname" placeholder="Prénom" class="form-control mb-2" required>
        <input type="email" name="email" placeholder="Email" class="form-control mb-2" required>

        <input type="password" name="password" placeholder="Mot de passe" class="form-control mb-2" required>
        <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" class="form-control mb-2" required>
        <input type="text" name="phone" placeholder="Téléphone" class="form-control mb-2">

        <select name="civility" class="form-control mb-2">
            <option value="M">Monsieur</option>
            <option value="Mme">Madame</option>
        </select>
        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>

</body>
</html>