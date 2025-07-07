
<?php
session_start();
include "../config/config.php";

// Connexion à la base de données
$host = "localhost";
$dbname = "gestion_inscription";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier qu'on a un id en GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID invalide");
}

$id = (int) $_GET['id'];

// Traitement du formulaire de modification
if (isset($_POST['modifier'])) {
    $nom = $_POST['nom'] ?? '';
    $fonction = $_POST['fonction'] ?? '';
    $email = $_POST['email'] ?? '';

    if ($nom && $fonction && $email) {
        $stmt = $pdo->prepare("UPDATE personnel SET nom = ?, fonction = ?, email = ? WHERE id = ?");
        $stmt->execute([$nom, $fonction, $email, $id]);
        header("Location: personnel.php");
        exit;
    } else {
        $erreur = "Tous les champs sont obligatoires.";
    }
}

// Récupérer les infos du personnel à modifier
$stmt = $pdo->prepare("SELECT * FROM personnel WHERE id = ?");
$stmt->execute([$id]);
$personnel = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$personnel) {
    die("Personnel non trouvé");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Modifier Personnel</title>
    <style>
        form {max-width: 400px; margin: auto;}
        label, input {display: block; width: 100%; margin-bottom: 10px;}
        .erreur {color: red;}
    </style>
</head>
<body>
    <h1>Modifier Personnel</h1>

    <?php if (!empty($erreur)): ?>
        <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label>Nom</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($personnel['nom']) ?>" required />

        <label>Fonction</label>
        <input type="text" name="fonction" value="<?= htmlspecialchars($personnel['fonction']) ?>" required />

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($personnel['email']) ?>" required />

        <button type="submit" name="modifier">Modifier</button>
    </form>
    <p><a href="personnel.php">Retour à la liste</a></p>
</body>
</html>