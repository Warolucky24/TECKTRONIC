<?php

class Produit{
    private $NumProd;
    private $NomProd;
    private $PrixProd;
    private $QteProd;
    private $SeuilReappro;
    private $Caractéristiques;
    private $Couleur;
    private $Largeur;
    private $Longueur;
    private $Profondeur;
    private $Poids;
    private $image;
    private $NumCat;


    public function __construct($NumProd, $NomProd, $PrixProd, $QteProd , $SeuilReappro, $Caractéristiques, $Couleur, $Largeur, $Longueur, $Profondeur, $Poids , $image , $NumCat){
        
        $this->NumProd              = $NumProd;
        $this->NomProd              = $NomProd;
        $this->PrixProd             = $PrixProd;
        $this->QteProd              = $QteProd;
        $this->SeuilReappro         = $SeuilReappro;
        $this->Caractéristiques     = $Caractéristiques;
        $this->Couleur              = $Couleur;
        $this->Largeur              = $Largeur;
        $this->Longueur             = $Longueur;
        $this->Profondeur           = $Profondeur;
        $this->Poids                = $Poids;
        $this->image                = $image;
        $this->NumCat               = $NumCat;


    }

    // numéro produit
    public function getNumProd(){return $this->NumProd;}
    public function setNumProd($NumProd){ $this->NumProd = $NumProd;}
    // Nom produit
    public function getNomProd(){return $this->NomProd;}
    public function setNomProd($NomProd){$this->NomProd = $NomProd;}
    // prix produit
    public function getPrixProd(){return $this->PrixProd;}
    public function setPrixProd($PrixProd){$this->PrixProd = $PrixProd;}
    // quantité de produit
    public function getQteProd(){return $this->QteProd;}
    public function setQteProd($QteProd){$this->NumProd = $QteProd;}
    // Seuil réappro
    public function getSeuilReappro(){return $this->SeuilReappro;}
    public function setSeuilReappro($SeuilReappro){$this->SeuilReappro = $SeuilReappro;}
    // Caractéristique
    public function getCaracteristiques(){return $this->Caractéristiques;}
    public function SetCaracteristiques($Caractéristiques){$this->Caractéristiques = $Caractéristiques;}
    // Couleur
    public function getCouleur(){return $this->Couleur;}
    public function setCouleur($Couleur){$this->Couleur = $Couleur;}
    // largeur
    public function getLargeur(){return $this->Largeur;}
    public function setLargeur($Largeur){$this->Largeur = $Largeur;}
    // longueur
    public function getLongueur(){return $this->Longueur;}
    public function setLongueur($Longueur){$this->Longueur = $Longueur;}
    // profondeur
    public function getProfondeur(){return $this->Profondeur;}
    public function setProfondeur($Profondeur){$this->Profondeur = $Profondeur;}
    // poids
    public function getPoids(){return $this->Poids;}
    public function setPoids($Poids){$this->Poids = $Poids;}
    // image
    public function getImage(){return $this->image;}
    public function setImage($image){$this->image = $image;}
    // numcat
    public function getNumCat(){return $this->NumCat;}
    public function setNumCat($NumCat){$this->NumCat = $NumCat;}
}
