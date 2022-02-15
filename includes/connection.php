<?php

class DBConnect{
      private $host = 'localhost';
      private $dbname = 'isdb';
      private $user = 'root';
      private $pass = "";
      private $conn;


      //function to open connection  
      public function open_connection(){
        try{
                $this->conn = new PDO('mysql:host=' .$this->host .';dbname=' .$this->dbname, $this->user,$this->pass);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	        $this->conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
                //echo "Connection Successful";
	        return $this->conn;
              }catch(PDOException $e){
                echo "Connection failed: " . $e->getMessage();
              }
      }
     
      
      //function to close connection
      public function close_connection(){
          $this->conn = null;
      }
 
              
}





?>