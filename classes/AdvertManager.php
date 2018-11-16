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
                WHERE   C.label LIKE :label OR A.title LIKE :title OR A.city LIKE :city ';
    }

    $select .= 'ORDER BY        A.likes   DESC,date DESC';

    $query = $this->pdo->prepare($select);

    if($search != null){
      $search = '%'.$search.'%';
      $query->bindParam(':label',$search);
      $query->bindParam(':title',$search);
      $query->bindParam(':city',$search);
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

  public function findByUser($user){
    $query = 'SELECT            A.id_advert,
                                A.title,
                                A.text,
                                DATE_FORMAT(A.date,"%d/%m/%Y %H:%i") AS date,
                                A.addr,
                                A.city,
                                A.pc,
                                A.likes,
                                C.label,
                                A.user
                FROM            advert    A
                LEFT  JOIN      category  C
                ON              A.category = C.id_category
                WHERE           A.user = :email
                ORDER BY        A.date DESC';
    $select = $this->pdo->prepare($query);
    $select->execute([':email'=> $user->getEmail()]);

    $rows = $select->fetchAll(PDO::FETCH_OBJ);

    if(!$rows) return null;

    $adverts = [];
    foreach($rows as $row){
      $advert = new Advert(
                            $row->title,
                            $row->text,
                            $row->date,
                            $row->addr,
                            $row->city,
                            $row->pc,
                            $row->likes,
                            $row->label,
                            $row->user
                          );
      $advert->setId($row->id_advert);
      array_push($adverts,$advert);
    }
    return $adverts;
  }

  public function deleteById($id){
    $query = $this->pdo->prepare('DELETE FROM advert WHERE id = :id');
    $query->bindParam(':id',intval($id));
    return $query->execute();
  }
}
