<?php
// Inclure ici votre configuration de connexion à la base de données

// Remplacez ces valeurs par vos propres informations de connexion
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "utilisateur";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer le code IATA depuis la requête POST
if(isset($_POST['code'])) {
    $iataCode = $_POST['code'];

    // Préparer la requête SQL pour récupérer les coordonnées
    $sql = "SELECT location FROM aeroports WHERE code = '$iataCode'";

    // Exécuter la requête
    $result = $conn->query($sql);

    // Vérifier si la requête a réussi
    if ($result) {
        // Récupérer les coordonnées depuis le résultat
        $row = $result->fetch_assoc();
        $location = $row['location'];

        // Retourner les coordonnées au format JSON
        echo json_encode(['location' => $location]);
    } else {
        // En cas d'erreur, retourner une réponse d'erreur
        echo json_encode(['error' => 'Erreur lors de la récupération des coordonnées.']);
    }

    // Fermer la connexion à la base de données
    $conn->close();
} else {
    // Si le code IATA n'est pas fourni, retourner une réponse d'erreur
    echo json_encode(['error' => 'Code IATA non fourni.']);
}
?>
