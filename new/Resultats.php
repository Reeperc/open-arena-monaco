

<?php

//require('Competition.js');
require('database.php');
//ini_set('display_errors', 0);
?>

<?php
echo 'test';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header Membre</title>
    <style>
        /*----------------genealogy-scroll----------*/

.genealogy-scroll::-webkit-scrollbar {
    width: 5px;
    height: 8px;
}
.genealogy-scroll::-webkit-scrollbar-track {
    border-radius: 10px;
    background-color: #e4e4e4;
}
.genealogy-scroll::-webkit-scrollbar-thumb {
    background: #212121;
    border-radius: 10px;
    transition: 0.5s;
}
.genealogy-scroll::-webkit-scrollbar-thumb:hover {
    background: #d5b14c;
    transition: 0.5s;
}


/*----------------genealogy-tree----------*/
.genealogy-body{
    white-space: nowrap;
    overflow-y: hidden;
    padding: 50px;
    min-height: 500px;
    padding-top: 10px;
    text-align: center;
}
.genealogy-tree{
  display: inline-block;
}
.genealogy-tree ul {
    padding-top: 20px; 
    position: relative;
    padding-left: 0px;
    display: flex;
    justify-content: center;
}
.genealogy-tree li {
    float: left; text-align: center;
    list-style-type: none;
    position: relative;
    padding: 20px 5px 0 5px;
}
.genealogy-tree li::before, .genealogy-tree li::after{
    content: '';
    position: absolute; 
  top: 0; 
  right: 50%;
    border-top: 2px solid #ccc;
    width: 50%; 
  height: 18px;
}
.genealogy-tree li::after{
    right: auto; left: 50%;
    border-left: 2px solid #ccc;
}
.genealogy-tree li:only-child::after, .genealogy-tree li:only-child::before {
    display: none;
}
.genealogy-tree li:only-child{ 
    padding-top: 0;
}
.genealogy-tree li:first-child::before, .genealogy-tree li:last-child::after{
    border: 0 none;
}
.genealogy-tree li:last-child::before{
    border-right: 2px solid #ccc;
    border-radius: 0 5px 0 0;
    -webkit-border-radius: 0 5px 0 0;
    -moz-border-radius: 0 5px 0 0;
}
.genealogy-tree li:first-child::after{
    border-radius: 5px 0 0 0;
    -webkit-border-radius: 5px 0 0 0;
    -moz-border-radius: 5px 0 0 0;
}
.genealogy-tree ul ul::before{
    content: '';
    position: absolute; top: 0; left: 50%;
    border-left: 2px solid #ccc;
    width: 0; height: 20px;
}
.genealogy-tree li a{
    text-decoration: none;
    color: #666;
    font-family: arial, verdana, tahoma;
    font-size: 11px;
    display: inline-block;
    border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
}

.genealogy-tree li a:hover+ul li::after, 
.genealogy-tree li a:hover+ul li::before, 
.genealogy-tree li a:hover+ul::before, 
.genealogy-tree li a:hover+ul ul::before{
    border-color:  #fbba00;
}

/*--------------memeber-card-design----------*/
.member-view-box{
    padding:0px 20px;
    text-align: center;
    border-radius: 4px;
    position: relative;
}
.member-image{
    width: 60px;
    position: relative;
}
.member-image img{
    width: 60px;
    height: 60px;
    border-radius: 6px;
  background-color :#000;
  z-index: 1;
}
</style>
</head>
<body>

<script src="js/Competition.js"></script>



<?php require_once('script_selection_vainqueurs_poule.php');?>
<?php require_once('script_selection_second_poule.php');?>
<?php require_once('script_competition.php'); ?>

<!-- Scripts pour les demis-finales -->
<?php require_once('script_premier_quarts.php'); ?>
<?php require_once('script_second_quarts.php'); ?>
<?php require_once('script_troisieme_quarts.php'); ?>
<?php require_once('script_quatrieme_quarts.php'); ?>

<!-- Scripts pour la finale -->
<?php require_once('script_premier_demi.php'); ?>
<?php require_once('script_second_demi.php'); ?>

<?php require_once('script_vainqueur.php'); ?>

