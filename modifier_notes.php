
<?php
session_start();
include "../config/config.php";

$conn = mysqli_connect("localhost", "root", "", "gestion_inscription");

if (!$conn) {
    die("Erreur : " . mysqli_connect_error());
}

$id = $_POST['note_id'];
$note = $_POST['nouvelle_note'];

$sql = "UPDATE notes SET note = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "di", $note, $id);

if (mysqli_stmt_execute($stmt)) {
    echo "✅ Note modifiée avec succès.";
} else {
    echo "❌ Erreur lors de la modification.";
}

mysqli_close($conn);
?>