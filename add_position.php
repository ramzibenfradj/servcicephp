// Inclusion du fichier de configuration
require_once 'config.php';

// Récupération des paramètres passés en POST
$longitude = $_POST['longitude'] ?? null; // Utilisation de la syntaxe ?? pour gérer les valeurs par défaut si le paramètre n'est pas défini
$latitude = $_POST['latitude'] ?? null;
$pseudo = $_POST['pseudo'] ?? null;
$image = $_POST['image'] ?? null; // Assuming image data is sent as a base64-encoded string

// Vérification si les paramètres sont présents
if ($longitude !== null && $latitude !== null && $pseudo !== null && $image !== null) {
    // Connexion à la base de données
    $con = mysqli_connect($server, $user, $mp, $database, $port);

    // Vérification de la connexion
    if (!$con) {
        die("Connexion échouée: " . mysqli_connect_error());
    }

    // Convert base64 image data to binary
    $imageData = base64_decode($image);

    // Requête d'insertion
    $sql = "INSERT INTO position (longitude, latitude, pseudo, image) VALUES (?, ?, ?, ?)";

    // Préparation de la requête
    $stmt = mysqli_prepare($con, $sql);

    // Liaison des paramètres
    mysqli_stmt_bind_param($stmt, "ddss", $longitude, $latitude, $pseudo, $imageData);

    // Exécution de la requête
    if (mysqli_stmt_execute($stmt)) {
        echo "Position ajoutée avec succès";
    } else {
        echo "Erreur lors de l'ajout de la position: " . mysqli_error($con);
    }

    // Fermeture de la connexion
    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    // Affichage d'un message d'erreur si les paramètres sont manquants
    echo "Paramètres manquants";
}
