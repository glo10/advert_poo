<?php
  require_once '../classes/AdvertManager.php';
  require_once '../classes/Advert.php';
  $advertManager = new AdvertManager();
  if(isset($_GET['id']) && preg_match('/[0-9]*/',$_GET['id'])){
      $advert = $advertManager->findById(htmlspecialchars(intval($_GET['id'])));
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Le don coin</title>
    <?php include 'inc/css.inc.php' ?>
  </head>
  <body>
    <div class="container">
      <?php include 'inc/menu.inc.php';?>
      <?php include 'inc/search.inc.php' ?>
          <section>
            <h2>Annonce détaillée</h2>
              <?php
              $html = '';
              if($advert)
              {
                $photos = $advert->getPhotos();
                $html .= '<div class="flex-center">';
                foreach($photos as $photo)
                {
                  $html .= '<div>
                                  <img data-idPhoto="'.$photo->getId().'" class="img-thumbnail img-detail" src="img/'.$photo->getSrc().'" alt="Photo principale de l\'annonce"/>
                            </div>';
                }

                $html .= '</div>';
                $html .= '<div class="card full">';
                  $html .= '<div class="card-body">';
                    $html .= '<h3 class="card-title glyphicon glyphicon-header">&nbsp;'.$advert->getTitle().'</h3>';
                    $html .= '<p><span class="glyphicon glyphicon-map-marker">&nbsp;'.$advert->getCity().'</span></p>';
                    $html .= '<p class="glyphicon glyphicon-list-alt card-text">&nbsp;'.$advert->getText().'</p>';
                    $html .= '<p><span class="glyphicon glyphicon-tag">&nbsp;' . $advert->getCategory() . '</span></p>';
                    $html .= '<p><span class="glyphicon glyphicon-user">&nbsp;' . $advert->getUser() . '</span></p>';
                    $html .= '<div class="flex-between">';
                      $html .= '<div>
                                    <span data-id="'.$advert->getId().'" data-likes="'.$advert->getLikes().'" class="glyphicon glyphicon-heart text-danger"></span>&nbsp;
                                    <span>' .$advert->getLikes() . '</span>
                                </div>';
                    $html .= '</div>';
                  $html .= '</div>';
                $html .= '</div>';
              }
              else
              {
                $html .='<p class="alert alert-info text-center">Aucune annonce a été trouvée</p>';
              }
              $html .= '</div>';
              echo $html;
              ?>
        </section>
    </div>
    <script src="js/app.js"></script>
  </body>
</html>
