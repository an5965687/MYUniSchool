
<?php
// 🔒 NE RIEN METTRE avant cette ligne !
session_start();
include "../Config/config.php";

// 1. Vérifie que les champs sont remplis
if (empty($_POST['nom']) || empty($_POST['password'])) {
    exit("Veuillez remplir tous les champs");
}

// 2. Récupère les valeurs du formulaire
$nom = $_POST['nom'];
$password = $_POST['password'];

try {
    // 3. Prépare la requête pour rechercher l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE nom = :nom AND password = :password");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // 4. Stocke les infos en session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];

        // 5. Redirection vers index.php
        header("Location: ../admin/admin_dashboard.php");
        exit();
    } else {
        exit("Nom ou mot de passe incorrect");
    }

} catch (PDOException $e) {
    exit("Erreur de connexion : " . $e->getMessage());
}