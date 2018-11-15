<?php
  session_start();
  require '../classes/PhotoManager.php';

  $photoManager = new PhotoManager();
  $title              = htmlspecialchars($_POST['title']);
  $text               = htmlspecialchars($_POST['text']);
  $date               = '0000-00-00';
  $addr               = htmlspecialchars($_POST['addr']);
  $city               = htmlspecialchars($_POST['city']);
  $pc                 = htmlspecialchars($_POST['pc']);
  $likes              = 0;
  $category           = htmlspecialchars($_POST['category']);
  $user               = $_SESSION['email'];

  $advert = new Advert(
                        $title,
                        $text,
                        $date,
                        $addr,
                        $city,
                        $pc,
                        $likes,
                        $category,
                        $user
                      );
  $photos = $photoManager->saveImagesDisc($advert,$_FILES['photos'],3000000,'../public/img');
  if(!$photos){
    echo 'ajout non ok';
  }
  else{
    $photoManager->saveAll($advert,$photos);
    echo 'ajout ok';
  }
