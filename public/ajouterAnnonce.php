<?php
  require_once '../classes/CategoryManager.php';
  require_once '../classes/Category.php';
  $categoryManager = new CategoryManager();
  $categories = $categoryManager->findAll();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ajouter une annonce</title>
    <?php include 'inc/css.inc.php' ?>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <?php include 'inc/menu.inc.php';?>
        <section class="content-center">
            <h2>Formulaire de saisi d'une annonce</h2>
            <p class="text-info"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;Formats [jpg,png] && taille inférieur à 3Mo</p>
            <?php if(isset($_GET['error']) && intval($_GET['error']) == -1):?>
              <p class="alert alert-danger">L'annonce n'a pas été enregistré, le format ou la taille d'un des fichiers ne correspond pas aux exigences</p>
            <?php endif;?>
            <form action="../process/processAddAdvert.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="text" class="form-control" name="title" placeholder="Titre">
                </div>
                <div class="form-group">
                  <select class="form-control" name="category">
                    <option value="-1" disabled selected>Choisir une catégorie</option>
                      <?php foreach($categories as $category) :?>
                        <option value="<?=$category->getId()?>"><?=$category->getLabel()?></option>
                      <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="addr" placeholder="Adresse">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="city" placeholder="Ville">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="pc" pattern="[0-9]{5}" placeholder="Code postale">
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="text" rows="3" placeholder="Votre annonce"></textarea>
                </div>
                <div class="form-group">
                  <input class="" type="file" name="photos[]" multiple>
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-success offset-8 col-4" value="Ajouter">
                </div>
              </form>
        </section>
      </div>
    </div>
  </body>
</html>
