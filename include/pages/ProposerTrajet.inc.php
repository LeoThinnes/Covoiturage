
<h1>Proposer un trajet</h1>
<?php
$db = new Mypdo();
$ParcoursManager = new ParcoursManager($db);
$VilleManager = new VilleManager($db);
$villesDep = $ParcoursManager->getAllVilleDep(); //recupération des villes dans la table parcours
if (empty($_POST['vil_num2'])) {  // ville d'arrivée vide dans le deuxieme formulaire
  if (empty($_POST['vil_num'])) { // ville de départ vide dans le premier formulaire
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
  } else {
    $_SESSION['vil_num'] = $_POST['vil_num'];
    $villesArr = $ParcoursManager->getAllVilleArr($_SESSION['vil_num']); // récuperation des villes d'arrivées possible en fonction de la ville de départ choisie
    date_default_timezone_set('Europe/Paris');
    ?>
    <form name="FormProp" method ="post">   <!-- formulaire pour recuperer les données sur le parcours proposé -->
      <div class="blockForm">
        <div class="colonne1">
          <label>Ville de départ : </label>
          <label>Date de départ : </label>
          <label>Nombre de Places : </label>
        </div>
        <div class="colonne2Prop">
          <label><?php echo $VilleManager->getVilNom($_SESSION['vil_num']) ?></label>
          <input type="date" name="pro_date" value="<?php echo date('Y-m-d'); ?>">
          <input type="number" name="pro_place" placeholder="ex: 3">
        </div>
        <div class="colonne3">
          <label>Ville d'arrivée : </label>
          <label>Heure de départ : </label>
        </div>
        <div class="colonne4Prop">
          <select class="form-control" name="vil_num2" id="vil_num2">
            <option value="">Sélectionnez la ville</option>
            <?php
            foreach ($villesArr as $ville) {
              ?>
              <option value="<?php echo $ville->getVilNum() ?>"><?php echo $ville->getVilNom() ?></option>
              <?php
            }
            ?>
          </select>
          <input type="time" name="pro_time" value="<?php echo date("H:i:s"); ?>">
        </div>
      </div>
      <input class="button" type="submit" value="Valider"/>
    </form>
    <?php
  }
}else {
  $ProposeManager = new ProposeManager($db);
  $parcours = $ParcoursManager->getParVilNums($_SESSION['vil_num'], $_POST['vil_num2']); //recupere si possible le numéro du parcour que l'on propose
  if ($parcours == NULL) { //si le parcour n'existe pas dans le sens testé la premiere fois on recupere dans l'autre sens
    $parcours = $ParcoursManager->getParVilNums($_POST["vil_num2"], $_SESSION["vil_num"]);
  }
  if ($parcours->getVilNum1() == $_SESSION['vil_num']) { //on affecte la valeur de sens de parcours
    $sens = 0;
  }else{
    $sens = 1;
  }
  $propose = new Propose(
    array(
      'per_num' => $_SESSION["per_num"],
      'pro_date' => $_POST['pro_date'],
      'pro_time' => $_POST['pro_time'],
      'pro_place' => $_POST['pro_place'],
      'pro_sens' => $sens,
    )
  );
  $propose->setParNum($parcours->getParNum());
  $retour=$ProposeManager->add($propose);  //ajout du trajet proposé
  if ($retour !=0){
    ?><img src="image/valid.png" alt="valid">
    <?php
    echo "Le trajet a bien été ajouté";
  }
}
?>
