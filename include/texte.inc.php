<div id="texte">
<?php
if (!empty($_GET["page"])){
	$page=$_GET["page"];}
	else
	{$page=0;
	}
switch ($page) {
//
// Personnes
//

case 0:
	// inclure ici la page accueil photo
	include_once('pages/accueil.inc.php');
	break;
	// page insertion nouveau client
case 1:
	// inclure ici la page insertion nouvelle personne
	include("pages/ajouterPersonne.inc.php");
    break;

case 2:
	// inclure ici la page liste des personnes
	include_once('pages/listerPersonnes.inc.php');
    break;
case 3:
	// inclure ici la page modification des personnes
	include("pages/ModifierPersonne.inc.php");
    break;
case 4:
	// inclure ici la page suppression personnes
	include_once('pages/supprimerPersonne.inc.php');
    break;
//
// Parcours
//
case 5:
	// inclure ici la page ajouter parcours
    include("pages/ajouterParcours.inc.php");
    break;

case 6:
	// inclure ici la page liste des parcours
	include("pages/listerParcours.inc.php");
    break;
//
// Villes
//

case 7:
	// inclure ici la page ajouter ville
	include("pages/ajouterVille.inc.php");
    break;

case 8:
// inclure ici la page lister  ville
	include("pages/listerVilles.inc.php");
    break;

//
// Trajets
//
case 9:
	// inclure ici la page proposer trajet
		
		include_once('pages/ProposerTrajet.inc.php');		
    break;
case 10:
	// inclure ici la page rechercher trajet
			
		include_once('pages/ChercherTrajet.inc.php');		
	
    break;
    
case 11:
	// inclure ici la page de connexion
	include_once('pages/Connexion.inc.php');
    break;

case 12:
	// inclure ici la page de déconnexion
	include_once('pages/Deconnexion.inc.php');
    break;    
    
default : 	include_once('pages/accueil.inc.php');
}
	
?>
</div>
