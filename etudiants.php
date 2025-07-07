
<?php
session_start();
include "../config/config.php";

$pdo = new PDO("mysql:host=localhost;dbname=gestion_inscription;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Ajout
if (isset($_POST['ajouter'])) {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $date = $_POST['date_naissance'] ?? '';

    if ($nom && $prenom && $email && $date) {
        $stmt = $pdo->prepare("INSERT INTO etudiants (nom, prenom, email, date_naissance) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $email, $date]);
        header("Location: etudiants.php");
        exit;
    }
}

// Suppression
if (isset($_GET['supprimer'])) {
    $id = (int)$_GET['supprimer'];
    $pdo->prepare("DELETE FROM etudiants WHERE id = ?")->execute([$id]);
    header("Location: etudiants.php");
    exit;
}

// Récupérer la liste
$etudiants = $pdo->query("SELECT * FROM etudiants ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Étudiants</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; margin: 20px; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        form { margin-bottom: 30px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 5px #ccc; }
        input, button { padding: 8px; margin: 5px 0; width: 100%; }
        .btn { background: #4CAF50; color: white; border: none; cursor: pointer; }
        .btn:hover { background: #45a049; }
        .sup { color: red; }
    </style>
</head>
<body>

<h1>Gestion des Étudiants</h1>

<form method="post">
    <input type="text" name="nom" placeholder="Nom" required>
    <input type="text" name="prenom" placeholder="Prénom" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="date" name="date_naissance" required>
    <button type="submit" name="ajouter" class="btn">Ajouter</button>
</form>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Date Naissance</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($etudiants as $e): ?>
        <tr>
            <td><?= htmlspecialchars($e['nom']) ?></td>
            <td><?= htmlspecialchars($e['prenom']) ?></td>
            <td><?= htmlspecialchars($e['email']) ?></td>
            <td><?= htmlspecialchars($e['date_naissance']) ?></td>
            <td>
                <a href="modifier_etudiant.php?id=<?= $e['id'] ?>">Modifier</a> |
                <a href="?supprimer=<?= $e['id'] ?>" class="sup" onclick="return confirm('Supprimer cet étudiant ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($etudiants)): ?>
        <tr><td colspan="5">Aucun étudiant</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>