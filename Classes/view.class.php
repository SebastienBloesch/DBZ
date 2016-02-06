<?php 

/* DBZ VIEW */

class View {
  
    public function __construct () { }
    
    // menu list of table link
    public static function MenuTable ($db_name, $array_table) {
      $menu = "<div>DB : ".$db_name;
      
      foreach ($array_table as $K => $TABLE) {
        $menu .= " <a href='?T=".$TABLE[0]."'>[ ".strtoupper($TABLE[0])." ]</a>";
      }
      
      $menu .= "</div>";
      
      return $menu;
    }
    
    // data list of a table
    public static function DataListTable($db_name, $table_name, $array_data){
      $list = "<table>";
      $i = 0; $a = 0; // counter
      $firstIdentifier = NULL;
      $assocTab = [];
      
      if(count($array_data) > 0){
        // get the heading of the table
        foreach ($array_data[0] as $key => $value) {
          // get the name of the first column
          if($i === 0) $firstIdentifier = utf8_encode($key);
          
          if($i%2 == 0){
            $list .= "<th>" . utf8_encode($key) . "</th>";
            $assocTab[$a] = $key;
            $a++;
          }
                 
          $i++;
        }
        
        // get the data of the table
        foreach ($array_data as $k => $DATA) {
          
          $list .= "<tr>";
          for($i = 0; $i < COUNT($DATA)/2; $i++){
            $list .= "<td>" . utf8_encode($DATA[$i]) . "</td>";
          }
          $list .= "<td><a href='?T=" . $table_name . "&d_ID=" . $DATA[0] . "&table=" . $table_name . "&champ=" . $firstIdentifier . "'><button>Delete</button></a></td>";
          $list .= "</tr>";
        }
        
        $list .= "<form method='GET' action='index.php'>
                    <tr>";
                    
        for($j = 0; $j < $i; $j++){
          $list .= "<td><input type='text' name='" . $assocTab[$j] . "'></td>";
        }
        
        $list .= "<input type='hidden' name='T' value='" . $table_name . "'>";
        $list .= "<td><input type='submit' name='add' value='Add'></td>";
                    
        $list .= "  </tr>
                  </form>";
        
        $list .= "</table>";
        
        return $list;
      }
      
    }
    
    // databases list
    public static function ListDatabases($list_db){
      $list = "<form method='POST' action=''>";
      $list .= "<select name='db_name'>";
      $list .= "<option></option>";
      foreach ($list_db as $key => $value) {
        $list .= "<option>" . $value[0] . "</option>";
      }
      $list .= "</select>";
      
      $list .= "<input type='submit' name='form_db' value='Change DB'>";
      $list .= "</form><br><br>";
      
      return $list;
    } 
    
    // html final rendering
    public static function HTML ($title, $contener) {
      echo "<html>
      <head>
        <title>".$title."</title>
        <link rel='stylesheet' type='text/css' href='Fichiers/css/style.css' />
      </head>
      <body>
        <img src='Fichiers/images/logo.jpg' height='80'/><br /><hr />
        </hr>".$contener."
      </body>
      </html>";
    }
    
}

?>
