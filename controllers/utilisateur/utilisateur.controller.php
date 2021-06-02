<?php


require_once "./models/produitManagement.class.php";
require_once "./controllers/MainController.php";


class UtilisateurController extends MainController{
    private $ProduitManager;
    private $utilisateurManager;
    private $FournisseurManager;

    public function __construct()
    {
        $this->ProduitManager = new ProduitManager;
        $this->ProduitManager->chargementProduits();
        $this->ProduitManager->chargementCategories();
        $this->FournisseurManager = new FournisseurManager;
        $this->FournisseurManager->chargementFournisseur();
        $this->utilisateurManager = new ClientManager;
    }


    public function afficherAccueil()
    {
        $data_page = [
            "produits" => $this->ProduitManager->getProduits(),
            "view" => "views/utilisateur/accueil.view.php",
            "template" => "./views/commun/templace.php"
        ];
        $this->genererPage($data_page);
    }

    public function afficherProduits(){
        if (isset($_POST['ajoutPanier'])) {
            $this->utilisateurManager->ajoutValeur($_POST['ajoutPanier']);
        }
        $data_page = [
            "produits" => $this->ProduitManager->getProduits(),
            "categories" => $this->ProduitManager->getCategories(),
            "view" => "./views/utilisateur/produits.view.php",
            "template" => "./views/commun/templace.php"
        ];
        $this->genererPage($data_page);
    }
    

    public function afficherProduit($id)
    {
        if (isset($_POST['ajoutPanier'])) {
            $this->utilisateurManager->ajoutValeur($_POST['ajoutPanier']);
        }
        $data_page = [
            "produits" => $this->ProduitManager->getProduitById($id),
            "view" => "./views/utilisateur/produit.detail.view.php",
            "template" => "./views/commun/templace.php"
        ];
        $this->genererPage($data_page);
    }

    public function afficherInscription()
    {
        $data_page = [
            "page_title" => "Page d'inscription",
            "view" => "./views/utilisateur/inscription.view.php",
            "template" => "./views/commun/templace.php"
        ];
        $this->genererPage($data_page);
    }


    public function afficherMonCompte(){
        $data_page = [
            "page_title" =>  "Mon compte : ".$this->utilisateurManager->getPrenomUser($_SESSION['email']),
            "view" => "./views/utilisateur/monCompte.view.php",
            "informationUser" => $this->utilisateurManager->getInformationUser($_SESSION['email']),
            "page_javascript" => ['modificationMonCompte.js'] ,
            "template" => "./views/commun/templace.php"
        ];
        $this->genererPage($data_page);
    }

    public function afficherConnection()
    {
        $data_page = [
            "page_title" => "Page de connexion",
            "view" => "./views/utilisateur/connexion.view.php",
            "template" => "./views/commun/templace.php"
        ];
        $this->genererPage($data_page);
    }


    public function validation_login($mail, $password){
      if($this->utilisateurManager->isCombinaisonValide($mail,$password)){
          $prenomUser = $this->utilisateurManager->getPrenomUser($mail);
          Toolbox::ajouterMessageAlerte('Bon retour sur le site '.$prenomUser." !",Toolbox::COULEUR_VERTE);
          $_SESSION['connect'] = 1;
          $_SESSION['email'] = $mail;
          if($mail === "admin@admin.fr"){
              $_SESSION['admin'] = 1;
          }
          header('location: '.URL.'compte');
      }else{
          Toolbox::ajouterMessageAlerte('Combinaison Log / Mot de passe non valide', Toolbox::COULEUR_ROUGE);
          header('location: '.URL.'connection');
      }
    }

    public function validation_inscription($nom, $prenom, $adresse, $ville, $codePostal, $email, $pass){
        if($this->utilisateurManager->verifEmailDisponible($email)){
            $passCrypter = cryptageMdp($pass);
            if($this->utilisateurManager->bdInscription($nom,$prenom,$adresse,$ville,$codePostal,$email,$passCrypter)){
                Toolbox::ajouterMessageAlerte('Le compte a bien été crée !', Toolbox::COULEUR_VERTE);
                header('location: '.URL.'connection');
            }else{
                Toolbox::ajouterMessageAlerte('Erreur lors de la création du compte, recommencez !', Toolbox::COULEUR_ORANGE);
            }
        }else{
            Toolbox::ajouterMessageAlerte("L'adresse mail esiste déjà !", Toolbox::COULEUR_ROUGE);
            header("Location: " . URL . "inscription");
        }
    }

    public function afficherPanier(){
        if (isset($_POST['SupNumProd'])) {
            $this->utilisateurManager->supprimerValeur($_POST['SupNumProd']);
        }
        if (isset($_POST['AjoutNumProd'])) {
            $this->utilisateurManager->ajoutValeur($_POST['AjoutNumProd']);
        }
        if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) {
            $data_page = [
                "page_title" => "Panier",
                "produits" => $this->ProduitManager->getProduits(),
                "panier" => $this->utilisateurManager->trierTableau($_SESSION['panier']),
                "view" => "./views/utilisateur/panier.view.php",
                "template" => "./views/commun/templace.php"
            ];
        }else{
            $data_page = [
                "page_title" => "Panier",
                "view" => "./views/utilisateur/panier.view.php",
                "template" => "./views/commun/templace.php"
            ];
        }
        $this->genererPage($data_page);
    }

    public function modificationBd($newModif,$nameColumn){

        if($newModif == $this->utilisateurManager->getInformationUser($_SESSION['email'])[$nameColumn]){
            header('location: '.URL.'compte');
        }else{
            $designation = $nameColumn;
            if($this->utilisateurManager->bdModificationClient($designation, $newModif)){
                Toolbox::ajouterMessageAlerte("Modification effectué !", Toolbox::COULEUR_VERTE);
                header('location: ' . URL . 'compte');
            } else {
                Toolbox::ajouterMessageAlerte('Erreur lors de la modification. réessayer !', Toolbox::COULEUR_ORANGE);
                header('location: ' . URL . 'compte');
            }
        }
    }
    
    public function afficherPageModifPass(){
            $data_page = [
                "page_javascript" => ['modifPass.js'],
                "page_title" => "Modification de votre password",
                "view" => "./views/utilisateur/modifPass.view.php",
                "template" => "./views/commun/templace.php"
            ];

        $this->genererPage($data_page);

    }

    public function modificationMotDePasse($AncienPass, $NewPass){
        $clients = $this->utilisateurManager->getInformationUser($_SESSION['email']);
        if($clients['Password'] === cryptageMdp($AncienPass)){
            $newPassCrypter = cryptageMdp($NewPass);
            $designation = 'Password';
            $this->modificationBd($newPassCrypter, $designation);
            Toolbox::ajouterMessageAlerte('Mot de passe changé !', Toolbox::COULEUR_VERTE);
            header('location: '.URL.'compte');
        }else{
            Toolbox::ajouterMessageAlerte('Le mot de passe actuel n\'est pas bon !', Toolbox::COULEUR_ROUGE);
            header('location: '.URL. 'modificationPassword');
        }
    }
}
