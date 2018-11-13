<nav class="navbar navbar-expand-lg navbar-light bg-light col-12">

  <ul class="navbar-nav col-12">
    <li class="nav-item col-2">
      <a href="accueil.php">Accueil</a>
    </li>
    <li class="nav-item col-2">
      <a href="ajouterAnnonce.php">Ajouter une annonce</a>
    </li>
    <?php if(isset($_SESSION['email'])) :?>
    <li class="nav-item offset-4 col-2">
      <a href="#"><?= $_SESSION['firstName']?></a>
    </li>
    <li class="nav-item col-2">
      <a href="deconnexion.php">Déconnexion</a>
    </li>
    <?php else :?>
    <li class="nav-item offset-4 col-2">
      <a href="index.php">Se connecter/S'inscrire</a>
    </li>
    <?php endif;?>
  </ul>

</nav>
