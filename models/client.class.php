<?php

class Client {
    private $NumClient;
    private $NomClient;
    private $PrenomClient;
    private $adresseClient;
    private $codePostalClient;
    private $villeClient;
    private $emailClient;
    private $password;


    public function __construct($NumClient, $NomClient, $PrenomClient, $adresseClient, $codePostalClient, $villeClient, $emailClient, $password) 
    {
        $this->NumClient        = $NumClient;
        $this->NomClient        = $NomClient;
        $this->PrenomClient     = $PrenomClient;
        $this->AdresseClient    = $adresseClient;
        $this->codePostalClient = $codePostalClient;
        $this->villeClient      = $villeClient;
        $this->emailClient      = $emailClient;
        $this->password         = $password;
    }

    public function getNumClient(){return $this->NumClient;}
    public function setNumClient($NumClient){$this->NumClient = $NumClient;}

    public function getNomClient(){return $this->NomClient;}
    public function setNomClient($NomClient){$this->NomClient = $NomClient;}

    public function getPrenomClient(){return $this->PrenomClient;}
    public function setPrenomClient($PrenomClient){$this->PrenomClient = $PrenomClient;}

    public function getAdresse(){return $this->adresseClient;}
    public function setAdresse($adresseClient){$this->adresseClient = $adresseClient;}


    public function getCodePostal(){return $this->codePostalClient;}
    public function setCodePostal($codePostalClient){$this->codePostalClient = $codePostalClient;}

    public function getVille(){return $this->villeClient;}
    public function setVille($villeClient){$this->villeClient = $villeClient;}


    public function getEmail(){return $this->emailClient;}
    public function SetEmail($emailClient){$this->emailClient = $emailClient;}

    public function getPassword(){return $this->password;}
    public function SetPassword($password){$this->password = $password;}

    





}
