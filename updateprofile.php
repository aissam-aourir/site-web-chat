<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("location: index.php"); // Rediriger vers la page de connexion si non connecté
    exit;
}
$email = $_SESSION['email']; // Récupérer l'email de la session
$message = ""; // Initialiser la variable pour afficher un message

if (isset($_POST['submit'])) {
    extract($_POST);
    include "DatabaseConnection.php"; // Inclure la classe pour la connexion à la BDD
    include "User.php";
    include "DAOUser.php"; //inclusion de la classe de DAOUSER
    include "uploadPhoto.php";//inclusion de la methode pour upload image 
    try {
        // Connexion à la base de données
        $dbConnection = new DatabaseConnection();
        $connection = $dbConnection->connect();
        // Créer un DAOUser et effectuer les opérations
        $daoUser = new DAOUser('users', $connection);
        if (!empty($nom) && !empty($prenom)) $daoUser->updateNPByEmail($email, $nom, $prenom);
        if (!empty($phone)) $daoUser->updatePhoneByEmail($email, $phone);
        if (!empty($password)) $daoUser->updateMdpByEmail($email, $password);
        $profilePhoto =uploadPhoto('C:/Users/pc/upload/', 'profilePhoto1');
        $daoUser->updateProfilePhoto($email, $profilePhoto);
        $message = "<p style='color:green;'>Profil mis à jour avec succès !</p>";
    } catch (PDOException $e) {
        $message = "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre à jour le profil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 400px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        form input[type="text"], form input[type="submit"], form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #dddfe2;
            border-radius: 4px;
        }
        form input[type="submit"] {
            background-color: #1877f2;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background-color: #145dbd;
        }
        .message {
            text-align: center;
            margin-top: 10px;
        }
        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            background: none;
            border: none;
            cursor: pointer;
        }
        .back-button img {
            width: 24px;
            height: 24px;
        }
    </style>
</head>
<body>
    <!-- Flèche de retour -->
    <form action="login.php" method="get">
        <button class="back-button" type="submit">
            <img src="https://cdn-icons-png.flaticon.com/512/93/93634.png" alt="Retour">
        </button>
    </form>

    <div class="container">
        <h1>Mettre à jour le profil</h1>
        <?php if (!empty($message)) echo "<div class='message'>$message</div>"; ?>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" placeholder="Votre nom">

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" placeholder="Votre prénom">

            <label for="phone">Téléphone :</label>
            <input type="text" id="phone" name="phone" placeholder="Votre téléphone">

            <label for="password">Mot de passe :</label>
            <input type="text" id="password" name="password" placeholder="Votre mot de passe">

            <label for="profilePhoto">Photo de profil :</label>
            <input type="file" id="profilePhoto" name="profilePhoto1" accept="image/*">

            <input type="submit" value="Mettre à jour" name="submit">
        </form>
    </div>
</body>
</html>

