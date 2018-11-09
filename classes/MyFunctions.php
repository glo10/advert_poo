<?php

  require_once 'Photo.php';
  
  public MyFunctions{
    public static saveImage($_FILES, $name,$maxSize,$destination){
      $fileName = $_FILES[$name]['name'];
      $fileType = $_FILES[$name]['type'];
      $logoSize = $_FILES[$name]['size'];

      $format = substr($logoType, 0, 5);
      $logoNameExploded = explode('.', $logoName);
      $lastIndex = sizeof($logoNameExploded) - 1;
      $extension = $logoNameExploded[$lastIndex];
      $fileName = strtolower($name) . '.' . $extension;
      $destination = 'public/img/' . $fileName;
      if ($format == 'image' && $logoSize < $maxSize) {
        if(move_uploaded_file($_FILES[$name]['tmp_name'], $destination))
          return new Photo($destination);
      } else {
        echo 'Format ou taille non accepté';
        $destination = null;
      }
    }
  }
