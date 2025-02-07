<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    <style>
        /* Style général du body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }

        /* Header */
        header {
            background-color: #34b7f1;
            padding: 20px 0;
            color: white;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 36px;
        }

        header p {
            margin: 5px 0;
            font-size: 14px;
        }

        /* Style du formulaire */
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: 30px auto;
        }

        .form-container h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .form-container p {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
            color: #555;
        }

        .form-container label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #555;
        }

        .form-container input, .form-container select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .form-container input[type="radio"] {
            width: auto;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #34b7f1;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #2a97c9;
        }

        .form-container .footer {
            font-size: 12px;
            text-align: center;
            margin-top: 20px;
            color: #777;
        }

        .form-container .footer a {
            color: #34b7f1;
            text-decoration: none;
        }

        .form-container .footer a:hover {
            text-decoration: underline;
        }

        .form-container .gender-options {
            display: flex;
            justify-content: space-between;
        }

        .error {
            color: red;
            font-size: 12px;
            display: none;
        }

        .input-error {
            border-color: red;
        }

        /* Section pour le lien de connexion */
        .text-center {
            text-align: center;
            margin-top: 15px;
        }

        .text-center a {
            color: #34b7f1;
            text-decoration: none;
            font-size: 14px;
        }

        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <h1>Créer un compte</h1>
        <p>Veuillez remplir les informations ci-dessous pour créer un compte.</p>
    </header>
    <?php
    if (isset($_POST['submit'])){
        extract($_POST);
        if (!empty($email) && !empty($password) && !empty($firstname) && !empty($lastname)) {
    include "DatabaseConnection.php";
    include "User.php";
    include "DAOUser.php";
    include "uploadePhoto.php";
    try {
        // Connexion à la base de données
        $dbConnection=new DatabaseConnection();
        $connection=$dbConnection->connect();
        // Créer un DAOUser et effectuer les opérations
        $daoUser = new DAOUser('users',$connection );
       
        // Vérifier si l'utilisateur existe déjà
        if (!$daoUser->userExists($user->getEmail())) {

             // Gestion du fichier photo de profil
            $profilePhoto =uploadPhoto('C:/Users/pc/upload/', 'profile-photo');
            echo $profilePhoto;
            // Créer un objet User
            $user = new User($email, $password, $firstname, $lastname,$gender,$phone,$profilePho);
            // Ajouter l'utilisateur
            $daoUser->addUser($user);
            echo "<p>Inscription réussie !</p>";}
        else {
            echo "<p style='color:red;'>Cet email est déjà utilisé.</p>";
        }
        }
        catch (Exception $e) {
            echo "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Tous les champs sont obligatoires.</p>";
    }
}
?><!-- Formulaire de création de compte -->
<div class="form-container">
    <h2>Inscription</h2>
    <p>C'est simple et rapide.</p>
    <form id="signup-form" action="inscription1.php" method="POST" enctype="multipart/form-data">
        <!-- Prénom -->
        <label for="firstname">Prénom</label>
        <input type="text" id="firstname" name="firstname" placeholder="aissam" required>
        <span class="error" id="firstname-error">Ce champ est obligatoire</span>

        <!-- Nom -->
        <label for="lastname">Nom</label>
        <input type="text" id="lastname" name="lastname" placeholder="aourir" required>
        <span class="error" id="lastname-error">Ce champ est obligatoire</span>

        <!-- Genre -->
        <label for="gender">Genre</label>
        <div class="gender-options">
            <label><input type="radio" name="gender" value="F"> Femme</label>
            <label><input type="radio" name="gender" value="M"> Homme</label>
            <label><input type="radio" name="gender" value="Autre"> Personnalisé</label>
        </div>
        <span class="error" id="gender-error">Ce champ est obligatoire</span>

        <!-- Email -->
        <label for="email">Numéro mobile ou e-mail</label>
        <input type="text" id="email" name="email" placeholder="Votre e-mail ou téléphone" required>
        <span class="error" id="email-error">Veuillez entrer un e-mail valide</span>




        <!-- Champ Répéter Email -->
<label for="repeter_email">Répétez votre e-mail</label>
<input type="text" id="repeter_email" name="repeter_email" placeholder="Répétez votre e-mail" required>
<span class="error" id="repeter-email-error">Les e-mails ne correspondent pas</span>


<label for="phone">PHONE</label>
        <input type="text" id="phone" name="phone" placeholder="aourir" required>
        <span class="error" id="lastname-error">Ce champ est obligatoire</span>

        <!-- Mot de passe -->
        <label for="password">Nouveau mot de passe</label>
        <input type="password" id="password" name="password" placeholder="Mot de passe" required>
        <span class="error" id="password-error">Mot de passe trop court</span>

        Photo de profil
        <label for="profile-photo">Photo de profil</label>
        <input type="file" id="profilePhoto" name="profile-photo" accept="image/*" required>

        <!-- Bouton d'inscription -->
        <button type="submit" name="submit">S'inscrire</button>
        <!-- Section du lien de connexion -->
    <div class="text-center">
        <a href="login.php" class="small">Déjà un compte ? Connectez-vous !</a>
    </div>

        <div class="footer">
            <p>Les personnes qui utilisent notre service ont pu importer vos coordonnées sur Facebook. <a href="#">En savoir plus</a>.</p>
            <p>En cliquant sur S'inscrire, vous acceptez nos <a href="#">Conditions générales</a>, notre <a href="#">Politique de confidentialité</a> et notre <a href="#">Politique d’utilisation des cookies</a>.</p>
        </div>
    </form>

     </div>
</body>
</html>
