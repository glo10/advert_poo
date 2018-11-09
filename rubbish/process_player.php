<?php
  require_once 'classes/Player.php';
  require_once 'classes/TeamManager.php';
  $body = trim(file_get_contents("php://input"));
  $myPlayer = json_decode($body);

  $tm = new TeamManager();

  $player = new Player(
                        $myPlayer->name,
                        $myPlayer->position,
                        $tm->findById(intval($myPlayer->team_id))
                      );

  echo json_encode($player->save());
