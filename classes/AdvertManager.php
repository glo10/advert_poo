<?php

require_once 'Advert.php';
require_once 'Photo.php';

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

    $select .= 'ORDER BY        A.likes   DESC,date DESC';

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

  public function findById($id){
    $query = 'SELECT            A.id_advert,
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
                WHERE           A.id_advert = :id';
    $select = $this->pdo->prepare($query);
    $select->bindParam(':id',intval($id));
    $select->execute();
    $row = $query->fetch(PDO::FETCH_OBJ);

    if(!$row) return null;

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
    return $advert;
  }

  public function deleteById($id){
    $query = $this->pdo->prepare('DELETE FROM advert WHERE id = :id');
    $query->bindParam(':id',intval($id));
    return $query->execute();
  }
}
