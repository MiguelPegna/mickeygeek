<?php
    class HomeModel extends Mysql{
        public function __construct(){

        }

        public static function selectItems(){
            $sql="SELECT id, name, email FROM users";
            $conn = Mysql::select_all($sql);
            $request = $conn;
            return $request;
        }

    }