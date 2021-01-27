<?php
class Parcours {
	// Attributs
	private $par_num;
	private $vil_num1;
	private $vil_num2;
	private $par_km;

	public function __construct($valeurs = array()){
			 $this->affecte($valeurs);
	}

	public function affecte($donnees){
		foreach ($donnees as $attribut => $valeur){
			switch ($attribut) {
				case 'par_num': $this->setParNum($valeur);
					break;
				case 'vil_num1': $this->setVilNum1($valeur);
					break;
				case 'vil_num2': $this->setVilNum2($valeur);
					break;
				case 'par_km': $this->setParKm($valeur);
					break;
			}
		}
	}

  public function getParNum(){
    return $this->par_num;
  }

  public function setParNum($par_num){
    $this->par_num = $par_num;
  }

  public function getVilNum1(){
    return $this->vil_num1;
  }

  public function setVilNum1($vil_num1){
    $this->vil_num1 = $vil_num1;
  }

  public function getVilNum2(){
    return $this->vil_num2;
  }

  public function setVilNum2($vil_num2){
    $this->vil_num2 = $vil_num2;
  }

  public function getParKm(){
    return $this->par_km;
  }

  public function setParKm($par_km){
    $this->par_km = $par_km;
  }
}
?>
