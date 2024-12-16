<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    // Email de l'association pour recevoir les demandes
    $to = "amarcoulibaly827@gmail.com";
    $subject = "Nouvelle demande d'adhésion : $name";

    $body = "Nom : $name\nEmail : $email\nTéléphone : $phone\nMessage :\n$message";
    $headers = "From: $email";

    // Envoi de l'email à l'association
    if (mail($to, $subject, $body, $headers)) {
        // Envoi d'un email de confirmation à l'utilisateur
        $confirmationSubject = "Demande d'adhésion reçue";
        $confirmationBody = "Bonjour $name,\n\nMerci d'avoir soumis votre demande d'adhésion. Nous vous contacterons bientôt.";
        $confirmationHeaders = "From: amarcoulibaly827@gmail.com";

        mail($email, $confirmationSubject, $confirmationBody, $confirmationHeaders);

        echo "Votre demande a été envoyée avec succès.";
    } else {
        echo "Erreur : votre demande n'a pas pu être envoyée. Veuillez réessayer.";
    }
}
?>
