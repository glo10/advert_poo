<?php
  require_once '../classes/AdvertManager.php';
  require_once '../classes/Advert.php';
  $advertManager = new AdvertManager();
  $search = isset($_POST['search'])?htmlspecialchars($_POST['search']):null;
  $adverts = $advertManager->findAll($search);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Le don coin</title>
    <?php include 'inc/css.inc.php' ?>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <?php include 'inc/menu.inc.php';?>
          <section class="col-10">
            <?php include 'inc/search.inc.php' ?>
            <h2>Liste des annonces</h2>
              <?php
              $html = '';
              if($adverts)
              {?>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Titre</th>
                      <th>Date de création</th>
                      <th>Contenu</th>
                      <th>Catégorie</th>
                      <th>Donneur</th>
                      <th>Like</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        foreach($adverts as $advert) {
                          $html .= '<tr data-id = "'. $advert->getId() .'">';
                          $html .= '<td><a href="annonce.php?id='. $advert->getId() .'">' . $advert->getTitle() . '</a></td>';
                          $html .= '<td>' . $advert->getDate() . '</td>';
                          $html .= '<td>' . $advert->getText() . '</td>';
                          $html .= '<td>' . $advert->getCategory() . '</td>';
                          $html .= '<td>' . $advert->getUser() . '</td>';
                          $html .= '<td data-id = "'. $advert->getId() .'" data-likes="'.$advert->getLikes().'"><span class="glyphicon glyphicon-heart text-danger"></span>&nbsp;' .$advert->getLikes() . '</td>';
                          $html .= '</tr>';
                        }
                $html .= '</tbody>';
              $html .= '</table>';
              }
              else
              {
                $html .='<p class="alert alert-info">Aucun annonce a été trouvé</p>';
              }
              echo $html;
              ?>
        </section>
      </div>
    </div>
    <script src="js/app.js"></script>
  </body>
</html>
