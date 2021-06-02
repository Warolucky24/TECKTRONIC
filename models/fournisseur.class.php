<?php

class Fournisseurs{
    private $NumFour;
    private $NomFour;
    private $AdresseFour;
    private $CodePostalFour;
    private $VilleFour;

    public function __construct($NumFour, $NomFour, $AdresseFour, $CodePostalFour, $VilleFour){
        $this->NumFour          = $NumFour;
        $this->NomFour          = $NomFour;
        $this->AdresseFour      = $AdresseFour;
        $this->CodePostalFour   = $CodePostalFour;
        $this->VilleFour        = $VilleFour;
    }

    public function getNumFour(){return $this->NumFour;}
    public function setNumFour($NumFour){$this->NumFour = $NumFour;}

    public function getNomFour(){return $this->NomFour;}
    public function setNomFour($NomFour){$this->NomFour = $NomFour;}

    public function getAdresseFour(){return $this->AdresseFour;}
    public function setAdresseFour($AdresseFour){$this->AdresseFour = $AdresseFour;}

    public function getCodePostalFour(){return $this->CodePostalFour;}
    public function setCodePostalFour($CodePostalFour){$this->CodePostalFour = $CodePostalFour;}

    public function getVilleFour(){return $this->VilleFour;}
    public function setVilleFour($VilleFour){$this->VilleFour = $VilleFour;}
}