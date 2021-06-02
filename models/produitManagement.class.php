<?php
require_once "bdd.class.php";
require_once "produit.class.php";
require_once "categorie.class.php";


class ProduitManager extends Bdd{
    private $produits; // tableau de met produits
    private $categories;

    // ajouter un produit
    public function ajoutProduit($produit){
        $this->produits[] = $produit;
    }
    public function ajoutCat($cat){
        $this->categories[] = $cat;
    }

    public function getProduits(){
        return $this->produits;
    }
    public function getCategories(){
        return $this->categories;
    }
    public function getProduitById($id){
        for($i = 0 ; $i < count($this->produits); $i++){
            if($this->produits[$i]->getNumProd() == $id){
                return $this->produits[$i];
            }
        }
    }
    public function chargementProduits(){
        $req = $this->getBdd()->prepare("SELECT * FROM produits");
        $req->execute();
        $lesProduits = $req->fetchAll();

        foreach($lesProduits as $prod){
            $p = new Produit($prod['NumProd'], 
                            $prod['NomProd'], 
                            $prod['PrixProd'], 
                            $prod['QteProd'], 
                            $prod['SeuilReappro'], 
                            $prod['Caracteristiques'], 
                            $prod['Couleur'], 
                            $prod['Largeur'], 
                            $prod['Longueur'], 
                            $prod['Profondeur'],
                            $prod['Poids'],
                            $prod['Image'],
                            $prod['NumCat']
                            );
            $this->ajoutProduit($p);

        }
    }


    
    public function chargementCategories(){
        $req = $this->getBdd()->prepare("SELECT * FROM categories");
        $req->execute();
        $lesCat =  $req->fetchAll();
        
        foreach($lesCat as $categorie){
            $c = new Categories($categorie['NumCat'], $categorie['LibCat']);
            $this->ajoutCat($c);
        }

    }


}