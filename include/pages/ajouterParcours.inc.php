<?php
$pdo=new Mypdo();
?>

<h1>Ajouter un parcours</h1>

<?php
if (empty($_POST["vil_num1"]) || empty($_POST["vil_num2"]) || empty($_POST["par_km"])){
  $villeManager = new VilleManager($pdo);
  $villes = $villeManager->getAllVille();
?>
  <form name="formParc" id="form" method="post">    <!--formulaire permettant l'ajout d'un parcours-->
    <label>Ville 1 : </label>
      <select name="vil_num1" id="vil_num1">
        <option value="">-- Ville de départ --</option>
        <?php foreach ($villes as $ville) { ?>
          <option value="<?php echo $ville->getVilNum()?>"><?php echo $ville->getVilNom()?></option>
        <?php
        }
        ?>
      </select>
    <label>Ville 2 : </label>
      <select name="vil_num2" id="vil_num2">
        <option value="">-- Ville d'arrivé --</option>
        <?php foreach ($villes as $ville) { ?>
          <option value="<?php echo $ville->getVilNum()?>"><?php echo $ville->getVilNom()?></option>
        <?php
        }
        ?>
      </select>
    <label>Nombre de kilomètre(s) : </label>
    <input type="number" placeholder="ex: 165" name="par_km" id="kmPar">
    </br></br>
    <input class="button" type="submit" value="Valider"/>
  </form>
  <br/>
<?php
}
if (!empty($_POST["vil_num1"]) || !empty($_POST["vil_num2"]) || !empty($_POST["par_km"])) {
  $ParcoursManager = new ParcoursManager($pdo);
  $Parcours = new Parcours($_POST);
  $retour=$ParcoursManager->add($Parcours);
  //si le parcours existe
  if (!$retour) {
  ?>
    <img src="image\erreur.png"/>
    <?php
    echo "erreur le parcours existe déjà";
  } elseif ($retour != 0) { //si le parcours n'existe pas
    ?>
		<img src="image\valid.png"/>
    <?php
    echo "Le parcours a été ajouté" ;
  }
}
?>
