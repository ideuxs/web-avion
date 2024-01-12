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
  <link rel="icon" href="image/airtracking.png" type="image/x-icon">
</head>

<body>
    <video autoplay loop muted plays-inline class="video">
        <source src="image/accueil_video.mp4" type="video/mp4">
    </video>
    <header>
        
        <div class="logo">
            <a href="carte.php"> <span>Air</span> Tracking</a>
        </div>
        <ul class="menu">
            <li><a href="carte.php">Accueil</a></li>
            <li><a href="depart.php">Départ</a></li>
            <li><a href="arrivee.php">Destinations</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <a href="#map" class="btn-reservation">Voir Carte</a>

        <div class="responsive-menu"></div>
    </header>
    <!-- acceuil section -->
    <section id="home">
        <h2>WELCOME TO</h2>
        <h4>Air Tracking</h4>
        <p>Regardez des vols en temps réel.</p>
        <a href="#map" class="btn-reservation home-btn">Voir Carte</a>
        
    </section>

    <br><br><br><br><br><br><br><br>
    <div id="map"></div><br><br><br><br><br><br><br><br>

    <!--  contact section -->
    <section id="contact">
        <h1 class="title">Contact</h1>
        <form action="">
            <div class="left-right">
                <div class="left">
                    <label>Nom Complet</label>
                    <input type="text">
                    <label>Objet</label>
                    <input type="text">
                    <label>Email</label>
                    <input type="text">
                    <label>Message</label>
                    <textarea name="" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="right">
                    <label>Numéro</label>
                    <input type="text">
                    <label>Date</label>
                    <input type="text">
                    <label>Autres Details</label>
                    <input type="text">
                    <label>Adresse</label>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.9916256937595!2d2.292292615509614!3d48.85837007928746!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e2964e34e2d%3A0x8ddca9ee380ef7e0!2sTour%20Eiffel!5e0!3m2!1sfr!2sfr!4v1647531560805!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
            <button>Envoyer</button>
        </form>
    </section>
    
    <br><br><br><br>
    <br><br><br><br><br><br>
    
    <?php
        $dsn = 'mysql:host=localhost;dbname=utilisateur;charset=utf8';
        $username = 'root';
        $password = 'root';

        try {
            $bdd = new PDO($dsn, $username, $password);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête pour récupérer les codes IATA et noms des aéroports depuis la base de données
            $query = "SELECT code, name FROM aeroports";
            $stmt = $bdd->prepare($query);
            $stmt->execute();

            // Récupérer les résultats de la requête
            $airportData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
            exit();
        }

        // Fermez la connexion à la base de données à la fin de vos opérations
        $bdd = null;
    ?>

    <div id="search-arrival">

    </div>

</body>

<footer>
        <p> Réalisé par <span>Issa Bilal Mohammed Amine</span> | Tous les droits sont réservés.</p>
    </footer>
</html>
