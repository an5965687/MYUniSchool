
<?php
session_start();
include "../config/config.php";

$pdo = new PDO("mysql:host=localhost;dbname=gestion_inscription;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Ajouter un enseignant
if (isset($_POST['ajouter'])) {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $specialite = $_POST['specialite'] ?? '';

    if ($nom && $prenom && $email) {
        $stmt = $pdo->prepare("INSERT INTO enseignants (nom, prenom, email, specialite) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $email, $specialite]);
        header("Location: enseignants.php");
        exit;
    }
}

// Supprimer un enseignant
if (isset($_GET['supprimer'])) {
    $id = (int) $_GET['supprimer'];
    $pdo->prepare("DELETE FROM enseignants WHERE id = ?")->execute([$id]);
    header("Location: enseignants.php");
    exit;
}

// Récupérer tous les enseignants
$enseignants = $pdo->query("SELECT * FROM enseignants ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Enseignants</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        h1 { text-align: center; }
        form { max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 5px #ccc; }
        input, button { width: 100%; padding: 10px; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; background: #fff; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        .btn { background: #4CAF50; color: white; border: none; }
        .btn:hover { background: #45a049; }
        .sup { color: red; }
    </style>
</head>
<body>

<h1>Gestion des Enseignants</h1>

<form method="post">
    <input type="text" name="nom" placeholder="Nom" required>
    <input type="text" name="prenom" placeholder="Prénom" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="specialite" placeholder="Spécialité">
    <button type="submit" name="ajouter" class="btn">Ajouter</button>
</form>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Spécialité</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($enseignants as $ens): ?>
        <tr>
            <td><?= htmlspecialchars($ens['nom']) ?></td>
            <td><?= htmlspecialchars($ens['prenom']) ?></td>
            <td><?= htmlspecialchars($ens['email']) ?></td>
            <td><?= htmlspecialchars($ens['specialite']) ?></td>
            <td>
                <a href="modifier_enseignants.php?id=<?= $ens['id'] ?>">Modifier</a> |
                <a href="?supprimer=<?= $ens['id'] ?>" class="sup" onclick="return confirm('Supprimer cet enseignant ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($enseignants)): ?>
        <tr><td colspan="5">Aucun enseignant trouvé.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>