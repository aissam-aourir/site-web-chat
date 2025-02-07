<?php
// Définir les informations de l'email
$to = "aissamaourir3@gmail.com"; // Adresse email du destinataire
$subject = "Hello World"; // Sujet de l'email
$message = "Hello! Ceci est un message envoyé avec PHP."; // Corps du message
$headers = "From: votreadresse@gmail.com"; // Adresse email de l'expéditeur

// Envoyer l'email
if (mail($to, $subject, $message, $headers)) {
    echo "Email envoyé avec succès à $to.";
} else {
    echo "Échec de l'envoi de l'email.";
}
?>
