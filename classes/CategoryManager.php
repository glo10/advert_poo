<?php
  require_once 'Category.php';

  class CategoryManager {
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

    public function findAll() {

      $query = $this->pdo->prepare('SELECT * FROM category');
      $query->execute();
      $rows = $query->fetchAll(PDO::FETCH_OBJ);

      $categories = [];
      foreach($rows as $row) {
        $category = new Category($row->label);

        $category->setId($row->id_category);
        array_push($categories, $category);
      }

      return $categories;
    }

    public function findById($id) {
      $query = $this->pdo->prepare(
                                    ' SELECT *
                                      FROM team
                                      WHERE id = :id'
                                    );
      $query->execute(array(':id' => $id));
      $row = $query->fetch(PDO::FETCH_OBJ);

      if(!$row)
        return null;

      $team = new Team(
        $row->name, intval($row->yearFoundation), $row->league, $row->stadium, $row->coach);
      $team->setId(intval($row->id));

      return $team;
    }

    public function findByIdJoin($id){

      $query =   'SELECT  T.id            AS  teamId,
                          T.name          AS  teamName,
                          T.yearFoundation,
                          T.league,
                          T.stadium,
                          T.coach,
                          P.id            AS playerId,
                          P.name          AS playerName,
                          P.position,
                          P.id            AS playerId
                  FROM team T
                  LEFT JOIN player P
                  ON T.id = P.team_id
                  WHERE T.id = :id';

      $select = $this->pdo->prepare($query);

      $select->bindParam(':id',intval($id));
      $select->execute();

      $rows = $select->fetchAll(PDO::FETCH_OBJ);

      $team = new Team(
        $rows[0]->teamName,
        $rows[0]->yearFoundation,
        $rows[0]->league,
        $rows[0]->stadium,
        $rows[0]->coach
      );

      $team->setId($rows[0]->teamId);

      foreach ($rows as $row) {
        if($row->playerName !== null){
          $player = new Player($row->playerName,$row->position);
          $player->setId($row->playerId);
          $team->addPlayer($player);
        }
      }
      return $team;
    }

    public function getTeamsSameLeague($team){

      $query =   'SELECT  *
                  FROM    team
                  WHERE   id <> :id
                  AND     league = :league';

      $select = $this->pdo->prepare($query);

      $id = $team->getId();
      $league = $team->getLeague();

      $select->bindParam(':id',$id);
      $select->bindParam(':league',$league);
      $select->execute();

      $rows = $select->fetchAll(PDO::FETCH_OBJ);
      $teams = [];

      foreach ($rows as $row) {
        $team = new Team(
          $row->name,
          $row->yearFoundation,
          $row->league,
          $row->stadium,
          $row->coach
        );

        $team->setId($row->id);
        array_push($teams,$team);
      }
      return $teams;
    }
  }
