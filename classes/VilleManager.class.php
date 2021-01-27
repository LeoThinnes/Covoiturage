<?php
class VilleManager{
	private $db;

	public function __construct($db){
		$this->db=$db;
	}

	public function add($ville){
		$requete = $this->db->prepare('INSERT INTO ville (vil_nom) VALUES (:vil_nom);');
		$requete->bindValue(':vil_nom',$ville->getVilNom());
		$retour=$requete->execute();
		return $retour;
	}

	public function getAllVille() {
    $listeVilles = array();
    $requete = $this->db->prepare("SELECT vil_num, vil_nom FROM ville ORDER BY vil_nom");
    $requete->execute();
    while ($ville = $requete->fetch(PDO::FETCH_ASSOC)) {
      $listeVilles[] = new Ville($ville);
    }
		return $listeVilles;
	}

	public function getVilNom($num) {
    $requete = $this->db->prepare("SELECT vil_nom FROM ville WHERE vil_num = :num");
    $requete->bindValue(':num', $num);
    $requete->execute();
    return $requete->fetch(PDO::FETCH_NUM)[0];
	}

	public function getNbreVille() {
		$listeVille = array();
		$requete = $this->db->prepare('SELECT count(vil_num) AS NbreVilles FROM ville');
		$requete->execute();
		$NbreVilles = $requete->fetch(PDO::FETCH_OBJ);
		return $NbreVilles->NbreVilles;
	}

	public function getVille($num) {
		$sql = "SELECT vil_num, vil_nom FROM ville WHERE vil_num = :num;";
		$requete = $this->db->prepare($sql);
		$requete->bindValue(':num', $num);
		$requete->execute();
		$ville = $requete->fetch(PDO::FETCH_OBJ);
		$maVille = new ville($ville);
		return $maVille;
	}

	//fonction qui verifie si la ville a ajouter est deja presente dans la base
	public function vilDejaPres($vil_nom) {
		$requete = $this->db->prepare("SELECT COUNT(*) FROM ville WHERE vil_nom = :vil_nom");
		$requete->bindValue(':vil_nom', $vil_nom);
		$requete->execute();
		$resultat = $requete->fetch(PDO::FETCH_NUM)[0];

		if ($resultat == 0)
		return false;
		else
		return true;
	}
}
?>
