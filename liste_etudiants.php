
<?php
session_start();
include "../config/config.php";

// Connexion à la base de données
$host = "localhost";
$user = "root";
$pass = "";
$db = "gestion_inscription";

$conn = mysqli_connect($host, $user, $pass, $db);

// Vérifier la connexion
if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// Requête pour récupérer tous les utilisateurs
$sql = "SELECT * FROM utilisateurs ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des étudiants inscrits</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      padding: 30px;
    }
    h2 {
      text-align: center;
      color: #333;
    }
    table {
      width: 80%;
      margin: auto;
      border-collapse: collapse;
      background: #fff;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: center;
    }
    th {
      background-color: #4CAF50;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
  </style>
</head>
<body>
  <h2>Liste des étudiants inscrits</h2>

  <table>
    <tr>
      <th>ID</th>
      <th>Nom</th>
      <th>Email</th>
      <th>Téléphone</th>
      <th>Genre</th>
    </tr>

        <td>
            <!-- ✅ TU COLLES LA LIGNE ICI -->
            <a href="bulletins/bulletin.php?etudiant_id=<?= $etudiant['id'] ?>">📄 Voir bulletin</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>


    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['nom']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['telephone']) ?></td>
        <td><?= htmlspecialchars($row['genre']) ?></td>
      </tr>
    <?php endwhile; ?>

  </table>
</body>
</html>

<?php
mysqli_close($conn);
?>