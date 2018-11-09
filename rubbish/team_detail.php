<?php
  require_once '../classes/TeamManager.php';
  $tm = new TeamManager();

  $id = intval($_GET['id']);
  $team = $tm->findByIdJoin($id);
  $othersTeams = $tm->getTeamsSameLeague($team);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Equipe: <?php echo $team->getName() ?></title>
    <?php include_once 'css.inc.php' ?>
  </head>
  <body>
    <div class="container">
    <?php include_once 'menu.inc.php';?>
    <h1>Equipe: <?php echo $team->getName() ?></h1>
    <p>Entraîneur:
      <strong><?php echo $team->getCoach(); ?></strong>
    </p>
    <h2>Enregistrement d'un joueur</h2>

    <form id="playerForm">
      <input  type="hidden" value="<?=$team->getId()?>">
      <input  id="name" type="text" placeholder="Saisir le nom">
      <select id="position">
        <option>gardien</option>
        <option>défenseur</option>
        <option>milieu</option>
        <option>attaquant</option>
      </select>
      <input type="submit"  value="Enregistrer">
    </form>
    <div class="row">
        <h2>Liste de joueurs</h2>
        <table id="playersTable" class="col-9">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Position</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($team->getPlayers() as $player):?>
              <tr>
                <td><?=$player->getName()?></td>
                <td><?=$player->getPosition()?></td>
                <td>
                  <button data-id="<?= $player->getId()?>" class="btnEdit btn btn-warning" type="button" name="button">Editer</button>
                  <button data-id="<?= $player->getId()?>" class="btnDelete btn btn-danger" type="button" name="button">Supprimer</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="col-3">

          <h4>Liste des autres équipes évoluant dans la même ligue</h4>
          <ul class="list-group">
            <?php foreach($othersTeams as $team) :?>
              <li><a href="team_detail.php?id=<?=$team->getId()?>"><?=$team->getName()?></a></li>
            <?php endforeach;?>
          </ul>
        </div>
  </div>
</div>


    <script src="js/app.js"></script>
  </body>
</html>
