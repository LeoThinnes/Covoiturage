<?php
class Propose{
  private $par_num;
  private $per_num;
  private $pro_date;
  private $pro_time;
  private $pro_place;
  private $pro_sens;

  //Constructeur
  public function __construct($valeurs = array()) {
    $this->affecte($valeurs);
  }

  //affectetion des valeurs pour la proposition d'un parcour
  public function affecte($donnees) {
    foreach ($donnees as $attribut => $valeur) {
      switch ($attribut) {
        case 'par_num': $this->setParNum($valeur);
          break;
        case 'per_num': $this->setPerNum($valeur);
          break;
        case 'pro_date': $this->setProDate($valeur);
          break;
        case 'pro_time': $this->setProTime($valeur);
          break;
        case 'pro_place': $this->setProPlace($valeur);
          break;
        case 'pro_sens': $this->setProSens($valeur);
          break;
      }
    }
  }

  //getters et setters sur les variables
  public function getProDate() {
    return $this->pro_date;
  }

  public function setProDate($pro_date) {
    $this->pro_date = $pro_date;
  }

  public function getProTime() {
    return $this->pro_time;
  }

  public function setProTime($pro_time) {
    $this->pro_time = $pro_time;
  }

  public function getProPlace() {
    return $this->pro_place;
  }

  public function setProPlace($pro_place) {
    $this->pro_place = $pro_place;
  }

  public function getProSens() {
    return $this->pro_sens;
  }

  public function setProSens($pro_sens) {
    $this->pro_sens = $pro_sens;
  }

  public function getParNum() {
    return $this->par_num;
  }

  public function setParNum($par_num) {
    $this->par_num = $par_num;
  }

  public function getPerNum() {
    return $this->per_num;
  }

  public function setPerNum($per_num) {
    $this->per_num = $per_num;
  }
}
?>
