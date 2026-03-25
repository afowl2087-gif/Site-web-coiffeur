<?php
session_start();

// Vérification admin
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Admin - Golden Salon</title>
</head>
<body>

<h1>Bienvenue ADMIN 🔥</h1>
<p>Bonjour <?php echo $_SESSION['firstname']; ?></p>
<p><a href="logout.php">Se déconnecter</a></p>

</body>
</html>