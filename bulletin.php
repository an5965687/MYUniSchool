
<?php
session_start();
include '../config/config.php';

if (!isset($_GET['etudiant_id'])) {
    echo "Spécifiez un id étudiant. Exemple : ?etudiant_id=1";
    exit;
}

$etudiant_id = $_GET['etudiant_id'];
?>

<!-- Ici on est en HTML -->
<a href="bulletin_pdf.php?etudiant_id=<?= $etudiant_id ?>" target="_blank">Télécharger le PDF</a>

<?php
// Puis tu peux reprendre le PHP ici
$annee = $_GET['annee'] ?? date("Y");

// suite du code...

$conn = mysqli_connect("localhost", "root", "", "gestion_inscription");
if (!$conn) die("Erreur de connexion : " . mysqli_connect_error());

$etudiant_id = $_GET['etudiant_id'] ?? null;
$annee = $_GET['annee'] ?? date('Y');

if (!$etudiant_id) die("❗ Spécifiez un ID étudiant. Exemple : ?etudiant_id=1");

$nom = "";
$reqNom = mysqli_query($conn, "SELECT nom FROM utilisateurs WHERE id = $etudiant_id LIMIT 1");
if ($reqNom && mysqli_num_rows($reqNom) > 0) {
    $nom = mysqli_fetch_assoc($reqNom)['nom'];
}

// Liste des matières fixes
$matieres = [
    "Algorithmique", "Programmation Web", "Base de données",
    "Mathématiques", "Réseaux", "Structures de données",
    "Systèmes d'exploitation", "Sécurité Informatique", "Anglais technique"
];

// Charger toutes les notes de l'étudiant
$notes_sql = "SELECT matiere, note, coefficient FROM notes WHERE etudiant_id = ?";
$stmt = mysqli_prepare($conn, $notes_sql);
mysqli_stmt_bind_param($stmt, "i", $etudiant_id);
mysqli_stmt_execute($stmt);
$notes_result = mysqli_stmt_get_result($stmt);

// Associer les notes à chaque matière
$notes_map = [];
while ($row = mysqli_fetch_assoc($notes_result)) {
    $notes_map[$row['matiere']] = $row;
}

$total_pondere = 0;
$total_coef = 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Bulletin Universitaire</title>
  <style>
    body { font-family: Arial; margin: 40px; background: #f5f5f5; }
    table { border-collapse: collapse; width: 100%; background: #fff; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
    h2, h3 { text-align: center; }
  </style>
</head>
<body>
  <h2>Bulletin Universitaire</h2>
  <h3>Nom : <?= htmlspecialchars($nom) ?> | Année scolaire : <?= htmlspecialchars($annee) ?></h3>
  <table>
    <tr>
      <th>Matière</th>
      <th>Note</th>
      <th>Coefficient</th>
      <th>Note pondérée</th>
      <th>Appréciation</th>
    </tr>

    <?php foreach ($matieres as $matiere):
      if (isset($notes_map[$matiere])) {
        $note = $notes_map[$matiere]['note'];
        $coef = $notes_map[$matiere]['coefficient'];
        $pondere = $note * $coef;
        $total_pondere += $pondere;
        $total_coef += $coef;

        if ($note >= 16) $appreciation = "Excellent";
        elseif ($note >= 14) $appreciation = "Très Bien";
        elseif ($note >= 12) $appreciation = "Bien";
        elseif ($note >= 10) $appreciation = "Passable";
        else $appreciation = "Insuffisant";
      } else {
        $note = "-";
        $coef = "-";
        $pondere = "-";
        $appreciation = "Aucune note";
      }
    ?>
    <tr>
      <td><?= $matiere ?></td>
      <td><?= $note ?></td>
      <td><?= $coef ?></td>
      <td><?= is_numeric($pondere) ? number_format($pondere, 2) : "-" ?></td>
      <td><?= $appreciation ?></td>
    </tr>
    <?php endforeach; ?>

    <tr>
      <td colspan="3"><strong>Moyenne pondérée</strong></td>
      <td colspan="2"><strong>
        <?= $total_coef ? number_format($total_pondere / $total_coef, 2) : "N/A" ?>
      </strong></td>
    </tr>
  </table>
</body>
</html>

<?php mysqli_close($conn); ?>