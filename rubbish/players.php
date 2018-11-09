<?php
  require_once '../classes/Player.php';
  require_once '../classes/PlayerManager.php';

  $playerManager = new PlayerManager();

  $players = $playerManager->findAll();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Les joueurs</title>
    <?php include 'css.inc.php' ?>
  </head>
  <body>
    <?php include 'menu.inc.php';?>
    <h1>Tous les joueurs</h1>
    <p>Total : <?= count($players)?></p>
    <table>
      <thead>
        <tr>
          <th>Nom</th>
          <th>Position</th>
          <th>Equipe</th>
        </tr>
      </thead>
      <tbody>
          <?php foreach ($players as $player ) :?>
            <tr>
              <td><?= $player->getName()?></td>
              <td><?= $player->getPosition()?></td>
              <td><?php if($player->getTeam() == null) echo 'Aucune équipe'; else echo $player->getTeam()->getName();?></td>
            </tr>
          <?php endforeach ;?>
      </tbody>
    </table>
  </body>
  </html>
