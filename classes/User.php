<?php

  class User {
    private $email;
    private $pswd;
    private $firstName;
    private $lastName;
    private $pdo;
    private $advertCollection;

    function __construct($email,$pswd = null,array $advertCollection = null) {
      $this->email = $email;
      if($pswd !== null)
        $this->pswd = $pswd;
      if($advertCollection !== null)
        $this->advertCollection = $advertCollection;

      try {
        $this->pdo = new PDO('mysql:host=localhost;dbname=annonce', 'root', '');
      } catch (PDOException $e) {
        var_dump($e);
      }
    }

    public function getEmail() { return $this->email; }
    public function getPswd() { return $this->pswd; }
    public function getFirstName() { return $this->firstName; }
    public function getLastName() { return $this->lastName; }
    public function getAdvertCollection() { return $this->advertCollection; }


    public function setEmail($email) { return $this->email = $email; }
    public function setPswd($pswd) { return $this->pswd = $pswd; }
    public function setFirstName($firstName) { return $this->firstName = $firstName; }
    public function setLastName($lastName) { return $this->lastName = $lastName; }
    public function setAdvertCollection(array $advertCollection) { return $this->advertCollection = $advertCollection; }

    public function save(){
      $query = 'INSERT INTO user(
                                        email,
                                        pswd,
                                        last_name,
                                        first_name
                                  )
                                  VALUES(
                                        :email,
                                        :pswd,
                                        :last_name,
                                        :first_name
                                  )';
      $insert = $this->pdo->prepare($query);
      return $insert->execute(
        array(
          ":email" => $this->getEmail(),
          ":pswd" =>  password_hash($this->getPswd(),PASSWORD_BCRYPT),
          ":last_name" => $this->getLastName(),
          ":first_name" => $this->getFirstName()
        )
      );
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

    public function connect(){
      $request = 'SELECT *
                  FROM user
                  WHERE email=:email';

      $select = $this->pdo->prepare($request);
      $email = $this->getEmail();
      $select->bindParam(':email',$email);

      $select->execute();
      if($result = $select->fetch(PDO::FETCH_OBJ))
      {
        if(password_verify($this->getPswd(),$result->pswd))
        {
          $this->setFirstName($result->first_name);
          $this->setLastName($result->last_name);
          return $this;
        }
      }
      return null;
    }
  }
