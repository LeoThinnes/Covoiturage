<?php
class EtudiantManager{
	private $db;

	public function __construct($db) {
		$this->db = $db;
	}

	public function add($etudiant, $per_num) {
		$requete = $this->db->prepare("INSERT INTO etudiant (per_num, dep_num, div_num) VALUES (:per_num, :dep_num, :div_num)");
		$requete->bindValue(':per_num', $per_num);  //ligne de l'erreur
		$requete->bindValue(':dep_num', $etudiant->getDepNum());
		$requete->bindValue(':div_num', $etudiant->getDivNum());
		$retour=$requete->execute();   // l'erreur est a cette ligne le probleme doit certainement venir de la ligne 13 comme évoqué.
		return $retour;
	}

	public function getEtudiant($numero) {
		$requete = $this->db->prepare("SELECT per_num, dep_num, div_num FROM etudiant WHERE per_num = $numero");
		$requete->execute();
		$etudiant = $requete->fetch(PDO::FETCH_ASSOC);
		return new Etudiant($etudiant);
	}

	public function getAllEtudiant() {
		$listeEtudiants = array();
		$requete = $this->db->prepare("SELECT per_num, dep_num, div_num FROM etudiant");
		$requete->execute();
		while ($etudiant = $requete->fetch(PDO::FETCH_ASSOC)) {
			$listeEtudiants[] = new Etudiant($etudiant);
		}
		return $listeEtudiants;
	}

	public function getInfosEtudiants($num) {
    $req = $this->db->prepare("SELECT d.dep_num, d.dep_nom, v.vil_nom, di.div_num, di.div_nom FROM personne p JOIN etudiant e ON p.per_num = e.per_num
			JOIN departement d ON d.dep_num = e.dep_num JOIN ville v ON v.vil_num = d.vil_num JOIN division di ON e.div_num=di.div_num
			WHERE p.per_num = $num");
    $req->execute();
    return $req->fetch(PDO::FETCH_OBJ);
  }
}
?>
