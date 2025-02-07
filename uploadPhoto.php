<?php

function uploadPhoto($uploadDir, $fileInputName) {
    $profilePhoto = null; // Initialisation de la variable pour l'image

    // Vérifier si un fichier a été envoyé
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES[$fileInputName]['tmp_name'];
        $fileName = $_FILES[$fileInputName]['name'];
        $fileSize = $_FILES[$fileInputName]['size'];
        $fileType = $_FILES[$fileInputName]['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Définir les extensions autorisées pour l'image
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        // Vérifier l'extension du fichier
        if (in_array($fileExtension, $allowedExts)) {
            // Créer un nom unique pour le fichier
            $newFileName = uniqid("user_") . '.' . $fileExtension;

            // Définir le chemin absolu du dossier de stockage
            $destFilePath = $uploadDir . $newFileName;

            // Déplacer le fichier téléchargé vers le dossier spécifié
            if (move_uploaded_file($fileTmpPath, $destFilePath)) {
                // Image téléchargée avec succès, on renvoie le nom du fichier
                return $newFileName;
            } else {
                // Erreur lors du déplacement du fichier
                echo "Erreur lors de l'upload de l'image.";
                return null;
                
            }
        } else {
            // Extension de fichier invalide
            return "Seules les images JPG, PNG et GIF sont autorisées.";
        }
    } else {
        echo "222222222222222222222";
        // Aucun fichier envoyé ou erreur d'upload
        return "Aucun fichier ou erreur d'upload.";
    }
}

?>
