<?php

  require_once '../classes/TeamManager.php';
  $id = intval($_GET['id']);
  $tm = new TeamManager();
  $team = $tm->findById($id);

  if($team->delete())
    header('location:index.php');
  else
    echo 'erreur';
