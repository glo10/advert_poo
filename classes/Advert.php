<?php
  require_once 'FilterException.php';
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

    function __construct($title, $text, $date,$addr,$city, $pc,$likes,$category,$user)
    {
      $this->setTitle($title);
      $this->setText($text);
      $this->setDate($date);
      $this->setAddr($addr);
      $this->setCity($city);
      $this->setPc($pc);
      $this->setLikes($likes);
      $this->setCategory($category);
      $this->setUser($user);

      try
      {
        $this->pdo = new PDO('mysql:host=localhost;dbname=annonce', 'root', '');
      } catch (PDOException $e)
      {
         echo 'La connexion n\'a pas pû être établi avec la base de données, veuillez recommencer ultérieurement ou signaler le prblème à l\'administrateur du site web';
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


    public function setId($id)
    {
      if(filter_var($id,FILTER_VALIDATE_INT) !== false)
        return $this->id = $id;
      else
        throw new FilterException('L\identifiiant n\'est pas un entier');
    }

    public function setTitle(String $title)
    {
      $titleClean = filter_var($title, FILTER_SANITIZE_STRING);
      return $this->title = $titleClean;
    }

    public function setText(String $text)
    {
      $textClean = filter_var($text, FILTER_SANITIZE_STRING);
      return $this->text = $textClean;
    }

    public function setDate(String $date)
    {
      if(preg_match('#(0[1-9]|1[0-9]|2[0-9]|3[01])\\/(0[1-9]|1[012])\\/(19|20)[0-9]{2}[\\s][0-9]{2}[:][0-9]{2}#',$date))
        return $this->date = $date;
      else
        throw new FilterException('La date n\'est pas au format jj-mm-aaaa');

    }

    public function setAddr(String $addr)
    {
      $addrClean = filter_var($addr, FILTER_SANITIZE_STRING);
      return $this->addr = $addrClean;
    }

    public function setCity(String $city)
    {
      $cityClean = filter_var($city,FILTER_SANITIZE_STRING);
      return $this->city = $cityClean;
    }

    public function setPc(String $pc)
    {
      if(preg_match('#[1-9][0-9]{4}#',$pc))
        return $this->pc = $pc;
      else
        throw new FilterException('Le code postal ne contient pas 5 chiffres');
    }

    public function setLikes($likes)
    {
      if(filter_var(intval($likes),FILTER_VALIDATE_INT) !== false)
        return $this->likes = $likes;
      else
        throw new FilterException('Le like n\est pas un entier');
    }

    public function setCategory(String $category)
    {
      $categoryClean = filter_var($category,FILTER_SANITIZE_STRING);
      return $this->category = $categoryClean;
    }

    public function setUser(User $user)
    {
      if($user == null)
        throw new FilterException('Aucun utilisateur n\'a été récupéré');
      return $this->user = $user;
    }

    public function setPhotoCollection(array $photos)
    {
      if(is_array($photos))
        return $this->photoCollection = $photos;
      else
        throw new FilterException('Les photos n\'ont pas été récupéré correctement');
    }

    public function save()
    {
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

    public function update($like = false)
    {
      $update = '';
      $params = [];

      if(!$like)
      {
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
      else
      {
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

    public function getPhotos()
    {
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
      while($row = $select->fetch(PDO::FETCH_OBJ))
      {
        $photo = new Photo($row->src,$row->id_photo);
        $photos[] = $photo;
      }
      return $photos;
    }

    public function getMainPhoto()
    {
      foreach($this->getPhotoCollection() as $obj => $photo)
        return $photo;
    }
  }
