<?php
// Include the configuration file
require_once 'config.php';

// Create a connection to the database
$con = mysqli_connect($server, $user, $mp, $database, $port);

// Check if the connection was successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Perform a query to fetch all positions from the database
$result = mysqli_query($con, "SELECT * FROM Position");

// Check if the query was successful
if ($result) {
    // Initialize the response array
    $response = array();
    $response["positions"] = array();

    // Loop through the result set and add each position to the response array
    while ($row = mysqli_fetch_array($result)) {
        $une_position = array(
            "idposition" => $row["idposition"],
            "pseudo" => $row["pseudo"],
            "longitude" => $row["longitude"],
            "latitude" => $row["latitude"]
        );
        array_push($response["positions"], $une_position);
    }

    // Set success flag and output the response as JSON
    $response["success"] = 1;
    echo json_encode($response);
} else {
    // If the query fails, set the success flag to 0 and output an error message
    $response["success"] = 0;
    $response["message"] = "Error retrieving positions: " . mysqli_error($con);
    echo json_encode($response);
}

// Close the database connection
mysqli_close($con);
?>
