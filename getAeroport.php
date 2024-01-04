<?php
$dsn = 'mysql:host=localhost;dbname=utilisateur;charset=utf8';
$username = 'root';
$password = 'root';

try {
    $bdd = new PDO($dsn, $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
    exit();
}

$Iata = $_POST['code'];

$query = "SELECT name FROM aeroports WHERE code = :Iata";
$stmt = $bdd->prepare($query);
$stmt->bindParam(':Iata', $Iata);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);

$airportName = ($result !== false) ? $result['name'] : 'Aéroport inconnu';

$bdd = null;

header('Content-Type: application/json');
echo json_encode(['name' => $airportName]);
?>
