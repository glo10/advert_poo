<nav class="navbar navbar-expand-lg navbar-light bg-light col-12">

  <ul class="navbar-nav col-12">
    <li class="nav-item col-2">
      <span class="text-danger glyphicon glyphicon-home"></span>
      <a href="accueil.php">Accueil</a>
    </li>
    <li class="nav-item col-2">
      <span class="text-danger glyphicon glyphicon-plus"></span>
      <a href="ajouterAnnonce.php">Annonce</a>
    </li>
    <?php if(isset($_SESSION['email'])) :?>
    <li class="nav-item offset-4 col-2">
      <span class="text-danger glyphicon glyphicon-user"></span>
      <a href="membre.php"><?= $_SESSION['firstName']?></a>
    </li>
    <li class="nav-item col-2">
      <span class="text-danger glyphicon glyphicon-off"></span>
      <a href="deconnexion.php">Déconnexion</a>
    </li>
    <?php else :?>
    <li class="nav-item offset-6 col-2">
      <span class="text-danger glyphicon glyphicon-user"></span>
      <a href="index.php">Authentification</a>
    </li>
    <?php endif;?>
  </ul>

</nav>
