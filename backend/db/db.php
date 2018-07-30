<?php 
    class DB {
        private $conn;

        public function connect(){
            require_once __DIR__ . '/dbconfig.php';
            $host = HOST;
            $db_name = DB_NAME;
            $user = USER;
            $pass = PASS;

            //connection
            try{
                $this->conn = new PDO("mysql:host=$host;dbname=$db_name",$user,$pass);
                //set error mode
                $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e){
                echo "connection failed " .$e->getMessage();
            }
            return $this->conn;
        }
    }
?>