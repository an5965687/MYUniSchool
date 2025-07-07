
<?php
session_start();
include "../config/config.php";

// connexion base de données
$conn = mysqli_connect("localhost", "root", "", "gestion_inscription");
if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

// filtres facultatifs
$etudiant_id = $_GET['etudiant_id'] ?? null;
$matiere = $_GET['matiere'] ?? null;
$semestre = $_GET['semestre'] ?? null;

// construction de la requête
$sql = "SELECT * FROM notes WHERE 1=1";
$params = [];
$types = "";

if (!empty($etudiant_id)) {
    $sql .= " AND etudiant_id = ?";
    $params[] = $etudiant_id;
    $types .= "i";
}

if (!empty($matiere)) {
    $sql .= " AND matiere = ?";
    $params[] = $matiere;
    $types .= "s";
}

if (!empty($semestre)) {
    $sql .= " AND semestre = ?";
    $params[] = $semestre;
    $types .= "s";
}

$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// formulaire de filtre
?><!DOCTYPE html><html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Notes étudiants</title>
  <style>
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
    form { margin: 20px 0; }
  </style>
</head>
<body>
  <h2>Gestion des notes universitaires</h2>
  <form method="GET">
    <label>ID étudiant :</label>
    <input type="number" name="etudiant_id" value="<?= htmlspecialchars($etudiant_id) ?>"><label>Matière :</label>
<input type="text" name="matiere" value="<?= htmlspecialchars($matiere) ?>">

<label>Semestre :</label>
<input type="text" name="semestre" value="<?= htmlspecialchars($semestre) ?>">

<button type="submit">Filtrer</button>

  </form> <table>
    <tr>
      <th>Matière</th>
      <th>Note</th>
      <th>Semestre</th>
      <th>Coefficient</th>
      <th>Note pondérée</th>
      <th>Modifier</th>
    </tr>
    <?php
    $total_coef = 0;
    $total_ponderee = 0;while ($row = mysqli_fetch_assoc($result)) {
    $ponderee = $row['note'] * $row['coefficient'];
    $total_ponderee += $ponderee;
    $total_coef += $row['coefficient'];

    echo "<tr>
            <td>{$row['matiere']}</td>
            <td>{$row['note']}</td>
            <td>{$row['semestre']}</td>
            <td>{$row['coefficient']}</td>
            <td>" . number_format($ponderee, 2) . "</td>
            <td>
              <form action='modifier_note.php' method='POST'>
                <input type='hidden' name='note_id' value='{$row['id']}'>
                <input type='number' name='nouvelle_note' step='0.01' required>
                <button type='submit'>Modifier</button>
              </form>
            </td>
          </tr>";
}

$moyenne = $total_coef ? $total_ponderee / $total_coef : 0;
echo "<tr><td colspan='5'><strong>Moyenne pondérée : " . number_format($moyenne, 2) . "</strong></td><td></td></tr>";
?>

  </table>
</body>
</html>
<?php mysqli_close($conn); ?>