<?php
$db = new Mypdo();

if (empty($_POST["per_nom"]) && empty($_POST["per_prenom"]) && empty($_POST["per_tel"]) && empty($_POST["per_mail"])    //si le formulaire est vide
&& empty($_POST["per_login"]) && empty($_POST["per_pwd"])) {
  ?>
  <h1>Ajouter une personne</h1>
  <form name="formPers" method="post">
    <div class="FormulairePers">
      <div class="blockForm">
        <div class="colonne1">
          <label>Nom : </label>
          <label>Téléphone : </label>
          <label>Login : </label>
        </div>
        <div class="colonne2">
          <div class="saisieGauche">
            <input type="text" placeholder="ex: Martin" name="per_nom" required="required">
          </div>
          <div class="saisieGauche">
            <input type="tel" placeholder="ex: 0555641328"  name="per_tel" required="required">
          </div>
          <div class="saisieGauche">
            <input type="text" placeholder="ex: votreLogin" name="per_login" required="required">
          </div>
        </div>
        <div class="colonne3">
          <label>Prénom : </label>
          <label>Mail : </label>
          <label>Mot de passe : </label>
        </div>
        <div class="colonne4">
          <div class="saisieDroite">
            <input type="text" placeholder="ex: Bob"  name="per_prenom" required="required">
          </div>
          <div class="saisieDroite">
            <input type="Adresse email" placeholder="ex: exemple@gmail.com" name="per_mail" pattern=".+@+.+.+."  required="required">
          </div>
          <div class="saisieDroite">
            <input type="password" placeholder="ex: sfv18" name="per_pwd" required="required">
          </div>
        </div>
      </div>
      <div class="categorie">
        <label>Catégorie</label>
        <input type="radio" name="per_cat" id="1" value="1" checked="checked"> Etudiant
        <input type="radio" name="per_cat" id="2" value="2" > Personnel
      </div>
      <input class="button" type="submit" value="Valider"/>
    </div>
  </form>
  <?php
  if (!empty($_POST["div_num"]) && !empty($_POST["dep_num"])) {   //si le formulaire étudiant a été rempli
    $PersonneManager = new PersonneManager($db);
    $personne = unserialize($_SESSION["personne"]);
    $retour_num_pers = $PersonneManager->add($personne);
    $EtudiantManager = new EtudiantManager($db);
    $etudiant = new Etudiant($_POST);
    $retour_Etu = $EtudiantManager->add($etudiant, $retour_num_pers);
    if ($retour_Etu != 0) {
      ?>
      <img src="image/valid.png" alt="valid">
      <?php
      echo "L'étudiant a été ajouté !";
    }
  }
  if (!empty($_POST["sal_telprof"]) && !empty($_POST["fon_num"])) {   //si le formulaire salarié a été rempli
    $PersonneManager = new PersonneManager($db);
    $personne = unserialize($_SESSION["personne"]);
    $retour_num_pers = $PersonneManager->add($personne);
    $SalarieManager = new SalarieManager($db);
    $salarie = new Salarie($_POST);
    $retour = $SalarieManager->add($salarie, $retour_num_pers);
    if ($retour != 0) {
      ?>
      <img src="image/valid.png" alt="valid">
      <?php
      echo "Le salarié a été ajouté !";
    }
  }
}
if (!empty($_POST["per_nom"]) && !empty($_POST["per_prenom"]) && !empty($_POST["per_tel"]) &&      //si le premier formulaire a été rempli
!empty($_POST["per_mail"]) && !empty($_POST["per_login"]) &&
!empty($_POST["per_pwd"])) {
  $PersonneManager = new PersonneManager($db);
  $personne = unserialize($_SESSION["personne"]);
  if ($PersonneManager->loginDejaPres($_POST['per_login'])) {
    ?>
    <img src="image/erreur.png" alt="erreur" />
    <?php
    echo "le login est déjà utilisé, choisissez en un autre.";
  }else{
    $personne = new Personne($_POST);
    $_SESSION["personne"] = serialize($personne);
    if ($_POST['per_cat'] == "1") {  //si la personne est un etudiant
      if(empty($_POST['dep_num']) && empty($_POST['div_num'])) {
        ?>
        <h1>Ajouter un étudiant</h1>
        <form name="formEtu" method="post">
          <div class="colonneEtu">
            <div class="ligne">
              <label> Année : </label>
              <select name="div_num" id="div_num" required="required">
                <option value="">-- Selectionnez --</option>
                <?php
                $DivisionManager = new DivisionManager($db);
                $divisions = $DivisionManager->getAllDivisions();
                foreach ($divisions as $division) {
                  ?>
                  <option value="<?php echo $division->getDivNum()?>"><?php echo $division->getDivNom()?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <div class="ligne">
              <label >Département : </label>
              <select name="dep_num" id="dep_num" required="required">
                <option value="">-- Selectionnez --</option>
                <?php
                $DepartementManager = new DepartementManager($db);
                $departements = $DepartementManager->getAllDepartements();
                foreach ($departements as $departement) {
                  ?>
                  <option value="<?php echo $departement->getDepNum()?>"><?php echo $departement->getDepNom()?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <input class="button" type="submit" value="Valider"/>
          </div>
        </form>
        <?php
      }
    }
    if ($_POST['per_cat'] == "2") { //si la personne est un salarié
      if (empty($_POST["sal_telprof"]) && empty($_POST["fon_num"])) {
        ?>
        <h1>Ajouter un salarié</h1>
        <form name="formSal" method="post">
          <div class="colonneEtu">
            <div class="ligne">
              <label> Téléphone professionnel : </label>
              <input name="sal_telprof" placeholder="ex: 0555081324" type="number" value="numéro de téléphone" required="required"/>
            </div>
            <div class="ligne">
              <label>Fonction : </label>
              <select name="fon_num" id="fon" required="required">
                <?php
                $FonctionManager = new FonctionManager($db);
                $fonctions = $FonctionManager->getAllFonctions();
                foreach ($fonctions as $fonction) {
                  ?>
                  <option value="<?php echo $fonction->getFonNum() ?>"><?php echo $fonction->getFonLibelle() ?></option>
                  <?php
                }
                ?>
              </select>
            </div>
            <input class="button" type="submit" value="Valider"/>
          </div>
        </form>
        <?php
      }
    }
  }
}
?>
