<?php


abstract class db {
   
    public  $conn;
    function __construct(){
       try{
       $this->conn = new mysqli(DBHost, DBUser, DBPass, DBName) or die ( mysqli_error($this->conn));
       }catch(Exception $err){
   
        exit(nbl($this->getTraceAsString()).$err->getMessage());

       }
    }

 public function getConn(){
    return $this->conn;
 }
  
  /**
   * Fully dinamic Select method
   */

  public function select ( array $arr,  array $config)  : array{
    if(  func_num_args() !==2 ){
        exit("Two array parameters are mandatory");
   }
    $rows = array();
    foreach($arr as $row) {
           $rows[] =  $row;
        }       
    
    $sql_fields = join(",", $rows);
    
    if(count($arr) ==0){
        $sql_fields = "*";
    }
    

    if(count($config)==0){
        exit("Sql tables configs are mandatory");
    }

    foreach($config as $k => $v){
        switch($k){
            case "table":
                $table = $config[$k];
            break;
            case "id":
                $idName = $config[$k];
            break;

            case "id_val":
             $idval = $config[$k];
            break;
           
        }
       
    }

    $sql = "SELECT * FROM  $table WHERE $idName = {$idval}";
    $result = $this->conn->query($sql);
 
    return $result->fetch_array();
   }

}


 





define("DBHost","localhost");
define("DBUser", "root") ;
define("DBPass",  "");
define("DBName", "test_db");

class dbConn extends db{
    public $conn;
    function __construct()
    {    
    parent::__construct();

    }
  



}

// database operations test
$db = new dbConn;

$a = array( "name" , "email");
//$b = array("table" => "users" , "id" =>  "id" , "id_val" => 1 );
$b = "";
$data = $db->select($a, $b);

print_r($data);