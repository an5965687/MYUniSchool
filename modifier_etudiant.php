
<?php
echo "Page de modification étudiant";
session_start();
include "../config/config.php";

// Connexion à la base
$pdo = new PDO("mysql:host=localhost;dbname=gestion_inscription;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérifier l’ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID invalide !");
}

$id = (int)$_GET['id'];

// Traitement de la modification
if (isset($_POST['modifier'])) {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $date = $_POST['date_naissance'] ?? '';

    if ($nom && $prenom && $email && $date) {
        $stmt = $pdo->prepare("UPDATE etudiants SET nom = ?, prenom = ?, email = ?, date_naissance = ? WHERE id = ?");
        $stmt->execute([$nom, $prenom, $email, $date, $id]);
        header("Location: etudiants.php");
        exit;
    } else {
        $erreur = "Tous les champs sont requis.";
    }
}

// Charger les données actuelles
$stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = ?");
$stmt->execute([$id]);
$etudiant = $stmt->fetch();

if (!$etudiant) {
    die("Étudiant non trouvé !");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Étudiant</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #f5f5f5; }
        form { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 5px #ccc; max-width: 400px; margin: auto; }
        input, button { width: 100%; padding: 8px; margin: 10px 0; }
        .btn { background: #2196F3; color: white; border: none; cursor: pointer; }
        .btn:hover { background: #1976D2; }
        .erreur { color: red; text-align: center; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Modifier un étudiant</h2>

<?php if (!empty($erreur)): ?>
    <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<form method="post">
    <input type="text" name="nom" value="<?= htmlspecialchars($etudiant['nom']) ?>" placeholder="Nom" required>
    <input type="text" name="prenom" value="<?= htmlspecialchars($etudiant['prenom']) ?>" placeholder="Prénom" required>
    <input type="email" name="email" value="<?= htmlspecialchars($etudiant['email']) ?>" placeholder="Email" required>
    <input type="date" name="date_naissance" value="<?= htmlspecialchars($etudiant['date_naissance']) ?>" required>
    <button type="submit" name="modifier" class="btn">Enregistrer</button>
</form>

<p style="text-align:center;"><a href="etudiants.php">⬅ Retour à la liste</a></p>

</body>
</html>