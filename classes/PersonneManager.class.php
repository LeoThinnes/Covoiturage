<?php
class PersonneManager{
	private $db;
	public $salt = "48@!alsd";

	public function __construct($db) {
		$this->db = $db;
	}

	//fonction d'ajout d'une personne
	public function add($personne) {
		$requete = $this->db->prepare("INSERT INTO personne (per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd) VALUES (:nom, :prenom, :tel, :mail, :login, :pwd);");
		$requete->bindValue(':nom', $personne->getPerNom());
		$requete->bindValue(':prenom', $personne->getPerPrenom());
		$requete->bindValue(':tel', $personne->getPerTel());
		$requete->bindValue(':mail', $personne->getPerMail());
		$requete->bindValue(':login', $personne->getPerLogin());
		$requete->bindValue(':pwd', sha1(sha1($personne->getPerPwd()) . $this->getSalt()));
		$requete->execute();
		return $this->db->lastInsertId();
	}

	//fonction qui modifie une personne
	public function upd($per_num, $per_nom, $per_prenom, $per_tel, $per_mail, $per_login, $per_pwd, $per_cat, $var1, $var2) {
		$requete1 = $this->db->prepare("UPDATE personne SET per_nom=:per_nom, per_prenom=:per_prenom, per_tel=:per_tel, per_mail=:per_mail, per_pwd=:per_pwd, per_login=:per_login
			WHERE per_num=$per_num");
		$requete1->bindValue(':per_nom', $per_nom);
		$requete1->bindValue(':per_prenom', $per_prenom);
		$requete1->bindValue(':per_tel', $per_tel);
		$requete1->bindValue(':per_mail', $per_mail);
		$requete1->bindValue(':per_login', $per_login);
		$requete1->bindValue(':per_pwd', sha1(sha1($per_pwd) . $this->getSalt()));
		$requete2 = $this->db->prepare("DELETE  FROM etudiant where per_num=$per_num;");
		$requete3 = $this->db->prepare("DELETE  FROM salarie where per_num=$per_num;");
		if ($per_cat == 1){
			$requete4 = $this->db->prepare("INSERT INTO etudiant (per_num, dep_num, div_num) VALUES ($per_num, $var1, $var2)");
		}else{
			$requete4 = $this->db->prepare("INSERT INTO salarie (per_num, sal_telprof, fon_num) VALUES ($per_num, $var1, $var2)");
		}
		$requete1->execute();
		$requete2->execute();
		$requete3->execute();
		$requete4->execute();
		return $this->db->lastInsertId();
	}

	//fonction qui supprime une personne
	public function del($num) {
		$requete1 = $this->db->prepare("DELETE  FROM salarie where per_num=$num;");
		$requete2 = $this->db->prepare("DELETE  FROM etudiant where per_num=$num;");
		$requete3 = $this->db->prepare("DELETE  FROM avis where per_num=$num;");
		$requete4 = $this->db->prepare("DELETE  FROM avis where per_per_num=$num;");
		$requete5 = $this->db->prepare("DELETE  FROM propose where per_num=$num;");
		$requete6 = $this->db->prepare("DELETE  FROM personne where per_num=$num;");
		$requete1->execute();
		$requete2->execute();
		$requete3->execute();
		$requete4->execute();
		$requete5->execute();
		$requete6->execute();
		return $this->db->lastInsertId();
	}

	//fonction qui recupere toutes les personnes
	public function getAllpersonne() {
		$listePersonnes = array();
		$requete = $this->db->prepare("SELECT per_num, per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd
			FROM personne ORDER BY per_nom");
		$requete->execute();
		while ($personne = $requete->fetch(PDO::FETCH_ASSOC)) {
			$listePersonnes[] = new Personne($personne);
		}
		return $listePersonnes;
	}

	//fonction qui recupere une personne en fonction de son numéro.
	public function getPersonne($numero) {
		$requete = $this->db->prepare("SELECT per_num, per_nom, per_prenom, per_tel, per_mail, per_login, per_pwd
			FROM personne WHERE per_num = $numero");
		$requete->execute();
		$personne = $requete->fetch(PDO::FETCH_ASSOC);
		return new Personne($personne);
	}

	//fonction qui recupere le statut d'une personne
	public function getStatut($num){
		$req1 = $this->db->prepare("SELECT per_num FROM etudiant WHERE per_num = $num");
		$req2 = $this->db->prepare("SELECT per_num FROM salarie WHERE per_num = $num");
		$req1->execute();
		$req2->execute();
		$etu = $req1->fetch(PDO::FETCH_ASSOC);
		$sal = $req2->fetch(PDO::FETCH_ASSOC);
		if ($etu != null && $sal == null){
			return "Etudiant";
		}else{
			return "Salarie";
		}
	}

	//fonction qui compte le nombre de personnes
	public function getNbrePersonnes() {
		$listePersonnes = array();
		$requete = $this->db->prepare('SELECT count(per_num) AS nbrePersonnes FROM personne');
		$requete->execute();
		$nbrePersonnes = $requete->fetch(PDO::FETCH_OBJ);
		return $nbrePersonnes->nbrePersonnes;
	}

	//fonction qui verifie que la personne qui se connecte est dans la BD avec le bon login et mdp
	public function VerifConnexion($per_login, $per_pwd) {
    $requete = $this->db->prepare('SELECT per_num FROM personne WHERE per_login = :login AND per_pwd = :password');
    $requete->bindValue(':login', $per_login);
    $requete->bindValue(':password', $per_pwd);
    $requete->execute();
    $per_nums = $requete->fetch(PDO::FETCH_OBJ);
    if (!empty($per_nums->per_num)) {
      return $per_nums->per_num;
    }
    return false;
  }

	//fonction qui verifie si le login à ajouter est deja present dans la base ou non
	public function loginDejaPres($per_login) {
		$requete = $this->db->prepare("SELECT COUNT(*) FROM personne WHERE per_login=:per_login");
		$requete->bindValue(':per_login', $per_login);
		$requete->execute();
		$resultat = $requete->fetch(PDO::FETCH_NUM)[0];
		if ($resultat == 0){
			return false;
		}else{
			return true;
		}
	}

	//fonction qui recupere les commentaires sur une personne
    public function avisCommPersonne($per_num) {
        $requete = $this->db->prepare("SELECT avi_comm, avg(avi_note) as avi_note FROM avis WHERE
				per_per_num = :per_num GROUP BY avi_comm, avi_note, avi_date ORDER BY avi_date DESC");
        $requete->bindValue(':per_num', $per_num);
        $requete->execute();
        $avis = $requete->fetch(PDO::FETCH_OBJ);
        return $avis;
    }

	public function getSalt() {
		return $this->salt;
	}
}
?>
