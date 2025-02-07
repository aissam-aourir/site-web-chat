<?php
if (isset($_POST['envoyer'])) {
    include "DatabaseConnection.php";
    include "User.php";
    include "DAOUser.php";
    
    // Extraction de l'identifiant depuis le formulaire
    $identifiant = $_POST['identifiant'] ?? ''; 
    
    if (!empty($identifiant)) {
        try {
            // Connexion à la base de données
            $dbConnection = new DatabaseConnection();
            $connection = $dbConnection->connect();
            $daoUser = new DAOUser('users', $connection);

            // Vérification de l'existence de l'utilisateur
            if ($daoUser->userExists($identifiant) || $daoUser->userExists1($identifiant)) {
                // Générer un token unique
                $token = bin2hex(random_bytes(16)); // Token aléatoire
                $expiry = date('Y-m-d H:i:s', strtotime('+15 minutes')); // Expiration dans 15 minutes
            
                // Mettre à jour la base de données avec le token et sa date d'expiration
                $daoUser->updateResetToken($identifiant, $token, $expiry);
            
                // Créer un lien de réinitialisation
                $resetLink = "http://votre-site.com/reinitialiser-mot-de-passe.php?token=$token";
            
                // Envoyer l'e-mail
                mail($identifiant, "Réinitialisation de mot de passe", "Cliquez sur ce lien pour réinitialiser votre mot de passe : $resetLink");
            
                echo "<p style='color:green;'>Un lien de réinitialisation de mot de passe a été envoyé à votre adresse e-mail.</p>";
                exit();
            }
            
             else {
                // Message d'erreur si l'utilisateur n'existe pas
                echo "<p style='color:red;'>Le mot de passe ou le nom d'utilisateur est incorrect.</p>";
                header("Location: index.php");
                exit();
            }
        } catch (Exception $e) {
            // Affichage d'une erreur en cas de problème
            echo "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
        }
    } else {
        // Message d'erreur si aucun identifiant n'est fourni
        echo "<p style='color:red;'>Veuillez entrer une adresse e-mail, un numéro de téléphone ou un nom d'utilisateur valide.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problèmes de connexion</title>
    <style>
        /* Général */
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        /* Conteneur du formulaire */
        .container {
            background-color: #1e1e1e;
            padding: 40px;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        /* Icône de cadenas */
        .icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
        
        /* Titre */
        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }
        
        /* Description sous le titre */
        p {
            font-size: 14px;
            color: #ccc;
            margin-bottom: 30px;
        }
        
        /* Champs de saisie */
        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #333;
            border-radius: 4px;
            background-color: #2c2c2c;
            color: white;
            font-size: 14px;
        }
        
        /* Bouton de soumission */
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        
        button:hover {
            background-color: #0056b3;
        }

        /* Section "OU" */
        .or {
            font-size: 14px;
            color: #ccc;
            margin: 20px 0;
        }

        /* Lien vers "Créer un compte" */
        .small {
            font-size: 14px;
            color: #ccc;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #bbb;
            text-align: center;
        }

        /* Style du formulaire */
        form {
            display: flex;
            flex-direction: column;
        }
        
        .text-center {
            text-align: center;
        }

    </style>
</head>
<body>
<div class="container">
        <div class="icon">
            <span>&#128274;</span> <!-- Icône de cadenas -->
        </div>
        <h2>Problèmes de connexion ?</h2>
        <p>Entrez votre adresse e-mail, votre numéro de téléphone ou votre nom d’utilisateur, et nous vous enverrons un lien pour récupérer votre compte.</p>

        <form action="mdpoublie.php" method="POST">
            <input type="text" id="email" placeholder="E-mail, téléphone ou nom d'utilisateur" name="identifiant" required>
            <button type="submit" name="envoyer">Envoyer un lien de connexion</button>
        </form>
        <a href="inscription.php" class="small">Créer un compte</a>
        <div class="or">OU</div>
        <a href="login.php" class="small">Se Connecter</a>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2024 MonSite. Tous droits réservés.</p>
            <p><a href="politique-de-confidentialite.html" class="small">Politique de confidentialité</a> | <a href="conditions-utilisation.html" class="small">Conditions d'utilisation</a></p>
        </div>
    </div>

    <script>
        // Gestion de l'envoi du formulaire
        document.getElementById('reset-password-form').addEventListener('submit', function(event) {
            let email = document.getElementById('email').value;
            if (!email) {
                alert("Veuillez entrer une adresse e-mail, un numéro de téléphone ou un nom d'utilisateur.");
                event.preventDefault();
                return;
            }
        });
    </script>

</body>
</html>
