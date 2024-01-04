<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carte du Trafic Aérien</title>
  
  <link rel="stylesheet" type="text/css" href="css/carte.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src= "js/carte.js"></script>

</head>

<body>
    <header>
        <ul class="menu">
            <li><a href="carte.php" id = "accueil">Accueil</a></li>
            <li><a href="#a-propos" id="searchByDep">Rechercher par Depart</a></li>
            <li><a href="" id ="searchByArr">Rechercher par Arrivée</a></li>
        </ul>
        <div class="responsive-menu"></div>
        <!--<div id ="message"><p id="departR">Recherche par Départ</p> <p><a href="carte.php">Accueil</a></p><p id="arriveeR">Recherche par Arrivée</p></div>-->
    </header><br><br><br><br><br>

    <h1 id="titre-accueil">Bienvenue dans la page d'accueil !</h1><br><br><br>

    <h2 id ="titre-carte">Voici la carte interactive avec les informations de chaque avion</h2><br><br><br>

    <div id="map"></div><br><br><br><br><br><br><br><br>

    <div id="proposition">
        <h1>&#X1F50D; Voudriez vous peut-être effectuer une recherche : </h1>    
    </div>
    <br><br><br><br>
    <div id="proposition-container">
        <div id="proposition-depart">
            <h1>Par aéroport de Départ ? &#x1F447;</h1>
            <br><br><br><br><br><br><br><br>
            <a href="depart.php">Voir ici</a>
        </div>
        <div id="proposition-arrivee">
            <h1>Par aéroport d'Arrivée ? &#x1F447;</h1>
            <br><br><br><br><br><br><br><br>
            <a href="arrivee.php">Voir ici</a>
        </div>
    </div>
    <br><br><br><br><br><br>
    
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

        // Requête pour récupérer les codes IATA et noms des aéroports depuis la base de données
        $query = "SELECT code, name FROM aeroports";
        $stmt = $bdd->prepare($query);
        $stmt->execute();

        // Récupérer les résultats de la requête
        $airportData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $bdd = null;
    ?>

    <!-- Utilisez les données pour peupler la liste déroulante 
    <label for="pseudo">Choisissez votre aéroport de départ</label><br><br>
    <select name="departure" id="dep-select">
        <?php
        foreach ($airportData as $airport) {
            echo "<option value='{$airport['code']}'>{$airport['name']}</option>";
        }
        ?>
    </select>-->


    <div id="search-arrival">

    </div>



</body>
</html>
