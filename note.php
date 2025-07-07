
<?php
session_start();
include "../config/config.php";

// Connexion à la base
$pdo = new PDO("mysql:host=localhost;dbname=gestion_inscription;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Traitement d'ajout
if (isset($_POST['ajouter'])) {
    $id_etudiant = $_POST['id_etudiant'];
    $id_matiere = $_POST['id_matiere'];
    $id_enseignant = $_POST['id_enseignant'];
    $note = $_POST['note'];

    if ($id_etudiant && $id_matiere && $id_enseignant && is_numeric($note)) {
        $stmt = $pdo->prepare("INSERT INTO note (id_etudiant, id_matiere, id_enseignant, note) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id_etudiant, $id_matiere, $id_enseignant, $note]);
        header("Location: note.php");
        exit;
    }
}

// Récupérer les listes
$etudiants = $pdo->query("SELECT id, nom, prenom FROM etudiants")->fetchAll();
$matieres = $pdo->query("SELECT id, nom FROM matieres")->fetchAll();
$enseignants = $pdo->query("SELECT id, nom, prenom FROM enseignants")->fetchAll();

// Liste des notes
$notes = $pdo->query("
    SELECT n.id, n.note, 
           e.nom AS nom_etudiant, e.prenom AS prenom_etudiant,
           m.nom AS matiere,
           ens.nom AS nom_ens, ens.prenom AS prenom_ens
    FROM note n
    JOIN etudiants e ON n.id_etudiant = e.id
    JOIN matieres m ON n.id_matiere = m.id
    JOIN enseignants ens ON n.id_enseignant = ens.id
    ORDER BY n.id DESC
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Notes</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; padding: 20px; }
        h1 { text-align: center; }
        form { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 8px #ccc; }
        select, input, button { width: 100%; padding: 10px; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; background: white; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        .btn { background-color: #4CAF50; color: white; border: none; }
        .btn:hover { background-color: #45a049; }
    </style>
</head>
<body>

<h1>Gestion des Notes</h1>

<form method="post">
    <label>Étudiant</label>
    <select name="id_etudiant" required>
        <option value="">-- Sélectionner --</option>
        <?php foreach ($etudiants as $e): ?>
            <option value="<?= $e['id'] ?>"><?= $e['nom'] . ' ' . $e['prenom'] ?></option>
        <?php endforeach; ?>
    </select>

    <label>Matière</label>
    <select name="id_matiere" required>
        <option value="">-- Sélectionner --</option>
        <?php foreach ($matieres as $m): ?>
            <option value="<?= $m['id'] ?>"><?= $m['nom'] ?></option>
        <?php endforeach; ?>
    </select>

    <label>Enseignant</label>
    <select name="id_enseignant" required>
        <option value="">-- Sélectionner --</option>
        <?php foreach ($enseignants as $ens): ?>
            <option value="<?= $ens['id'] ?>"><?= $ens['nom'] . ' ' . $ens['prenom'] ?></option>
        <?php endforeach; ?>
    </select>

    <label>Note</label>
    <input type="number" step="0.01" name="note" placeholder="Note sur 20" required>

    <button type="submit" name="ajouter" class="btn">Ajouter</button>
</form>

<h2 style="margin-top:40px;">Liste des Notes</h2>

<table>
    <thead>
        <tr>
            <th>Étudiant</th>
            <th>Matière</th>
            <th>Enseignant</th>
            <th>Note</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($notes as $n): ?>
        <tr>
            <td><?= htmlspecialchars($n['nom_etudiant']) . ' ' . htmlspecialchars($n['prenom_etudiant']) ?></td>
            <td><?= htmlspecialchars($n['matiere']) ?></td>
            <td><?= htmlspecialchars($n['nom_ens']) . ' ' . htmlspecialchars($n['prenom_ens']) ?></td>
            <td><?= htmlspecialchars($n['note']) ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($notes)): ?>
        <tr><td colspan="4">Aucune note enregistrée</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>