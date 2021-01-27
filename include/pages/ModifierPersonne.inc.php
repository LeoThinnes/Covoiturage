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
  <h1>Cliquez sur la personne a modifier </h1>
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
    foreach ($Personne as $Personne) { ?>
      <tr>
        <td><a href="index.php?page=3&per_num=<?php echo $Personne->getPerNum() ?>"><?php echo $Personne->getPerNum(); ?></a></td>
        <td><?php echo $Personne->getPerNom(); ?></td>
        <td><?php echo $Personne->getPerPrenom(); ?></td>
        <td><?php echo $PersonneManager->getStatut($Personne->getPerNum()); ?></td>
      </tr>
      <?php
    }
    ?>
  </table>
  <?php
} else {
  $personneModif = $PersonneManager->getPersonne($_GET["per_num"]);
if(empty($_POST["per_nom"])&&empty($_POST["per_prenom"])&&empty($_POST["per_tel"])&&empty($_POST["per_mail"])
&&empty($_POST["per_login"])&&empty($_POST["per_pwd"])&&empty($_POST["dep_num"])&&empty($_POST["div_num"])
&&empty($_POST["fon_num"])&&empty($_POST["sal_telprof"])){
  ?>
    <h1>Modifiez ce que vous souhaitez </h1>
    <div class="tablModif">
      <table class="tablPers">
        <tr>
          <th> Nom </th>
          <th> Prénom </th>
          <th> Telephone </th>
          <th> Mail </th>
          <th> Login </th>
          <th> Mot de passe </th>
          <?php
          if ($PersonneManager->getStatut($_GET["per_num"])=="Etudiant"){
            ?>
            <th> Departement </th>
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
          <td><?php echo $personneModif->getPerNom()?></td>
          <td><?php echo $personneModif->getPerPrenom()?></td>
          <td><?php echo $personneModif->getPerTel()?></td>
          <td><?php echo $personneModif->getPerMail()?></td>
          <td><?php echo $personneModif->getPerLogin()?></td>
          <td>**********</td>
          <?php
          if ($PersonneManager->getStatut($_GET["per_num"])=="Etudiant"){
            $etudiantModif = $EtudiantManager->getInfosEtudiants($_GET['per_num']);
            ?>
            <td><?php echo $etudiantModif->dep_nom;?></td>
            <td><?php echo $etudiantModif->div_nom;?></td>
            <?php
          }
          if ($PersonneManager->getStatut($_GET["per_num"])=="Salarie"){
            $salarieModif = $SalarieManager->getInfosSalaries($_GET['per_num']);
            ?>
            <td><?php echo $salarieModif->sal_telprof;?></td>
            <td><?php echo $salarieModif->fon_libelle;?></td>
            <?php
          }
          ?>
        </tr>
        <tr>
          <form name="formPers" method="post">
            <td><input type="text" placeholder="Nouveau Nom" name="per_nom"></td>
            <td><input type="text" placeholder="Nouveau Prénom"  name="per_prenom"></td>
            <td><input type="text" placeholder="Nouveau tel"  name="per_tel"></td>
            <td><input type="email" placeholder="Nouveau Mail" name="per_mail" pattern=".+@+.+.+."></td>
            <td><input type="text" placeholder="Nouveau Login" name="per_login"></td>
            <td><input type="password" placeholder="Nouveau Mot de passe" name="per_pwd"></td>
            <?php
            if ($PersonneManager->getStatut($_GET["per_num"])=="Etudiant"){
              $etudiantModif = $EtudiantManager->getInfosEtudiants($_GET['per_num']);
              ?>
              <td>
                <select name="dep_num" id="dep_num">
                  <option value="">-- Selectionnez --</option>
                  <?php
                  $DepartementManager = new DepartementManager($pdo);
                  $departements = $DepartementManager->getAllDepartements();

                  foreach ($departements as $departement) {
                    ?>
                    <option value="<?php echo $departement->getDepNum()?>"><?php echo $departement->getDepNom()?></option>
                    <?php
                  }
                  ?>
                </select>
              </td>
              <td>
                <select name="div_num" id="div_num">
                  <option value="">-- Selectionnez --</option>
                  <?php
                  $DivisionManager = new DivisionManager($pdo);
                  $divisions = $DivisionManager->getAllDivisions();
                  foreach ($divisions as $division) {
                    ?>
                    <option value="<?php echo $division->getDivNum()?>"><?php echo $division->getDivNom()?></option>
                    <?php
                  }
                  ?>
                </select>
              </td>
              <?php
            }
            if ($PersonneManager->getStatut($_GET["per_num"])=="Salarie"){
              $salarieModif = $SalarieManager->getInfosSalaries($_GET['per_num']);
              ?>
              <td><input name="sal_telprof" placeholder="ex: 0555081324" type="number" value="numéro de téléphone"></td>
              <td>
                <select name="fon_num" id="fon_num">
                  <?php
                  $FonctionManager = new FonctionManager($pdo);
                  $fonctions = $FonctionManager->getAllFonctions();

                  foreach ($fonctions as $fonction) {
                    ?>
                    <option value="<?php echo $fonction->getFonNum() ?>"><?php echo $fonction->getFonLibelle() ?></option>
                    <?php
                  }
                  ?>
                </select>
              </td>
              <?php
            }
            ?>
          </tr>
        </table>
      </div>
      <input class="button" type="submit" value="Valider"/>
    </form>
    <?php
  }else{
    if(empty($_POST["per_nom"])){
      $per_nom = $personneModif->getPerNom();
    }else{
      $per_nom = $_POST["per_nom"];
    }
    if(empty($_POST["per_prenom"])){
      $per_prenom = $personneModif->getPerPrenom();
    }else{
      $per_prenom = $_POST["per_prenom"];
    }
    if(empty($_POST["per_tel"])){
      $per_tel = $personneModif->getPerTel();
    }else{
      $per_tel = $_POST["per_tel"];
    }
    if(empty($_POST["per_mail"])){
      $per_mail = $personneModif->getPerMail();
    }else{
      $per_mail = $_POST["per_mail"];
    }
    if(empty($_POST["per_login"])){
      $per_login = $personneModif->getPerLogin();
    }else{
      $per_login = $_POST["per_login"];
    }
    if(empty($_POST["per_pwd"])){
      $per_pwd = $personneModif->getPerPwd();
    }else{
      $per_pwd = $_POST["per_pwd"];
    }
    if ($PersonneManager->getStatut($_GET["per_num"])=="Etudiant"){
      $etudiantModif = $EtudiantManager->getInfosEtudiants($_GET['per_num']);
      if(empty($_POST["dep_num"])){
        $dep_num = $etudiantModif->dep_num;
      }else{
        $dep_num = $_POST["dep_num"];
      }
      if(empty($_POST["div_num"])){
        $div_num = $etudiantModif->div_num;
      }else{
        $div_num = $_POST["div_num"];
      }
      $PersonneManager->upd($_GET["per_num"],$per_nom, $per_prenom, $per_tel, $per_mail, $per_login,$per_pwd , '1', $dep_num, $div_num);
      ?>
      <img src="image/valid.png" alt="valid">
      <?php
      echo "L'étudiant $per_nom a été modifiée !";
    }
    if ($PersonneManager->getStatut($_GET["per_num"])=="Salarie"){
      $salarieModif = $SalarieManager->getInfosSalaries($_GET['per_num']);
      if(empty($_POST["sal_telprof"])){
        $sal_telprof = $salarieModif->sal_telprof;
      }else{
        $sal_telprof = $_POST["sal_telprof"];
      }
      if(empty($_POST["fon_num"])){
        $fon_num = $salarieModif->fon_num;
      }else{
        $fon_num = $_POST["fon_num"];
      }
      $PersonneManager->upd($_GET["per_num"],$per_nom, $per_prenom, $per_tel, $per_mail, $per_login, $per_pwd, '0', $sal_telprof, $fon_num);
      ?>
      <img src="image/valid.png" alt="valid">
      <?php
      echo "Le salarié $per_nom a été modifiée !";
    }
  }
}
?>
