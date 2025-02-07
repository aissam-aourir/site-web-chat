<?php
if (isset($_POST['nouveau_mot_de_passe']) && isset($_POST['token'])) {
    include "DatabaseConnection.php";
    include "DAOUser.php";

    $token = $_POST['token'];
    $nouveauMotDePasse = password_hash($_POST['nouveau_mot_de_passe'], PASSWORD_DEFAULT);

    $dbConnection = new DatabaseConnection();
    $connection = $dbConnection->connect();
    $daoUser = new DAOUser('users', $connection);

    // Vérifier la validité du token
    if ($daoUser->isValidToken($token)) {
        // Mettre à jour le mot de passe
        $daoUser->updatePasswordByToken($token, $nouveauMotDePasse);

        echo "<p style='color:green;'>Votre mot de passe a été réinitialisé avec succès.</p>";
    } else {
        echo "<p style='color:red;'>Le lien de réinitialisation est invalide ou expiré.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Réinitialiser le mot de passe</title>
</head>
<body>
    <form action="reinitialiser-mot-de-passe.php" method="POST">
        <input type="hidden" name="token" value="<?php echo $_GET['token'] ?? ''; ?>" required>
        <input type="password" name="nouveau_mot_de_passe" placeholder="Nouveau mot de passe" required>
        <button type="submit">Réinitialiser</button>
    </form>
</body>
</html>
