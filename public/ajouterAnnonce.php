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
    <div class="container-fluid">
      <div class="row">
        <?php include 'inc/menu.inc.php';?>
        <section>
            <h2>Formaulaire de saisi d'une annonce</h2>
            <form action="../process/processAddAdvert.php" method="POST">
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
                  <input type="submit" class="btn btn-success" value="Ajouter">
                </div>
              </form>
        </section>
      </div>
    </div>
  </body>
</html>
