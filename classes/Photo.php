<?php

  class Photo {
    private $id;
    private $src;
    private $pdo;

    function __construct($id,$src) {
      $this->id = $id;
      $this->src = $src;

      try {
        $this->pdo = new PDO('mysql:host=localhost;dbname=annonce', 'root', '');
      } catch (PDOException $e) {
        var_dump($e);
      }
    }

    public function getId() { return $this->id; }
    public function getSrc() { return $this->src; }


    public function setId($id) { return $this->id = $id; }
    public function setSrc($src) { return $this->src = $src; }

    public function save(){
      $insert = 'INSERT INTO photo(
                                        src
                                  )
                                  VALUES(
                                        :src
                                  )';
      $query = $this->pdo->prepare($insert);
      $query->execute(
        array(
          ":src" => $this->getSrc()
        )
      );
      return $this->pdo->lastInsertId();
    }

    public function update(){
      $update = ' UPDATE  photo
                  SET     src = :src
                  WHERE   id_photo = :id';

      $query = $this->pdo->prepare($update);
      return $query->execute(
        array(
          ":id_photo" => $this->getId(),
          ":src" => $this->getSrc()
        )
      );
    }

  }
