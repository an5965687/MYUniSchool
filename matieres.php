
<?php
session_start();
include "../config/config.php";

$pdo = new PDO("mysql:host=localhost;dbname=gestion_inscription;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Ajouter une matière
if (isset($_POST['ajouter'])) {
    $nom = $_POST['nom'] ?? '';
    $coef = $_POST['coefficient'] ?? '';

    if ($nom && is_numeric($coef)) {
        $stmt = $pdo->prepare("INSERT INTO matieres (nom, coefficient) VALUES (?, ?)");
        $stmt->execute([$nom, $coef]);
        header("Location: matieres.php");
        exit;
    }
}

// Supprimer une matière
if (isset($_GET['supprimer'])) {
    $id = (int)$_GET['supprimer'];
    $pdo->prepare("DELETE FROM matieres WHERE id = ?")->execute([$id]);
    header("Location: matieres.php");
    exit;
}

// Lister les matières
$matieres = $pdo->query("SELECT * FROM matieres ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Matières</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        h1 { text-align: center; }
        form { max-width: 400px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 5px #ccc; }
        input, button { width: 100%; padding: 10px; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; background: #fff; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        .btn { background: #4CAF50; color: white; border: none; }
        .btn:hover { background: #45a049; }
        .sup { color: red; }
    </style>
</head>
<body>

<h1>Gestion des Matières</h1>

<form method="post">
    <input type="text" name="nom" placeholder="Nom de la matière" required>
    <input type="number" name="coefficient" placeholder="Coefficient" required>
    <button type="submit" name="ajouter" class="btn">Ajouter</button>
</form>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Coefficient</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($matieres as $m): ?>
        <tr>
            <td><?= htmlspecialchars($m['nom']) ?></td>
            <td><?= htmlspecialchars($m['coefficient']) ?></td>
            <td>
                <a href="modifier_matieres.php?id=<?= $m['id'] ?>">Modifier</a> |
                <a href="?supprimer=<?= $m['id'] ?>" class="sup" onclick="return confirm('Supprimer cette matière ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($matieres)): ?>
        <tr><td colspan="3">Aucune matière enregistrée.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>