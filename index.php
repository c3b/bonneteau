<!-- 
    Created on : 5 nov. 2014, 19:38:56
    Author     : sebastien
    La page index.php est le lobby du jeu
*/


/* page index*/
-->

<!DOCTYPE HTML>
<html lang="fr-FR">
    <head>
        <meta charset="UTF-8">
        <title> Bonneteau </title>
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
    </head>

    <div id="accueil">
        <body class="body1">
            <h1 class="titre"> Jeu du Bonneteau</h1>


            <form action="jeu.php" method="POST" accept-charset="utf-8">
                <p>
                    <label>Votre nom</label>
                    <input type="text" name="nom" required="true"/>
                </p>

                <p>
                    <input type="submit" value="Commencer" />
                </p>

            </form>
            
<?php
if (!empty($_GET['erreur'])) {
    $erreur = $_GET['erreur'];
    if ($erreur == 1) {
        $msg = $_GET['nom'] . " n'est pas un nom valide !";
    } else {
        $msg = "Veuillez entrer un nom";
    }
    echo '<h1 class="erreur">' . $msg . ' </h1>';
}
?>
    </div>

</body>
</html>
