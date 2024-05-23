<?php

//require('Competition.js');
require('database.php');
ini_set('display_errors', 0);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arbre de Compétition</title>
    <link rel="stylesheet" href="style.css">
    <?php include('MenuOrganisateurF.php'); ?>

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
        .genealogy-body {
            white-space: nowrap;
            overflow-y: hidden;
            padding: 50px;
            min-height: 500px;
            padding-top: 10px;
            text-align: center;
        }

        .genealogy-tree {
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
            float: left;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;
        }

        .genealogy-tree li::before,
        .genealogy-tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 2px solid #ccc;
            width: 50%;
            height: 18px;
        }

        .genealogy-tree li::after {
            right: auto;
            left: 50%;
            border-left: 2px solid #ccc;
        }

        .genealogy-tree li:only-child::after,
        .genealogy-tree li:only-child::before {
            display: none;
        }

        .genealogy-tree li:only-child {
            padding-top: 0;
        }

        .genealogy-tree li:first-child::before,
        .genealogy-tree li:last-child::after {
            border: 0 none;
        }

        .genealogy-tree li:last-child::before {
            border-right: 2px solid #ccc;
            border-radius: 0 5px 0 0;
            -webkit-border-radius: 0 5px 0 0;
            -moz-border-radius: 0 5px 0 0;
        }

        .genealogy-tree li:first-child::after {
            border-radius: 5px 0 0 0;
            -webkit-border-radius: 5px 0 0 0;
            -moz-border-radius: 5px 0 0 0;
        }

        .genealogy-tree ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 2px solid #ccc;
            width: 0;
            height: 20px;
        }

        .genealogy-tree li a {
            text-decoration: none;
            color: #e09722;
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
        .genealogy-tree li a:hover+ul ul::before {
            border-color: #fbba00;
        }

        /*--------------memeber-card-design----------*/
        .member-view-box {
            padding: 0px 20px;
            text-align: center;
            border-radius: 4px;
            position: relative;
        }

        .member-image {
            width: 60px;
            position: relative;
        }

        .member-image img {
            width: 60px;
            height: 60px;
            border-radius: 6px;
            background-color: #000;
            z-index: 1;
        }
    </style>

</head>

<body>
    <video autoplay loop muted playsinline id="background-video">
        <source src="videos/video6.mp4" type="video/mp4">
    </video>
    <script src="js/Competition.js"></script>

    <!-- Initinalisation des matchs dans la DB -->

    <?php

    try {


        require('database.php');

        // Vérifier si les équipes initiales sont déjà ajoutées
        $sql_count_teams = "SELECT COUNT(*) AS total FROM matchs";
        $stmt = $connexion->prepare($sql_count_teams);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        //echo $result['total'];

        $poules = array("A", "B", "C", "D");

        if ($result['total'] < 16) { // Il y a 16 équipes au total pour 4 poules de 4 équipes chacune
            // Ajouter les équipes à la table "matchs" pour chaque poule
            foreach ($poules as $poule) {
                $equipes = array("1", "2", "3", "4"); // Changez ici les noms des équipes si nécessaire
                $nombre_equipes = count($equipes);
                for ($i = 0; $i < $nombre_equipes - 1; $i++) {
                    for ($j = $i + 1; $j < $nombre_equipes; $j++) {
                        $equipe1 = ($poule) . "_" . $equipes[$i]; // Ajout du suffixe numérique
                        $equipe2 = ($poule) . "_" . $equipes[$j]; // Ajout du suffixe numérique
                        // Vérifier si le match n'existe pas déjà
                        $sql_check_match = "SELECT COUNT(*) AS match_exist FROM matchs WHERE (equipe1 = '$equipe1' AND equipe2 = '$equipe2' AND poule = '$poule') OR (equipe1 = '$equipe2' AND equipe2 = '$equipe1' AND poule = '$poule')";
                        $stmt = $connexion->prepare($sql_check_match);
                        $stmt->execute();
                        $match_exist = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($match_exist['match_exist'] == 0) {
                            // Le match n'existe pas, on peut l'ajouter
                            $sql_insert_team = "INSERT INTO matchs (equipe1, equipe2, poule) VALUES ('$equipe1', '$equipe2', '$poule')";
                            $connexion->exec($sql_insert_team);
                        }
                    }
                }
            }
        }
    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion dans la DB'" . $e->getMessage();
    } finally {
        $connexion = null;
    }

    ?>

    <?php //require_once('script_selection_vainqueurs_poule.php'); ?>
    <?php require_once('script_selection_vainqueur_poule2.php'); ?>
    <?php //require_once('script_selection_second_poule.php'); ?>
    <?php require_once('script_selection_second_poule2.php'); ?>
    <?php //require_once('script_competition.php'); ?>
    <?php require_once('script_competition2.php'); ?>    

    <!-- Scripts pour les demis-finales -->
    <?php //require_once('script_premier_quarts.php'); ?>
    <?php //require_once('script_second_quarts.php'); ?>
    <?php //require_once('script_troisieme_quarts.php'); ?>
    <?php //require_once('script_quatrieme_quarts.php'); ?>

    <!-- Scripts pour la finale -->
    <?php require_once('script_premier_demi2.php'); ?>

    <?php require_once('script_second_demi2.php'); ?>

    <?php require_once('script_vainqueur2.php'); ?>

    <?php require_once('script_vainqueur_quart2.php'); ?>

    <?php require_once('creation_arbre.php'); ?>

    <!-- Integration de l'arbre dans le design du site -->

    <!-- <?php include('MenuOrganisateurF.php'); ?> -->


<h2>Veuillez selectionner l'annee du tournois</h2>
<form method='get' action=''>
    <p> <input type='number' name='annee' style="width: 50px;"><br></p>
    <button type="submit" style="width: 100px;"> Valider annee</button>
</form>
<?php 
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    $annee= $_POST['selection_annee'];
//    echo $annee;
//}
?>
<?php echo $annee; ?>
<?php echo $_GET['annee']; ?>
<?php $annee= $_GET['annee'];?>
<?php echo $annee; ?>

<form method='post' action=''>
    <button type="submit" style="width: 100px;"> Creer nouvel arbre</button>
    <input type="hidden" name="separator" value="nouvel_arbre" />
</form>
<?php if ($_POST['separator']== 'nouvel_arbre') {
        if ($_SERVER["REQUEST_METHOD"]== "POST") {
            echo "test creation nouvel arbre";
            creation_arbre($annee);
        }
}
?>


    <div class="body genealogy-body genealogy-scroll">
        <div class="genealogy-tree">
            <ul>
                <li>
                    <a href="javascript:void(0);">
                        <div class="member-view-box">
                            <div class="member-image">
                                <img src="images/akalogo.png" alt="Member">
                                <div class="member-details">
                                    <h2><?php script_vainqueur2($annee); ?></h2>
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul>

                        <a href="javascript:void(0);">
                            <div class="member-view-box">
                                <div class="member-image">
                                    <div class="member-details">
                                        <h3>Vainqueur <?php echo $annee?> </h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </ul>

                    <a href="javascript:void(0);">
                        <div class="member-view-box">
                            <div class="member-image">
                                <img src="images/akalogo.png" alt="Member">
                                <div class="member-details">
                                    <?php script_premier_demi2($annee);
                                    print(" VS ");
                                    script_second_demi2($annee); ?>
                                </div>
                                <form method='post' action=''>
                                    <p><?php script_premier_demi2($annee); ?> : <input type='number' name='score_1_1001' style="width: 50px;"><br></p>
                                    <p><?php script_second_demi2($annee); ?> : <input type='number' name='score_2_1001' style="width: 50px;"><br></p>
                                    <input type="hidden" name="separator" value="1001" />
                                    <button type="submit" style="width: 100px;"> Valider score</button>
                                </form>
                                <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->

                                <?php if ($_POST['separator'] == 1001) {
                                    //Pour n'envoyer que le questionnaire associe
                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                        // Récupérer les données du formulaire
                                        $score1 = $_POST["score_1_1001"];
                                        $score2 = $_POST["score_2_1001"];
                                        $equipe1 = script_premier_demi2($annee);
                                        $equipe2 = script_second_demi2($annee);
                                    }
                                    script_competition($score1, $score2, $equipe1, $equipe2, $poule = "G", $match_ids = 1001);
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
                                        <img src="images/akalogo.png" alt="Member">
                                        <div class="member-details">
                                            <?php script_vainqueur_quart2($poule ="E4", $annee); //977
                                            print(" VS ");
                                            script_vainqueur_quart2($poule = "E2" , $annee);//979 ?>
                                        </div>
                                        <form method='post' action=''>
                                            <p><?php script_vainqueur_quart2($poule ="E4", $annee); ?> : <input type='number' name='score_1_995' style="width: 50px;"><br></p>
                                            <p><?php script_vainqueur_quart2($poule = "E2" , $annee); ?> : <input type='number' name='score_2_995' style="width: 50px;"><br></p>
                                            <input type="hidden" name="separator" value="995" />
                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                        </form>
                                        <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->

                                        <?php if ($_POST['separator'] == 995) {
                                            //Pour n'envoyer que le questionnaire associe
                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                // Récupérer les données du formulaire
                                                $score1 = $_POST["score_1_995"];
                                                $score2 = $_POST["score_2_995"];
                                                $equipe1 = script_vainqueur_quart2($poule ="E4", $annee);
                                                $equipe2 = script_vainqueur_quart2($poule = "E2" , $annee);
                                            }
                                            script_competition($score1, $score2, $equipe1, $equipe2, $poule = "F", $match_ids = 995);
                                        }

                                        ?>
                                    </div>
                                </div>
                            </a>


                            <a href="javascript:void(0);">
                                <div class="member-view-box">
                                    <div class="member-image">
                                        <img src="images/akalogo.png" alt="Member">
                                        <div class="member-details">
                                            <?php script_vainqueur_quart2($poule= "E3", $annee);//978
                                            print(" VS ");
                                            script_vainqueur_quart2($poule="E1", $annee);//980 ?>
                                        </div>
                                        <form method='post' action=''>
                                            <p><?php script_vainqueur_quart2($poule= "E3", $annee); ?> : <input type='number' name='score_1_996' style="width: 50px;"><br></p>
                                            <p><?php script_vainqueur_quart2($poule="E1", $annee); ?> : <input type='number' name='score_2_996' style="width: 50px;"><br></p>
                                            <input type="hidden" name="separator" value="996" />
                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                        </form>
                                        <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->

                                        <?php if ($_POST['separator'] == 996) {
                                            //Pour n'envoyer que le questionnaire associe
                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                // Récupérer les données du formulaire
                                                $score1 = $_POST["score_1_996"];
                                                $score2 = $_POST["score_2_996"];
                                                $equipe1 = script_vainqueur_quart2($poule= "E3", $annee);
                                                $equipe2 = script_vainqueur_quart2($poule="E1", $annee);
                                            }
                                            script_competition($score1, $score2, $equipe1, $equipe2, $poule = "F", $match_ids = 996);
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
                                                <img src="images/akalogo.png" alt="Member">
                                                <div class="member-details">
                                                    <?php script_selection_vainqueur_poule2($poule = "A", $annee);
                                                    print(" VS ");
                                                    script_selection_second_poule2($poule = "B", $annee); ?>
                                                </div>
                                                <form method='post' action=''>
                                                    <p><?php script_selection_vainqueur_poule2($poule = "A", $annee); ?> : <input type='number' name='score_1_977' style="width: 50px;"><br></p>
                                                    <p><?php script_selection_second_poule2($poule = "B", $annee); ?> : <input type='number' name='score_2_977' style="width: 50px;"><br></p>
                                                    <input type="hidden" name="separator" value="977" />
                                                    <button type="submit" style="width: 100px;"> Valider score</button>
                                                </form>
                                                <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->

                                                <?php if ($_POST['separator'] == 977) {
                                                    //Pour n'envoyer que le questionnaire associe
                                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                        // Récupérer les données du formulaire
                                                        $score1 = $_POST["score_1_977"];
                                                        $score2 = $_POST["score_2_977"];
                                                        $equipe1 = script_selection_vainqueur_poule2($poule = "A", $annee);
                                                        $equipe2 = script_selection_second_poule2($poule = "B", $annee);
                                                    }
                                                    //Poule E pour toutes les quipes des quarts de finale
                                                    script_competition($score1, $score2, $equipe1, $equipe2, $poule = "E4", $match_ids = 977);
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
                                                <img src="images/akalogo.png" alt="Member">
                                                <div class="member-details">
                                                    <?php script_selection_second_poule2($poule = "A", $annee);
                                                    print(" VS ");
                                                    script_selection_vainqueur_poule2($poule = "B", $annee); ?>
                                                </div>
                                                <form method='post' action=''>
                                                    <p><?php script_selection_second_poule2($poule = "A", $annee); ?> : <input type='number' name='score_1_978' style="width: 50px;"><br></p>
                                                    <p><?php script_selection_vainqueur_poule2($poule = "B", $annee); ?> : <input type='number' name='score_2_978' style="width: 50px;"><br></p>
                                                    <input type="hidden" name="separator" value="978" />
                                                    <button type="submit" style="width: 100px;"> Valider score</button>
                                                </form>
                                                <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->

                                                <?php if ($_POST['separator'] == 978) {
                                                    //Pour n'envoyer que le questionnaire associe
                                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                        // Récupérer les données du formulaire
                                                        $score1 = $_POST["score_1_978"];
                                                        $score2 = $_POST["score_2_978"];
                                                        $equipe1 = script_selection_second_poule2($poule = "A", $annee);
                                                        $equipe2 = script_selection_vainqueur_poule2($poule = "B", $annee);
                                                    }
                                                    //Poule E pour toutes les quipes des quarts de finale
                                                    script_competition($score1, $score2, $equipe1, $equipe2, $poule = "E3", $match_ids = 978);
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
                                                <img src="images/akalogo.png" alt="Member">
                                                <div class="member-details">
                                                    <?php script_selection_vainqueur_poule2($poule = "C", $annee);
                                                    print(" VS ");
                                                    script_selection_second_poule2($poule = "D", $annee); ?>
                                                </div>
                                                <form method='post' action=''>
                                                    <p><?php script_selection_vainqueur_poule2($poule = "C", $annee); ?> : <input type='number' name='score_1_979' style="width: 50px;"><br></p>
                                                    <p><?php script_selection_second_poule2($poule = "D", $annee); ?> : <input type='number' name='score_2_979' style="width: 50px;"><br></p>
                                                    <input type="hidden" name="separator" value="979" />
                                                    <button type="submit" style="width: 100px;"> Valider score</button>
                                                </form>
                                                <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->

                                                <?php if ($_POST['separator'] == 979) {
                                                    //Pour n'envoyer que le questionnaire associe
                                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                        // Récupérer les données du formulaire
                                                        $score1 = $_POST["score_1_979"];
                                                        $score2 = $_POST["score_2_979"];
                                                        $equipe1 = script_selection_vainqueur_poule2($poule = "C", $annee);
                                                        $equipe2 = script_selection_second_poule2($poule = "D", $annee);
                                                    }
                                                    script_competition($score1, $score2, $equipe1, $equipe2, $poule = "E2", $match_ids = 979);
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
                                                <img src="images/akalogo.png" alt="Member">
                                                <div class="member-details">
                                                    <?php script_selection_vainqueur_poule2($poule = "D", $annee);
                                                    print(" VS ");
                                                    script_selection_second_poule2($poule = "C", $annee); ?>
                                                </div>
                                                <form method='post' action=''>
                                                    <p><?php script_selection_vainqueur_poule2($poule = "D", $annee); ?> : <input type='number' name='score_1_980' style="width: 50px;"><br></p>
                                                    <p><?php script_selection_second_poule2($poule = "C", $annee); ?> : <input type='number' name='score_2_980' style="width: 50px;"><br></p>
                                                    <input type="hidden" name="separator" value="980" />
                                                    <button type="submit" style="width: 100px;"> Valider score</button>
                                                </form>
                                                <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->

                                                <?php if ($_POST['separator'] == 980) {
                                                    //Pour n'envoyer que le questionnaire associe
                                                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                        // Récupérer les données du formulaire
                                                        $score1 = $_POST["score_1_980"];
                                                        $score2 = $_POST["score_2_980"];
                                                        $equipe1 = script_selection_vainqueur_poule2($poule = "D", $annee);
                                                        $equipe2 = script_selection_second_poule2($poule = "C", $annee);
                                                    }
                                                    script_competition($score1, $score2, $equipe1, $equipe2, $poule = "E1", $match_ids = 980);
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
                            <ul>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="member-view-box">
                                            <div class="member-image">
                                                <img src="images/akalogo.png" alt="Member">
                                                <div class="member-details">
                                                    <!-- On determine les deux premieres equipes -->

                                                    <?php script_selection_vainqueur_poule2($poule = "A", $annee); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);">
                                        <div class="member-view-box">
                                            <div class="member-image">
                                                <img src="images/akalogo.png" alt="Member">
                                                <div class="member-details">
                                                    <?php script_selection_second_poule2($poule = "A", $annee); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="member-view-box">
                                                    <div class="member-image">
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>A_1 vs A_2</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>A_1 : <input type='number' name='score_1_953' style="width: 50px;"><br></p>
                                                            <p>A_2 : <input type='number' name='score_2_953' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="953" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <!-- score_1 et score_2 doivent avoir des noms differents pour chaque formulaire pour la bonne execution du code php suivant-->

                                                        <?php if ($_POST['separator'] == 953) {
                                                            //Pour n'envoyer que le questionnaire associe
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_953"];
                                                                $score2 = $_POST["score_2_953"];
                                                            }
                                                            script_competition2($score1, $score2, $equipe1 = "A_1", $equipe2 = "A_2", $poule = "A", $annee);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>A_1 vs A_3</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>A_1 : <input type='number' name='score_1_954' style="width: 50px;"><br></p>
                                                            <p>A_3 : <input type='number' name='score_2_954' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="954" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 954) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_954"];
                                                                $score2 = $_POST["score_2_954"];
                                                            }
                                                            script_competition2($score1, $score2, $equipe1 = "A_1", $equipe2 = "A_3", $poule = "A", $annee);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>A_1 vs A_4</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>A_1 : <input type='number' name='score_1_955' style="width: 50px;"><br></p>
                                                            <p>A_4 : <input type='number' name='score_2_955' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="955" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 955) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_955"];
                                                                $score2 = $_POST["score_2_955"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "A_1", $equipe2 = "A_4", $poule = "A", $match_ids = 955);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>A_2 vs A_3</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>A_2 : <input type='number' name='score_1_956' style="width: 50px;"><br></p>
                                                            <p>A_3 : <input type='number' name='score_2_956' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="956" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 956) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_956"];
                                                                $score2 = $_POST["score_2_956"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "A_2", $equipe2 = "A_3", $poule = "A", $match_ids = 956);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>A_2 vs A_4</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>A_2 : <input type='number' name='score_1_957' style="width: 50px;"><br></p>
                                                            <p>A_4 : <input type='number' name='score_2_957' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="957" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 957) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_957"];
                                                                $score2 = $_POST["score_2_957"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "A_2", $equipe2 = "A_4", $poule = "A", $match_ids = 957);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>A_3 vs A_4</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>A_3 : <input type='number' name='score_1_958' style="width: 50px;"><br></p>
                                                            <p>A_4 : <input type='number' name='score_2_958' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="958" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 958) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_958"];
                                                                $score2 = $_POST["score_2_958"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "A_3", $equipe2 = "A_4", $poule = "A", $match_ids = 958);
                                                        }
                                                        ?>
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
                                                <img src="images/akalogo.png" alt="Member">
                                                <div class="member-details">
                                                    <?php script_selection_vainqueur_poule2($poule = "B", $annee); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);">
                                        <div class="member-view-box">
                                            <div class="member-image">
                                                <img src="images/akalogo.png" alt="Member">
                                                <div class="member-details">
                                                    <?php script_selection_second_poule2($poule = "B", $annee); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="member-view-box">
                                                    <div class="member-image">
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>B_1 vs B_2</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>B_1 : <input type='number' name='score_1_959' style="width: 50px;"><br></p>
                                                            <p>B_2 : <input type='number' name='score_2_959' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="959" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 959) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_959"];
                                                                $score2 = $_POST["score_2_959"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "B_1", $equipe2 = "B_2", $poule = "B", $match_ids = 959);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>B_1 vs B_3</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>B_1 : <input type='number' name='score_1_960' style="width: 50px;"><br></p>
                                                            <p>B_3 : <input type='number' name='score_2_960' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="960" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 960) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_960"];
                                                                $score2 = $_POST["score_2_960"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "B_1", $equipe2 = "B_3", $poule = "B", $match_ids = 960);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>B_1 vs B_4</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>B_1 : <input type='number' name='score_1_961' style="width: 50px;"><br></p>
                                                            <p>B_4 : <input type='number' name='score_2_961' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="961" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 961) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_961"];
                                                                $score2 = $_POST["score_2_961"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "B_1", $equipe2 = "B_4", $poule = "B", $match_ids = 961);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>B_2 vs B_3</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>B_2 : <input type='number' name='score_1_962' style="width: 50px;"><br></p>
                                                            <p>B_3 : <input type='number' name='score_2_962' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="962" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 962) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_962"];
                                                                $score2 = $_POST["score_2_962"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "B_2", $equipe2 = "B_3", $poule = "B", $match_ids = 962);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>B_2 vs B_4</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>B_2 : <input type='number' name='score_1_963' style="width: 50px;"><br></p>
                                                            <p>B_4 : <input type='number' name='score_2_963' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="963" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 963) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_963"];
                                                                $score2 = $_POST["score_2_963"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "B_2", $equipe2 = "B_4", $poule = "B", $match_ids = 963);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>B_3 vs B_4</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>B_3 : <input type='number' name='score_1_964' style="width: 50px;"><br></p>
                                                            <p>B_4 : <input type='number' name='score_2_964' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="964" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 964) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_964"];
                                                                $score2 = $_POST["score_2_964"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "B_3", $equipe2 = "B_4", $poule = "B", $match_ids = 964);
                                                        }
                                                        ?>
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
                                                <img src="images/akalogo.png" alt="Member">
                                                <div class="member-details">
                                                    <?php script_selection_vainqueur_poule2($poule = "C", $annee); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);">
                                        <div class="member-view-box">
                                            <div class="member-image">
                                                <img src="images/akalogo.png" alt="Member">
                                                <div class="member-details">
                                                    <?php script_selection_second_poule2($poule = "C", $annee); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="member-view-box">
                                                    <div class="member-image">
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>C_1 vs C_2</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>C_1 : <input type='number' name='score_1_965' style="width: 50px;"><br></p>
                                                            <p>C_2 : <input type='number' name='score_2_965' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="965" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 965) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_965"];
                                                                $score2 = $_POST["score_2_965"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "C_1", $equipe2 = "C_2", $poule = "C", $match_ids = 965);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>C_1 vs C_3</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>C_1 : <input type='number' name='score_1_966' style="width: 50px;"><br></p>
                                                            <p>C_3 : <input type='number' name='score_2_966' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="966" /> <!-- sert a differencier les formulaires -->
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 966) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_966"];
                                                                $score2 = $_POST["score_2_966"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "C_1", $equipe2 = "C_3", $poule = "C", $match_ids = 966);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>C_1 vs C_4</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>C_1 : <input type='number' name='score_1_967' style="width: 50px;"><br></p>
                                                            <p>C_4 : <input type='number' name='score_2_967' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="967" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 967) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_967"];
                                                                $score2 = $_POST["score_2_967"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "C_1", $equipe2 = "C_4", $poule = "C", $match_ids = 967);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>C_2 vs C_3</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>C_2 : <input type='number' name='score_1_968' style="width: 50px;"><br></p>
                                                            <p>C_3 : <input type='number' name='score_2_968' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="968" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 968) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_968"];
                                                                $score2 = $_POST["score_2_968"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "C_2", $equipe2 = "C_3", $poule = "C", $match_ids = 968);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>C_2 vs C_4</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>C_2 : <input type='number' name='score_1_969' style="width: 50px;"><br></p>
                                                            <p>C_4 : <input type='number' name='score_2_969' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="969" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 969) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_969"];
                                                                $score2 = $_POST["score_2_969"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "C_2", $equipe2 = "C_4", $poule = "C", $match_ids = 969);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>C_3 vs C_4</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>C_3 : <input type='number' name='score_1_970' style="width: 50px;"><br></p>
                                                            <p>C_4 : <input type='number' name='score_2_970' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="970" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 970) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_970"];
                                                                $score2 = $_POST["score_2_970"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "C_3", $equipe2 = "C_4", $poule = "C", $match_ids = 970);
                                                        }
                                                        ?>
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
                                                <img src="images/akalogo.png" alt="Member">
                                                <div class="member-details">
                                                    <?php script_selection_vainqueur_poule2($poule = "D", $annee); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0);">
                                        <div class="member-view-box">
                                            <div class="member-image">
                                                <img src="images/akalogo.png" alt="Member">
                                                <div class="member-details">
                                                    <?php script_selection_second_poule2($poule = "D", $annee); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="member-view-box">
                                                    <div class="member-image">
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>D_1 vs D_2</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>D_1 : <input type='number' name='score_1_971' style="width: 50px;"><br></p>
                                                            <p>D_2 : <input type='number' name='score_2_971' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="971" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 971) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_971"];
                                                                $score2 = $_POST["score_2_971"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "D_1", $equipe2 = "D_2", $poule = "D", $match_ids = 971);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>D_1 vs D_3</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>D_1 : <input type='number' name='score_1_972' style="width: 50px;"><br></p>
                                                            <p>D_3 : <input type='number' name='score_2_972' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="972" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 972) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_972"];
                                                                $score2 = $_POST["score_2_972"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "D_1", $equipe2 = "D_3", $poule = "D", $match_ids = 972);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>D_1 vs D_4</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>D_1 : <input type='number' name='score_1_973' style="width: 50px;"><br></p>
                                                            <p>D_4 : <input type='number' name='score_2_973' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="973" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 973) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_973"];
                                                                $score2 = $_POST["score_2_973"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "D_1", $equipe2 = "D_4", $poule = "D", $match_ids = 973);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>D_2 vs D_3</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>D_2 : <input type='number' name='score_1_974' style="width: 50px;"><br></p>
                                                            <p>D_3 : <input type='number' name='score_2_974' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="974" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 974) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_974"];
                                                                $score2 = $_POST["score_2_974"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "D_2", $equipe2 = "D_3", $poule = "D", $match_ids = 974);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>D_2 vs D_4</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>D_2 : <input type='number' name='score_1_975' style="width: 50px;"><br></p>
                                                            <p>D_4 : <input type='number' name='score_2_975' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="975" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 975) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_975"];
                                                                $score2 = $_POST["score_2_975"];
                                                            }
                                                            script_competition($score1, $score2, $equipe1 = "D_2", $equipe2 = "D_4", $poule = "D", $match_ids = 975);
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
                                                        <img src="images/akalogo.png" alt="Member">
                                                        <div class="member-details">
                                                            <h3>D_3 vs D_4</h3>
                                                        </div>
                                                        <form method='post' action=''>
                                                            <p>D_3 : <input type='number' name='score_1_976' style="width: 50px;"><br></p>
                                                            <p>D_4 : <input type='number' name='score_2_976' style="width: 50px;"><br></p>
                                                            <input type="hidden" name="separator" value="976" />
                                                            <button type="submit" style="width: 100px;"> Valider score</button>
                                                        </form>
                                                        <?php if ($_POST['separator'] == 976) {
                                                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                                                // Récupérer les données du formulaire
                                                                $score1 = $_POST["score_1_976"];
                                                                $score2 = $_POST["score_2_976"];
                                                                $annee=$_POST["selection_annee"];
                                                            }
                                                            //$annee=2019;
                                                            echo $annee;
                                                            print("Test");
                                                            script_competition2($score1, $score2, $equipe1 = "D_3", $equipe2 = "D_4", $poule = "D", $annee);
                                                        }
                                                        echo $annee;
                                                        ?>
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
        <!-- <?php include('FooterF.php'); ?> -->
    </div>