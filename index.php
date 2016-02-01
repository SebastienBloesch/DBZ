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

// set the menu based on tables
$OUTPUT .= View::MenuTable ($MODEL->Name_DB(), $MODEL->List_Table());

// if the user has clicked on a table link
if(isset($_GET['T'])){
  $OUTPUT .= View::DataListTable($MODEL->Name_DB(), $MODEL->ListEntitiesTable($_GET['T']));
}

// output echo screen rendering 
View::HTML($CONFIG['MODULE_NAME'], $OUTPUT);

?>
