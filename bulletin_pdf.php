
<?php
// bulletin_pdf.php (sans utf8_decode, compatible PHP 8.2)
// -------------------------------------------------------------
// Tables : utilisateurs, notes (etudiant_id, matiere, note, semestre)
// -------------------------------------------------------------

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../libs/fpdf.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    die('Erreur : variable $pdo non définie.');
}

if (!isset($_GET['etudiant_id']) || !ctype_digit($_GET['etudiant_id'])) {
    die('ID étudiant manquant ou invalide.');
}
$etudiant_id = (int) $_GET['etudiant_id'];

// Helper : convertir UTF‑8 → ISO‑8859‑1 (FPDF standard)
function toISO($s) {
    return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $s);
}

// 1) Étudiant
$stmt = $pdo->prepare('SELECT nom FROM utilisateurs WHERE id = ?');
$stmt->execute([$etudiant_id]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$etudiant) {
    die('Étudiant introuvable.');
}
$fullName = $etudiant['nom'];

// 2) Notes (matiere = texte)
$sql = 'SELECT matiere AS nom_matiere, note, semestre
        FROM notes
        WHERE etudiant_id = ?
        ORDER BY semestre, nom_matiere';
$stmt = $pdo->prepare($sql);
$stmt->execute([$etudiant_id]);
$notes_by_sem = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $sem = (int) $row['semestre'];
    $notes_by_sem[$sem][] = $row;
}

// 3) PDF
$pdf = new FPDF();
$pdf->SetTitle('Bulletin - ' . toISO($fullName));
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, toISO('Bulletin Scolaire'), 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, toISO('Nom : ') . toISO($fullName), 0, 1);
$pdf->Cell(0, 8, toISO('Date : ') . date('d/m/Y'), 0, 1);
$pdf->Ln(3);

if (empty($notes_by_sem)) {
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Cell(0, 10, toISO('Aucune note enregistrée.'), 0, 1, 'C');
} else {
    foreach ($notes_by_sem as $sem => $liste) {
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, toISO('Semestre ') . $sem, 0, 1);

        // En-têtes
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(100, 8, toISO('Matière'), 1, 0);
        $pdf->Cell(40, 8, toISO('Note'), 1, 1, 'C');

        // Lignes
        $pdf->SetFont('Arial', '', 12);
        $total = 0; $count = 0;
        foreach ($liste as $n) {
            $pdf->Cell(100, 8, toISO($n['nom_matiere']), 1, 0);
            $pdf->Cell(40, 8, $n['note'], 1, 1, 'C');
            $total += $n['note'];
            $count++;
        }

        // Moyenne du semestre
        if ($count) {
            $avg = round($total / $count, 2);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(100, 8, toISO('Moyenne semestre'), 1, 0);
            $pdf->Cell(40, 8, $avg, 1, 1, 'C');
        }
        $pdf->Ln(4);
    }
}

$pdf->Output('D', 'bulletin_' . $etudiant_id . '.pdf');
exit;