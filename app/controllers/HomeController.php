<?php 
    class HomeController extends Controllers{
        public function __construct(){
			parent::__construct();
            //se declara inicio de sesion
			session_start();
            session_regenerate_id(true);
		}

        public function home ($params){
            $info['page_id'] = 'p_home';
            $info['meta_description'] = 'Pagina principal';
            $info['page_title'] = EMPRESA;
            $info['page_name'] = 'home';
            $info['page_scripts'] = getScript('home', 'js');
            //$info['page_scripts']='';
            $this->views->getView($this, METATAGS, $info);
            $this->views->getView($this, HEADER, $info);
            $this->views->getView($this, 'home', $info);
            $this->views->getView($this, FOOTER, $info);
        }

        public static function contacts(){
            header("Access-Control-Allow-Origin: *");
            $model= HomeModel::selectItems();
            $info = $model;
            echo json_encode($info, JSON_UNESCAPED_UNICODE);
            die();
        }
    }