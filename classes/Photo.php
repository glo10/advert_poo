<?php

  class Photo {
    private $id;
    private $src;
    private $pdo;

    function __construct($src,$id=null) {
      $this->setSrc($src);
      if($id != null)
        $this->setId($id);

      try {
        $this->pdo = new PDO('mysql:host=localhost;dbname=annonce', 'root', '');
      } catch (PDOException $e) {
        var_dump($e);
      }
    }

    public function getId() { return $this->id; }
    public function getSrc() { return $this->src; }


    public function setId($id)
    {
      if(filter_var($id,FILTER_VALIDATE_INT) !== false)
        return $this->id = $id;
      else
        throw new FilterException('L\identifiiant n\'est pas un entier');
    }

    public function setSrc($src)
    {
      $srcClean = filter_var($src,FILTER_SANITIZE_STRING);
      $srcClean = strtolower($srcClean);
      if(preg_match('#([\.](jpg|png|jpeg))$#',$srcClean))
        return $this->src = $srcClean;
      else
        throw new FilterException('L\'url de la photo n\'est pas au bon format');
    }

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
