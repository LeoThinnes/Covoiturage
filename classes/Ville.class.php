<?php
class Ville {
	private $vil_nom;
	private $vil_num;

	public function __construct($valeurs = array()) {
				 $this->affecte($valeurs);
	}

	public function affecte($donnees) {
		foreach ($donnees as $attribut => $valeur) {
			switch ($attribut) {
				case 'vil_nom': $this->setVilNom($valeur);
					break;
				case 'vil_num': $this->setVilNum($valeur);
					break;
			}
		}
	}

	public function getVilNom() {
    return $this->vil_nom;
  }

	public function getVilNum(){
  	return $this->vil_num;
  }

	public function setVilNom($vil_nom){
		$this->vil_nom = $vil_nom;
	}

	public function setVilNum($vil_num){
		$this->vil_num = $vil_num;
	}
}
?>
