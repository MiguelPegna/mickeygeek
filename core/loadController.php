<?php
    //load
    $controller = ucwords($controller);
    $controllerFile = 'app/controllers/'.$controller. 'Controller.php';
    $controller = $controller.'Controller';
    
    if(file_exists($controllerFile)){
        require_once($controllerFile);
        $controller = new $controller();
        if(method_exists($controller, $method)){
            $controller-> {$method}($params);
        }
        else{
            require_once('app/controllers/ErrorController.php');
        }
    }
    else{
        require_once('app/controllers/ErrorController.php');
    }
?>