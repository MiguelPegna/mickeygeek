<?php
    class ApiModel extends Mysql{
        public function __construct(){

        }

        public static function selectCollections(){
            $sql="SELECT * FROM collections WHERE status=1";
            $conn = Mysql::select_all($sql);
            $request = $conn;
            return $request;
        }

        public static function selectSlider(){
            $sql="SELECT * FROM banners WHERE gallery=1 AND status=1";
            $conn = Mysql::select_all($sql);
            $request = $conn;
            return $request;
        }

        public static function selectCollage(){
            $sql="SELECT * FROM banners WHERE gallery=2 AND status=1";
            $conn = Mysql::select_all($sql);
            $request = $conn;
            return $request;
        }

    }