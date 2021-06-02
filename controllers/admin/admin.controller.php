<?php

require_once "./controllers/MainController.php";
require_once "./models/fournisseurManagement.class.php";
require_once "./models/produitManagement.class.php";

class AdminController extends MainController{
    private $FournisseurManager;
    private $ProduitManager;
    private $AdminManager;

    public function __construct()
    {
        $this->FournisseurManager = new FournisseurManager;
        $this->FournisseurManager->chargementFournisseur();
        $this->ProduitManager = new ProduitManager;
        $this->ProduitManager->chargementProduits();
        $this->ProduitManager->chargementCategories();
        
    }

    public function affichagerGestionProd(){
        $data_page = [
            "page_title" => "Gestion des produits",
            "produits" => $this->ProduitManager->getProduits(),
            "view" => "views/admin/gestionProd.view.php",
            "template" => "./views/commun/templace.php"
        ];
        $this->genererPage($data_page);

    }
    public function afficherAjoutProd(){
        $data_page = [
            "page_title" => "Ajoutez un produit",
            "view" => "views/admin/ajoutProduit.view.php",
            "categories" => $this->ProduitManager->getCategories(),
            "template" => "views/commun/templace.php"
        ];
        $this->genererPage($data_page);
    }



    public function afficherModifProduit($NumProd){
        $produits = $this->ProduitManager->getProduits();
        for($i = 0 ; $i < count($produits) ; $i++){
            if($produits[$i]->getNumProd() === $NumProd){
                $produit = $produits[$i];
            }
        }
        $data_page = [
            "page_title" => "Modification du produit",
            "produits" => $produit,
            "categories" => $this->ProduitManager->getCategories(),
            "view" => "views/admin/modifierProduit.view.php",
            "template" => "./views/commun/templace.php"
        ];
        $this->genererPage($data_page);
    }

    public function afficherGestionFour(){
        $data_page = [
            "page_title" => "Gestion des fournisseurs",
            "fournisseurs" => $this->FournisseurManager->getFournisseurs(),
            "view" => "views/admin/fournisseur.view.php",
            "template" => "./views/commun/templace.php"
        ];
        $this->genererPage($data_page);

    }

    public function afficherCategories(){
        $data_page = [
            "page_title" => "Gestion des catégories",
            "categories" =>$this->ProduitManager->getCategories(),
            "view" => "views/admin/categorie.view.php",
            "template" => "./views/commun/templace.php"
        ];
        $this->genererPage($data_page);
    }
}