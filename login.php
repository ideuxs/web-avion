<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/login.css" rel="stylesheet" />
    <link rel="icon" href="image/airtracking.png" type="image/x-icon">
    <title>Se connecter</title>
</head>


<body>

    <?php
        $serveurname = "localhost";
        $usersname = "root";
        $password = "root";
        
        try {
            $bdd = new PDO("mysql:host=$serveurname;dbname=utilisateur", $usersname, $password);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo "Erreur :" . $e->getMessage();
        }

        $error_msg = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $pseudo = $_POST['pseudo'];
            $password = $_POST['password'];

            if ($pseudo != "" && $password != "") {
                // Connexion à la bdd avec une requête préparée
                $req = $bdd->prepare("SELECT * FROM users WHERE pseudo = :pseudo AND mdp = :password");
                $req->execute(array(':pseudo' => $pseudo, ':password' => $password));

                $rep = $req->fetch();

                if ($rep['id'] != false) {
                    // C'est ok
                    echo "Vous êtes connecté(e) !";
                    header("Location: http://localhost:8080/projet_web/carte.php");
                    exit();
                                    
                } else {
                    $error_msg = "Pseudo ou mot de passe incorrect !";
                }
            }
        }
    ?>


<div id = "formulaire">
        <form method="POST" action="">
        <h2>Bienvenue sur la page de connexion !</h2>

            <br>
            <label for = "pseudo">Pseudo</label><br><br>
            <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" required><br>

            <label for = "password">Mot de Passe</label><br><br>
            <input type="password" placeholder="Votre mot de passe..." id="password" name="password" required><br><br><br>

            <input id ="envoyer"type="submit" value="Se connecter" name="ok"><br>

            <a href = "./index.php">S'inscrire</a>
        </form>

  <div class="drop drop-1"></div>
  <div class="drop drop-2"></div>
  <div class="drop drop-3"></div>
  <div class="drop drop-4"></div>
  <div class="drop drop-5"></div>
</div>
    

        

        
</body>





</html>
