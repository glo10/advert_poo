<?php

  class User {
    private $email;
    private $pswd;
    private $pdo;
    private $advertCollection[];

    function __construct($email,$pswd,array $advertCollection = null) {
      $this->email = $email;
      $this->pswd = $pswd;
      if($advertCollection !== null)
        $this->advertCollection[] = $advertCollection;

      try {
        $this->pdo = new PDO('mysql:host=localhost;dbname=annonce', 'root', '');
      } catch (PDOException $e) {
        var_dump($e);
      }
    }

    public function getEmail() { return $this->email; }
    public function getPswd() { return $this->pswd; }
    public function getAdvertCollection() { return $this->advertCollection; }


    public function setEmail($email) { return $this->email = $email; }
    public function setPswd($pswd) { return $this->pswd = $pswd; }
    public function setAdvertCollection(array $advertCollection) { return $this->advertCollection[] = $advertCollection; }

    public function save(){
      $insert = 'INSERT INTO user(
                                        email,
                                        pswd
                                  )
                                  VALUES(
                                        :email,
                                        :pswd
                                  )';
      $query = $this->pdo->prepare($insert);
      $query->execute(
        array(
          ":email" => $this->getEmail(),
          ":pswd" => $this->getPswd()
        )
      );
      return $this->pdo->lastInsertId();
    }

    public function update(){
      $update = ' UPDATE  user
                  SET     pswd = :pswd
                  WHERE   email = :email';

      $query = $this->pdo->prepare($update);
      return $query->execute(
        array(
          ":pswd" => $this->getMdp(),
          ":id" => $this->getId()
        )
      );
    }

  }
