
<?php
require_once(__DIR__ . '/../config/config.php'); // Inclure la base de données

$filiere = 'IDA'; // ✅ définie correctement

$stmt = $pdo->prepare("
  SELECT * FROM emplois_temps 
  WHERE filiere = ? 
  ORDER BY 
    FIELD(jour, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'),
    heure_debut
");
$stmt->execute([$filiere]);
$emplois = $stmt->fetchAll();
?>

<h2>Emploi du temps - Filière <?= $filiere ?></h2>
<table border="1" cellpadding="8">
  <tr>
    <th>Jour</th>
    <th>Heure</th>
    <th>Matière</th>
    <th>Salle</th>
    <th>Enseignant</th>
  </tr>

  <?php foreach ($emplois as $cours): ?>
  <tr>
    <td><?= $cours['jour'] ?></td>
    <td><?= substr($cours['heure_debut'], 0, 5) ?> - <?= substr($cours['heure_fin'], 0, 5) ?></td>
    <td><?= $cours['matiere'] ?></td>
    <td><?= $cours['salle'] ?></td>
    <td><?= $cours['enseignant'] ?></td>
  </tr>
  <?php endforeach; ?>
</table>