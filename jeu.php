<?php

/* 
    Created on : 5 nov. 2014, 19:38:56
    Author     : sebastien
    La page jeu.php contient l'essentiel du code (controleur).
*/


/* page jeu*/

session_start();
include 'regles.php';

$erreur = "";
$partie = true;
$reponse ="";

$tabImg = ['dos', 'as', 'roi'];

if (!empty($_GET['rejouer'])) {
    $rejoue = $_GET['rejouer'];
    if($rejoue == "oui"){
        $gain = 500;
        $_SESSION['gain'] = $gain;
    }else{
        header("Location: http://localhost/Bonneteau/");
    }
}

// test si l'on reçoit un nom depuis la page index
if (!empty($_POST['nom'])) {
    //test si nom est un sepspace
    $nom = trim($_POST['nom']);
    //test si nom est une variable numerique --> retour accueil si vrai
    if (is_numeric($nom)) {
        header("Location: http://localhost/Bonneteau/index.php?erreur=1&nom=$nom");
        //test si nom est vide --> retour accueil si vrai
    } elseif (empty($nom)) {
        header("Location: http://localhost/Bonneteau/index.php?erreur=2");
    } else {
        $_SESSION['nom'] = $nom;
        $_SESSION['ale'] = 0;
        $gain = 500;
        $chance = 2;
        $tour = 0;
        $choix = 0;
        $ale = 4;
        $mise = 0;
        $_SESSION['gain'] = $gain;
        $_SESSION['chance'] = $chance;
        $_SESSION['tour'] = $tour;
        $_SESSION['choix'] = $choix;
        $_SESSION['mise'] = $mise;
        $_SESSION['etat'] = "Init";
    }
}
//Calcul de la carte gagnante
if (!empty($_SESSION['ale'])) {
    $ale = $_SESSION['ale'];
} else {
    $ale = mt_rand(1, 3);
    $_SESSION['ale'] = $ale;
    $ale = 0;
    $chance = 2;
    $_SESSION['chance'] = $chance;
    unset($_SESSION['pile']);
}

//test si le programme recoit une mise
if (!empty($_POST['mise'])) {
    if($_POST['mise'] < 100){
        if($_SESSION['gain'] > 100){
        $erreur = "La mise minimum autorisée est de: 100";
        $tour = 0;
        $_SESSION['tour'] = $tour;
        }else{
                    $mise = $_POST['mise'];
        $tour = $_SESSION['tour'];
        $_SESSION['mise'] = $mise;
        $tour++;
        $_SESSION['tour'] = $tour;
        $ale = 0; 
        $chance =2;
        $_SESSION['chance'] = $chance;
        }
    }elseif($_POST['mise'] > $_SESSION['gain']){
        $erreur = "Le montant maximum autorisé est de: ". $_SESSION['gain'];
        $tour = 0;
        $_SESSION['tour'] = $tour;
    }else{
        $mise = $_POST['mise'];
        $tour = $_SESSION['tour'];
        $_SESSION['mise'] = $mise;
        $tour++;
        $_SESSION['tour'] = $tour;
        $ale = 0; 
        $chance =2;
        $_SESSION['chance'] = $chance;
        }
}

//melange des cartes si on a fait une mise
if ($_SESSION['tour'] == 0) {// melange des cartes donc provocation sd'un tirage de nombre == réponse
    $_SESSION['ale'] = 0;
    $chance = 2;
    $tour = 0;
    $choix = 0;
    $ale = 0;
    $mise = 0;
    $_SESSION['chance'] = $chance;
    $_SESSION['choix'] = $choix;
    $_SESSION['tour'] = $tour;
    $_SESSION['mise'] = $mise;
}

//test si le nom est dans la session
if (!empty($_SESSION['nom'])) {
    $nom = $_SESSION['nom'];
}

//test des variables de sessions $gain et $chance
if (!empty($_SESSION['gain']) && !empty($_SESSION['chance'])) {
    $gain = $_SESSION['gain'];
    $chance = $_SESSION['chance'];
}

