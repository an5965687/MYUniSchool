
<?php
session_start();
include "../config/config.php";

if (isset($_GET['message']) && $_GET['message'] == 'deconnexion') {
    echo '
    <div style="
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        margin: 20px auto;
        width: 90%;
        max-width: 500px;
        border: 1px solid #c3e6cb;
        border-radius: 6px;
        text-align: center;
        font-weight: bold;
        font-size: 16px;
        box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
    ">
        ✅ Déconnexion réussie. À bientôt !
    </div>
    ';
}


// Identifiants test
$utilisateur = 'admin';
$motdepasse = 'unchk123';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['username'] === $utilisateur && $_POST['password'] === $motdepasse) {
        $_SESSION['connecté'] = true;
        header("Location: index.php");
        exit();
    } else {
        $erreur = "Identifiants incorrects.";
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - UNCHK</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        img {
            margin-bottom: 20px;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        input {
            display: block;
            margin: 10px auto;
            padding: 10px;
            width: 250px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #2980b9;
        }

        .footer {
            margin-top: 30px;
            color: #888;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- ✅ Logo UNCHK -->
    <img src="../assets/img/unchk_logo.png" alt="Logo UNCHK" width="120">

    <h2>Connexion à l'espace admin</h2>

    <!-- ✅ Formulaire -->
    <form method="POST" action="traitement_connexion.php">
        <input type="text" name="nom" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
</form>

<!-- Lien vers inscription -->
<div style="text-align:center; margin-top:15px;">
    <p>Pas encore inscrit ? <a href="../etudiants/inscription.html">Créer un compte</a></p>
</div>

<!-- Pied de page -->
<div class="footer" style="text-align:center; margin-top:20px; color:gray;">
    Université Cheikh Hamidou Kane - © 2025
</div>

</body>
</html>