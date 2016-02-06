<?php 

/* DBZ FRONTAL CONTROLLER
** MVC CMS for database management */

// configuration
require_once("Config/config.script.php");

// connexion db
require_once("Classes/pdo.connexion.class.php");
$PDO = new Pdo_Connexion ($CONFIG['DB_INI_FILE']);

// model class
require_once("Classes/model.class.php");
$MODEL = new Model ($PDO->CNX);

// view class
require_once("Classes/view.class.php");

// html output increment
$OUTPUT = NULL;

if(isset($_POST['form_db'])){
  if($_POST['db_name'] != null){
    $MODEL->ChangeDB($_POST['db_name']);
  }
}

// if a user want to delete an entity in a table
if(isset($_GET['d_ID'])){
  $MODEL->DeleteEntity($_GET['d_ID'], $_GET['table'], $_GET['champ']);
}

// add a new entity
if(isset($_GET['add'])){
  
  $i = 0;
  $sizeOfTab = count($_GET) - 2;
  $finalTab = [];
  
  foreach ($_GET as $key => $value) {
    if($i === $sizeOfTab){
      break;
    }
    else {
      $finalTab[$key] = $value;
    }
    $i++;
  }
  
  $MODEL->AddEntity($finalTab, $_GET['T']);
}

// list of databases
$OUTPUT .= View::ListDatabases($MODEL->GetDatabasesList());

// set the menu based on tables
$OUTPUT .= View::MenuTable ($MODEL->Name_DB(), $MODEL->List_Table());

// if the user has clicked on a table link
if(isset($_GET['T'])){
  $OUTPUT .= View::DataListTable($MODEL->Name_DB(), $_GET['T'], $MODEL->ListEntitiesTable($_GET['T']));
}

// output echo screen rendering 
View::HTML($CONFIG['MODULE_NAME'], $OUTPUT);

?>
