<?php
session_start();


define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));
require "./controllers/function.php";
require "./controllers/utilisateur/utilisateur.controller.php";
require "./controllers/admin/admin.controller.php";
$UtilisateurController = new UtilisateurController;
$AdminController = new AdminController;
try {
	if (empty($_GET['page'])) {
		$UtilisateurController->afficherAccueil();
	} else {
		$url = explode("/", filter_var($_GET['page']), FILTER_SANITIZE_URL);
			switch ($url[0]) {
				case "accueil":
					$UtilisateurController->afficherAccueil();
				break;
				case "produit":
					if(!isset($url['1'])){
						$UtilisateurController->afficherProduits();
					}else{
						$UtilisateurController->afficherProduit($url['1']);
					}
				break;
				case "connection":
					if(est_connecter()){
						Toolbox::ajouterMessageAlerte('Vous êtes dèjà connecté' , Toolbox::COULEUR_ROUGE);
						header('location: '.URL.'accueil');
					}else{
						$UtilisateurController->afficherConnection();
					}
				break;
                case "validation_login":
					if(est_connecter()){
						Toolbox::ajouterMessageAlerte('Vous êtes dèjà connecté', Toolbox::COULEUR_ROUGE);
						header('location: ' . URL . 'accueil');
					}else{
						if (!empty($_POST['email']) && !empty($_POST['pass'])) {
							$email = dataSecure($_POST['email']);
							$password = dataSecure($_POST['pass']);
							$UtilisateurController->validation_login($email, $password);
						} else {
							Toolbox::ajouterMessageAlerte("Login ou mot de passe non renseigné !", Toolbox::COULEUR_ROUGE);
							header('location: ' . URL . "connection");
						}
					}
				break;
				case "compte":
					if(est_connecter()){
						$UtilisateurController->afficherMonCompte();
					}else{
						Toolbox::ajouterMessageAlerte('Vous devez vous connecter !', Toolbox::COULEUR_ROUGE);
						header('location: ' . URL . 'accueil');
					}
				break;
				case "inscription":
					if(est_connecter()){
						Toolbox::ajouterMessageAlerte('Vous êtes dèjà connecté', Toolbox::COULEUR_ROUGE);
						header('location: ' . URL . 'accueil');
					}else{
						$UtilisateurController->afficherInscription();
					}
				break;
				case "validation_inscription":
					if(est_connecter()){
						Toolbox::ajouterMessageAlerte('Vous êtes dèjà connecté', Toolbox::COULEUR_ROUGE);
						header('location: ' . URL . 'accueil');
					}else{
						if(!empty($_POST['nom']) && 
							!empty($_POST['prenom']) && 
							!empty($_POST['adresse']) && 
							!empty($_POST['ville']) && 
							!empty($_POST['codePostale']) &&
							!empty($_POST['email']) &&
							!empty($_POST['pass']) &&
							!empty($_POST['pass2'])
						){
							if(dataSecure($_POST['pass']) == dataSecure($_POST['pass2'])){
							$nom = dataSecure($_POST['nom']);
							$prenom = dataSecure($_POST['prenom']);
							$adresse = dataSecure($_POST['adresse']);
							$ville = dataSecure($_POST['ville']);
							$codePostal = dataSecure($_POST['codePostale']);
							$email = dataSecure($_POST['email']);
							$pass = dataSecure($_POST['pass']);
							$UtilisateurController->validation_inscription($nom,$prenom, $adresse,$ville, $codePostal, $email, $pass);
							}else{
								Toolbox::ajouterMessageAlerte('Les mots de passe ne sont pas identitque !', Toolbox::COULEUR_ORANGE);
								header('location: ' . URL . 'inscription');
							}
						}else{
							Toolbox::ajouterMessageAlerte('Données d\'entrées manquantes !', Toolbox::COULEUR_ROUGE);
							header('location: ' . URL . 'inscription');
						}
					}
				break;
				case "panier":
					if(isset($_SESSION['connect'])){
						$UtilisateurController->afficherPanier();
					}else{
						Toolbox::ajouterMessageAlerte('Connectez-vous pour accéder au panier.', Toolbox::COULEUR_ROUGE);
						header('location: '.URL.'accueil');
					}
				break;

				// modification information compte
				case "modif_Prenom":
					if(isset($_POST['newPrenom'])){
						$newPrenom = dataSecure($_POST['newPrenom']);
						$UtilisateurController->modificationBd($newPrenom, "PrenomClient");
					}else{
						header('location: '.URL.'compte');
					}
				break;
				case "modif_Nom":
					if(isset($_POST['newNom'])){
						$newNom = dataSecure($_POST['newNom']);
						$UtilisateurController->modificationBd($newNom,"NomClient");
					}else{
						header('location: '.URL.'compte');
					}
				break;
				case "modif_Adresse":
					if(isset($_POST['newAdresse'])) {
						$newAdresse = dataSecure($_POST['newAdresse']);
						$UtilisateurController->modificationBd($newAdresse,'AdresseClient');
					}else {
						header('location: ' . URL . 'compte');
					}
				break;
				case "modif_CodePostal":
					if(isset($_POST['newCodePostal'])){
						$newCodePostal = dataSecure($_POST['newCodePostal']); 
						$UtilisateurController->modificationBd($newCodePostal, 'CodePostalClient');
					}else{
						header('location: '.URL.'compte');
					}
				break;
				case "modif_Ville":
					if(isset($_POST['newVille'])){
						$newVille = dataSecure($_POST['newVille']);
						$UtilisateurController->modificationBd($newVille, 'VilleClient');
					}else{
						header('location: ' . URL . 'compte');
					}
				break;
				case "modificationPassword":
					if(isset($_SESSION['connect'])){
						$UtilisateurController->afficherPageModifPass();
					}else{
						Toolbox::ajouterMessageAlerte('Vous n\'êtes pas connecté !', Toolbox::COULEUR_ROUGE);
						header('location: ' . URL . 'accueil');
					}
				break;
				case "modif_pass":
					if(isset($_POST['AncienPass']) && isset($_POST['NewPass']) && isset($_POST['NewPass2'])){
						$AncienPass = dataSecure($_POST['AncienPass']);
						$NewPass = dataSecure($_POST['NewPass']);
						$NewPass2 = dataSecure($_POST['NewPass2']);
						var_dump($NewPass,$NewPass2);
						if($NewPass === $NewPass2){
							$UtilisateurController->modificationMotDePasse($AncienPass, $NewPass);
						}else{
							Toolbox::ajouterMessageAlerte('Les mots de passe ne sont pas identique !', Toolbox::COULEUR_ORANGE);
							header('location: ' . URL . 'modificationPassword');
						}
					}else{
						Toolbox::ajouterMessageAlerte('Données d\'entrée manquante !',Toolbox::COULEUR_ORANGE);
						header('location: '.URL. 'modificationPassword');
					}
				break;

				case "gestionProd":
					if(!isset($url['1'])){
						$AdminController->affichagerGestionProd();
					}else if($url['1'] == 'AjoutProduit'){
						$AdminController->afficherAjoutProd();
					}else{
						$AdminController->afficherModifProduit($url['1']);
					}
				break;
                case "fournisseurs":
					if(isset($_SESSION['admin'])){
						if (!isset($url['1'])) {
							$AdminController->afficherGestionFour();
						} else {
							// $mainController->afficherModifFour($url['1']);
						}
					}else{
						Toolbox::ajouterMessageAlerte('Vous devez être Admin ! ', Toolbox::COULEUR_ROUGE);
						header('location: '.URL.'accueil');
					}
                break;
				case "catégories":
					if(isset($_SESSION['admin'])){
						$AdminController->afficherCategories();
					}else{
						Toolbox::ajouterMessageAlerte('Vous devez être Admin ! ', Toolbox::COULEUR_ROUGE);
						header('location: ' . URL . 'accueil');
					}
				break;

				


				// case "contact":
				// 	require "views/contact.view.php";
				// break;




				case "logout":
					require "views/utilisateur/logout.php";
				break;
				default:
					throw new Exception("La page n'existe pas");
			}
		}
} catch (Exception $e) {
	echo $e->getMessage();
}
