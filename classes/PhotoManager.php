<?php

require_once 'Photo.php';
require_once 'Advert.php';

class PhotoManager {
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

  public function saveImagesDisc($advert,$files,$maxSize,$baseUrl){
    $photos = [];
    $files = $this->diverse_array($files);

    foreach($files as $key => $file){
      $fileName = $file['name'];
      $fileType = $file['type'];

      $size = $file['size'];


      $format = substr($fileType, 0, 5);
      $extension = pathinfo($fileName,PATHINFO_EXTENSION);
      $extensions = ['jpg','JPG','jpeg','JPEG','png','PNG'];

      $dir = $baseUrl.'\\'.$advert->getId();

      //TODO store pictures in the respective folders advert
      /*if (!file_exists($dir) && !is_dir($dir))
      {
          mkdir($dir);
      }*/

      //check if the extension is allowed
      if(in_array($extension,$extensions))
      {
        //check if it's a image format
        if ($format == 'image' && $size < $maxSize )
        {
          //shift in advert directory
          if(move_uploaded_file($file['tmp_name'], $dir.'\\'.$fileName))
          {
            $src = $advert->getId().'/'.$fileName;
            $photo = new Photo($src);
            array_push($photos,$photo);
          }
          else{
            return null;
          }
        }
        else
        {
          return null;
        }
      }
      else{
        return null;
      }
    }
    return $photos;
  }

  public function saveAll(Advert $advert,array $photos){
      $lastIdAdvert = null;
      $lastIdPhoto = null;
      $errors = [];
      $this->pdo->beginTransaction();

      //INSERT INTO advert
      $insertAdvert = 'INSERT INTO advert(
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
      $queryAdvert = $this->pdo->prepare($insertAdvert);
      $paramsAdvert = array(
                            ":title"    => $advert->getTitle(),
                            ":text"     => $advert->getText(),
                            ":addr"     => $advert->getAddr(),
                            ":city"     => $advert->getCity(),
                            ":pc"       => $advert->getPc(),
                            ":category" => $advert->getCategory(),
                            ":user"     => $advert->getUser()
                        );
      if(
        $queryAdvert->execute($paramsAdvert)
      )
      {
        $lastIdAdvert = $this->pdo->lastInsertId();
        $advert->setId($lastIdAdvert);
        //insert  for each src into photo then get id_photo and insert into photo_advert
        foreach($photos as $photo)
        {
          //INSERT INTO photo
          $insertPhoto = 'INSERT INTO photo(src) VALUES(:src)';
          $queryPhoto = $this->pdo->prepare($insertPhoto);

          if($queryPhoto->execute([':src' => $photo->getSrc()]))
          {
            //INSERT INTO photo_advert
            $lastIdPhoto = $this->pdo->lastInsertId();
            $photo->setId($lastIdPhoto);
            $queryPhotoAdvert = 'INSERT INTO photo_advert(
                                                          id_advert,
                                                          id_photo
                                                        )
                                        VALUES(
                                                          :id_advert,
                                                          :id_photo
                                              )';
            $insertPhotoAdvert = $this->pdo->prepare($queryPhotoAdvert);

            if(!$insertPhotoAdvert->execute(
                                              [
                                                ':id_advert'  =>  $advert->getId(),
                                                ':id_photo'   =>  $photo->getId()
                                              ]
                                            )
            )
            {
              $errors = 'roolback';
            }
        }
        else{
          $errors = 'roolback';
        }
      }
    }
    else
    {
      $errors = 'roolback';
    }

    //Evaluate if evrything success at the database

    if(empty($errors)){
      $this->pdo->commit();
    }
    else{
      $this->pdo->rollback();
      $dir = 'img/'.$lastIdAdvert;
      if(file_exists($dir)){
        //delete files into the directory and then this directory
        $this->clearDir($dir);
      }
    }
  }

    public function diverse_array($vector) {
    $result = array();
    foreach($vector as $key1 => $value1)
        foreach($value1 as $key2 => $value2)
            $result[$key2][$key1] = $value2;
    return $result;
  }

  public function clearDir($dir){
       $files = glob($dir.'/*');
       foreach($files as $file){
           if(is_file($file))
               unlink($file);
       }
       unlik($dir);
  }
}