//test de la présence du nombre de $tour et du $choix (suppression tu test origin)

    $tour = $_SESSION['tour'];
    $choix = $_SESSION['choix'];

//test si le programme recoit une carte donc un choix$_SESSION['choix'] != $choix && $_SESSION['choix'] != 0
if (!empty($_POST['carte'])) {
    $_SESSION['tour'] = ++$tour;
    $choix = $_POST['carte'];
    if ($_SESSION['choix'] != $choix && $_SESSION['choix'] != 0) {
        $chance--;
        $_SESSION['chance'] = $chance;
    }
    $_SESSION['choix'] = $choix;
    $mise = $_SESSION['mise'];
}

if ($_SESSION['tour'] == 3) {
    $tour=0;
    $_SESSION['tour'] = $tour;
    if($_SESSION['choix'] == $_SESSION['ale']){
        $_SESSION['etat'] = "Gagné";
        if($_SESSION['chance'] != 2){
            $gain+= ($mise*2);
            $_SESSION['gain'] = $gain;
        }else{
            $gain+= ($mise*3);
            $_SESSION['gain'] = $gain;
        }
    }else{
        $_SESSION['etat'] = "Perdu";
        $gain = $gain - $mise;
        $_SESSION['gain'] = $gain;
    }
    if ($gain <= 0){
        $reponse = "Vous avez perdu";
        $partie = false;
    }
    if ($gain >= 10000){
        $reponse = "Vous avez gagné";
        $partie = false;
    }
        $_SESSION['ale'] = 0;
}

//Test de $ale pour connaitre sa valeur
switch ($ale) {
    case 1: {
            if($choix == 1 && $tour == 2){
                $plage = 1000;
                $tmp = mt_rand(0, $plage);
                $tmp =($tmp <= $plage/2) ? 1 : 2;
            if($tmp == 1){
                $carte1 = $tabImg[0];
                $carte2 = $tabImg[1];
                $carte3 = $tabImg[0];
            }else{
                $carte1 = $tabImg[0];
                $carte2 = $tabImg[0];
                $carte3 = $tabImg[1]; 
                }
            }elseif ($choix == 2 && $tour == 2) {
                $carte1 = $tabImg[0];
                $carte2 = $tabImg[0];
                $carte3 = $tabImg[1];
            }elseif ($choix == 3 && $tour == 2) {
                $carte1 = $tabImg[0];
                $carte2 = $tabImg[1];
                $carte3 = $tabImg[0];
            }elseif ($tour == 1) {
                $carte1 = $tabImg[0];
                $carte2 = $tabImg[0];
                $carte3 = $tabImg[0];
            }else{
                $carte1 = $tabImg[2];
                $carte2 = $tabImg[1];
                $carte3 = $tabImg[1];
            }
        }
        break;
        
    case 2: {
            if($choix == 1 && $tour == 2){
                $carte1 = $tabImg[0];
                $carte2 = $tabImg[0];
                $carte3 = $tabImg[1];
            }elseif ($choix == 2 && $tour == 2) {  
                $plage = 1000;
                $tmp = mt_rand(0, $plage);
                $tmp =($tmp <= $plage/2) ? 1 : 2;
             if($tmp == 1){
                $carte1 = $tabImg[1];
                $carte2 = $tabImg[0];
                $carte3 = $tabImg[0];
            }else{
                $carte1 = $tabImg[0];
                $carte2 = $tabImg[0];
                $carte3 = $tabImg[1];
            }
            }elseif ($choix == 3 && $tour == 2) {
                $carte1 = $tabImg[1];
                $carte2 = $tabImg[0];
                $carte3 = $tabImg[0];
            }elseif ($tour == 1) {
                $carte1 = $tabImg[0];
                $carte2 = $tabImg[0];
                $carte3 = $tabImg[0];
            }else{
                $carte1 = $tabImg[1];
                $carte2 = $tabImg[2];
                $carte3 = $tabImg[1];
            }
    }
        break;
        
            case 3: {
            if($choix == 1 && $tour == 2){
                $carte1 = $tabImg[0];
                $carte2 = $tabImg[1];
                $carte3 = $tabImg[0];
            }elseif($choix == 2 && $tour == 2){
                $carte1 = $tabImg[1];
                $carte2 = $tabImg[0];
                $carte3 = $tabImg[0]; 
            }elseif ($choix == 3 && $tour == 2) {
                $plage = 1000;
                $tmp = mt_rand(0, $plage);
                $tmp =($tmp <= $plage/2) ? 1 : 2;
                if($tmp == 1){
                    $carte1 = $tabImg[1];
                    $carte2 = $tabImg[0];
                    $carte3 = $tabImg[0];
                }else{
                    $carte1 = $tabImg[0];
                    $carte2 = $tabImg[1];
                    $carte3 = $tabImg[0];
                    }
            }elseif ($tour == 1) {
                $carte1 = $tabImg[0];
                $carte2 = $tabImg[0];
                $carte3 = $tabImg[0];
            }else{
                $carte1 = $tabImg[1];
                $carte2 = $tabImg[1];
                $carte3 = $tabImg[2];
            }
        }
        break;
        
            case 0:{
                $carte1 = $tabImg[0];
                $carte2 = $tabImg[0];
                $carte3 = $tabImg[0];
            }
}
?>

