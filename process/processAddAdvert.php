<?php

  require '../classes/Advert.php';

  $title              = htmlspecialchars($_POST['title']);
  $text               = htmlspecialchars($_POST['text']);
  $date               = '0000-00-00';
  $addr               = htmlspecialchars($_POST['addr']);
  $city               = htmlspecialchars($_POST['city']);
  $pc                 = htmlspecialchars($_POST['pc']);
  $likes              = 0;
  $category           = htmlspecialchars($_POST['category']);
  $user               = 'glodie.tshimini@gmail.com';//get session value when member space will be implemented

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


  if ($advert->save())
    header('location:../public/index.php');
  else
    echo 'L\'enregisrement a échoué';
