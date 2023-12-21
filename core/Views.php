<?php
    class Views{
        
        function getView($controller, $view, $info=''){
            $controller = get_class($controller);
            $viewController = str_replace('Controller', '', $controller);
            //dep($viewController);return;
            if($viewController == 'Home'){
                $view = 'views/'. $view. '.php';
            }
            else{
                $view = 'views/'. $viewController. '/'. $view. '.php';
            }
            //print_r($view);return;
            ob_start();
            require_once($view);
            //$view = ob_get_clean();
            //return $view;
        }


    }