<?php
// Start the session
session_start();

//Verification d'utilisateur connecté
if ( (empty($_SESSION["user"])) || ($_SESSION["droits"] != "RJ") ) {
    header('Location: http://ja.de.pau.free.fr');
    exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="refresh" content="900">
        <title>JA de PAU </title>   
        <meta name="description" content="Planning et badge des JA de Pau">
        <meta name="keywords" content="JA, PAU, Badge, Adventiste, Jeunesse">
        <meta name="robots" content="index,follow">
        <meta name="google" content="index"> 
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="designJA.css">
        <script src="inscription.js"></script>
        
    </head>
    <body>
        <div class="container">
            <?php 
            include('entete.html');
            ?>
            <?php 
            include('barreNav.php');
            ?>
            <div class="row">
            
            <?php
            $servername = "sql.free.fr";
            $username = "ja.de.pau";
            $password = "Sq7:P@ss";   
            $dbname = "ja_de_pau";

            $civilite = "";
            $nom = "";
            $nomJeuneFille = "";
            $prenom = "";
            $nationalite = "Française";
            $adressePostale = "";
            $adresseCP = "";
            $adresseVille = "";
            $email = "";
            $numeroTel = "";
            $dateNaissance = "";
            $lieuNaissance = "";
            $departementNaissance = "";
            $numSecu = "";
            $nomCaisse = "";
            $aPaye = "";
            // TODO
            $idPere = "";
            $idMere = "";
            $idSection = "";
            $okInterventionMedicale = "";
            $okPhotos = "";
            $okComuniquerRenseignements = "";

            //Verifier la modification d'un user
            if (!empty($_GET["adh"])) {
                echo 'salut' ;
                
                // Connexion à la BDD
                $db = connecterBDD($servername, $username, $password);
                mysql_select_db($dbname, $db);
                mysql_query("SET NAMES 'utf8'");
                
                // Récupérer les différentes activités Tisons du futur
                $sql = "SELECT * FROM Adherent, Adresse WHERE adresse = idAdresse AND idAdherent=".$_GET["adh"];
                $result = mysql_query($sql, $db) or exit(mysql_error() . "<br/>$sql");
                $row = mysql_fetch_assoc($result);
                
                $civilite = $row["civilite"];
                $nom = $row["nom"];
                $nomJeuneFille = $row["nomJeuneFille"];
                $prenom = $row["prenom"];
                $nationalite = $row["nationalite"];
                $adressePostale = $row["adressePostale"];
                $adresseCP = $row["adresseCP"];
                $adresseVille = $row["adresseVille"];
                $email = $row["email"];
                $numeroTel = $row["numeroTel"];
                $dateNaissance = $row["dateNaissance"];
                $lieuNaissance = $row["lieuNaissance"];
                $departementNaissance = $row["departementNaissance"];
                $numSecu = $row["numSecu"];
                $nomCaisse = $row["nomCaisse"];
                $aPaye = $row["aPaye"];
                // TODO
                $idPere = $row["idPere"];
                $idMere = $row["idMere"];
                $idSection = $row["idSection"];
                $okInterventionMedicale = $row["okInterventionMedicale"];
                $okPhotos = $row["okPhotos"];
                $okComuniquerRenseignements = $row["okComuniquerRenseignements"];
                
                deconnecterBDD($db);
                
                $modif=true;
            } else {
                $modif=false;
            }

            ?>
				<div class="panel ">
					<div class="panel-heading"><h2> 
					<?php if ($modif) { ?>
					Adhérent : <?php echo $nom." ".$prenom;  } else { echo "Nouvel Adhérent"; } ?> </h2></div>
					<div class="panel-body">
						<form class="form-horizontal" action="" method="POST">
						<?php 
						if ($modif) {
                                                    echo "<input type='hidden' name='idAdherent' value='".$_GET["adh"]."' >";
						}
						?>
						<fieldset>
						<legend> Coordonnées de l'adhérent </legend>
						<div class="form-group">
						  <label class="control-label col-sm-2" for="civilite">Civilité*:</label>
						  <div class="col-sm-10">
							<label class="radio-inline"><input type="radio" name="civilite" value="M">M</label>
							<label class="radio-inline"><input type="radio" name="civilite" value="Mme">Mme</label>
							<label class="radio-inline"><input type="radio" name="civilite" value="Mlle">Mlle</label>
						  </div>
						</div>
						<div class="form-group">
							<div>
							  <label class="control-label col-sm-2" for="nom">Nom*:</label>
							  <div class="col-sm-4">
                                                                <?php if ($modif) { 
                                                                echo '<input type="text" onfocusout="nomSaisi(this)" class="form-control" id="nom" value="'.$nom.'" name="nom">';
                                                                } else { ?>
								<input type="text" onfocusout="nomSaisi(this)" class="form-control" id="nom" placeholder="Saisir le nom" name="nom">
								<?php } ?>
							  </div>
							</div>
							<div>
							  <label class="control-label col-sm-2" for="nomJF">Nom de jeune fille:</label>
							  <div class="col-sm-4">
							  <?php if ($modif) { 
                                                                echo '<input type="text" class="form-control" id="nomJF" value="'.$nomJeuneFille.'" name="nomJF">';
                                                                } else { ?>
								<input type="text" class="form-control" id="nomJF" placeholder="Saisir le nom de jeune fille" name="nomJF">
                                                         <?php } ?>
							  </div>
							</div>
						</div>
						<div class="form-group">
							<div>
							  <label class="control-label col-sm-2" for="prenom">Prénom*:</label>
							  <div class="col-sm-4">
							  <?php if ($modif) { 
                                                                echo '<input type="text" onfocusout="nomSaisi(this)" class="form-control" id="prenom" value="'.$prenom.'" name="prenom">';
                                                                } else { ?>
								<input type="text" onfocusout="nomSaisi(this)" class="form-control" id="prenom" placeholder="Saisir le prénom" name="prenom">
                                                          <?php } ?>
							  </div>
							</div>
							<div class=" has-success has-feedback">
							  <label class="control-label col-sm-2" for="nationalite">Nationalité:</label>
							  <div class="col-sm-4">
							  <?php if ($modif) { 
                                                                echo '<input type="text" class="form-control" id="nationalite" value="'.$nationalite.'" name="nationalite">';
                                                                } else { ?>
								<input type="text" class="form-control" id="nationalite" value="Française" name="nationalite">
								<?php } ?>
								<span class="glyphicon glyphicon-ok form-control-feedback"></span>
							  </div>
							</div>
						</div>
						<div class="form-group" >
						  <label class="control-label col-sm-2" for="dateNaissance">Date de naissance*:</label>
						  <div class="col-sm-2">
                                                    <?php if ($modif) { 
                                                        //TODO : Mettre la date dans le bon sens (JJ avant MM)
                                                        echo '<input type="date" onfocusout="display_DivMineur(this)" class="form-control" id="dateNaissance" value="'.$dateNaissance.'" name="dateNaissance">';
                                                        } else { ?>
							<input type="date" onfocusout="display_DivMineur(this)" class="form-control" id="dateNaissance" placeholder="JJ/MM/AAAA" name="dateNaissance">
							<?php } ?>
						  </div>
						  <label class="control-label col-sm-2" for="lieuNaissance">Lieu de Naissance*:</label>
						  <div class="col-sm-2">
						  <?php if ($modif) { 
                                                        echo '<input type="text" class="form-control" id="lieuNaissance" value="'.$lieuNaissance.'" name="lieuNaissance">';
                                                        } else { ?>
							<input type="text" class="form-control" id="lieuNaissance" placeholder="Saisir la ville de naissance" name="lieuNaissance">
							<?php  } ?>
						  </div>
						  <label class="control-label col-sm-2" for="departement">Département*:</label>
						  <div class="col-sm-2">
						  <?php if ($modif) { 
                                                        echo '<input type="text" class="form-control" id="departement" value="'.$departementNaissance.'" name="departement">';
                                                        } else { ?>
							<input type="text" class="form-control" id="departement" placeholder="Saisir le département de naissance" name="departement">
							<?php } ?>
						  </div>
						</div>
						<div class="form-group">
						  <label class="control-label col-sm-2" for="adresseRue">Adresse*:</label>
						  <div class="col-sm-10">
						  <?php if ($modif) { 
                                                        echo '<input type="text" onfocusout="copy_AddressInput(this)" class="form-control" id="adresseRue" value="'.$adressePostale.'" name="adresseRue">';
                                                        } else { ?>
							<input type="text" onfocusout="copy_AddressInput(this)" class="form-control" id="adresseRue" placeholder="Saisir l'adresse" name="adresseRue">
							<?php } ?>
						  </div>
						</div>
						<div class="form-group">
						  <label class="control-label col-sm-2" for="codePostale">Code postale*:</label>
						  <div class="col-sm-2">
						  <?php if ($modif) { 
                                                        echo '<input type="text" onfocusout="copy_AddressInput(this)" class="form-control" id="codePostale" value="'.$adresseCP.'" name="codePostale">';
                                                        } else { ?>
							<input type="text" onfocusout="copy_AddressInput(this)" class="form-control" id="codePostale" placeholder="Saisir le code postale" name="codePostale">
							<?php } ?>
						  </div>
						  <label class="control-label col-sm-2" for="ville">Ville*:</label>
						  <div class="col-sm-6">
						  <?php if ($modif) { 
                                                        echo '<input type="text" onfocusout="copy_AddressInput(this)" class="form-control" id="ville" value="'.$adresseVille.'" name="ville">';
                                                        } else { ?>
							<input type="text" onfocusout="copy_AddressInput(this)" class="form-control" id="ville" placeholder="Saisir la ville" name="ville">
							<?php } ?>
						  </div>
						</div>
						<div class="form-group">
						  <label class="control-label col-sm-2" for="telFixe">Téléphone fixe:</label>
						  <div class="col-sm-4">
						  <?php if ($modif) { 
                                                        echo '<input type="text" class="form-control" id="telFixe" value="'.$telFixe.'" name="telFixe">';
                                                        } else { ?>
							<input type="text" class="form-control" id="telFixe" placeholder="0559000000" name="telFixe">
							<?php } ?>
						  </div>
						  <label class="control-label col-sm-2" for="telPortable">Téléphone portable:</label>
						  <div class="col-sm-4">
						  <?php if ($modif) { 
                                                        echo '<input type="text" class="form-control" id="telPortable" value="'.$telPortable.'" name="telPortable">';
                                                        } else { ?>
							<input type="text" class="form-control" id="telPortable" placeholder="0600000000" name="telPortable">
							<?php } ?>
						  </div>
						</div>
						<div class="form-group">
						  <label class="control-label col-sm-2" for="email">Email:</label>
						  <div class="col-sm-10">
						  <?php if ($modif) { 
                                                        echo '<input type="email" class="form-control" id="email" value="'.$email.'" name="email">';
                                                        } else { ?>
							<input type="email" class="form-control" id="email" placeholder="exemple@domaine.com" name="email">
							<?php } ?>
						  </div>
						</div>
						<div class="form-group">
						  <label class="control-label col-sm-2" for="numSecu">Numéro de sécurité sociale:</label>
						  <div class="col-sm-4">
						  <?php if ($modif) { 
                                                        echo '<input type="text" class="form-control" id="numSecu" value="'.$numSecu.'" name="numSecu">';
                                                        } else { ?>
							<input type="text" class="form-control" id="numSecu" placeholder="Saisir le numero de sécurité sociale" name="numSecu">
							<?php } ?>
						  </div>
						  <label class="control-label col-sm-2" for="caisseSecu">Nom de la caisse:</label>
						  <div class="col-sm-4">
						  <?php if ($modif) { 
                                                        echo '<input type="text" class="form-control" id="caisseSecu" value="'.$caisseSecu.'" name="caisseSecu">';
                                                        } else { ?>
							<input type="text" class="form-control" id="caisseSecu" placeholder="Saisir le nom de la caisse" name="caisseSecu">
							<?php } ?>
						  </div>
						</div>
						</fieldset>
						<div id="mineur"  style="display:none">
                                                    <fieldset>
							<legend> Coordonnées du ou des parents responsable(s) du mineur  </legend>
							<div class="form-group">
							  <label class="control-label col-sm-2" for="nomPere">Nom du père:</label>
							  <div class="col-sm-4">
								<input type="text" class="form-control" id="nomPere" placeholder="Saisir le nom du père" name="nomPere">
							  </div>
							  <label class="control-label col-sm-2" for="nomMere">Nom de la mère:</label>
							  <div class="col-sm-4">
								<input type="text" class="form-control" id="nomMere" placeholder="Saisir le nom de la mère" name="nomMere">
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-2" for="prenomPere">Prénom du père:</label>
							  <div class="col-sm-4">
								<input type="text" class="form-control" id="prenomPere" placeholder="Saisir le prénom du père" name="prenomPere">
							  </div>
							  <label class="control-label col-sm-2" for="prenomMere">Prénom de  la mère:</label>
							  <div class="col-sm-4">
								<input type="text" class="form-control" id="prenomMere" placeholder="Saisir le prénom de la mère" name="prenomMere">
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-2" for="telPortablePere">Téléphone portable du père:</label>
							  <div class="col-sm-4">
								<input type="text" class="form-control" id="telPortablePere" placeholder="0600000000" name="telPortablePere">
							  </div>
							  <label class="control-label col-sm-2" for="telPortableMere">Téléphone portable de la mère:</label>
							  <div class="col-sm-4">
								<input type="text" class="form-control" id="telPortableMere" placeholder="0600000000" name="telPortableMere">
							  </div>
							</div>
							<div class="form-group">
							  <label class="control-label col-sm-2" for="emailPere">Email du père:</label>
							  <div class="col-sm-4">
								<input type="email" class="form-control" id="emailPere" placeholder="exemple@domaine.com" name="emailPere">
							  </div>
							  <label class="control-label col-sm-2" for="emailMere">Email de la mère:</label>
							  <div class="col-sm-4">
								<input type="email" class="form-control" id="emailMere" placeholder="exemple@domaine.com" name="emailMere">
							  </div>
							</div>
							<div class="form-group">        
							  <div class="col-sm-offset-2 col-sm-10">
								<div class="checkbox">
								  <label><input type="checkbox" onchange="change_checkbox(this)" id="adressePereIdentiqueEnfant" name="adressePereIdentiqueEnfant"> Cocher si l'adresse est différente pour le père et la mère</label>
								</div>
							  </div>
							</div>
							<div id="adressePere">
								<div class="form-group">
								  <label class="control-label col-sm-2" for="adresseRuePere">Adresse:</label>
								  <div class="col-sm-10">
									<input type="text" class="form-control" id="adresseRuePere" placeholder="Saisir l'adresse" name="adresseRuePere">
								  </div>
								</div>
								<div class="form-group">
								  <label class="control-label col-sm-2" for="codePostalePere">Code postale:</label>
								  <div class="col-sm-2">
									<input type="text" class="form-control" id="codePostalePere" placeholder="Saisir le code postale" name="codePostalePere">
								  </div>
								  <label class="control-label col-sm-2" for="villePere">Ville:</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" id="villePere" placeholder="Saisir la ville" name="villePere">
								  </div>
								</div>
							</div>
							<div id="adresseMere" style="display:none">
								<div class="form-group">
								  <label class="control-label col-sm-2" for="adresseRueMere">Adresse (Mère):</label>
								  <div class="col-sm-10">
									<input type="text" class="form-control" id="adresseRueMere" placeholder="Saisir l'adresse" name="adresseRueMere">
								  </div>
								</div>
								<div class="form-group">
								  <label class="control-label col-sm-2" for="codePostaleMere">Code postale:</label>
								  <div class="col-sm-2">
									<input type="text" class="form-control" id="codePostaleMere" placeholder="Saisir le code postale" name="codePostaleMere">
								  </div>
								  <label class="control-label col-sm-2" for="villeMere">Ville:</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" id="villeMere" placeholder="Saisir la ville" name="villeMere">
								  </div>
								</div>
							</div>
                                                    </fieldset>
                                                </div>
                                                <fieldset>
						<legend> Identité JA  </legend>
						<div class="form-group">
						  <label class="control-label col-sm-2" for="antenne">Antenne Locale:</label>
						  <div class="col-sm-4">
							<input type="text" class="form-control" id="antenne" value="PAU" name="antenne">
						  </div>
						  <label class="control-label col-sm-2" for="sectionJA">Section:</label>
						  <div class="col-sm-4">
							<input type="text" class="form-control" id="sectionJA" placeholder="Générer en PHP les choix" name="sectionJA">
						  </div>
						</div>
						<div class="form-group">        
						  <div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
							  <label><input type="checkbox" checked id="okInterventionMedicale" name="okInterventionMedicale"> 
							  J’autorise le directeur de l’antenne locale ou le responsable de la section à faire pratiquer sur <span id="interventionMineur">moi</span> 
							  une intervention chirurgicale sous anesthésie générale en cas d’urgence.</label>
							</div>
						  </div>
						</div>
						<div class="form-group">        
						  <div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
							  <label><input type="checkbox" checked id="okPhotos" name="okPhotos"> 
							  J’autorise l’UFBJA à utiliser les photos, prises lors des activités JA, dans les documents et les publications d’information JA, de la
							  Revue Adventiste ou sur le site <a href="http://www.ffs.adventiste.org">www.ffs.adventiste.org</a>. Ces photos sont libres de droit et seul l’UFBJA et ses associations
							  membres auront le droit de les utiliser.
							</div>
						  </div>
						</div>
						<div class="form-group">        
						  <div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
							  <label><input type="checkbox" checked id="okInterventionMedicale" name="okInterventionMedicale"> 
							  Je m’engage en tant que titulaire de l’adhésion ou en tant que parent pour les mineurs, à communiquer aux responsables de section
							  tous les renseignements qui permettraient d’assurer le suivi de l’enfant ou du jeunes lors des sorties ou des activités et ceci <b>toute
							  l’année</b> (santé, état civile, responsable du mineur, etc.).
							</div>
						  </div>
						</div>
						</fieldset>
						</form>
					</div>
				</div>
				
            </div>
        <?php 
        include('piedPage.html');
        ?>
        </div>
    </body>
</html> 
