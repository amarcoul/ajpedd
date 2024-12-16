<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "abpedd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données du formulaire
$title = $_POST['title'];
$description = $_POST['description'];
$date = $_POST['date'];

// Enregistrer l'image de l'événement
$image = $_FILES['image'];
$imagePath = 'uploads/' . basename($image['name']);
move_uploaded_file($image['tmp_name'], $imagePath);

// Insérer les données dans la base de données
$sql = "INSERT INTO events (title, description, date, image) VALUES ('$title', '$description', '$date', '$imagePath')";

if ($conn->query($sql) === TRUE) {
    echo "Événement créé avec succès.";
} else {
    echo "Erreur : " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
