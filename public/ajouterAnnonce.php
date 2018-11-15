<?php
  session_start();
  if(empty($_SESSION['email']))
    header('location:index.php?connect=-1');
  require_once '../classes/CategoryManager.php';
  require_once '../classes/Category.php';
  $categoryManager = new CategoryManager();
  $categories = $categoryManager->findAll();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php include 'inc/css.inc.php' ?>
    <title>Ajouter une annonce</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <?php include 'inc/menu.inc.php';?>
        <section class="content-center">
            <h2>Formulaire de saisi d'une annonce</h2>
            <p id="userMsg" class="text-danger"></p>
            <p class="text-info">
              <span class="glyphicon glyphicon-info-sign"></span><br/>
              <span>Formats autorisées jpg, jpeg ou png</span><br/>
              <span>Taille maximale d'une photo 3Mo</span><br/>
              <span>Taille totale des photos 8Mo</span>
            </p>
            <form data-url="../process/processAddAdvert.php" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="text" class="form-control" name="title" placeholder="Titre" pattern=".{1,80}" required>
                </div>
                <div class="form-group">
                  <select class="form-control" name="category" required>
                    <option value="-1" disabled selected>Choisir une catégorie</option>
                      <?php foreach($categories as $category) :?>
                        <option value="<?=$category->getId()?>"><?=$category->getLabel()?></option>
                      <?php endforeach;?>
                  </select>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="addr" placeholder="Adresse" pattern=".{1,80}" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="city" placeholder="Ville" pattern=".{1,80}" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="pc" placeholder="Code postale" pattern="[0-9]{5}" required>
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="text" rows="3" placeholder="Votre annonce" required></textarea>
                </div>
                <div class="form-group">
                  <input class="" type="file" name="photos[]" multiple required>
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-success offset-8 col-4" value="Ajouter">
                </div>
              </form>
        </section>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="js/appJquery.js"></script>
  </body>
</html>
