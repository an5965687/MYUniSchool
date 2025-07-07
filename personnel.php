
<?php
session_start();
include "../config/config.php";

$conn = mysqli_connect("localhost", "root", "", "gestion_inscription");
if (!$conn) die("Erreur : " . mysqli_connect_error());

// Ajouter un personnel
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajouter'])) {
  $nom = $_POST['nom'];
  $fonction = $_POST['fonction'];
  $email = $_POST['email'];
  mysqli_query($conn, "INSERT INTO personnel (nom, fonction, email) VALUES ('$nom', '$fonction', '$email')");
}

// Supprimer
if (isset($_GET['supprimer'])) {
  $id = $_GET['supprimer'];
  mysqli_query($conn, "DELETE FROM personnel WHERE id = $id");
}

// Liste
$personnels = mysqli_query($conn, "SELECT * FROM personnel");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion du Personnel</title>
  <style>
    body { font-family: Arial; margin: 30px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
    form { margin-bottom: 20px; }
    input[type=text], input[type=email] { padding: 6px; width: 200px; margin-right: 10px; }
    button { padding: 6px 12px; }
  </style>
</head>
<body>
  <h2>👥 Gestion du Personnel</h2>

  <form method="POST">
    <input type="text" name="nom" placeholder="Nom" required>
    <input type="text" name="fonction" placeholder="Fonction" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit" name="ajouter">Ajouter</button>
  </form>

  <table>
    <tr>
      <th>Nom</th>
      <th>Fonction</th>
      <th>Email</th>
      <th>Action</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($personnels)): ?>
      <tr>
        <td><?= htmlspecialchars($row['nom']) ?></td>
        <td><?= htmlspecialchars($row['fonction']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td>
          <a href="modifier_personnel.php?id=<?= $row['id'] ?>">✏️ Modifier</a> |
          <a href="personnel.php?supprimer=<?= $row['id'] ?>" onclick="return confirm('Supprimer ?')">🗑️ Supprimer</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>

<?php mysqli_close($conn); ?>