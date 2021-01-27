<h1>Rechercher un trajet</h1>
<?php
require_once("include/functions.inc.php");
$db = new Mypdo();
$ProposeManager = new ProposeManager($db);
$VilleManager = new VilleManager($db);
$ParcoursManager = new ParcoursManager($db);
$PersonneManager = new PersonneManager($db);
if (empty($_POST['vil_num']) && empty($_POST['vil_num2'])) {
  $villesDep = $ProposeManager->getAllVilleDep();
  ?>
  <form method ="post" name="formPropVille">
    <div class="formPropVille">
      <label>Ville de départ : </label>
      <select class="form-control" name="vil_num" id="vil_num" required="required">
        <option value="">--Sélectionnez la ville--</option>
        <?php
        foreach ($villesDep as $ville) {
          ?>
          <option value="<?php echo $ville->getVilNum() ?>"><?php echo $ville->getVilNom() ?></option>
          <?php
        }
        ?>
      </select>
      <input class="button" type="submit" value="Valider"/>
    </div>
  </form>
  <?php
} else if (empty($_POST['vil_num2']) && !empty($_POST['vil_num'])) {
  $_SESSION['vil_num'] = $_POST['vil_num'];
  $villesArr = $ProposeManager->getAllVilleArr($_POST['vil_num']);
  ?>
  <form name="FormRech" method ="post">   <!-- formulaire pour recuperer les données sur le parcours recherché -->
    <div class="blockForm">
      <div class="colonne1">
        <label>Ville de départ : </label>
        <label>Date de départ : </label>
        <label>A partir de : </label>
      </div>
      <div class="colonne2Prop">
        <label><?php echo $VilleManager->getVilNom($_SESSION['vil_num']) ?></label>
        <input type="date" name="pro_date" value="<?php echo date('Y-m-d'); ?>">
        <select class="partir" name="pro_time">
          <?php
          for ($i=0;$i<24;$i++) {
            echo "<option value=".$i.">".$i."h"."</option>";
          }
          ?>
        </select>
      </div>
      <div class="colonne3">
        <label>Ville d'arrivée : </label>
        <label>Précision : </label>
      </div>
      <div class="colonne4Prop">
        <select name="vil_num2" id="vil_num2" class="form-control">
          <option value="">Sélectionnez la ville</option>
          <?php
          foreach ($villesArr as $ville) {
            ?>
            <option value="<?php echo $ville->getVilNum() ?>"><?php echo $ville->getVilNom($_SESSION['vil_num']) ?></option>
            <?php
          }
          ?>
        </select>
        <select name="pro_date_prec" >
          <option value=""> -- Ce jour --</option>
          <option value="1">+/- 1 jour</option>
          <option value="2">+/- 2 jours</option>
          <option value="3">+/- 3 jours</option>
        </select>
      </div>
    </div>
    <input class="button" type="submit" value="Valider"/>
  </form>
  <?php
}else {
  $date = getEnglishDate($_POST['pro_date']); /*$_POST['date']; */
  $heure = $_POST['pro_time'];
  switch($_POST['pro_date_prec']){
    case 1:
    $date1 = addJours($date, -1);
    $date2 = addJours($date, 1);
      break;
    case 2:
    $date1 = addJours($date, -2);
    $date2 = addJours($date, 2);
      break;
    case 3:
    $date1 = addJours($date, -3);
    $date2 = addJours($date, 3);
      break;
    default:
    $date1 = addJours($date, 0);
    $date2 = addJours($date, 0);
      break;
  }
  $resultats = $ProposeManager->getResultatsParcours($_SESSION['vil_num'], $_POST['vil_num2'],$date1, $date2, $_POST['pro_time']);
  if (COUNT($resultats) == 0) {
    ?>
    <img src="image/erreur.png" alt="erreur">
    <?php
    echo "Désolé, il n'y a pas de trajet disponible !";

  } else {
    ?>
    <table class="tablRech"> <!-- tableau affichant les trajets possibles. -->
      <tr>
        <th class="pointer">Ville de départ</th>
        <th class="pointer">Ville d'arrivée</th>
        <th class="pointer">Date de départ</th>
        <th class="pointer">Heure de départ</th>
        <th class="pointer">Nombre de places</th>
        <th class="pointer">Nom du covoitureur</th>
      </tr>
      <?php
      foreach ($resultats as $resultat) {
        $parcours = $ParcoursManager->getParcours($resultat->getParNum())[0];
        $villeDep = $VilleManager->getVilNom($parcours->getVilNum1());
        $villeArr = $VilleManager->getVilNom($parcours->getVilNum2());
        $personne = $PersonneManager->getPersonne($resultat->getPerNum());
        $datefr=getFrenchDate($resultat->getProDate());
        $avis = $PersonneManager->avisCommPersonne($personne->getPerNum());
        ?>
        <tr>
          <td><?php echo $villeDep ?></td>
          <td><?php echo $villeArr ?></td>
          <td><?php echo $datefr ?></td>
          <td><?php echo $resultat->getProTime() ?></td>
          <td><?php echo $resultat->getProPlace() ?></td>
          <td><span title="
            <?php
            if ($avis == NULL) {
                echo "Aucun avis";
              } elseif ($avis->avi_comm != NULL && $avis->avi_note == NULL) {
                echo "Dernier Avis : $avis->avi_comm";
              } elseif ($avis->avi_comm == NULL && $avis->avi_note != NULL) {
                echo "Moyenne avis : $avis->avi_note";
              } elseif ($avis->avi_comm != NULL && $avis->avi_note != NULL) {
                echo "Moyenne avis : $avis->avi_note \n Dernier avis : $avis->avi_comm";
              }
            ?>
            ">
            <?php echo $personne->getPerPrenom() . " " . $personne->getPerNom() ?>
          </span></td>
        </tr>
        <?php
      }
      ?>
    </table>
    <?php
  }
}
?>
