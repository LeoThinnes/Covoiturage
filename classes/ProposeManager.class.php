<?php
class ProposeManager{
	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	//Fonction permettant l'ajout d'une proposition de trajet
	public function add($propose) {
		$requete = $this->db->prepare("INSERT INTO propose (par_num, per_num, pro_date, pro_time, pro_place, pro_sens) VALUES
																												(:par_num, :per_num, :pro_date, :pro_time, :pro_place, :pro_sens);");
		$requete->bindValue(':par_num', $propose->getParNum());
		$requete->bindValue(':per_num', $propose->getPerNum());
		$requete->bindValue(':pro_date', $propose->getProDate());
		$requete->bindValue(':pro_time', $propose->getProTime());
		$requete->bindValue(':pro_place', $propose->getProPlace());
		$requete->bindValue(':pro_sens', $propose->getProSens());
		$retour = $requete->execute();
		return $retour;
	}

	//Fonction recupérant toutes les villes de départ quelque soit le sens
	public function getAllVilleDep() {
		$listeVilles = array();
		$villeManager = new VilleManager($this->db);
		$requete = $this->db->prepare("SELECT vil_num1 AS vil_num FROM parcours p
			INNER JOIN propose pr ON pr.par_num = p.par_num WHERE pro_sens = 0
			UNION SELECT vil_num2 FROM parcours p
			INNER JOIN propose pr ON pr.par_num = p.par_num WHERE pro_sens = 1");
		$requete->execute();
		while ($ligne = $requete->fetch(PDO::FETCH_ASSOC)) {
			$listeVilles[] = new Ville(array('vil_nom' => $villeManager->getVilNom($ligne['vil_num']), 'vil_num' => $ligne['vil_num']));
		}
		return $listeVilles;
	}

	//Fonction recuperant toutes les villes d'arrivée possible suivant la ville de départ selectionnée
	public function getAllVilleArr($vil_numDepart) {
		$listeVilles = array();
		$VilleManager = new VilleManager($this->db);
		$requete = $this->db->prepare("SELECT vil_num2 AS vil_num FROM parcours p
			INNER JOIN propose pr ON pr.par_num = p.par_num WHERE pro_sens = 0 AND vil_num1 = :vil_num
			UNION SELECT vil_num1 FROM parcours p
			INNER JOIN propose pr ON pr.par_num = p.par_num WHERE pro_sens = 1 AND vil_num2 = :vil_num");
		$requete->bindValue(':vil_num', $vil_numDepart);
		$requete->execute();
		while ($ligne = $requete->fetch(PDO::FETCH_ASSOC)) {
			$listeVilles[] = new Ville(array('vil_nom' => $VilleManager->getVilNom($ligne['vil_num']), 'vil_num' => $ligne['vil_num']));
		}
		return $listeVilles;
	}

	//Fonction retournant les parcours possibles suivant les parametres de parcours choisis.
	public function getResultatsParcours($vil_num1, $vil_num2, $pro_date_deb, $pro_date_fin, $pro_time) {
		$listePropositions = array();
		$requete = $this->db->prepare("SELECT pr.par_num, per_num, pro_date, pro_time, pro_place, pro_sens FROM propose pr
			INNER JOIN parcours pa ON pa.par_num = pr.par_num
			WHERE vil_num1 = :vil_num1 AND vil_num2 = :vil_num2 AND pro_sens = 0 AND pro_date BETWEEN :pro_date_deb AND :pro_date_fin AND pro_time >= :pro_time
			UNION	SELECT pr.par_num, per_num, pro_date, pro_time, pro_place, pro_sens FROM propose pr
			INNER JOIN parcours pa ON pa.par_num = pr.par_num
			WHERE vil_num2 = :vil_num1 AND vil_num1 = :vil_num2 AND pro_sens = 1 AND pro_date BETWEEN :pro_date_deb AND :pro_date_fin AND pro_time >= :pro_time");
		$requete->bindValue(':vil_num1', $vil_num1);
		$requete->bindValue(':vil_num2', $vil_num2);
		$requete->bindValue(':pro_date_deb', $pro_date_deb);
		$requete->bindValue(':pro_date_fin', $pro_date_fin);
		$requete->bindValue(':pro_time', $pro_time);
		$requete->execute();
		while($ligne = $requete->fetch(PDO::FETCH_ASSOC)) {
			$listePropositions[] = new Propose($ligne);
		}
		return $listePropositions;
	}
}
?>
