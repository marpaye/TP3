<?php
session_start();
include 'connexion.php';
if(isset($_POST['texteCommentaire']))
{
    $nbPublicationsTotales +=1;
$sql5 = "INSERT INTO publication (pk_publication,texte,fk_publication,fk_type_publication,fk_utilisateur,fk_specialite)
VALUES ('".$nbPublicationsTotales."', '".$_POST['texteCommentaire']."','".$_POST['clePub'].",'".$_SESSION['cleUser']."', '".$_POST['specialite']."')";
}
$sql4= "SELECT valeur FROM vote INNER JOIN publication on vote.fk_publication = publication.pk_publication where vote.fk_utilisateur = '".$_SESSION['cleUser']."' AND publication.fk_type_publication = 2;";
$listeVotes = $bd->query($sql4)->fetchAll(PDO::FETCH_ASSOC);

$lien = "pageUtilisateur.php";
?>

    <!DOCTYPE html>
    <html>
    <style>
        h9 {
            text-align: right;
            padding: 5px;
            color: dodgerblue;
        }

        .publication {
            background-color: lightgrey;
            width: 800px;
            padding: 20px;
            display: inline-block;
            margin-left: 320px;
            margin-bottom: 15px;
            border: solid 1px #000;
        }


        .reponse {
            background-color: lightgray;
            width: 800px;
            padding: 20px;
            display: inline-block;
            margin-left: 320px;
            margin-top: -25px;
            margin-bottom: 15px;
            border-left: solid 1px #000;
            border-bottom: solid 1px #000;
            border-right: solid 1px #000;
        }

        .ajouterReponse {
            background-color: lightgray;
            width: 800px;
            padding: 20px;
            text-align: center;
            margin-left: 320px;
            margin-top: -25px;
            margin-bottom: 25px;
            display: inline-block;
            border-left: solid 1px #000;
            border-bottom: solid 1px #000;
            border-right: solid 1px #000;
            padding-bottom: 15px;
        }

        .rating_reponse {
            float: left;
            margin-left: 100px;
            margin-top: 30px;
        }

        .connexion {
            display: none;
        }

    </style>

    <head>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>

    <body style="background-color: rgb(242,242,242);">
        <div style="display:inline;">
            <a href="pageUtilisateur.php"><i class="glyphicon glyphicon-user" style="font-size:60px;float:right;margin-top:20px;margin-right:80px;padding: 2px 3px 3px 2px; color: #FFF;" href="pageUtilisateur.php"></i></a>
            <p style="font-size:80px;text-align:center;background-color:#c2334a;padding-left:150px;color:white;">Fil d'actualité</p>
        </div>
        <br/>
        <br/>
        <div class="border">
            <?php
       foreach($listePub as $pub) {
           if($pub['pk_utilisateur']== $_SESSION['cleUser']) {
                $lien = "pageUtilisateur.php";
           }
           if($pub['pk_utilisateur']!= $_SESSION['cleUser']) {
                $lien = "autrePageUtilisateur.php";
           }
	?>
                <div class="publication">
                    <div style="width:700px;margin-left:50px;margin-top:20px;">
                        <p style="font-weight: bold;">
                            <?php echo $pub['texte']; ?>
                        </p>

                        <i class="glyphicon glyphicon-user"></i>
                        <h9>
                            <a href="<?php echo $lien ?>" style="color: dodgerblue;">
                                <?php echo $pub['prenom']; ?>
                                <?php echo $pub['nom']; ?>
                            </a>
                        </h9>
                    </div>
                </div>

                <?php
			foreach($listeReponse as $reponse){
                if($reponse['pk_utilisateur']== $_SESSION['cleUser']) {
                    $lien = "pageUtilisateur.php";
                }
                if($reponse['pk_utilisateur']!= $_SESSION['cleUser']) {
                    $lien = "autrePageUtilisateur.php";
                }
                if($reponse['fk_publication'] == $pub['fk_publication']){

			?>
                    <div class="reponse">
                        <div class="rating_reponse">
                            <i class="glyphicon glyphicon-triangle-top" style="color:dimgrey;"></i> <br/>
                            <p style="padding-left:3px;padding-top:3px;font-weight: bold;">
                                //Vote ne marche pas (?)
                                <?php echo $listeVotes ?>
                            </p>
                            <i class="glyphicon glyphicon-triangle-bottom" style="color:dimgrey;"></i> <br/>
                        </div>
                        <div style="width:600px;float: right;">
                            <hr/>
                            <p style="font-weight: bold;">
                                <?php echo $reponse['texte']; ?>
                            </p>

                            <i class="glyphicon glyphicon-user"></i>
                            <h9>
                                <a href="<?php echo $lien ?>" style="color: dodgerblue;">
                                    <?php echo $reponse['prenom']; ?>
                                    <?php echo $reponse['nom']; ?>
                                </a>
                            </h9>
                        </div>
                    </div>
                    <?php }} ?>
                    <div class="ajouterReponse">
                        <hr/>
                        <form id="form" method="post" action="index.php">
                            <textarea class="texte" name="texteCommentaire" rows="10" style="width:500px;height:150px;margin-top:10px;resize:none;"></textarea><br/>
                            <button type="submit" style="color:dimgrey;margin-left:-420px;margin-top:5px;">Répondre</button>
                        </form>
                    </div>
                    <?php } ?>
    </body>

    </html>
