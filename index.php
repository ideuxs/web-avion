<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/index.css" rel="stylesheet" />
    <link rel="icon" href="image/airtracking.png" type="image/x-icon">
    <title>Inscription</title>
</head>


<body>

    <?php
        session_start();

        // Afficher le message d'erreur s'il existe
        if (isset($_SESSION['erreur_message'])) {
            echo "<script>alert('".$_SESSION['erreur_message']."');</script>";
            unset($_SESSION['erreur_message']); // Supprimer la variable de session après l'avoir affichée
        }
    ?>


    <div id = "formulaire">
        <form method="POST" action="traitement.php">
        <h2>Bienvenu(e) sur la page d'inscription !</h2>

            <br><br>
            <label for = "nom">Votre nom</label><br>
            <input type="text" id="nom" name="nom" placeholder="Entrez votre nom" required><br><br>

            <label for = "prenom">Votre prenom</label><br>
            <input type="text" id="prenom" name= "prenom" placeholder ="Entrez votre prenom" required><br><br>

            <label for = "pseudo">Votre pseudo</label><br>
            <input type="text" id="pseudo" name="pseudo" placeholder ="Entrez votre pseudo" required ><br><br>

            <label for = "mdp">Votre mot de passe</label><br>
            <input type="password" id="mdp" name="mdp" placeholder ="Entrez votre mot de passe" required><br><br><br>

            <input id= "envoyer" type="submit" value ="M'inscrire" name = "ok"><br><br>

            <a href = "./login.php">Se connecter</a>

        </form>


        <div class="drop drop-1"></div>
        <div class="drop drop-2"></div>
        <div class="drop drop-3"></div>
        <div class="drop drop-4"></div>
        <div class="drop drop-5"></div>
    </div>
</body>

</html>