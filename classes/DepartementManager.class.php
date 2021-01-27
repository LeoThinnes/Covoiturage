<?php
class DepartementManager{
	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function getAllDepartements() {
		$listeDepartements = array();
		$requete = $this->db->prepare("SELECT dep_num, dep_nom FROM departement ORDER BY dep_num");
		$requete->execute();
		while ($departement = $requete->fetch(PDO::FETCH_ASSOC)) {
			$listeDepartements[] = new Departement($departement);
		}
		return $listeDepartements;
	}

	public function getDepNom($num) {
		$requete = $this->db->prepare("SELECT dep_nom FROM departement WHERE dep_num = :num");
		$requete->bindValue(':num', $num);
		$requete->execute();
		return $requete->fetch(PDO::FETCH_OBJ);
	}
}
?>
