<h1>Ajouter une ville</h1>
<?php
if (empty($_POST['vil_nom'])) {
  ?>
  <form name="formulaire" id="form" method="post">    <!-- formulaire permettant d'ajouter une ville -->
    Nom : <input type="text" placeholder="ex: Limoges" name="vil_nom">
    <input class="button" type="submit" value="Valider">
  </form>
  <?php
}else{
  //ajout de la ville dans la BDD
  $db = new Mypdo();
  $VilleManager = new VilleManager($db);
  $ville = new Ville($_POST);
  if ($VilleManager->vilDejaPres($_POST['vil_nom'])) {
    ?>
    <img src="image/erreur.png" alt="erreur" />
    <?php
    $affVille = $ville->getVilNom();
    echo "la ville "."<b>\"$affVille\"</b>"." est déjà présente";
  }else{
    $retour=$VilleManager->add($ville);
    //affichage de confirmation
    if ($retour !=0) {
      ?>
      <img src="image/valid.png" alt="Valid" />
      <?php
      $affVille = $ville->getVilNom();
      echo "la ville "."<b>\"$affVille\"</b>"." a été ajoutée.";
    }
  }
}
?>
