<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Adresse email de réception (remplacez par votre email)
    $to = "esistackoverflow@gmail.com";
    $from_name = strip_tags(trim($_POST["name"]));
    $from_email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));
    
    // Validation des champs
    if (empty($from_name) || empty($from_email) || empty($subject) || empty($message)) {
        echo "Veuillez remplir tous les champs.";
        exit;
    }

    if (!filter_var($from_email, FILTER_VALIDATE_EMAIL)) {
        echo "L'adresse email n'est pas valide.";
        exit;
    }

    // Structure de l'email
    $email_subject = "Nouveau message de contact : $subject";
    $email_body = "Vous avez reçu un nouveau message de votre site web.\n\n" .
                  "Nom : $from_name\n" .
                  "Email : $from_email\n\n" .
                  "Sujet : $subject\n\n" .
                  "Message :\n$message\n";

    $headers = "From: $from_name <$from_email>\r\n";
    $headers .= "Reply-To: $from_email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Envoi de l'email
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "Votre message a été envoyé avec succès. Merci!";
    } else {
        echo "Une erreur est survenue lors de l'envoi. Veuillez réessayer plus tard.";
    }
} else {
    echo "Méthode de requête non valide.";

}

?>
