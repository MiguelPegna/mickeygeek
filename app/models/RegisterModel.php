<?php
    class RegisterModel extends Mysql{
        private $idUser;
        private $pass;
        public $name;
        public $mail;
        
        public function __construct(){
            parent::__construct();
        }

        public static function setUser($name, $email, $pass){
            //se busca si no existe el usuario
            $sql = "SELECT email FROM users WHERE email = '$email';";
            $request = Mysql::select_all($sql);
            
            //si la respuesta es vacia el usuario se puede registrar
            if(empty($request)){
                $query="INSERT INTO users(name, email, password) VALUES (?, ?, ?);";
                $values = [$name, $email, $pass];
                $request = Mysql::insert($query, $values);
                isset($request) ? $request : $request = false;
                return $request;
            }
            else{
                return 0;
            }
        }

    }