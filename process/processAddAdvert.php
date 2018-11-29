<?php

  session_start();
  require '../classes/User.php';
  require '../classes/PhotoManager.php';
  require '../classes/Advert.php';

  $photoManager = new Advert_poo\Classes\PhotoManager();
  $title              = htmlspecialchars($_POST['title']);
  $text               = htmlspecialchars($_POST['text']);
  $date               = '01/01/1991 10:10';
  $addr               = htmlspecialchars($_POST['addr']);
  $city               = htmlspecialchars($_POST['city']);
  $pc                 = htmlspecialchars($_POST['pc']);
  $likes              = 0;
  $category           = htmlspecialchars($_POST['category']);
  $user               = new Advert_poo\Classes\User($_SESSION['email']);

  try
  {
    $advert = new Advert_poo\Classes\Advert(
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
  }
  catch(FilterException $e)
  {
    echo $e->showError();
  }
