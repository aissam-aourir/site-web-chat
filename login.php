<?php
session_start();
if (isset($_POST['valider'])){
    $email=$_POST['email'];
    $password=$_POST['password'];
   // extract($_POST);
    if(!empty($email) && !empty($password)){
        // Inclure les classes nécessaires
    include "DatabaseConnection.php";
    include "User.php";
    include "DAOUser.php";
        try {
            // Connexion à la base de données
            $dbConnection=new DatabaseConnection();
            $connection=$dbConnection->connect();
            $daoUser = new DAOUser('users',$connection);
            if($daoUser->userExists2($email,$password)){
                                // Stocker l'email dans la session
                                $_SESSION['email'] = $email;

                header("location:updateprofile.php");
            }
            else{
                echo " le mot de passe ou le username est faux";
                header("location:index.php");
            }
        }
        catch (Exception $e) {
            echo "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
        }

    }
}   
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter sur le site</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .earth-container {
            position: relative;
            width: 100%;
            height: 100%;
        }
        .earth {
            width: 100%;
            height: 100%;
            background: url('https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/Rotating_earth_%28large%29.gif/480px-Rotating_earth_%28large%29.gif') no-repeat center center / cover;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        .signup-form {
            width: 350px;
            text-align: center;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .signup-form h2 {
            font-size: 24px;
            font-weight: bold;
            color: #1877f2;
            margin-bottom: 20px;
        }
        .signup-form label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }
        .signup-form input[type="email"],
        .signup-form input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #dddfe2;
            border-radius: 6px;
            font-size: 16px;
        }
        .signup-form input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #1877f2;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .signup-form input[type="submit"]:hover {
            background-color: #145dbd;
        }
        .signup-form .link {
            font-size: 14px;
            color: #1877f2;
            margin-top: 10px;
        }
        .signup-form .link a {
            color: #1877f2;
            text-decoration: none;
        }
        .signup-form .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="earth-container">
        <div class="earth">
            <form class="signup-form" method="post" name="monform">
                <h2>Notre Site</h2>
                <label for="email">Adresse e-mail ou numéro de tél. :</label>
                <input type="email" id="email" name="email" placeholder="Entrer votre email" required>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" placeholder="Entrer votre mot de passe" required>
                <input type="submit" value="Se connecter" name="valider">
                <p class="link"><a href="mdpoublie.php">mot de passe oublie?</a></p>
                <p class="link">ou</p>
                <p class="link"><a href="inscription.php">Créer nouveau compte</a></p>
            </form>
        </div>
    </div>
</body>
</html>
