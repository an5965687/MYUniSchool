
<?php
session_start();
include "../config/config.php";

$pdo = new PDO("mysql:host=localhost;dbname=gestion_inscription;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Détection du mode (ajout ou modification)
$editMode = false;
$id = '';
$filiere = '';
$niveau = '';
$responsable = '';

// Si on clique sur modifier
if (isset($_GET['modifier'])) {
    $editMode = true;
    $id = intval($_GET['modifier']);
    $stmt = $pdo->prepare("SELECT * FROM classes WHERE id = ?");
    $stmt->execute([$id]);
    $classe = $stmt->fetch();

    if ($classe) {
        $filiere = $classe['filiere'];
        $niveau = $classe['niveau'];
        $responsable = $classe['responsable'];
    }
}

// Ajouter ou modifier
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filiere = $_POST['filiere'];
    $niveau = $_POST['niveau'];
    $responsable = $_POST['responsable'];

    if (isset($_POST['modifier'])) {
        $id = intval($_POST['id']);
        $stmt = $pdo->prepare("UPDATE classes SET filiere = ?, niveau = ?, responsable = ? WHERE id = ?");
        $stmt->execute([$filiere, $niveau, $responsable, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO classes (filiere, niveau, responsable) VALUES (?, ?, ?)");
        $stmt->execute([$filiere, $niveau, $responsable]);
    }

    header("Location: classes.php");
    exit;
}

// Supprimer une classe
if (isset($_GET['supprimer'])) {
    $id = intval($_GET['supprimer']);
    $stmt = $pdo->prepare("DELETE FROM classes WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: classes.php");
    exit;
}

// Récupérer toutes les classes
$classes = $pdo->query("SELECT * FROM classes ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gestion des Classes</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f4f4f4; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        form { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 10px; }
        input[type=text], select { width: 100%; padding: 10px; margin-top: 10px; }
        button { margin-top: 15px; padding: 10px 20px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background: #388E3C; }
        a { text-decoration: none; color: #2196F3; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<h1>Gestion des Classes</h1>

<h2><?= $editMode ? "Modifier une classe" : "Ajouter une nouvelle classe" ?></h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $id ?>">
    <label>Filière</label>
    <input type="text" name="filiere" value="<?= htmlspecialchars($filiere) ?>" required>

    <label>Niveau</label>
    <select name="niveau" required>
        <?php
        $niveaux = ['Licence 1', 'Licence 2', 'Licence 3', 'Master 1', 'Master 2'];
        foreach ($niveaux as $niv) {
            $selected = ($niveau === $niv) ? 'selected' : '';
            echo "<option value=\"$niv\" $selected>$niv</option>";
        }
        ?>
    </select>

    <label>Responsable</label>
    <input type="text" name="responsable" value="<?= htmlspecialchars($responsable) ?>" required>

    <button type="submit" name="<?= $editMode ? 'modifier' : 'ajouter' ?>">
        <?= $editMode ? 'Modifier' : 'Ajouter' ?>
    </button>
</form>

<h2>Liste des Classes</h2>
<table>
    <thead>
        <tr>
            <th>Filière</th>
            <th>Niveau</th>
            <th>Responsable</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($classes as $classe): ?>
        <tr>
            <td><?= htmlspecialchars($classe['filiere']) ?></td>
            <td><?= htmlspecialchars($classe['niveau']) ?></td>
            <td><?= htmlspecialchars($classe['responsable']) ?></td>
            <td>
                <a href="classes.php?modifier=<?= $classe['id'] ?>">Modifier</a> |
                <a href="classes.php?supprimer=<?= $classe['id'] ?>" onclick="return confirm('Supprimer cette classe ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($classes)): ?>
        <tr><td colspan="4">Aucune classe enregistrée</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>