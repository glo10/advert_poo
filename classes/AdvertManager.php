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
    $select = ' SELECT          A.id_advert,
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
                FROM            advert    A
                LEFT  JOIN      category  C
                ON              A.category = C.id_category
                JOIN            user      U
                ON              A.user = U.email
              ';

    if($search != null){
      $select .= '
                WHERE   C.label = :label OR A.title = :title ';
    }

    $select .= 'ORDER BY        A.likes   DESC';

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
      $lastIdAdvert = null;
      $lastIdPhoto = null;
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
        $lastIdAdvert = $this->pdo->lastInsertId();
        $advert->setId($lastIdAdvert);
        //INSERT INTO photo
        $insertPhoto = 'INSERT INTO photo(src) VALUES(:src)';
        $queryPhoto = $this->pdo->prepare($insertPhoto);

        $queryPhoto->bindParam(':src',$photo->getSrc());
        if($queryPhoto->execute())
        {
          //INSERT INTO photo_advert
          $lastIdPhoto = $this->pdo->lastInsertId();
          $photo->setId($lastIdPhoto);
          $queryPhotoAdvert = 'INSERT INTO photo_advert(
                                                        id_advert,
                                                        id_photo
                                                      )
                                      VALUES(
                                                        :id_advert,
                                                        :id_photo
                                            )';
          $insertPhotoAdvert = $this->pdo->prepare($queryPhotoAdvert);
          $insertPhotoAdvert->bindParam(':id_advert',$advert->getId());
          $insertPhotoAdvert->bindParam(':id_photo',$photo->getId());

          if($insertPhotoAdvert->execute())
          {
            $this->pdo->commit();
            return $advert->getId();
          }
        }
      }
      $this->pdo->rollback();
      return null;
    }

  public function findById($id){
    $query = $this->pdo->prepare('SELECT * FROM advert WHERE id = :id');
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
