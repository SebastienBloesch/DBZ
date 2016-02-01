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
    public static function DataListTable($db_name, $array_data){
      $list = "<table>";
      $i = 0; // counter
      
      // get the heading of the table
      foreach ($array_data[0] as $key => $value) {
        if($i%2 == 0){
          $list .= "<th>" . utf8_encode($key) . "</th>";
        }        
        $i++;
      }
      
      // get the data of the table
      foreach ($array_data as $k => $DATA) {
        
        $list .= "<tr>";
        
        for($i = 0; $i < COUNT($DATA)/2; $i++){
          $list .= "<td>" . utf8_encode($DATA[$i]) . "</td>";
        }
        
        $list .= "</tr>";
      }
      
      $list .= "</div>";
      
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
