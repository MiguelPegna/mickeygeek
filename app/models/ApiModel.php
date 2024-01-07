<?php
    class ApiModel extends Mysql{
        public function __construct(){

        }

        public static function selectCollections(){
            $sql="SELECT * FROM collections WHERE status=1";
            $connectionDB = Mysql::select_all($sql);
            $request = $connectionDB;
            return $request;
        }

        public static function selectSlider(){
            $sql="SELECT * FROM banners WHERE gallery=1 AND status=1";
            $connectionDB = Mysql::select_all($sql);
            $request = $connectionDB;
            return $request;
        }

        public static function selectCollage(){
            $sql="SELECT * FROM banners WHERE gallery=2 AND status=1";
            $connectionDB = Mysql::select_all($sql);
            $request = $connectionDB;
            return $request;
        }

        public static function selectCatalog(){
            $sql = "SELECT pr.id AS id, pr.product AS product, pr.gender AS gender, pr.price AS price, pr.url AS url, p.picture AS picture
            FROM products AS pr
            INNER JOIN photos AS p ON p.product = pr.id WHERE pr.status = 1 
            ORDER BY rand() LIMIT " .PZSHOME;
            $request = Mysql::select_all($sql);
            return $request;
        }

    }