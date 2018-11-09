<?php
  require_once '../classes/TeamManager.php';
  $id = intval($_GET['id']);
  $tm = new TeamManager();
  $team = $tm->findById($id);

  if(!empty($_POST)){
    $team->setName($_POST['name']);
    $team->setYearFoundation(intval($_POST['yearFoundation']));
    $team->setLeague($_POST['league']);
    $team->setStadium($_POST['stadium']);
    $team->setCoach($_POST['coach']);
    if($team->update())
      header('location:index.php');
    else
      echo 'erreur';
  }

 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Modifier joueur</title>
         <?php include 'css.inc.php';?>
   </head>
   <body>
         <?php include 'menu.inc.php';?>

         <form method="post">
           <input type="text" name="name" placeholder="Nom" value="<?= $team->getName()?>">
           <input type="text" name="yearFoundation" placeholder="Année de création" value="<?= $team->getYearFoundation()?>">
           <input type="text" name="league" placeholder="Championnat" value="<?= $team->getLeague()?>">
           <input type="text" name="stadium" placeholder="Nom du stade" value="<?= $team->getStadium()?>">
           <input type="text" name="coach" placeholder="Entraîneur" value="<?= $team->getCoach()?>">
           <input type="submit" value="Mettre à jour">
         </form>

   </body>
 </html>