<?php require_once('script_recuperer_resultat1.php'); ?>
<?php require_once('script_recuperer_resultat2.php'); ?>
<!-- Integration de l'arbre dans le design du site -->

<?php include('MenuAdminF.php'); ?>

<button id="return-button" onclick="window.location.href='AccueilAdminF.php'">Retour Acceuil</button>


<div class="body genealogy-body genealogy-scroll">
    <div class="genealogy-tree">
        <ul>
            <li>
            <a href="javascript:void(0);">
                    <div class="member-view-box">
                        <div class="member-image">
                            <img src="logo site.png" alt="Member">
                            <div class="member-details">
                            <?php script_vainqueur(); ?>
                            </div>
                        </div>
                    </div>
                </a>
            <ul>
            
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <div class="member-details">
                                    <h3>Vainqueur</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
            </ul>
                <a href="javascript:void(0);">
                    <div class="member-view-box">
                        <div class="member-image">
                            <img src="logo site.png" alt="Member">
                            <div class="member-details">
                            <?php script_premier_demi();print(" VS ");script_second_demi(); ?>
                            </div>
                            <form method='post' action=''>
                                                        <p><p><?php script_premier_demi(); ?> : <input type='number'name='score_1_1001'style="width: 50px;"><br></p>
                                                        <p><?php script_second_demi(); ?> : <input type='number'name='score_2_1001'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="1001"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==1001) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_1001"];
                                                            $score2 = $_POST["score_2_1001"]; 
                                                            $equipe1=script_premier_demi();
                                                            $equipe2= script_second_demi();
                                                            
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="G", $match_ids=1001);
                                                        }
                                                    
                                                    ?>
                        </div>
                    </div>
                </a>
                <ul class="active">
                    <li>
                    <ul>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <div class="member-details">
                                    <h3>Finale</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                        </ul>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_premier_quarts();print(" VS ");script_second_quarts(); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_premier_quarts(); ?>  : <input type='number'name='score_1_995'style="width: 50px;"><br></p>
                                                        <p><?php script_second_quarts(); ?>  : <input type='number'name='score_2_995'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="995"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==995) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_995"];
                                                            $score2 = $_POST["score_2_995"]; 
                                                            $equipe1=script_premier_quarts();
                                                            $equipe2=script_second_quarts();
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="F", $match_ids=995);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_premier_quarts();print(" VS ");script_troisieme_quarts(); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_premier_quarts(); ?>  : <input type='number'name='score_1_996'style="width: 50px;"><br></p>
                                                        <p><?php script_troisieme_quarts(); ?> : <input type='number'name='score_2_996'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="996"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==996) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_996"];
                                                            $score2 = $_POST["score_2_996"]; 
                                                            $equipe1=script_premier_quarts();
                                                            $equipe2=script_troisieme_quarts();
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="F", $match_ids=996);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_premier_quarts();print(" VS ");script_quatrieme_quarts(); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_premier_quarts(); ?> : <input type='number'name='score_1_997'style="width: 50px;"><br></p>
                                                        <p><?php script_quatrieme_quarts(); ?> : <input type='number'name='score_2_997'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="997"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==997) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_997"];
                                                            $score2 = $_POST["score_2_997"]; 
                                                            $equipe1=script_premier_quarts();
                                                            $equipe2=script_quatrieme_quarts();
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="F", $match_ids=997);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_second_quarts();print(" VS ");script_troisieme_quarts(); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_second_quarts(); ?> : <input type='number'name='score_1_998'style="width: 50px;"><br></p>
                                                        <p><?php script_troisieme_quarts(); ?> : <input type='number'name='score_2_998'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="998"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==998) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_998"];
                                                            $score2 = $_POST["score_2_998"]; 
                                                            $equipe1=script_second_quarts();
                                                            $equipe2=script_troisieme_quarts();
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="F", $match_ids=998);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_second_quarts();print(" VS ");script_quatrieme_quarts(); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_second_quarts(); ?> : <input type='number'name='score_1_999'style="width: 50px;"><br></p>
                                                        <p><?php script_quatrieme_quarts(); ?> : <input type='number'name='score_2_999'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="999"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==999) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_999"];
                                                            $score2 = $_POST["score_2_999"]; 
                                                            $equipe1= script_second_quarts();
                                                            $equipe2=script_quatrieme_quarts();
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="F", $match_ids=999);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_troisieme_quarts();print(" VS ");script_quatrieme_quarts(); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_troisieme_quarts(); ?> : <input type='number'name='score_1_1000'style="width: 50px;"><br></p>
                                                        <p><?php script_quatrieme_quarts(); ?> : <input type='number'name='score_2_1000'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="1000"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==1000) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_1000"];
                                                            $score2 = $_POST["score_2_1000"];
                                                            $equipe1=script_troisieme_quarts();
                                                            $equipe2=script_quatrieme_quarts(); 
                                                            }
                                                            //Poule F pour les matchs de demi
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="F", $match_ids=1000);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        <ul>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <div class="member-details">
                                    <h3>Demi-Finale</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                        </ul>
                        <ul>
                        <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_vainqueur_poule($poule="A");print(" VS ");script_selecion_second_poule($poule="B"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <h2><?php script_selecion_vainqueur_poule($poule="A");print(" : "); script_recuperer_resultat1($equipe=script_selecion_vainqueur_poule($poule="A"), $match_ids=977); ?><br></h2>
                                                        <p><?php script_selecion_second_poule($poule="B"); ?> : <input type='number'name='score_2_977'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="977"/>

                                                        <h2>D_1 : <?php script_recuperer_resultat1($equipe="D_1", $match_ids=971); ?><br></h2>
                                                    <h2>D_2 : <?php script_recuperer_resultat2($equipe="D_2", $match_ids=971); ?><br></h2>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==977) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_977"];
                                                            $score2 = $_POST["score_2_977"]; 
                                                            $equipe1=script_selecion_vainqueur_poule($poule="A");
                                                            $equipe2=script_selecion_second_poule($poule="B");
                                                            }
                                                            //Poule E pour toutes les quipes des quarts de finale
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=977);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_vainqueur_poule($poule="A");print(" VS ");script_selecion_second_poule($poule="C"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_vainqueur_poule($poule="A"); ?> : <input type='number'name='score_1_978'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_second_poule($poule="C"); ?> : <input type='number'name='score_2_978'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="978"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==978) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_978"];
                                                            $score2 = $_POST["score_2_978"]; 
                                                            $equipe1=script_selecion_vainqueur_poule($poule="A");
                                                            $equipe2=script_selecion_second_poule($poule="C");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=978);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_vainqueur_poule($poule="A");print(" VS ");script_selecion_second_poule($poule="D"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_vainqueur_poule($poule="A"); ?> : <input type='number'name='score_1_979'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_second_poule($poule="D"); ?> : <input type='number'name='score_2_979'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="979"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==979) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_979"];
                                                            $score2 = $_POST["score_2_979"]; 
                                                            $equipe1=script_selecion_vainqueur_poule($poule="A");
                                                            $equipe2=script_selecion_second_poule($poule="D");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=979);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_vainqueur_poule($poule="A");print(" VS ");script_selecion_second_poule($poule="A"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_vainqueur_poule($poule="A"); ?> : <input type='number'name='score_1_980'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_second_poule($poule="A"); ?> : <input type='number'name='score_2_980'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="980"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==980) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_980"];
                                                            $score2 = $_POST["score_2_980"]; 
                                                            $equipe1=script_selecion_vainqueur_poule($poule="A");
                                                            $equipe2=script_selecion_second_poule($poule="A");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=980);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_vainqueur_poule($poule="A");print(" VS ");script_selecion_vainqueur_poule($poule="B"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_vainqueur_poule($poule="A"); ?> : <input type='number'name='score_1_981'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_vainqueur_poule($poule="B"); ?> : <input type='number'name='score_2_981'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="981"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==981) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_981"];
                                                            $score2 = $_POST["score_2_981"]; 
                                                            $equipe1=script_selecion_vainqueur_poule($poule="A");
                                                            $equipe2=script_selecion_vainqueur_poule($poule="B");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=981);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_vainqueur_poule($poule="A");print(" VS ");script_selecion_vainqueur_poule($poule="C"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_vainqueur_poule($poule="A"); ?> : <input type='number'name='score_1_982'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_vainqueur_poule($poule="C"); ?> : <input type='number'name='score_2_982'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="982"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==982) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_982"];
                                                            $score2 = $_POST["score_2_982"]; 
                                                            $equipe1=script_selecion_vainqueur_poule($poule="A");
                                                            $equipe2=script_selecion_vainqueur_poule($poule="C");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=982);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        </a>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_vainqueur_poule($poule="A");print(" VS ");script_selecion_vainqueur_poule($poule="D"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_vainqueur_poule($poule="A"); ?> : <input type='number'name='score_1_983'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_vainqueur_poule($poule="D"); ?> : <input type='number'name='score_2_983'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="983"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==983) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_983"];
                                                            $score2 = $_POST["score_2_983"]; 
                                                            $equipe1=script_selecion_vainqueur_poule($poule="A");
                                                            $equipe2=script_selecion_vainqueur_poule($poule="D");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=983);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        </a>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_second_poule($poule="A");print(" VS ");script_selecion_second_poule($poule="B"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_second_poule($poule="A"); ?> : <input type='number'name='score_1_984'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_second_poule($poule="B"); ?> : <input type='number'name='score_2_984'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="984"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==984) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_984"];
                                                            $score2 = $_POST["score_2_984"]; 
                                                            $equipe1=script_selecion_second_poule($poule="A");
                                                            $equipe2=script_selecion_second_poule($poule="B");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=984);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_second_poule($poule="A");print(" VS ");script_selecion_second_poule($poule="C"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_second_poule($poule="A"); ?> : <input type='number'name='score_1_985'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_second_poule($poule="C"); ?> : <input type='number'name='score_2_985'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="985"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==985) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_985"];
                                                            $score2 = $_POST["score_2_985"]; 
                                                            $equipe1=script_selecion_second_poule($poule="A");
                                                            $equipe2=script_selecion_second_poule($poule="C");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=985);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_second_poule($poule="A");print(" VS ");script_selecion_second_poule($poule="D"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_second_poule($poule="A"); ?> : <input type='number'name='score_1_986'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_second_poule($poule="D"); ?> : <input type='number'name='score_2_986'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="986"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==986) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_986"];
                                                            $score2 = $_POST["score_2_986"]; 
                                                            $equipe1=script_selecion_second_poule($poule="A");
                                                            $equipe2=script_selecion_second_poule($poule="D");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=986);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_vainqueur_poule($poule="B");print(" VS ");script_selecion_vainqueur_poule($poule="C"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_vainqueur_poule($poule="B"); ?> : <input type='number'name='score_1_987'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_vainqueur_poule($poule="C"); ?> : <input type='number'name='score_2_987'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="987"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==987) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_987"];
                                                            $score2 = $_POST["score_2_987"]; 
                                                            $equipe1=script_selecion_vainqueur_poule($poule="B");
                                                            $equipe2=script_selecion_vainqueur_poule($poule="C");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=987);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_vainqueur_poule($poule="B");print(" VS ");script_selecion_vainqueur_poule($poule="D"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_vainqueur_poule($poule="B"); ?> : <input type='number'name='score_1_988'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_vainqueur_poule($poule="D"); ?> : <input type='number'name='score_2_988'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="988"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==988) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_988"];
                                                            $score2 = $_POST["score_2_988"]; 
                                                            $equipe1=script_selecion_vainqueur_poule($poule="B");
                                                            $equipe2=script_selecion_vainqueur_poule($poule="D");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=988);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_vainqueur_poule($poule="B");print(" VS ");script_selecion_second_poule($poule="B"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_vainqueur_poule($poule="B"); ?> : <input type='number'name='score_1_989'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_second_poule($poule="B"); ?> : <input type='number'name='score_2_989'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="989"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==989) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_989"];
                                                            $score2 = $_POST["score_2_989"]; 
                                                            $equipe1=script_selecion_vainqueur_poule($poule="B");
                                                            $equipe2=script_selecion_second_poule($poule="B");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=989);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_vainqueur_poule($poule="B");print(" VS ");script_selecion_second_poule($poule="C"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_vainqueur_poule($poule="B"); ?> : <input type='number'name='score_1_990'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_second_poule($poule="C"); ?> : <input type='number'name='score_2_990'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="990"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==990) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_alien"];
                                                            $score2 = $_POST["score_2_alien"]; 
                                                            $equipe1=script_selecion_vainqueur_poule($poule="B");
                                                            $equipe2=script_selecion_second_poule($poule="C");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=990);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_vainqueur_poule($poule="B");print(" VS ");script_selecion_second_poule($poule="D"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_vainqueur_poule($poule="B"); ?>: <input type='number'name='score_1_991'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_second_poule($poule="D"); ?> : <input type='number'name='score_2_991'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="991"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==991) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_991"];
                                                            $score2 = $_POST["score_2_991"]; 
                                                            $equipe1= script_selecion_vainqueur_poule($poule="B");
                                                            $equipe2=script_selecion_second_poule($poule="D");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=991);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_vainqueur_poule($poule="C");print(" VS ");script_selecion_vainqueur_poule($poule="D"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_vainqueur_poule($poule="C"); ?> : <input type='number'name='score_1_992'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_vainqueur_poule($poule="D"); ?>: <input type='number'name='score_2_992'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="992"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==992) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_992"];
                                                            $score2 = $_POST["score_2_992"];
                                                            $equipe1 =  script_selecion_vainqueur_poule($poule="C");
                                                            $equipe2 = script_selecion_vainqueur_poule($poule="D");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=992);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_vainqueur_poule($poule="C");print(" VS ");script_selecion_second_poule($poule="C"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_vainqueur_poule($poule="C"); ?> : <input type='number'name='score_1_993'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_second_poule($poule="C"); ?> : <input type='number'name='score_2_993'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="993"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==993) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_993"];
                                                            $score2 = $_POST["score_2_993"];
                                                            $equipe1 =  script_selecion_vainqueur_poule($poule="C");
                                                            $equipe2 = script_selecion_second_poule($poule="C");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=993);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        <li>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <img src="logo site.png" alt="Member">
                                    <div class="member-details">
                                    <?php script_selecion_vainqueur_poule($poule="C");print(" VS ");script_selecion_second_poule($poule="D"); ?>
                                    </div>
                                    <form method='post' action=''>
                                                        <p><?php script_selecion_vainqueur_poule($poule="C"); ?> : <input type='number'name='score_1_994'style="width: 50px;"><br></p>
                                                        <p><?php script_selecion_second_poule($poule="D"); ?> : <input type='number'name='score_2_994'style="width: 50px;"><br></p>
                                                        <input type="hidden" name="separator" value="994"/>
                                                    <button type="submit"style="width: 100px;"> Valider score</button>
                                                    </form>
                                                    <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->
                                                    
                                                    <?php if ($_POST['separator']==994) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                             if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                             // Récupérer les données du formulaire
                                                             $score1 = $_POST["score_1_994"];
                                                            $score2 = $_POST["score_2_994"];
                                                            $equipe1= script_selecion_vainqueur_poule($poule="C");
                                                            $equipe2=script_selecion_second_poule($poule="D");
                                                            }
                                                            script_competition($score1, $score2, $equipe1,$equipe2, $poule="E", $match_ids=994);
                                                        }
                                                    
                                                    ?>
                                </div>
                            </div>
                        </a>
                        </li>
                        </ul>
                        <ul>
                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <div class="member-details">
                                        <h3>Quart de finale</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                        </ul>
                        <ul >
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="member-view-box">
                                        <div class="member-image">
                                            <img src="logo site.png" alt="Member">
                                            <div class="member-details">
                                                <!-- On determine les deux premieres equipes -->
                                                
                                                <?php script_selecion_vainqueur_poule($poule="A"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="javascript:void(0);">
                                    <div class="member-view-box">
                                        <div class="member-image">
                                            <img src="logo site.png" alt="Member">
                                            <div class="member-details">
                                            <?php script_selecion_second_poule($poule="A"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>A_1 vs A_2</h3> <!--h3 maximum size -->
                                                    </div>
                                                    
                                                        <h2>A_1 : <?php script_recuperer_resultat1($equipe="A_1", $match_ids=953); ?><br></h2>
                                                        <h2>A_2 : <?php script_recuperer_resultat2($equipe="A_2", $match_ids=953); ?><br></h2> 
                                                    
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>A_1 vs A_3</h3>
                                                    </div>
                                                    
                                                        <h2>A_1 : <?php script_recuperer_resultat1($equipe="A_1", $match_ids=954); ?><br></h2>
                                                        <h2>A_3 : <?php script_recuperer_resultat2($equipe="A_3", $match_ids=954); ?><br></h2>
                                                    
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>A_1 vs A_4</h3>
                                                    </div>
                                                    <h2>A_1 : <?php script_recuperer_resultat1($equipe="A_1", $match_ids=955); ?><br></h2>
                                                    <h2>A_4 : <?php script_recuperer_resultat2($equipe="A_4", $match_ids=955); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>A_2 vs A_3</h3>
                                                    </div>
                                                    <h2>A_2 : <?php script_recuperer_resultat1($equipe="A_2", $match_ids=956); ?><br></h2>
                                                    <h2>A_3 : <?php script_recuperer_resultat2($equipe="A_3", $match_ids=956); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                    <h3>A_2 vs A_4</h3>
                                                    </div>
                                                    <h2>A_2 : <?php script_recuperer_resultat1($equipe="A_2", $match_ids=957); ?><br></h2>
                                                    <h2>A_4 : <?php script_recuperer_resultat2($equipe="A_4", $match_ids=957); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>A_3 vs A_4</h3>
                                                    </div>
                                                    <h2>A_3 : <?php script_recuperer_resultat1($equipe="A_3", $match_ids=958); ?><br></h2>
                                                    <h2>A_4 : <?php script_recuperer_resultat2($equipe="A_4", $match_ids=958); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="member-view-box">
                                        <div class="member-image">
                                            <img src="logo site.png" alt="Member">
                                            <div class="member-details">
                                            <?php script_selecion_vainqueur_poule($poule="B"); ?>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="javascript:void(0);">
                                    <div class="member-view-box">
                                        <div class="member-image">
                                            <img src="logo site.png" alt="Member">
                                            <div class="member-details">
                                            <?php script_selecion_second_poule($poule="B"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>B_1 vs B_2</h3>
                                                    </div>
                                                    <h2>B_1 : <?php script_recuperer_resultat1($equipe="B_1", $match_ids=959); ?><br></h2>
                                                    <h2>B_2 : <?php script_recuperer_resultat2($equipe="B_2", $match_ids=959); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>B_1 vs B_3</h3>
                                                    </div>
                                                    <h2>B_1 : <?php script_recuperer_resultat1($equipe="B_1", $match_ids=960); ?><br></h2>
                                                    <h2>B_3 : <?php script_recuperer_resultat2($equipe="B_3", $match_ids=960); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>B_1 vs B_4</h3>
                                                    </div>
                                                    <h2>B_1 : <?php script_recuperer_resultat1($equipe="B_1", $match_ids=961); ?><br></h2>
                                                    <h2>B_4 : <?php script_recuperer_resultat2($equipe="B_4", $match_ids=961); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>B_2 vs B_3</h3>
                                                    </div>
                                                    <h2>B_2 : <?php script_recuperer_resultat1($equipe="B_2", $match_ids=962); ?><br></h2>
                                                    <h2>B_3 : <?php script_recuperer_resultat2($equipe="B_3", $match_ids=962); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                    <h3>B_2 vs B_4</h3>
                                                    </div>
                                                    <h2>B_2 : <?php script_recuperer_resultat1($equipe="B_2", $match_ids=963); ?><br></h2>
                                                    <h2>B_4 : <?php script_recuperer_resultat2($equipe="B_4", $match_ids=963); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>B_3 vs B_4</h3>
                                                    </div>
                                                    <h2>B_3 : <?php script_recuperer_resultat1($equipe="B_3", $match_ids=964); ?><br></h2>
                                                    <h2>B_4 : <?php script_recuperer_resultat2($equipe="B_4", $match_ids=964); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="member-view-box">
                                        <div class="member-image">
                                            <img src="logo site.png" alt="Member">
                                            <div class="member-details">
                                            <?php script_selecion_vainqueur_poule($poule="C"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="javascript:void(0);">
                                    <div class="member-view-box">
                                        <div class="member-image">
                                            <img src="logo site.png" alt="Member">
                                            <div class="member-details">
                                            <?php script_selecion_second_poule($poule="C"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>C_1 vs C_2</h3>
                                                    </div>
                                                    <h2>C_1 : <?php script_recuperer_resultat1($equipe="C_1", $match_ids=965); ?><br></h2>
                                                    <h2>C_2 : <?php script_recuperer_resultat2($equipe="C_2", $match_ids=965); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>C_1 vs C_3</h3>
                                                    </div>
                                                    <h2>C_1 : <?php script_recuperer_resultat1($equipe="C_1", $match_ids=966); ?><br></h2>
                                                    <h2>C_3 : <?php script_recuperer_resultat2($equipe="C_3", $match_ids=966); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>C_1 vs C_4</h3>
                                                    </div>
                                                    <h2>C_1 : <?php script_recuperer_resultat1($equipe="C_1", $match_ids=967); ?><br></h2>
                                                    <h2>C_4 : <?php script_recuperer_resultat2($equipe="C_4", $match_ids=967); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>C_2 vs C_3</h3>
                                                    </div>
                                                    <h2>C_2 : <?php script_recuperer_resultat1($equipe="C_2", $match_ids=968); ?><br></h2>
                                                    <h2>C_3 : <?php script_recuperer_resultat2($equipe="C_3", $match_ids=968); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                    <h3>C_2 vs C_4</h3>
                                                    </div>
                                                    <h2>C_2 : <?php script_recuperer_resultat1($equipe="C_2", $match_ids=969); ?><br></h2>
                                                    <h2>C_4 : <?php script_recuperer_resultat2($equipe="C_4", $match_ids=969); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>C_3 vs C_4</h3>
                                                    </div>
                                                    <h2>C_3 : <?php script_recuperer_resultat1($equipe="C_3", $match_ids=970); ?><br></h2>
                                                    <h2>C_4 : <?php script_recuperer_resultat2($equipe="C_4", $match_ids=970); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <div class="member-view-box">
                                        <div class="member-image">
                                            <img src="logo site.png" alt="Member">
                                            <div class="member-details">
                                            <?php script_selecion_vainqueur_poule($poule="D"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="javascript:void(0);">
                                    <div class="member-view-box">
                                        <div class="member-image">
                                            <img src="logo site.png" alt="Member">
                                            <div class="member-details">
                                            <?php script_selecion_second_poule($poule="D"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>D_1 vs D_2</h3>
                                                    </div>
                                                    <h2>D_1 : <?php script_recuperer_resultat1($equipe="D_1", $match_ids=971); ?><br></h2>
                                                    <h2>D_2 : <?php script_recuperer_resultat2($equipe="D_2", $match_ids=971); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>D_1 vs D_3</h3>
                                                    </div>
                                                    <h2>D_1 : <?php script_recuperer_resultat1($equipe="D_1", $match_ids=972); ?><br></h2>
                                                    <h2>D_3 : <?php script_recuperer_resultat2($equipe="D_3", $match_ids=972); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>D_1 vs D_4</h3>
                                                    </div>
                                                    <h2>D_1 : <?php script_recuperer_resultat1($equipe="D_1", $match_ids=973); ?><br></h2>
                                                    <h2>D_4 : <?php script_recuperer_resultat2($equipe="D_4", $match_ids=973); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>D_2 vs D_3</h3>
                                                    </div>
                                                    <h2>D_2 : <?php script_recuperer_resultat1($equipe="D_2", $match_ids=974); ?><br></h2>
                                                    <h2>D_3 : <?php script_recuperer_resultat2($equipe="D_3", $match_ids=974); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                    <h3>D_2 vs D_4</h3>
                                                    </div>
                                                    <h2>D_2 : <?php script_recuperer_resultat1($equipe="D_2", $match_ids=975); ?><br></h2>
                                                    <h2>D_4 : <?php script_recuperer_resultat2($equipe="D_4", $match_ids=975); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="member-view-box">
                                                <div class="member-image">
                                                    <img src="logo site.png" alt="Member">
                                                    <div class="member-details">
                                                        <h3>D_3 vs D_4</h3>
                                                    </div>
                                                    <h2>D_3 : <?php script_recuperer_resultat1($equipe="D_3", $match_ids=976); ?><br></h2>
                                                    <h2>D_4 : <?php script_recuperer_resultat2($equipe="D_4", $match_ids=976); ?><br></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <?php include('FooterF.php'); ?>
</div>
    