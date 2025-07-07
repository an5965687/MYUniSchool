
<?php
session_start();
include "../config/config.php";

// Connexion à la base de données
$host = "localhost";
$user = "root";
$pass = "";
$db = "gestion_inscription"; // Remplace par le nom de ta base

$conn = mysqli_connect($host, $user, $pass, $db);

// Vérifier la connexion
if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Récupérer les données du formulaire
$nom = $_POST['nom'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$genre = $_POST['genre'];

// Préparer et exécuter la requête
$sql = "INSERT INTO utilisateurs (nom, email, telephone, genre)
        VALUES (?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $nom, $email, $telephone, $genre);

if (mysqli_stmt_execute($stmt)) {
    echo "✅ Inscription réussie !";
} else {
    echo "❌ Erreur lors de l'inscription : " . mysqli_error($conn);
}

// Fermer la connexion
mysqli_close($conn);
?>