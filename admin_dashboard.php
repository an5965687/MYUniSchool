
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../admin/admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord - Administrateur</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #e0f7fa, #fce4ec);
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        h1 {
            margin: 0;
            font-size: 24px;
        }

        .logout {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #e74c3c;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
        }

        .logout:hover {
            background: #c0392b;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            padding: 40px;
        }

        .card {
            background: white;
            border-radius: 15px;
            width: 220px;
            height: 150px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
            padding: 25px;
            transition: transform 0.2s ease;
            font-size: 18px;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .emoji {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .card a {
            text-decoration: none;
            color: #2c3e50;
            font-weight: bold;
            display: block;
        }

        footer {
            text-align: center;
            padding: 15px;
            color: #555;
            font-size: 14px;
        }
    </style>
</head>
<body>

<header>
    <h1>Bienvenue, MYUniSchool <?= htmlspecialchars($_SESSION['user_nom']) ?> 👋</h1>
    <a href="../auth/logout.php"
     class="logout">Déconnexion</a>
</header>

<div class="container">
    <div class="card" style="background-color: #d0f0c0;">
        <div class="emoji">👩‍🎓</div>
        <a href="../etudiants/etudiants.php">Gestion des étudiants</a>
    </div>

    <div class="card" style="background-color: #ffebcc;">
        <div class="emoji">👨‍🏫</div>
        <a href="../enseignants/enseignants.php">Gestion des enseignants</a>
    </div>

    <div class="card" style="background-color: #fcdada;">
        <div class="emoji">📚</div>
        <a href="../matieres/matieres.php">Gestion des matières</a>
    </div>

    <div class="card" style="background-color: #e6e6fa;">
        <div class="emoji">📝</div>
        <a href="../notes/note.php">Gestion des notes</a>
    </div>

<div class="card" style="background-color: #d1c4e9;">
    <div class="emoji">🏫</div>
    <a href="../Classes/classes.php">Gestion des classes</a>
</div>

    <div class="card" style="background-color: #d0e6ff;">
        <div class="emoji">📄</div>
<a href="../bulletins/bulletin.php?etudiant_id=1">Voir bulletins</a> 
    </div>
<a href="/Gestion-inscription/emploi/emploi.php">🗓️ Emploi du temps</a>
</div>

<a href="bulletins/bulletin_pdf.php?etudiant_id=<?= $etudiant['id'] ?>" target="_blank">
    📄 Télécharger bulletin PDF
</a>

<footer>
    Université Cheikh Hamidou Kane - Application de gestion scolaire © 2025
</footer>

</body>
</html>