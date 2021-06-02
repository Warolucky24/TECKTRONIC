<?php
require_once "bdd.class.php";
require_once "fournisseur.class.php";

class FournisseurManager extends Bdd{
    private $fournisseurs;

    public  function ajoutFournisseur($fournisseurs){
        $this->fournisseurs[] = $fournisseurs;
    }
    public function getFournisseurs(){
        return $this->fournisseurs;
    }
    public function chargementFournisseur(){
        $req = $this->getBdd()->prepare('SELECT * FROM fournisseurs');
        $req->execute();
        $lesFournisseurs = $req->fetchAll();

        foreach ($lesFournisseurs as $four){
            $f = new Fournisseurs($four['NumFour'],$four['NomFour'], $four['AdresseFour'], $four['CodePostalFour'], $four['VilleFour']);
            $this->ajoutFournisseur($f);
        }
    }
    public function getFournisseursById($id){
        for($i = 0 ; $i < count($this->fournisseurs); $i++){
            if($this->fournisseurs[$i]->getNumFour() == $id){
                return $this->fournisseurs[$i];
            }
        }
    }
}