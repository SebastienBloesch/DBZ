<?php 

/* DBZ MODELE KAMEHAMEHA */

class Model {
  
  private $PDO = NULL;
  
  public function __construct ($pdo) {
    $this->PDO = $pdo;
  }
  
  // db name
  public function Name_DB () {
    return $this->PDO->Query('select database()')->fetchColumn();
  }
  
  // list table
  public function List_Table () {
    $SQL = "show tables";
    $RES = $this->PDO->prepare($SQL);
    $RES->execute();
    return $RES->fetchAll();
  }
  
  // list entities of a table
  public function ListEntitiesTable($table_name){
    $SQL = "select * from " . $table_name;
    $RES = $this->PDO->prepare($SQL);
    $RES->execute();
    return $RES->fetchAll();
  }
  
  // delete an entity from a table
  public function DeleteEntity($id_entity, $table_name, $champ){
    $SQL = "delete from " . $table_name . " where " . $champ . " = " . $id_entity;
    $RES = $this->PDO->prepare($SQL);
    $RES->execute();
  }
  
  // add a new entity
  public function AddEntity($tab_entities, $table_name){
    // Params
    $i = 0;
    $tabSize = count($tab_entities);
    // Check if the first columns (presumed PK)
    $firstColumn = null;
    foreach ($tab_entities as $key => $value) {
      $firstColumn = $key;
      break;
    }
    $SQL = "select COUNT(*) FROM " . $table_name . " where " . $firstColumn . " = " . $tab_entities[$firstColumn];
    $RES = $this->PDO->prepare($SQL);
    $RES->execute();
    $nb = $RES->fetchColumn();
    
    if($nb == 0){
      $SQL = "INSERT INTO " . $table_name . " (";
      
      foreach ($tab_entities as $key => $value) {
        $SQL .= $key;
        if($i == $tabSize - 1) break;
        else $SQL .= ",";
        $i++;
      }
      
      $i = 0;
      
      $SQL .= ") VALUES (";
      
      foreach ($tab_entities as $key => $value) {
        $SQL .= "'" . $value . "'";
        if($i == $tabSize - 1) break;
        else $SQL .= ",";
        $i++;
      }
      
      $SQL .= ")";
      
      $RES = $this->PDO->prepare($SQL);
      $RES->execute($tab_entities);
    }
  }
  
}

?>
