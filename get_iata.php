<?php
// get_iata_code.php

$dsn = 'mysql:host=localhost;dbname=utilisateur;charset=utf8';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aeroportName = $_POST['nom'];

    // Utilisez une requête préparée pour éviter les injections SQL
    $query = "SELECT code FROM aeroports WHERE name = :nom LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nom', $aeroportName, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $response = array('code' => $result['code']);
        echo json_encode($response);
    } else {
        // Ajustez le comportement en cas de non-correspondance
        echo json_encode(array('error' => 'Aéroport non trouvé.'));
    }
} else {
    // Ajustez le comportement si la requête n'est pas de type POST
    echo json_encode(array('error' => 'Méthode de requête non autorisée.'));
}
?>
