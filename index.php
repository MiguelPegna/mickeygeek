<?php

    require_once('config/config.php');
    require_once('config/colors.php');
    require_once('handlers/helpers.php');
    require_once('handlers/verifyForms.php');
    require_once('handlers/components.php');

    $uri = !empty($_GET['uri']) ?  $_GET['uri'] : 'home/home';
    $arrUri = explode("/", $uri);
    $controller = $arrUri[0];
    $method = $arrUri[0];
    $params = '';

    //if(!empty($arrUri[0]==='API')){
    //    header('location: API/index.php');
    //}

    if(!empty($arrUri[1])){
        if($arrUri[1] != ''){
            //pasar el metodo a camelCase
            $method = $arrUri[1];
            $firstLetter =substr($method, 0, 1);
            $lower = strtolower($method);
            $mayus = ucwords($lower,'-');
            $dropFirst = substr($mayus, 1);
            $str = $firstLetter.$dropFirst;
            $method = str_replace('-','', $str);
        }
    }

    if(!empty($arrUri[2])){
        //print_r($arrUri[2]);
        if($arrUri[2] != ''){
            for($i=2; $i < count($arrUri); $i++){
                $params.= $arrUri[$i]. ',';
            }
            $params = trim($params. ',');
        }
    }
    require_once('core/autoload.php');
    require_once('core/loadController.php');