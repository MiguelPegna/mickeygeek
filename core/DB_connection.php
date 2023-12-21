<?php
    class DB_connection{

        public function __construct(){
            $this->connect();
        }
        

        public static function connect(){
            //$connectionString = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";.DB_CHARSET.";
            $connectionString = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
            
            try{
                $plug = new PDO($connectionString, DB_USER, DB_PASS);
			    $plug->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $plug->exec('set names utf8mb4');
                //echo 'Flipa en colores bien mogollón a todo gas chaval.. se ha hecho la conexión';
            }
            catch (Exception $e){
                $plug = 'Error vale verdi la vida mejor matate';
                echo "ERROR: ". $e->getMessage();
            }
            return $plug;
        }

    }

    //$prueba = new DB_conection();