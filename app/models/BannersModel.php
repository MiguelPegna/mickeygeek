<?php
    class BannersModel extends Mysql{
        public function __construct(){

        }

        public static function selectBanners($gallery){
            $sql="SELECT * FROM banners WHERE gallery=$gallery AND status=1";
            $conn = Mysql::select_all($sql);
            $request = $conn;
            return $request;
        }

    }