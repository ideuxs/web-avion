<?php
$serveurname= "localhost";
$usersname="root";
$password="root";

try{
    $bdd=new PDO("mysql:host=$serveurname;dbname=utilisateur",$usersname, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e){
    echo "Erreur :".$e->getMessage();
}


if(isset($_POST['ok'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];

    // Vérification si le pseudo existe déjà
    $verificationRequete = $bdd->prepare("SELECT COUNT(*) AS count FROM users WHERE pseudo = :pseudo");
    $verificationRequete->execute(array("pseudo" => $pseudo));
    $resultat = $verificationRequete->fetch(PDO::FETCH_ASSOC);

    if ($resultat['count'] > 0) {
        // Le pseudo existe déjà, enregistrez le message d'erreur dans une variable de session
        session_start();
        $_SESSION['erreur_message'] = "Ce pseudo existe déjà. Veuillez en choisir un autre.";
        header("Location: index.php");
        exit();
    } else {
        // Le pseudo n'existe pas, procéder à l'insertion
        $requete = $bdd->prepare("INSERT INTO users VALUES (0, :prenom, :nom, :pseudo, :mdp)");
        $requete->execute(
            array(
                "pseudo" => $pseudo,
                "prenom" => $prenom,
                "nom" => $nom,
                "mdp" => $mdp
            )
        );

        // Redirection vers login.php
        header("Location: login.php");
        exit(); // Assurez-vous d'ajouter exit() après la redirection pour éviter toute exécution ultérieure du script
    }
}