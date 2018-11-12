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
    <div class="container">
      <?php include 'inc/menu.inc.php';?>
      <?php include 'inc/search.inc.php' ?>
          <section>
            <h2>Liste des annonces</h2>
            <?php if(isset($_GET['success']) && intval($_GET['success']) == 1):?>
              <p class="alert alert-success text-center">L'annonce a été ajouté avec succès</p>
            <?php endif;?>
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
                      $html .= '<h5 class="card-title glyphicon glyphicon-header">&nbsp;'.$advert->getTitle().'</h5>';
                      $html .= '<p><span class="glyphicon glyphicon-map-marker">&nbsp;'.$advert->getCity().'</span></p>';
                      $html .= '<p class="glyphicon glyphicon-list-alt card-text">&nbsp;'.$advert->showLessText(15).'</p>';
                      $html .= '<p><span class="glyphicon glyphicon-tag">&nbsp;' . $advert->getCategory() . '</span></p>';
                      $html .= '<p><span class="glyphicon glyphicon-user">&nbsp;' . $advert->getUser() . '</span></p>';
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
