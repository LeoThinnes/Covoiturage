<?php
class ParcoursManager{
	private $db;

	//constructeur
	public function __construct($db){
		$this->db = $db;
	}

	//Méthodes
	public function add($parcours){
		$par1 = $this->getParVilNums($parcours->getVilNum1(), $parcours->getVilNum2()); //utilisation de la fonction recupérant les parcours pour voir
		$par2 = $this->getParVilNums($parcours->getVilNum2(), $parcours->getVilNum1());	//s'il est present ou non.
		// Si le parcours existe déjà
		if ($par1 != null || $par2 != null){
			return false;
		}else{
      $requete = $this->db->prepare('INSERT INTO parcours (par_km, vil_num1, vil_num2) VALUES (:kmParcours, :vil_num1, :vil_num2)');
			$requete->bindValue(':kmParcours', $parcours->getParKm());
			$requete->bindValue(':vil_num1', $parcours->getVilNum1());
			$requete->bindValue(':vil_num2', $parcours->getVilNum2());
			$retour=$requete->execute();
			return $retour;
    }
	}

	//récupère tous les parcours presents dans la table parcours
	public function getAllParcours(){
    $listeParcours = array();
    $requete = $this->db->prepare('SELECT par_num, par_km, vil_num1, vil_num2 FROM parcours ORDER BY 1');
    $requete->execute();
    while ($parcours = $requete->fetch(PDO::FETCH_OBJ)){
    	$listeParcours[] = new Parcours($parcours);
		}
    return $listeParcours;
	}

	//compte le nombre de parcours dans la table parcours
	public function getNbreParcours() {
		$listeParcours = array();
		$requete = $this->db->prepare('SELECT count(par_num) AS nbreParcours FROM parcours');
		$requete->execute();
		$nbreParcours = $requete->fetch(PDO::FETCH_OBJ);
		return $nbreParcours->nbreParcours;
	}

	//fonction recupérant le parcours en fonction de son numero
	public function getParcours($numero) {
		$requete = $this->db->prepare("SELECT par_num, par_km, vil_num1, vil_num2 FROM parcours WHERE par_num = :par_num");
		$requete->bindValue(':par_num', $numero);
		$requete->execute();
		while ($parcours = $requete->fetch(PDO::FETCH_OBJ)) {
			$listeParcours[] = new Parcours($parcours);
		}
		$requete->closeCursor();
		return $listeParcours;
	}

	//fonction permettant de recuperer le nom des villes presentes dans la table parcours (vil_num1 et vil_num2)
	public function getAllVilleDep() {
		$listeVilles = array();
		$requete = $this->db->prepare("SELECT DISTINCT vil_num, vil_nom FROM ville v, parcours p WHERE v.vil_num=p.vil_num2
			UNION SELECT DISTINCT vil_num, vil_nom FROM ville v, parcours p WHERE v.vil_num=p.vil_num1
			GROUP BY vil_num, vil_nom ORDER BY vil_nom asc");
		$requete->execute();
		while ($ville = $requete->fetch(PDO::FETCH_ASSOC)) {
			$listeVilles[] = new Ville($ville);
		}
		return $listeVilles;
	}

	//récupère les villes d'arrivée en fonction de la ville de départ choisie précedemment
	public function getAllVilleArr($vil_num) {
		$listeVilles = array();
		$villeManager = new VilleManager($this->db);
		$requete = $this->db->prepare("SELECT vil_num1 AS vil_num FROM parcours WHERE vil_num2 = :vil_num
			UNION	SELECT vil_num2 FROM parcours WHERE vil_num1 = :vil_num");
		$requete->bindValue(":vil_num", $vil_num);
		$requete->execute();
		while($ligne = $requete->fetch(PDO::FETCH_ASSOC)) {
			$listeVilles[] = new Ville(array('vil_nom' => $villeManager->getVilNom($ligne['vil_num']), 'vil_num' => $ligne['vil_num']));
		}
		return $listeVilles;
	}

	//fonction récupérant le parcour en fonction des villes saisies
	public function getParVilNums($vil_num1, $vil_num2) {
		$requete = $this->db->prepare("SELECT par_num, par_km, vil_num1, vil_num2 FROM parcours WHERE vil_num1 = :vil_num1 AND vil_num2 = :vil_num2");
		$requete->bindValue(':vil_num1', $vil_num1);
		$requete->bindValue(':vil_num2', $vil_num2);
		$requete->execute();
		$resultat = $requete->fetch(PDO::FETCH_ASSOC);
		if ($resultat != null){
			return new Parcours($resultat);
		}else{
			return null;
		}
	}
}
?>
