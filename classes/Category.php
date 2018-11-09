<?php

  class Category {
    private $id;
    private $label;
    private $advertCollection;
    private $pdo;

    function __construct($label,array $advertCollection = null) {
      $this->label = $label;

      if($advertCollection !== null)
        $this->advertCollection[] = $advertCollection;

      try {
        $this->pdo = new PDO('mysql:host=localhost;dbname=annonce', 'root', '');
      } catch (PDOException $e) {
        var_dump($e);
      }
    }

    public function getId() { return $this->id; }
    public function getLabel() { return $this->label; }
    public function getAdvertCollection() { return $this->advertCollection; }


    public function setId($id) { return $this->id = $id; }
    public function setLabel($label) { return $this->label = $label; }
    public function setAdvertCollection(array $advertCollection) { return $this->advertCollection[] = $advertCollection; }

    public function save(){
      $insert = 'INSERT INTO category(
                                        label
                                  )
                                  VALUES(
                                        :label
                                  )';
      $query = $this->pdo->prepare($insert);
      $query->execute(
        array(
          ":label" => $this->getLabel()
        )
      );
      return $this->pdo->lastInsertId();
    }

    public function update(){
      $update = ' UPDATE  category
                  SET     label = :label
                  WHERE   id = :id';

      $query = $this->pdo->prepare($update);
      return $query->execute(
        array(
          ":label" => $this->getLabel(),
          ":id" => $this->getId()
        )
      );
    }

  }
