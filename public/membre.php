<?php
  session_start();

  require_once '../classes/user.php';
  require_once '../classes/AdvertManager.php';
  require_once '../classes/Advert.php';

  $user = new User($_SESSION['email']);
  $advertManager = new AdvertManager();
  $adverts = $advertManager->findByUser($user);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Espace membre</title>
    <?php include 'inc/css.inc.php'?>
  </head>
  <body>
    <div class="container">
      <?php include 'inc/menu.inc.php'?>
      <h2 class="display-6">Mes annonces</h2>
      <?php if($adverts) :?>
        <?php $user->setAdvertCollection($adverts);?>
        <table class="table table-responsive">
          <thead>
            <tr>
              <th></th>
              <th>
                <span class="glyphicon glyphicon-header"></span>
              </th>
              <th>
                <span class="glyphicon glyphicon-time"></span>
              </th>
              <th>
                <span class="glyphicon glyphicon-heart text-danger"></span>
              </th>
              <th>
                <span class="glyphicon glyphicon-tags"></span>
              </th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($user->getAdvertCollection() as $advert) :?>
                <tr>
                  <td><?=$advert->getId()?></td>
                  <td><?=$advert->gettitle()?></td>
                  <td><?=$advert->getDate()?></td>
                  <td><?=$advert->getLikes()?></td>
                  <td><?=$advert->getCategory()?></td>
                  <td>
                    <button data-idAvert="" class="edit btn btn-info"><span class="glyphicon glyphicon-eye-open"></span></button>
                  </td>
                  <td>
                    <button data-idAvert="" class="edit btn btn-warning"><span class="glyphicon glyphicon-edit"></span></button>
                  </td>
                  <td>
                    <button data-idAvert="" class="remove btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button>
                  </td>
                </tr>
            <?php endforeach;?>
          </tbody>
        </table>
        <?php else: ?>
          <p class="alert alert-info text-center">Vous avez aucune annonce de publiée </p>
        <?php endif;?>
    </div>
  </body>
</html>
