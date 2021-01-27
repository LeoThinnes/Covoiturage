<?php
$pdo=new Mypdo();
$PersonneManager = new PersonneManager($pdo);
$EtudiantManager = new EtudiantManager($pdo);
$SalarieMaanager = new SalarieManager($pdo);
$DepartementManager = new DepartementManager($pdo);
$VilleManager = new VilleManager($pdo);
$FonctionManager = new FonctionManager($pdo);
$NbrePersonnes = $PersonneManager->getNbrePersonnes();
$Personne = $PersonneManager->getAllPersonne();
$Etudiant = $EtudiantManager->getAllEtudiant();
$Salarie = $SalarieMaanager->getAllSalaries();
if(empty($_GET["per_num"])){
?>
  <h1>Liste des personnes enregistrées </h1>
  <?php
  echo "Actuellement ".$NbrePersonnes. " personnes enregistrées";
  ?>
  <table class="tablPers">
    <tr>
      <th> Numéro </th>
      <th> Nom </th>
      <th> Prénom </th>
    </tr>
    <?php
    foreach ($Personne as $Personne) { ?>
      <tr>
        <td><a href="index.php?page=2&per_num=<?php echo $Personne->getPerNum() ?>"><?php echo $Personne->getPerNum(); ?></a></td>
        <td><?php echo $Personne->getPerNom(); ?></td>
        <td><?php echo $Personne->getPerPrenom(); ?></td>
      </tr>
    <?php
    }
    ?>
  </table>
  <?php
}else{
  $Per_select = $PersonneManager->getPersonne($_GET["per_num"]);
  foreach ($Etudiant as $Etudiant) {
    if($_GET["per_num"]==$Etudiant->getPerNum()){
      echo "<h1>Détail sur l'étudiant ".$Per_select->getPerNom()."</h1>";
      $etu = $EtudiantManager->getInfosEtudiants($_GET['per_num']);
      ?>
      <table class="listEtu">
        <tr>
          <th> Prénom </th>
          <th> Mail </th>
          <th> Tel </th>
          <th> Département </th>
          <th> Ville </th>
        </tr>
        <tr>
          <td><?php echo $Per_select->getPerPrenom(); ?></td>
          <td><?php echo $Per_select->getPerMail(); ?></td>
          <td><?php echo $Per_select->getPerTel(); ?></td>
          <td><?php echo $etu->dep_nom;?></td>
          <td><?php echo $etu->vil_nom;?></td>
        </tr>
      </table>
    <?php
    }
  }
  foreach ($Salarie as $Salarie) {
    if($_GET["per_num"]==$Salarie->getPerNum()){
      echo "<h1>Détail sur le salarié ".$Per_select->getPerNom()."</h1>";
      ?>
      <table class="listEtu">
        <tr>
          <th> Prénom </th>
          <th> Mail </th>
          <th> Tel </th>
          <th> Tel Pro </th>
          <th> Fonction </th>
        </tr>
        <tr>
          <td><?php echo $Per_select->getPerPrenom(); ?></td>
          <td><?php echo $Per_select->getPerMail(); ?></td>
          <td><?php echo $Per_select->getPerTel(); ?></td>
          <td><?php echo $Salarie->getTelProf(); ?></td>
          <td><?php echo $FonctionManager->getFonction($Salarie->getFonNum())->getFonLibelle(); ?></td>
        </tr>
      </table>
    <?php
    }
  }
}
?>
