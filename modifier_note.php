
<?php
session_start();
include "../config/config.php";

$pdo = new PDO("mysql:host=localhost;dbname=gestion_inscription;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérification ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID invalide !");
}
$id = (int)$_GET['id'];

// Traitement de modification
if (isset($_POST['modifier'])) {
    $id_etudiant = $_POST['id_etudiant'];
    $id_matiere = $_POST['id_matiere'];
    $id_enseignant = $_POST['id_enseignant'];
    $note = $_POST['note'];

    if ($id_etudiant && $id_matiere && $id_enseignant && is_numeric($note)) {
        $stmt = $pdo->prepare("UPDATE notes SET id_etudiant = ?, id_matiere = ?, id_enseignant = ?, note = ? WHERE id = ?");
        $stmt->execute([$id_etudiant, $id_matiere, $id_enseignant, $note, $id]);
        header("Location: notes.php");
        exit;
    } else {
        $erreur = "Tous les champs sont requis.";
    }
}

// Charger données actuelles
$noteData = $pdo->prepare("SELECT * FROM notes WHERE id = ?");
$noteData->execute([$id]);
$note = $noteData->fetch();

if (!$note) {
    die("Note introuvable !");
}

// Chargement des listes
$etudiants = $pdo->query("SELECT id, nom, prenom FROM etudiants")->fetchAll();
$matieres = $pdo->query("SELECT id, nom FROM matieres")->fetchAll();
$enseignants = $pdo->query("SELECT id, nom, prenom FROM enseignants")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une Note</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        form { max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 5px #ccc; }
        select, input, button { width: 100%; padding: 10px; margin: 10px 0; }
        .btn { background: #2196F3; color: white; border: none; }
        .btn:hover { background: #1976D2; }
        .erreur { color: red; text-align: center; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Modifier une Note</h2>

<?php if (!empty($erreur)): ?>
    <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
<?php endif; ?>

<form method="post">
    <label>Étudiant</label>
    <select name="id_etudiant" required>
        <?php foreach ($etudiants as $e): ?>
            <option value="<?= $e['id'] ?>" <?= $e['id'] == $note['id_etudiant'] ? 'selected' : '' ?>>
                <?= $e['nom'] . ' ' . $e['prenom'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Matière</label>
    <select name="id_matiere" required>
        <?php foreach ($matieres as $m): ?>
            <option value="<?= $m['id'] ?>" <?= $m['id'] == $note['id_matiere'] ? 'selected' : '' ?>>
                <?= $m['nom'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Enseignant</label>
    <select name="id_enseignant" required>
        <?php foreach ($enseignants as $ens): ?>
            <option value="<?= $ens['id'] ?>" <?= $ens['id'] == $note['id_enseignant'] ? 'selected' : '' ?>>
                <?= $ens['nom'] . ' ' . $ens['prenom'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="number" step="0.01" name="note" value="<?= htmlspecialchars($note['note']) ?>" placeholder="Note sur 20" required>

    <button type="submit" name="modifier" class="btn">Enregistrer</button>
</form>

<p style="text-align:center;"><a href="notes.php">⬅ Retour à la liste</a></p>

</body>
</html>