<?php
  require_once '../classes/PlayerManager.php';
  // $id = intval($_GET['id']);
  $pm = new PlayerManager();

  $id = htmlspecialchars(intval($_GET['id']));

  echo json_encode($pm->deleteById($id));
