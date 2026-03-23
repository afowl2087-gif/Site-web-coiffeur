<?php
session_start();
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
        try {
            // Connexion PDO
            $pdo = new PDO("mysql:host=localhost;dbname=salon_coiffure;charset=utf8", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Vérifier si email existe déjà
            $stmt = $pdo->prepare("SELECT email FROM clients WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                $message = "<div class='alert alert-danger'>Cet email est déjà utilisé</div>";
            } else {
                // Hash du mot de passe
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insertion en base
                $stmt = $pdo->prepare("INSERT INTO clients (lastname, firstname, email, phone, password, civility) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nom, $prenom, $email, $telephone, $hashedPassword, $civility]);

                $message = "<div class='alert alert-success'>Inscription réussie ✅</div>";
            }
        } catch (PDOException $e) {
            $message = "<div class='alert alert-danger'>Erreur base de données : " . htmlspecialchars($e->getMessage()) . "</div>";
        }
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

<p class="mt-3">Déjà inscrit ? <a href="formulaire-connexion2.php">Se connecter</a></p>

</body>
</html>