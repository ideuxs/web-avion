<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/arrivee.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src= "js/arrivee.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="icon" href="image/airtracking.png" type="image/x-icon">

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <title>Recherche par Aéroport d'arrivée</title>
</head>
<body>
    <video autoplay loop muted plays-inline class="video">
        <source src="image/atterrissage.mp4" type="video/mp4">
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

    <section id="home">
            <h2>Cherchez un vol</h2>
            <h4>par Départ</h4>
            <p>Regardez des vols en temps réel.</p>
            <a href="#map" class="btn-reservation home-btn">Voir Carte</a>
            
            <div class="find_trip">
                <form action="">
                    <div>
                        <!--Je voudrais l'inserer ici-->
                        <label for="aeroport">Sélectionnez un aéroport :</label>
                        <select name="aeroport" id="aeroport">
                        <?php foreach ($aeroports as $aeroport) : ?>
                            <option value="<?= $aeroport['name']; ?>"><?= $aeroport['name']; ?></option>
                        <?php endforeach; ?>
                    </select>   
                    </div>
                    
                </form>
            </div>

    </section>
    
    
    <br><br><br><br><br><br>
    <!-- Ajoutez cette div dans votre fichier HTML où vous souhaitez afficher la carte -->
    <div id="map"></div>

    
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

    <footer>
        <p> Réalisé par <span>Issa Bilal Mohammed Amine</span> | Tous les droits sont réservés.</p>
    </footer>

</form>

</body>
</html>