<!DOCTYPE HTML>
<html lang="fr-FR">
    <head>
        <meta charset="UTF-8">
        <title> Jeu du Bonneteau</title>
        <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
    </head>
    <body>
        <div class="contener">
             <div class="regles">
            </div>
            <div class="table">
                <form action="jeu.php" method="POST">
                    <div class="tapis">

                        <?php if ($partie): ?>
                        <div class="cartes">
                            <div class="carte <?php echo $carte1 ?>">
                            </div>
                            <div class="choix">
                                <?php if ($tour != 0): ?>
                                    <input type="radio" name="carte" value="1"/>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="cartes">
                            <div class="carte <?php echo $carte2 ?>">
                                
                            </div>
                            <div class="choix">
                                <?php if ($tour != 0): ?>
                                    <input type="radio" name="carte" value="2"/>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="cartes">
                            <div class="carte <?php echo $carte3 ?>">
                            </div>
                            <div class="choix">
                                <?php if ($tour != 0): ?>
                                    <input type="radio" name="carte" value="3"/>
                                <?php endif; ?>
                            </div>
                        </div>
                            <?php else: ?>
                        <div id="partie">
                            <h1> <?php echo $reponse ?></h1>
                            <p><a href="jeu.php?rejouer=oui">Rejouer</a></p>
                            <p><a href="index.php?rejouer=non">Terminer</a></p>
                        </div>
                            <?php endif; ?>

                        <?php if ($tour == 0): ?>
                            <div class="mise">
                                <p><label for="mise">Faites votre mise: </label></p>
                                <p><input type="text" name="mise" plceholder="Faites votre mise"</p>
                                <p><input type="submit" value="Enregistrer la mise"></p>
                                <?php if ($erreur != ""): ?>
                                <h4 style="color:red"><?php echo $erreur; ?></h4>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <div class="controle">
                            <?php
                            if ($tour == 1) {
                                echo'<p><input type="submit" value="Valider mon choix" /></p>';
                                echo'<p><input type="submit" value="donner la réponse" disabled/></p>';
                            }elseif ($tour == 2) {
                                echo'<p><input type="submit" value="Valider mon choix" disabled/></p>';
                                echo'<p><input type="submit" value="donner la réponse"/></p>';
                            }
                            ?>
                        </div>
                </form>
            </div>
        </div> <!-- fin de table -->
        
        <div class="cadreDroit">
            <div class="points">
                <ul>
                    <h2>Infos joueur</h2>
                    <li>Nom du joueur: <?php echo $nom ?></li>
                    <li>Banque: <?php echo $gain ?></li>
                    <li>Nombre de chances: <?php echo $chance ?></li>
                    <?php if($tour != 0): ?>
                    <li><b>Mise en cours: <?php echo $mise ?></b></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="regles">
                <?php echo $regles; ?>
            </div>
        </div>
    </body>
</html>