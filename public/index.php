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
              $html = '';
              if($adverts){
                foreach($adverts as $advert) {
                  $html .= '<tr>';
                  $html .= '<td><a href="annonce.php?id='. $advert->getId() .'">' . $advert->getTitle() . '</a></td>';
                  $html .= '<td>' . $advert->getDate() . '</td>';
                  $html .= '<td>' . $advert->getText() . '</td>';
                  $html .= '<td>' . $advert->getCategory() . '</td>';
                  $html .= '<td>' . $advert->getUser() . '</td>';
                  $html .= '<td><span class="glyphicon glyphicon-heart text-danger"></span>&nbsp;' .$advert->getLikes() . '</td>';
                  $html .= '</tr>';
                }
              }
              else{
                $html .='<tr>
                            <td class="alert alert-info">Aucun annonce a été trouvé</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>';
              }

              echo $html;
              ?>
            </tbody>
          </table>
        </section>
      </div>
    </div>
  </body>
</html>
