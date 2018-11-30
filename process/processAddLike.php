<?php
  use Advert_poo\Classes\Advert;
  use Advert_poo\Classes\User;

  require '../classes/Advert.php';
  require '../classes/User.php';
  
  $request = file_get_contents('php://input');
  //$request = json_encode(['id' => 2,"likes" => 0, "update" =>false]);
  $data = json_decode($request);

  $id              = htmlspecialchars(intval($data->id));
  $likes           = htmlspecialchars(intval($data->likes) + 1);
  $isUpdate        = htmlspecialchars($data->isUpdate);
  try
  {
    $user  = (isset($_SESSION['email']))?new User($_SESSION['email']): new User('anonymous@anonymous.com');
    $advert = new Advert(
                          'title',
                          'text',
                          '1991-01-01 10:00',
                          'addr',
                          'city',
                          'pc',
                          $likes,
                          'category',
                          $user
                        );
    $advert->setId($id);

    if ($advert->update($isUpdate))
      echo json_encode(['result' =>'ok','likes' => $advert->getLikes()],JSON_FORCE_OBJECT);
    else
      echo json_encode(['result' =>'erreur'],JSON_FORCE_OBJECT);

  } catch (FilterException $e) {
    echo $e->showError();
  }
