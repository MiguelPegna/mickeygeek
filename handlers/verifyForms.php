<?php
    #verificar maximo de  caracteres de cadena
    function maxLenght($max, $string){
        if(strlen(trim($string)) > $max){
            return true;            
        }
        else {
            return false;
        }

    }

    #verificar maximo de  caracteres de cadena
    function minLenght($min, $string){
        if(strlen(trim($string)) < $min){
            return true;            
        }
        else {
            return false;
        }

    }

    #verificar que los campos no esten vacios
    function isFormEmpty(array $data){
        foreach($data as $key => $value){
            //se limpia los values de sql injection y se verifica si el campo viene vacio
            if(strClean($value) == ''){
                $return = true;
            }
            else{
                $return = false;
            }
        }
        return $return;
    }

    #Verificar que se esta igresando una direccion de correo valida
    function isMail ($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;            
        }
        else {
            return false;
        }
    }

    #Verificar que password coincidan
    function matchPass ($password, $password_confimation){
        if($password === $password_confimation){
            return true;            
        }
        else {
            return false;
        }
    }

    #hashear password
    function hashPass($password){
        //codificar la contraseña
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        return $hashedPass;
    }

    #verificar password
    function checkPass($password, $passDB){
        $checkPass = password_verify($password, $passDB);
        return $checkPass;
    }

    //genera un password de 10 caracteres
    function passGenerator($length = 10) {
        $pass ='';
        $longPass = $length;
        $cadena = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789-_#';
        $longitudCadena = strlen($cadena);

        for($i=1; $i<=$longPass; $i++){
            $pos = rand(0, $longitudCadena-1);
            $pass .= substr($cadena, $pos,1);
        }
        return $pass;
    }

    //genera token
    function token(){
        $r1 = bin2hex(random_bytes(10));
        $r2 = bin2hex(random_bytes(10));
        $r3 = bin2hex(random_bytes(10));
        $r4 = bin2hex(random_bytes(10));
        $token = $r1. '-'. $r2. '-'. $r3. '-'. $r4;
        return $token;
    }

    //Elimina excesos de espacios entre palabras
    function strClean($strTxt){
        $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strTxt);
        $string = trim($string);  //elimina espacios en blanco al inicio y al final
        $string = stripslashes($string);  // elimina \invertidas
        $string = str_ireplace('<script>', '', $string);
        $string = str_ireplace('</script>', '', $string);
        $string = str_ireplace('<script src>', '', $string);
        $string = str_ireplace('<script type=>', '', $string);
        $string = str_ireplace('SELECT * FROM', '', $string);
        $string = str_ireplace('DELETE FROM', '', $string);
        $string = str_ireplace('INSERT INTO', '', $string);
        $string = str_ireplace('SELECT COUNT(*) FROM', '', $string);
        $string = str_ireplace('DROP TABLE', '', $string);
        $string = str_ireplace("OR '1'='1'", '', $string);
        $string = str_ireplace('OR "1"="1"', '', $string);
        $string = str_ireplace('OR ´1´=´1´', '', $string);
        $string = str_ireplace('OR `1`=`1`', '', $string);
        $string = str_ireplace('is NULL; --', '', $string);
        $string = str_ireplace('is NULL; --', '', $string);
        $string = str_ireplace("LIKE '", '', $string);
        $string = str_ireplace('LIKE "', '', $string);
        $string = str_ireplace('LIKE ´', '', $string);
        $string = str_ireplace("OR 'a'='a'", '', $string);
        $string = str_ireplace('OR "a"="a"', '', $string);
        $string = str_ireplace('OR ´a´=´a´', '', $string);
        $string = str_ireplace('OR `a`=`a`', '', $string);
        $string = str_ireplace('--', '', $string);
        $string = str_ireplace('^', '', $string);
        $string = str_ireplace('[', '', $string);
        $string = str_ireplace(']', '', $string);
        $string = str_ireplace('==', '', $string);
        return $string;
    }

    function uploadPhoto($data, $name){
        $root= 'public/img/catalogo/';                    //regresamos al directorio raiz   //Creamos la carpeta pruebas en la carpeta raiz si no existe
        if(!is_dir($root)){
            mkdir($root);
        }
        $host =$root.$name;
        //Si el archivo no existe se crea en la carpeta
        if(!file_exists($host)){
            $url=move_uploaded_file($data, $host);                                     
        }  
        return $url; 
    }

    function dropFile(string $name){
        //solo se borra la img si es diferente de la img por defecto
        if($name!='001.jpg'){
            unlink('public/img/catalogo/'.$name); 
        }
    }

    function dropFileSection(string $name){
        unlink('public/img/icons/sections/'.$name);
    }