<?php

  class Category {
    private $id;
    private $label;
    private $advertCollection;
    private $pdo;

    function __construct($label,array $advertCollection = null) {
      $this->setLabel($label);

      if($advertCollection !== null)
        $this->setAdvertCollection($advertCollection);

      try {
        $this->pdo = new PDO('mysql:host=localhost;dbname=annonce', 'root', '');
      } catch (PDOException $e) {
        var_dump($e);
      }
    }

    public function getId() { return $this->id; }
    public function getLabel() { return $this->label; }
    public function getAdvertCollection() { return $this->advertCollection; }


    public function setId($id)
    {
      if(filter_var($id,FILTER_VALIDATE_INT) !== false)
        return $this->id = $id;
      else
        throw new FilterException('L\identifiiant n\'est pas un entier');
    }

    public function setLabel($label)
    {
      $labelClean = filter_var($label,FILTER_SANITIZE_STRING);
      return $this->label = $labelClean;
    }

    public function setAdvertCollection(array $advertCollection)
    {
      if(is_array($advertCollection))
        return $this->advertCollection = $advertCollection;
      else
        throw new FilterException('Le format n\'est pas un tableau');

    }

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
