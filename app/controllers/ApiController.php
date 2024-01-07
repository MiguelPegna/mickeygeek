<?php
    class ApiController extends Controllers{
        public function __construct(){
			parent::__construct();
            //se declara inicio de sesion
			session_start();
            session_regenerate_id(true);
		}

        public function collections(){
            $data = $this->model->selectCollections();
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function slider(){
            $data = $this->model->selectSlider();
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function collage(){
            $data = $this->model->selectSlider();
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function catalog(){
            $data =  $this->model->selectCatalog();
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
    }