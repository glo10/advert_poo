<?php

/**
 *
 */
class MyPdo extends PDO
{
  private $pdo;

  function __construct(){
    parent::__construct();
  }

  function static connect(){
    try {
      return $this->pdo = new PDO('mysql:host=localhost;dbname=annonce', 'root', '');
    } catch(PDOException $e) {
      return null;
    }
  }
}
