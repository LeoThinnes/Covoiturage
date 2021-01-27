<?php
$pdo=new Mypdo();
$ParcoursManager = new ParcoursManager($pdo);
$VilleManager = new VilleManager($pdo);
$NbreParcours = $ParcoursManager->getNbreParcours();
$Parcours = $ParcoursManager->getAllParcours();
?>
<h1>Liste des parcours proposés </h1>
<?php
echo "Actuellement ".$NbreParcours. " parcours sont enregistrés";
?>
<!--tableau listant tous les parcours presents dans la BDD -->
<table class="tablParc">
  <tr>
    <th> Numéro </th>
    <th> Nom ville de départ </th>
    <th> Nom ville d'arrivé </th>
    <th> Nombre de Km </th>
  </tr>
  <?php
  foreach ($Parcours as $Parcour) {
    ?>
    <tr>
      <td><?php echo $Parcour->getParNum(); ?></td>
      <td><?php echo $VilleManager->getVilNom($Parcour->getVilNum1()); ?></td>
      <td><?php echo $VilleManager->getVilNom($Parcour->getVilNum2()); ?></td>
      <td><?php echo $Parcour->getParKm(); ?></td>
    </tr>
  <?php
  }
  ?>
</table>
