<?php

require_once 'Advert.php';
require_once 'Photo.php';
require_once 'AdvertManager.php';

class AdvertManager {
  private $pdo = null;

  function __construct() {
    $this->connect();
  }

  private function connect() {
    try {
      $this->pdo = new PDO('mysql:host=localhost;dbname=annonce', 'root', '');
    } catch(PDOException $e) {
      var_dump($e);
    }
  }

  public function findAll($search = null) {
    $select = ' SELECT  A.id_advert,
                        A.title,
                        A.text,
                        A.date,
                        A.addr,
                        A.city,
                        A.pc,
                        A.likes,
                        C.label,
                        U.last_name,
                        U.first_name
                FROM    advert    A
                JOIN    category  C
                ON      A.category = C.id_category
                JOIN    user      U
                ON      A.user = U.email
              ';

    if($search != null){
      $select .= '
                WHERE   C.label = :label OR A.title = :title';
    }


    $query = $this->pdo->prepare($select);

    if($search != null){
      $query->bindParam(':label',$search);
      $query->bindParam(':title',$search);
    }

    $adverts = [];

    if($query->execute()){
      $rows = $query->fetchAll(PDO::FETCH_OBJ);

      foreach($rows as $row) {
        $advert = new Advert(
                              $row->title,
                              $row->text,
                              $row->date,
                              $row->addr,
                              $row->city,
                              $row->pc,
                              $row->likes,
                              $row->label,
                              $row->first_name.' '.$row->last_name
                            );

        $advert->setId($row->id_advert);
        array_push($adverts,$advert);
      }
    }

    return $adverts;
  }

  public function save(Advert $advert, Photo $photo){
      $lastId = null;
      $this->pdo->beginTransaction();

      //INSERT INTO advert
      $insertAdvert = 'INSERT INTO advert(
                                    title,
                                    text,
                                    addr,
                                    city,
                                    pc,
                                    category,
                                    user
                                  )
                                  VALUES(
                                    :title,
                                    :text,
                                    :addr,
                                    :city,
                                    :pc,
                                    :category,
                                    :user
                                  )';
      $query = $this->pdo->prepare($insertAdvert);
      $paramsAdvert = array(
                            ":title" => $advert->getTitle(),
                            ":text" => $advert->getText(),
                            ":addr" => $advert->getAddr(),
                            ":city" => $advert->getCity(),
                            ":pc" => $advert->getPc(),
                            ":category" => $advert->getCategory(),
                            ":user" => $advert->getUser()
                        );
      if(
        $queryAdvert->execute($paramsAdvert)
      )
      {
        //INSERT INTO photo
        $lastId = $this->pdo->lastInsertId();
        $insertPhoto = 'INSERT INTO photo(src) VALUES(:src)';
        $queryPhoto = $this->pdo->prepare($insertPhoto);

        $queryPhoto->bindParam('src',$photo->getSrc());
        if($queryPhoto->execute())
        {
          $this->pdo->commit();
        }
        else{
          $this->pdo->rollback();
        }
      }
      else{
        $this->pdo->rollback();
      }
      return lastId();
    }













  public function findById($id){
    $query = $this->pdo->prepare('SELECT * FROM player WHERE id = :id');
    $query->bindParam(':id',intval($id));
    $query->execute();
    $row = $query->fetch(PDO::FETCH_OBJ);

    if(!$row) return null;

    $player = new Player($row->name, $row->position);
    $player->setId($row->id);

    return $player;
  }

  public function deleteById($id){
    $query = $this->pdo->prepare('DELETE FROM player WHERE id = :id');
    $query->bindParam(':id',intval($id));
    return $query->execute();
  }
}
