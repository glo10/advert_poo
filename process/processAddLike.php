<?php

  require '../classes/Advert.php';
  $request = file_get_contents('php://input');
  //$request = json_encode(['id' => 2,"likes" => 0, "update" =>false]);
  $data = json_decode($request);

  $id              = htmlspecialchars(intval($data->id));
  $likes            = htmlspecialchars(intval($data->likes) + 1);
  $update          = htmlspecialchars($data->update);

  $advert = new Advert(
                        'title',
                        'text',
                        '0000-00-00',
                        'addr',
                        'city',
                        'pc',
                        $likes,
                        'category',
                        '$user'
                      );
  $advert->setId($id);

  if ($advert->update($update))
    echo json_encode(['result' =>'ok','likes' => $advert->getLikes()],JSON_FORCE_OBJECT);
  else
    echo json_encode(['result' =>'erreur'],JSON_FORCE_OBJECT);
