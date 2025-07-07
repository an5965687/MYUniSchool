
<?php
session_start();
include "../config/config.php";

$conn = mysqli_connect("localhost", "root", "", "gestion_inscription");

if (!$conn) {
    die("Erreur : " . mysqli_connect_error());
}

$etudiant_id = $_POST['etudiant_id'];
$matiere = $_POST['matiere'];
$note = $_POST['note'];
$semestre = $_POST['semestre'];

$sql = "INSERT INTO notes (etudiant_id, matiere, note, semestre) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "isds", $etudiant_id, $matiere, $note, $semestre);

if (mysqli_stmt_execute($stmt)) {
    echo "✅ Note enregistrée avec succès.";
} else {
    echo "❌ Erreur d'enregistrement.";
}

mysqli_close($conn);
?>