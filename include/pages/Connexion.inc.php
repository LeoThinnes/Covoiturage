<h1>Pour vous connecter</h1>
<?php
$db = new Mypdo();
$PersonneManager = new PersonneManager($db);
if (empty($_POST["per_login"]) || empty($_POST["per_pwd"]) || empty($_POST["robot"])) {
  $_SESSION["chiffre1"] = rand(1, 9);
  $_SESSION["chiffre2"] = rand(1, 9);
  ?>
  <form action="index.php?page=11" method="post" id="connexion">
    <div class="formConnex">
      <label>Nom d'utilisateur :</label>
      <input type="text" name="per_login">
      <label>Mot de passe : </label>
      <input type="password" name="per_pwd">

      <label>
        <img name="image1" src="image/nb/<?php echo $_SESSION["chiffre1"] ?>.jpg">
        +
        <img name="image2" src="image/nb/<?php echo $_SESSION["chiffre2"] ?>.jpg">
        =
      </label>
      <input type="number" name="robot">
    </div>
    <input class="button" type="submit" value="Valider"/>
  </form>
  <?php
} else {
  $per_login = $_POST["per_login"];
  $per_pwd = sha1(sha1($_POST["per_pwd"]) . $PersonneManager->getSalt());
  if ($PersonneManager->VerifConnexion($per_login, $per_pwd) != false && $_POST["robot"] == ($_SESSION['chiffre1'] + $_SESSION['chiffre2'])) {
    $_SESSION["per_login"] = $per_login;
    $_SESSION["per_num"] = $PersonneManager->VerifConnexion($per_login, $per_pwd);
    header("Location: index.php?page=0");
    exit;
  } else {
    ?>
    <img src="image/erreur.png" alt="erreur">
    <?php
    echo "Votre identifiant ou votre mot de passe est incorrecte.";
  }
}
?>
