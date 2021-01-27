<?php
class Departement {
    private $depnum;
    private $depnom;
    private $vilnum;

  public function __construct($departement) {
    if(!empty($departement)) {
      $this->affecte($departement);
    }
  }

  public function affecte($donnes) {
    foreach($donnes as $attribut => $valeur) {
      var_dump($donnes);
      switch($attribut) {
        case 'dep_num': $this->setDepnum($valeur);
          break;
        case 'dep_nom': $this->setDepnom($valeur);
          break;
        case 'vil_num': $this->setVilnum($valeur);
          var_dump($vilnum);
          break;
        default:
          break;
      }
    }
  }

  public function getDepNum() {
    return $this->dep_num;
  }

  public function setDepNum($dep_num) {
    $this->dep_num = $dep_num;
  }

  public function getDepNom() {
    return $this->dep_nom;
  }

  public function setDepNom($dep_nom) {
    $this->dep_nom = $dep_nom;
  }

  public function getVilNum() {
    return $this->vil_num;
  }

  public function setVilNum() {
    $this->vil_num = $vil_num;
  }
}
?>
