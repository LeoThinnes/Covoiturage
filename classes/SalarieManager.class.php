<?php
class SalarieManager{
	private $db;

	public function __construct($db){
		$this->db = $db;
	}

	public function add($salarie, $per_num){
    $requete = $this->db->prepare('INSERT INTO salarie (per_num, sal_telprof, fon_num) VALUES (:per_num, :sal_telprof, :fon_num)');
		$requete->bindValue(':per_num', $per_num);
		$requete->bindValue(':sal_telprof', $salarie->getTelProf());
		$requete->bindValue(':fon_num', $salarie->getFonNum());
    $retour=$requete->execute();
		return $retour;
  }

	public function getSalarie($numero) {
  	$requete = $this->db->prepare("SELECT per_num, sal_telprof, fon_num, fon_libelle
			FROM salarie s JOIN fonction f ON s.fon_num=f.fon_num WHERE per_num = $per_num");
		$requete->execute();
    $salarie = $requete->fetch(PDO::FETCH_ASSOC);
    return new Salarie($salarie);
	}

  public function getAllSalaries() {
    $listeSalaries = array();
		$requete = $this->db->prepare("SELECT per_num, sal_telprof, fon_num FROM salarie");
		$requete->execute();
    while ($salarie = $requete->fetch(PDO::FETCH_ASSOC)) {
      $listeSalaries[] = new Salarie($salarie);
    }
    $requete->closeCursor();
    return $listeSalaries;
  }

	public function getInfosSalaries($num) {
    $req = $this->db->prepare("SELECT f.fon_num, f.fon_libelle, s.sal_telprof FROM personne p JOIN salarie s ON p.per_num = s.per_num
			JOIN fonction f ON s.fon_num=f.fon_num WHERE p.per_num = $num");
    $req->execute();
    return $req->fetch(PDO::FETCH_OBJ);
  }
}
?>
