<?php
class FonctionManager{
	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function add($fonction) {
		$requete = $this->db->prepare("INSERT INTO fonction VALUES (fon_libelle) VALUES (:libelle);");
		$requete->bindValue(':libelle', $fonction->getFonNum());
		$retour = $requete->execute();
		return $retour;
	}

	public function getAllFonctions() {
		$listefonctions = array();
		$requete = $this->db->prepare("SELECT fon_num, fon_libelle FROM fonction");
		$requete->execute();
		while ($fonction = $requete->fetch(PDO::FETCH_ASSOC)) {
			$listefonctions[] = new Fonction($fonction);
		}
		return $listefonctions;
	}

	public function getFonNom($num) {
		$requete = $this->db->prepare("SELECT fon_libelle FROM fonction WHERE fon_num = :num");
		$requete->bindValue(':num', $num);
		$requete->execute();
		return $requete->fetch(PDO::FETCH_OBJ);
	}

	public function getFonction($num) {
		$requete = $this->db->prepare("SELECT fon_num, fon_libelle FROM fonction WHERE fon_num = :num");
		$requete->bindValue(':num', $num);
		$requete->execute();
		$fonction = $requete->fetch(PDO::FETCH_OBJ);
		return new Fonction($fonction);
	}
}
?>
