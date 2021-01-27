<?php
$pdo=new Mypdo();
$PersonneManager = new PersonneManager($pdo);
$EtudiantManager = new EtudiantManager($pdo);
$SalarieManager = new SalarieManager($pdo);
$NbrePersonnes = $PersonneManager->getNbrePersonnes();
$Personne = $PersonneManager->getAllPersonne();
$Etudiant = $EtudiantManager->getAllEtudiant();
$Salarie = $SalarieManager->getAllSalaries();
if(empty($_GET["per_num"])){
  ?>
  <h1>Cliquez sur la personne a supprimer </h1>
  <?php
  echo "Actuellement ".$NbrePersonnes. " personnes enregistrées";
  ?>
  <table class="tablPers">
    <tr>
      <th> Numéro </th>
      <th> Nom </th>
      <th> Prénom </th>
      <th> Fonction </th>
    </tr>
    <?php
    foreach ($Personne as $Personne) {
      ?>
      <tr>
        <td><a href="index.php?page=4&per_num=<?php echo $Personne->getPerNum() ?>"><?php echo $Personne->getPerNum(); ?></a></td>
        <td><?php echo $Personne->getPerNom(); ?></td>
        <td><?php echo $Personne->getPerPrenom(); ?></td>
        <td><?php echo $PersonneManager->getStatut($Personne->getPerNum()); ?></td>
      </tr>
      <?php
    }
    ?>
  </table>
  <?php
}else {
  if(empty($_POST['suppr'])){
    ?>
    <h1>Details sur la personne à supprimer </h1>
    <?php
    $personneSuppr = $PersonneManager->getPersonne($_GET["per_num"]);
    ?>
    <div class="suppr">
    <table class="tablPers">
      <tr>
        <th> Numéro </th>
        <th> Nom </th>
        <th> Prénom </th>
        <th> Telephone </th>
        <th> Mail </th>
        <th> Fonction </th>
        <?php
        if ($PersonneManager->getStatut($_GET["per_num"])=="Etudiant"){
          ?>
          <th> Departement </th>
          <th> Ville </th>
          <th> Division </th>
          <?php
        }
        if ($PersonneManager->getStatut($_GET["per_num"])=="Salarie"){
          ?>
          <th> Telephone professionnel </th>
          <th> Fonction </th>
          <?php
        }
        ?>
      </tr>
      <tr>
        <td><?php echo $personneSuppr->getPerNum()?></td>
        <td><?php echo $personneSuppr->getPerNom()?></td>
        <td><?php echo $personneSuppr->getPerPrenom()?></td>
        <td><?php echo $personneSuppr->getPerTel()?></td>
        <td><?php echo $personneSuppr->getPerMail()?></td>
        <td><?php echo $PersonneManager->getStatut($_GET["per_num"]); ?></td>
        <?php
        if ($PersonneManager->getStatut($_GET["per_num"])=="Etudiant"){
          $etudiantSuppr = $EtudiantManager->getInfosEtudiants($_GET['per_num']);
          ?>
          <td><?php echo $etudiantSuppr->dep_nom;?></td>
          <td><?php echo $etudiantSuppr->vil_nom;?></td>
          <td><?php echo $etudiantSuppr->div_nom;?></td>
          <?php
        }
        if ($PersonneManager->getStatut($_GET["per_num"])=="Salarie"){
          $salarieSuppr = $SalarieManager->getInfosSalaries($_GET['per_num']);
          ?>
          <td><?php echo $salarieSuppr->sal_telprof;?></td>
          <td><?php echo $salarieSuppr->fon_libelle;?></td>
          <?php
        }
        ?>
      </tr>
    </table>
  </div>
    <form name="formSuppr" method="post">
      <label>Voulez-vous vraiment supprimer cette personne ?</label>
      <input type="radio" name="suppr" id="1" value="1" > Oui
      <input type="radio" name="suppr" id="2" value="2" checked="checked"> Non
      <input class="button" type="submit" value="Valider"/>
    </form>
    <?php
  }else{
    if ($_POST['suppr'] == "1"){
      $PersonneManager->del($_GET["per_num"]);
      ?>
      <img src="image/valid.png" alt="valid">
      <?php
      echo "La personne a été supprimée !";
    }else {
        echo "kdls";
    }
  }
}
?>
