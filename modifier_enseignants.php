
<?php
session_start();
include "../config/config.php";

$pdo = new PDO("mysql:host=localhost;dbname=gestion_inscription;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID invalide !");
}

$id = (int) $_GET['id'];

if (isset($_POST['modifier'])) {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $specialite = $_POST['specialite'] ?? '';

    if ($nom && $prenom && $email) {
        $stmt = $pdo->prepare("UPDATE enseignants SET nom = ?, prenom = ?, email = ?, specialite = ? WHERE id = ?");
        $stmt->execute([$nom, $prenom, $email, $specialite, $id]);
        header("Location: enseignants.php");
        exit;
    } else {
        $erreur = "Champs requis manquants.";
    }
}

$stmt = $pdo->prepare("SELECT * FROM enseignants WHERE id = ?");
$stmt->execute([$id]);
$enseignant = $stmt->fetch();

if (!$enseignant) {
    die("Enseignant introuvable !");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Enseignant</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        form { max-width: 400px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 5px #ccc; }
        input, button { width: 100%; padding: 10px; margin: 10px 0; }
        .btn { background: #2196F3; color: white; border: none; }
        .btn:hover { background: #1976D2; }
        .erreur { color: red; text-align: center; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Modifier Enseignant</h2>

<?php if (!empty($erreur)): ?>
    <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<form method="post">
    <input type="text" name="nom" value="<?= htmlspecialchars($enseignant['nom']) ?>" placeholder="Nom" required>
    <input type="text" name="prenom" value="<?= htmlspecialchars($enseignant['prenom']) ?>" placeholder="Prénom" required>
    <input type="email" name="email" value="<?= htmlspecialchars($enseignant['email']) ?>" placeholder="Email" required>
    <input type="text" name="specialite" value="<?= htmlspecialchars($enseignant['specialite']) ?>" placeholder="Spécialité">
    <button type="submit" name="modifier" class="btn">Enregistrer</button>
</form>

<p style="text-align:center;"><a href="enseignants.php">⬅ Retour à la liste</a></p>

</body>
</html>