<?php

class Categories{
    private $NumCat;
    private $LibCat;


    public function __construct($NumCat, $LibCat)
    {
        $this->NumCat = $NumCat;
        $this->LibCat = $LibCat;
    }

    public function getNumCat(){return $this->NumCat;}
    public function setNumCat($NumCat){ $this->NumCat = $NumCat;}

    public function getLibCat(){return $this->LibCat;}
    public function setLibCat($LibCat){ $this->LibCat = $LibCat;}

}