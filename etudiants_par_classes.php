
<?php
session_start();
include "../config/config.php";

$pdo = new PDO("mysql:host=localhost;dbname=gestion_inscription;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupération des classes
$classes = $pdo->query("SELECT * FROM classes ORDER BY filiere, niveau")->fetchAll();

// Classe sélectionnée
$classe_id = isset($_GET['classe']) ? intval($_GET['classe']) : 0;
$etudiants = [];

if ($classe_id > 0) {
    $stmt = $pdo->prepare("
        SELECT e.*
        FROM etudiants e
        WHERE e.id_classe = ?
        ORDER BY e.nom
    ");
    $stmt->execute([$classe_id]);
    $etudiants = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Étudiants par Classe</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #eef2f7;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #34495e;
        }
        form {
            text-align: center;
            margin: 20px 0;
        }
        select {
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        th {
            background-color: #3498db;
            color: white;
            padding: 12px;
        }
        td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .no-data {
            text-align: center;
            font-style: italic;
            padding: 20px;
            color: #888;
        }
    </style>
</head>
<body>

<h1>Liste des Étudiants par Classe</h1>

<form method="GET">
    <label for="classe">Choisir une classe :</label>
    <select name="classe" id="classe" onchange="this.form.submit()">
        <option value="">-- Sélectionner une classe --</option>
        <?php foreach ($classes as $classe): ?>
            <option value="<?= $classe['id'] ?>" <?= $classe_id == $classe['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($classe['filiere']) ?> - <?= htmlspecialchars($classe['niveau']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if ($classe_id > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($etudiants) > 0): ?>
                <?php foreach ($etudiants as $e): ?>
                    <tr>
                        <td><?= htmlspecialchars($e['nom']) ?></td>
                        <td><?= htmlspecialchars($e['prenom']) ?></td>
                        <td><?= htmlspecialchars($e['email']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3" class="no-data">Aucun étudiant dans cette classe</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>