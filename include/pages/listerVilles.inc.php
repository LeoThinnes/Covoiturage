<?php
$pdo = new Mypdo();
$VilleManager = new VilleManager($pdo);
$Villes = $VilleManager->getAllVille();
$NbreVilles = $VilleManager->getNbreVille();
?>
<h1>Liste des villes</h1>
<?php
echo "Actuellement ".$NbreVilles. " villes sont enregistrées";
?>
<table>
  <tr>
    <th>Numéro</th>
    <th>Nom</th>
  </tr>
  <?php
  foreach ($Villes as $Ville) {
    ?>
    <tr >
        <td><?php echo $Ville->getVilNum() ?></td>
        <td><?php echo $Ville->getVilNom() ?></td>
    </tr>
    <?php
  }
  ?>
</table>
