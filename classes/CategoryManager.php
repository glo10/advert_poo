<?php
  namespace Advert_poo\Classes;
  require_once 'Category.php';

  class CategoryManager {
    private $pdo = null;

    function __construct() {
      $this->connect();
    }

    private function connect() {
      try {
        $this->pdo = new \PDO('mysql:host=localhost;dbname=annonce', 'root', '');
      } catch(PDOException $e) {
        var_dump($e);
      }
    }

    public function findAll() {

      $query = $this->pdo->prepare('SELECT * FROM category');
      $query->execute();
      $rows = $query->fetchAll(\PDO::FETCH_OBJ);

      $categories = [];
      foreach($rows as $row) {
        $category = new namespace\Category($row->label);

        $category->setId($row->id_category);
        array_push($categories, $category);
      }

      return $categories;
    }

    public function findById($id) {
      $query = $this->pdo->prepare(
                                    ' SELECT label
                                      FROM category
                                      WHERE id = :id'
                                    );
      $query->execute(\array(':id' => $id));
      $row = $query->fetch(\PDO::FETCH_OBJ);

      if(!$row)
        return null;

      $category = new namespace\Category($row->label);
      $category->setId(\intval($row->id));

      return $category;
    }
  }
