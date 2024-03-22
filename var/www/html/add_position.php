<?php
require_once 'config.php';

// Récupération des paramètres passés en POST
$longitude = $_POST['longitude'] ?? null;
$latitude = $_POST['latitude'] ?? null;
$pseudo = $_POST['pseudo'] ?? null;
$image = $_POST['imageData'] ?? null; // Assuming image data is sent as a base64-encoded string

// Vérification si les paramètres sont présents
if ($longitude !== null && $latitude !== null && $pseudo !== null && $image !== null) {
    // Connexion à la base de données
    $con = mysqli_connect($databaseConfig['server'], $databaseConfig['user'], $databaseConfig['password'], $databaseConfig['database'], $databaseConfig['port']);

    // Vérification de la connexion
    if (!$con) {
        error_log("Connexion échouée: " . mysqli_connect_error());
        die("Connexion échouée: " . mysqli_connect_error());
    }

    // Convert base64 image data to binary
    $imageData = base64_decode($image);

    // Requête d'insertion
    $sql = "INSERT INTO position (longitude, latitude, pseudo, image) VALUES (?, ?, ?, ?)";

    // Préparation de la requête
    $stmt = mysqli_prepare($con, $sql);

    // Vérification de la préparation de la requête
    if (!$stmt) {
        $error_message = "Erreur lors de la préparation de la requête: " . mysqli_error($con);
        error_log($error_message);
        die($error_message);
    }

    // Liaison des paramètres
    mysqli_stmt_bind_param($stmt, "ddsb", $longitude, $latitude, $pseudo, $imageData);

    // Exécution de la requête
    if (mysqli_stmt_execute($stmt)) {
        echo "Position ajoutée avec succès";
    } else {
        $error_message = "Erreur lors de l'ajout de la position: " . mysqli_error($con);
        error_log($error_message);
        echo $error_message;
    }

    // Fermeture de la connexion
    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    // Affichage d'un message d'erreur si les paramètres sont manquants
    $error_message = "Paramètres manquants";
    error_log($error_message);
    echo $error_message;
}
?>
