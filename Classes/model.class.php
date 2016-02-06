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
    
    // example, if first column is PK
    if($tab_entities[$firstColumn] == NULL){
      $SQL = "INSERT INTO " . $table_name . " (";
      
      // construct sql query
      foreach ($tab_entities as $key => $value) {
        $SQL .= $key;
        if($i == $tabSize - 1) break;
        else $SQL .= ",";
        $i++;
      }
      
      // reset iterator
      $i = 0;
      
      $SQL .= ") VALUES (";
      
      foreach ($tab_entities as $key => $value) {
        $SQL .= "'" . $value . "'";
        if($i == $tabSize - 1) break;
        else $SQL .= ",";
        $i++;
      }
      
      $SQL .= ")";
      
      // execute query
      $RES = $this->PDO->prepare($SQL);
      $RES->execute($tab_entities);
    }
    else {
      // check if PK is not used
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
        
        // reset iterator
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
  
  // return databases list
  public function GetDatabasesList(){
    // get all databases names
    $SQL = 'show databases';
    $RES = $this->PDO->prepare($SQL);
    $RES->execute();
    
    $result = $RES->fetchAll();
    return $result;
  }
  
  // change db name in ID-VARS-DB.ini
  public function ChangeDB($newDB){
    // Get ID-VARS-DB.ini
    $ini_array = parse_ini_file("Config/ID-VARS-DB.ini");
    // Change db name
    $ini_array['DB_db'] = $newDB;
    $result = null;
    
    foreach ($ini_array as $key => $value) {
      $result .= $key . " = '" . $value . "'\r\n";
    }
    
    // Open file and write
    if($fp = fopen("Config/ID-VARS-DB.ini", 'w')){
      fwrite($fp, $result);
      fclose($fp);
      // reload page and pdo connection
      header('location: ./');
    }    
  }
  
}

?>
