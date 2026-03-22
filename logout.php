<?php
session_start();
session_destroy();
header("Location: formulaire-connexion2.php");
exit;