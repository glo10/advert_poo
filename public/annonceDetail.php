<?php
  session_start();
  require_once '../classes/AdvertManager.php';
  require_once '../classes/Advert.php';
  $advertManager = new AdvertManager();
  $advert = null;
  if(isset($_GET['id']) && preg_match('/[0-9]*/',$_GET['id'])){
      try
      {
        $advert = $advertManager->findById(intval($_GET['id']));
      } catch (FilterException $e)
      {
        echo $e->showError();
      }
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include 'inc/css.inc.php' ?>
    <title>Ledoncoin</title>
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
                $photos = null;
                if($advert->getPhotos())
                {
                  $photos = $advert->getPhotos();
                }
                else
                {
                  $photos = array(0 => new Photo('no_image.png',-1));
                }

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
                    $html .= '<h3 class="card-title"><span class="glyphicon glyphicon-text-width"></span>&nbsp;'.$advert->getTitle().'</h3>';
                    $html .= '<p><span class="glyphicon glyphicon-map-marker"></span>&nbsp;'.$advert->getCity().'</p>';
                    $html .= '<p class="card-text"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;'.$advert->getText().'</p>';
                    $html .= '<p><span class="glyphicon glyphicon-tag"></span>&nbsp;' . $advert->getCategory() . '</p>';
                    $html .= '<p><span class="glyphicon glyphicon-user"></span>&nbsp;' .$advert->getUser()->getFirstName() . '&nbsp;'.$advert->getUser()->getLastName().'</p>';
                    $html .= '<p><span class="glyphicon glyphicon-envelope"></span>&nbsp;'.$advert->getUser()->getEmail().'</p>';
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
