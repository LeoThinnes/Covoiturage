<?php
class DivisionManager{
	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function getAllDivisions() {
		$listeDivisions = array();
		$requete = $this->db->prepare("SELECT div_num, div_nom FROM division ORDER BY div_num");
		$requete->execute();
		while ($division = $requete->fetch(PDO::FETCH_ASSOC)) {
			$listeDivisions[] = new Division($division);
		}
		return $listeDivisions;
	}

	public function getDivNom($num) {
		$requete = $this->db->prepare("SELECT div_nom FROM division WHERE div_num = :num");
		$requete->bindValue(':num', $num);
		$requete->execute();
		return $requete->fetch(PDO::FETCH_OBJ);
	}
}
?>
