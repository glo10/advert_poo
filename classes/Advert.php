<?php
  require_once 'Photo.php';

  class Advert {
    private $id;
    private $title;
    private $text;
    private $date;
    private $addr;
    private $city;
    private $pc;
    private $likes;
    private $category;
    private $user;
    private $photoCollection;
    private $pdo;

    function __construct($title, $text, $date,$addr,$city, $pc,$likes,$category,$user) {
      $this->title = $title;
      $this->text = $text;
      $this->date = $date;
      $this->addr = $addr;
      $this->city = $city;
      $this->pc = $pc;
      $this->likes = $likes;
      $this->category = $category;
      $this->user = $user;

      try {
        $this->pdo = new PDO('mysql:host=localhost;dbname=annonce', 'root', '');
      } catch (PDOException $e) {
        var_dump($e);
      }
    }

    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getText() { return $this->text; }
    public function getDate() { return $this->date; }
    public function getAddr() { return $this->addr; }
    public function getCity() { return $this->city; }
    public function getPc() { return $this->pc; }
    public function getLikes() { return $this->likes; }
    public function getCategory() { return $this->category; }
    public function getUser() { return $this->user; }
    public function getPhotoCollection() { return $this->photoCollection; }


    public function setId($id) { return $this->id = $id; }
    public function setTitle($title) { return $this->title = $title; }
    public function setText($text) { return $this->text = $text; }
    public function setDate($date) { return $this->date = $date; }
    public function setAddr($addr) { return $this->addr = $addr; }
    public function setCity($city) { return $this->city = $city; }
    public function setPc($pc) { return $this->pc = $pc; }
    public function setLikes($likes) { return $this->likes = $likes; }
    public function setCategory($category) { return $this->category = $category; }
    public function setUser($user) { return $this->user = $user; }
    public function setPhotoCollection($photos) { return $this->photoCollection = $photos; }

    public function save(){
      $insert = 'INSERT INTO advert(
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
      $query = $this->pdo->prepare($insert);
      $query->execute(
        array(
          ":title" => $this->getTitle(),
          ":text" => $this->getText(),
          ":addr" => $this->getAddr(),
          ":city" => $this->getCity(),
          ":pc" => $this->getPc(),
          ":category" => $this->getCategory(),
          ":user" => $this->getUser()
        )
      );
      return $this->pdo->lastInsertId();
    }

    public function update($like = false){
      $update = '';
      $params = [];
      if(!$like){
        //update all properties allowed to update
        $update = ' UPDATE  advert
                    SET     title = :title,
                            text = :text,
                            addr = :addr,
                            city = :city,
                            pc = :pc,
                            likes = :likes,
                            category = :category
                    WHERE   id_advert = :id';
        $params =  array(
                        ":title" => $this->getTitle(),
                        ":text" => $this->getText(),
                        ":addr" => $this->getAddr(),
                        ":city" => $this->getCity(),
                        ":pc" => $this->getPc(),
                        ":likes" => $this->getLikes(),
                        ":category" => $this->getCategory(),
                        ":id" => $this->getId()
                    );

      }
      else{
        //update only likes
        $update = ' UPDATE  advert
                    SET     likes = :likes
                    WHERE   id_advert = :id';
        $params =  array(
                        ":likes" => $this->getLikes(),
                        ":id" => $this->getId()
                    );
      }

      $query = $this->pdo->prepare($update);
      return $query->execute($params);
    }

    public function getPhotos(){
      $query = 'SELECT  P.id_photo,
                        P.src
                FROM    photo P
                JOIN    photo_advert S
                ON      S.id_photo = P.id_photo
                WHERE   S.id_advert = :id_advert';

      $select = $this->pdo->prepare($query);
      $id = $this->getId();
      $select->bindParam(':id_advert',$id);
      $select->execute();
      $photos = [];
      while($row = $select->fetch(PDO::FETCH_OBJ)){
        $photo = new Photo($row->src,$row->id_photo);
        $photos[] = $photo;
      }
      return $photos;
    }

    public function getMainPhoto(){
      foreach($this->getPhotoCollection() as $obj => $photo){
        return $photo;
      }
    }

    public function showLessText($length){
      $text = $this->getText();
      $length = intval($length);
      if(strlen($text) > $length)
        return substr($text,0,($length-3)).'...';
      else
        return $text;
    }

  }
