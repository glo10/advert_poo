<?php
  session_start();

  require_once '../classes/AdvertManager.php';
  require_once '../classes/Advert.php';
  require_once '../classes/MyFunctions.php';

  $advertManager = new AdvertManager();
  $search = isset($_POST['search'])?htmlspecialchars($_POST['search']):null;
  $adverts = null;
  try
  {
    $adverts = $advertManager->findAll($search);
  } catch (FilterException $e)
  {
    echo $e->showError();
  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>Ledoncoin</title>
    <?php include 'inc/css.inc.php' ?>
  </head>
  <body>
    <div class="container">
      <?php include 'inc/menu.inc.php';?>
      <?php include 'inc/search.inc.php' ?>
          <section>
            <h2>Liste des annonces</h2>
            <p id="userMsg" class="text-info"></p>
              <?php
              $html = '<div class="flex-center">';
              if($adverts)
              {
                foreach($adverts as $advert)
                {

                  $photos = $advert->getPhotos();
                  $advert->setPhotoCollection($photos);

                  $src = ($advert->getMainPhoto())?$advert->getMainPhoto()->getSrc():'no_image.png';
                  $idPhoto = ($advert->getMainPhoto())?$advert->getMainPhoto()->getId():-1;

                  $html .= '<div class="card">';
                    $html .= '<img data-idPhoto="'.$idPhoto.'" class="card-img-top" src="img/'.$src.'" alt="Photo principale de l\'annonce">';
                    $html .= '<div class="card-body">';
                      $html .= '<h5 class="card-title glyphicon glyphicon-text-width">&nbsp;'.$advert->getTitle().'</h5>';
                      $html .= '<p><span class="glyphicon glyphicon-map-marker">&nbsp;'.$advert->getCity().'</span></p>';
                      $html .= '<p class="glyphicon glyphicon-list-alt card-text">&nbsp;'.MyFunctions::showLessText($advert->getText(),15).'</p>';
                      $html .= '<p><span class="glyphicon glyphicon-tag">&nbsp;'.$advert->getCategory().'</span></p>';
                      $html .= '<p><span class="glyphicon glyphicon-user">&nbsp;'.MyFunctions::showLessText($advert->getUser()->getFirstName(),15).'</span></p>';
                      $html .= '<div class="flex-between">';
                      $html .= '<div><a href="annonceDetail.php?id='. $advert->getId() .'"><span class="glyphicon glyphicon-eye-open"></span></a></div>';
                      $html .= '<div><span data-id="'.$advert->getId().'" data-likes="'.$advert->getLikes().'" class="glyphicon glyphicon-heart text-danger"></span>&nbsp;<span>' .$advert->getLikes() . '</span></div>';
                      $html .= '</div>';
                    $html .= '</div>';
                  $html .= '</div>';

                }
              }
              else
              {
                $html .='<p class="alert alert-info">Aucune annonce a été trouvée</p>';
              }
              $html .= '</div>';
              echo $html;
              ?>
        </section>
    </div>
    <script src="js/app.js"></script>
  </body>
</html>
