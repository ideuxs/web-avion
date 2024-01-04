<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/depart.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src= "js/arrivee.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <title>Recherche par Aéroport d'arrivée</title>
</head>
<body>

    <?php
        $dsn = 'mysql:host=localhost;dbname=utilisateur;charset=utf8';
        $username = 'root';
        $password = 'root';

        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }

        // Sélectionnez les noms des aéroports depuis la base de données
        $query = "SELECT name FROM aeroports";
        $stmt = $pdo->query($query);
        $aeroports = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

<div id ="message">
        <p>Veuillez sélectionner ci-dessous votre aéroport d'Arrivée :</p>
    </div>

    <a href="carte.php">Retour</a>

    <form action="" method="post">
    <label for="aeroport">Sélectionnez un aéroport :</label>
    <select name="aeroport" id="aeroport">
        <?php foreach ($aeroports as $aeroport) : ?>
            <option value="<?= $aeroport['name']; ?>"><?= $aeroport['name']; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Soumettre">
    <br><br><br><br><br><br>
    <!-- Ajoutez cette div dans votre fichier HTML où vous souhaitez afficher la carte -->
    <div id="map" style="height: 400px;"></div>

</form>

</body>
</html>