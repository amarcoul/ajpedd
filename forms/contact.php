<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require '../vendor/autoload.php'; // Charge les classes de PHPMailer et Dotenv

// Charge les variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $name = htmlspecialchars($_POST['name']); // Sécurisation des entrées utilisateur
    $userEmail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); // Validation de l'email
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
    
    if (!$userEmail) {
        echo "Adresse e-mail invalide.";
        exit;
    }

    // Configuration de PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Paramètres du serveur
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Hôte SMTP pour Gmail
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME']; // Votre e-mail depuis .env
        $mail->Password = $_ENV['MAIL_PASSWORD']; // Votre mot de passe ou clé d'application depuis .env
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Paramètres de l'e-mail
        $mail->setFrom($_ENV['MAIL_USERNAME'], 'Bily Karambiri'); // Adresse e-mail de l'expéditeur
        $mail->addReplyTo($userEmail, $name); // Pour permettre une réponse directe à l'utilisateur
        $mail->addAddress($_ENV['MAIL_USERNAME']); // Votre adresse e-mail pour recevoir le message
        $mail->Subject = 'Message de : ' . $name . ' - ' . $subject; // Sujet de l'e-mail
        $mail->Body = "Nom: $name\nEmail: $userEmail\n\nMessage:\n$message"; // Corps du message

        // Tentative d'envoi de l'e-mail
        if ($mail->send()) {
            echo 'Message envoyé avec succès.';
        } else {
            echo 'Échec de l\'envoi du message. Erreur: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        // Afficher l'erreur si l'envoi échoue
        echo "Le message n'a pas pu être envoyé. Erreur: {$e->getMessage()}";
    }
} else {
    echo 'Aucune donnée reçue.';
}
?>