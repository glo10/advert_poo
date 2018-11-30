<?php
  namespace Advert_poo\Classes;
  //require_once 'MyPdo.php';
  class User {
    private $email;
    private $pswd;
    private $firstName;
    private $lastName;
    private $pdo;
    private $advertCollection;

    function __construct($email,$firstName = null,$lastName = null,$pswd = null,array $advertCollection = null) {
      $this->setEmail($email);
      if($firstName !== null)
        $this->setFirstName($firstName);
      if($lastName !== null)
        $this->setLastName($lastName);
      if($pswd !== null)
        $this->setPswd($pswd);
      if($advertCollection !== null)
        $this->setAdvertCollection($advertCollection);

      try {
        $this->pdo = new \PDO('mysql:host=localhost;dbname=annonce', 'root', '');
      } catch (PDOException $e) {
        var_dump($e);
      }
    }

    public function getEmail() { return $this->email; }
    public function getPswd() { return $this->pswd; }
    public function getFirstName() { return $this->firstName; }
    public function getLastName() { return $this->lastName; }
    public function getAdvertCollection() { return $this->advertCollection; }


    public function setEmail(String $email)
    {
      if(filter_var($email,FILTER_VALIDATE_EMAIL))
        return $this->email = $email;
      else
        throw new FilterException('L\'email n\'est pas au bon format');
    }

    public function setPswd(String $pswd)
    {
      if(\strlen($pswd) >= 8 && \preg_match('#[^\s]{8,}#',$pswd) && \strlen($pswd) <= 30)
        return $this->pswd = $pswd;
      else
        throw new FilterException('Le mot de passe n\'a pas été hashé correctement');
    }

    public function setFirstName(String $firstName)
    {
      if(\strlen($firstName) < 2)
      {
        throw new FilterException('Le Prénom doit avoir au moins 2 caractères alphabétiques');
      }
      else
      {
        $firstNameClean = \filter_var($firstName,FILTER_SANITIZE_STRING);
        return $this->firstName = $firstNameClean;
      }
    }

    public function setLastName(String $lastName)
    {
      if(\strlen($lastName) < 2)
      {
        throw new FilterException('Le nom doit avoir au moins 2 caractères alphabétiques');
      }
      else
      {
        $lastNameClean = \filter_var($lastName,FILTER_SANITIZE_STRING);
        return $this->lastName = $lastNameClean;
      }
    }

    public function setAdvertCollection(array $advertCollection)
    {
      if(\is_array($advertCollection))
        return $this->advertCollection = $advertCollection;
      else
        throw new FilterException('Le format des annonces n\est pas correct');
    }

    public function save()
    {
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
          ":pswd" =>  \password_hash($this->getPswd(),PASSWORD_BCRYPT),
          ":last_name" => $this->getLastName(),
          ":first_name" => $this->getFirstName()
        )
      );
    }

    public function update()
    {
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

    public function connect()
    {
      $request = 'SELECT *
                  FROM user
                  WHERE email=:email';

      $select = $this->pdo->prepare($request);
      $email = $this->getEmail();
      $select->bindParam(':email',$email);

      $select->execute();
      if($result = $select->fetch(\PDO::FETCH_OBJ))
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
