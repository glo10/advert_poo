<?php

  class MyFunctions{
    public static function showLessText($string,$length){
      $length = intval($length);
      return (strlen($string) > $length)?substr($string,0,($length-3)).'...':$string;
    }
  }
