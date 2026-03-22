<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: formulaire-connexion2.php");
    exit;
}
?>

<h2>Bienvenue <?php echo htmlspecialchars($_SESSION['firstname']); ?> !</h2>
<p><a href="logout.php">Se déconnecter</a></p>