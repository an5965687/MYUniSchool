 
<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=gestion_inscription", "root", "");
$stmt = $pdo->query("SELECT * FROM etudiants");


// Si l'utilisateur est déjà connecté, rediriger vers la page d'accueil
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion à l'espace admin</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .message-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px 25px;
            margin-top: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            width: 80%;
            max-width: 500px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .login-box {
            margin-top: 40px;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
            width: 90%;
            max-width: 400px;
        }

        .login-box h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #00bfff;
            color: white;
            border: none;
            padding: 10px 15px;
            width: 100%;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        .register-link {
            margin-top: 15px;
            text-align: center;
            font-size: 14px;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>

<?php if (isset($_GET['message']) && $_GET['message'] == 'deconnexion') : ?>
    <div class="message-success" id="logout-message">
        ✅ Déconnexion réussie. À bientôt !
    </div>
<?php endif; ?>

<div class="login-box">
    <h2>Connexion à l'espace admin</h2>
    <form method="POST" action="traitement_login.php">
        <div class="form-group">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Mot de passe" required>
        </div>
        <input type="submit" value="Se connecter">
    </form>
    <div class="register-link">
        Pas encore inscrit ? <a href="register.php">Créer un compte</a>
    </div>
</div>

<!-- ✅ Script pour faire disparaître le message après 5 secondes -->
<script>
    setTimeout(() => {
        const message = document.getElementById('logout-message');
        if (message) {
            message.style.transition = "opacity 1s ease-out";
            message.style.opacity = 0;
            setTimeout(() => message.remove(), 1000);
        }
    }, 5000);
</script>

</body>
</html>