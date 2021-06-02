<?php
require_once "./models/bdd.class.php";
require_once "./models/client.class.php";
require_once "./controllers/function.php";

class ClientManager extends Bdd{

   public function isCombinaisonValide($mail, $password){
       $passwordBD = $this->getPasswordUser($mail);
       $passChiffre = cryptageMdp($password);
       return $passChiffre === $passwordBD;
   }

     public function getInformationUser($mail)
     {
          $req = "SELECT * FROM clients WHERE EmailClient = :email";
          $stmt = $this->getBdd()->prepare($req);
          $stmt->bindValue(":email", $mail, PDO::PARAM_STR);
          $stmt->execute();
          $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
          $stmt->closeCursor();
          return $resultat;
     }

   public function getPrenomUser($mail)
   {
     return $this->getInformationUser($mail)['PrenomClient'];
   }
   public function getNomUser($email){
        return $this->getInformationUser($email)['NomClient'];
   }

     public function getPasswordUser($email)
     {
          return $this->getInformationUser($email)['Password'];
     }
     public function getAdresseUser($email)
     {
          return $this->getInformationUser($email)['AdresseClient'];
     }

   public function verifEmailDisponible($email){
        $utilisateur = $this->getInformationUser($email);
        return empty($utilisateur);
   }

   public function bdInscription($nom, $prenom, $adresse, $ville, $codePostal, $email, $pass){
        $req = "INSERT INTO `clients`(`NomClient`, `PrenomClient`, `AdresseClient`, `CodePostalClient`, `VilleClient`, `EmailClient`, `Password`) 
        VALUES (:NomClient, :PrenomClient, :AdresseClient, :CodePostalClient, :VilleClient, :EmailClient, :Password)";
        $stmt = $this->getBdd()->prepare($req);
          $stmt->bindValue(":NomClient",$nom , PDO::PARAM_STR);
          $stmt->bindValue(":PrenomClient", $prenom, PDO::PARAM_STR);
          $stmt->bindValue(":AdresseClient", $adresse, PDO::PARAM_STR);
          $stmt->bindValue(":CodePostalClient", $codePostal, PDO::PARAM_INT);
          $stmt->bindValue(":VilleClient", $ville, PDO::PARAM_STR);
          $stmt->bindValue(":EmailClient", $email, PDO::PARAM_STR);
          $stmt->bindValue(":Password", $pass, PDO::PARAM_STR);
          $stmt->execute();
          $estAjouter = ($stmt->rowCount() > 0);
          $stmt->closeCursor();
          return $estAjouter;
   }


   public function bdModificationClient($intitule, $modif){
          $req = "UPDATE clients SET ". $intitule." = :". $intitule." WHERE EmailClient = :EmailClient";
          $stmt = $this->getBdd()->prepare($req);
          $stmt->bindValue(':'.$intitule, $modif, PDO::PARAM_STR);
          $stmt->bindValue(':EmailClient', $_SESSION['email'], PDO::PARAM_STR);
          $stmt->execute();
          $estModifier = ($stmt->rowCount() > 0);
          $stmt->closeCursor();
          return $estModifier;
   }

     public function trierTableau($table)
     {
          sort($table);
          $cpt = 1;
          if (count($table) <= 1) {
               $resultat[] = [$table[0], $cpt];
          } else {
               for ($i = 1; $i < count($table); $i++) {
                    if ($table[$i - 1] == $table[$i]) {
                         $cpt += 1;
                    } else {
                         $resultat[] = [$table[$i - 1], $cpt];
                         $cpt = 1;
                    }
                    if ($i == count($table) - 1) {
                         $resultat[] = [$table[$i], $cpt];
                    }
               }
          }
          return $resultat;
     }

     public function supprimerValeur($nom)
     {
          $key = array_search($nom, $_SESSION['panier']);
          unset($_SESSION['panier'][$key]);
     }

     public function ajoutValeur($num)
     {
          $_SESSION['panier'][] = $num;
     }

}

