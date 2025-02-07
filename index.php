<?php 
  //démarer la session
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
       if(isset($_POST['button_con'])){
           //si le formulaire est envoyé
           //se connecter à la base de donnée
           include "connexion_bdd.php";
           //extraire les infos du formulaire
           extract($_POST);
           //verifions si les champs sont vides
           if(isset($email) && isset($mdp1) && $email != "" && $mdp1 != ""){
               //verifions si les identifiants sont justes
               $req = mysqli_query($con , "SELECT * FROM utilisateurs WHERE email = '$email' AND mdp = '$mdp1'");
               if(mysqli_num_rows($req) > 0){
                   //si les ids sont justes
                   //Création d'une session qui contient l'email
                   $_SESSION['user'] = $email ;
                   //redirection vesr la page chat
                   header("location:chat.php");
                   // detruire la variable du message d'inscription
                   unset($_SESSION['message']);
               }else {
                   //si non
                   $error = "Email ou Mots de passe incorrecte(s) !";
               }
           }else {
               //si les champs sont vides
               $error = "Veuillez remplir tous les champs !" ;
           }
       }
    ?>
    <form action=""  method="POST" class="form_connexion_inscription">
        <h1>CONNEXION</h1>
        <?php
           //affichons le message qui dit qu'un compte a été créer
           if(isset($_SESSION['message'])){
               echo $_SESSION['message'] ;
           }
        ?>
        <p class="message_error">
            <?php 
               //affichons l'erreur
               if(isset($error)){
                   echo $error ;
               }
            ?>
        </p>
        <label>Adresse Mail</label>
        <input type="email" name="email">
        <label>Mots de passe</label>
        <input type="password" name="mdp1">
        <input type="submit" value="Connexion" name="button_con">
        <p class="link">Vous n'avez pas de compte ? <a href="inscription.php">Créer un compte</a></p>
    </form>
    
</body>
</html>