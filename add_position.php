<?php
// Inclusion du fichier de configuration
require_once 'config.php';

// Récupération des paramètres passés en POST
$longitude = $_POST['longitude'] ?? null; // Utilisation de la syntaxe ?? pour gérer les valeurs par défaut si le paramètre n'est pas défini
$latitude = $_POST['latitude'] ?? null;
$pseudo = $_POST['pseudo'] ?? null;

// Vérification si les paramètres sont présents
if ($longitude !== null && $latitude !== null && $pseudo !== null) {
    // Connexion à la base de données
    $con = mysqli_connect($server, $user, $mp, $database, $port);

    // Vérification de la connexion
    if (!$con) {
        die("Connexion échouée: " . mysqli_connect_error());
    }

    // Requête d'insertion
    $sql = "INSERT INTO position (longitude, latitude, pseudo) VALUES ('$longitude', '$latitude', '$pseudo')";

    // Exécution de la requête
    if (mysqli_query($con, $sql)) {
        echo "Position ajoutée avec succès";
    } else {
        echo "Erreur lors de l'ajout de la position: " . mysqli_error($con);
    }

    // Fermeture de la connexion
    mysqli_close($con);
} else {
    // Affichage d'un message d'erreur si les paramètres sont manquants
    echo "Paramètres manquants";
}
?>
