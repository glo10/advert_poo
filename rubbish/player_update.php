<?php
    //get data from front
    require_once '../classes/playerManager.php';
    $request = file_get_contents('php://input');
    $data = json_decode($request);

    $pm = new PlayerManager();

    $player = $pm->findById(intval($data->id));

    //update properties of player
    $player->setName($data->name);
    $player->setPosition($data->position);

    //save new values in database
    echo json_encode(['id'=>$player->Update()]);
