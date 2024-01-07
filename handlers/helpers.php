<?php
    //muestra información formateada
    function dp($data){
        $format = print_r('<pre');
        $format .= print_r($data);
        $format .= print_r('<pre');
        return $format;
    }

    /**
    * funcion para agregar un script a la vista 
    * @var string $name Nombre del archivo
    * @var string $ext Exntesion del archivo
    * @return string $file es la etiqueta html para agregar el script requerido
    */
    function getScript($name, $ext){
        if($ext == 'js'){
            $file = '<script type="module" src="'. PUBLICDOCS .'/js/' .$name. '.js"></script>';
            //$file = '<script src="'. PUBLICDOCS .'/js/' .$name. '.js"></script>';
        }
        else if($ext == 'css'){
            $file = '<link href="'. PUBLICDOCS .'/css/' .$name. '.css" rel="stylesheet">';
        }
        else{
            $file='';
        }
        return $file;
    }

    //funcion para llamar ventanas modales del proyecto
    function getModal(string $nameModal, $data){
        $viewModal = 'views/_layouts/modals/'.$nameModal.'.php';
        require_once $viewModal;
    }

    /**
    * funcion para llamar layouts para el proyecto
    * @var string $nameLayout nombre del archivo
    * @var array $data variable de datos para usar en el layout
    */
    function getLayout($nameLayout, $data){
        
        $viewLayout = 'views/_sections/'.$nameLayout.'.php';
        require_once $viewLayout;
    }

    //funcion para pasar el json carrito al modal de la vista
    function getFile($url, $data){
        ob_start();
        require_once('views/'.$url.'.php');
        $file = ob_get_clean();
        return $file;
    }

    //funcion convertir string de DB a array
    function toArr($char, $string){
        $string= str_replace("[", "", $string);
        $array = explode("'" .$char. "'", $string);
        return $array;
    }

    //funcion que quita caracteres especiales para url
    function removeChars($cadena){
        //Reemplazamos la A y a
        $cadena = str_replace(
            array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
            array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
            $cadena
            );
     
            //Reemplazamos la E y e
            $cadena = str_replace(
            array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
            array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
            $cadena );
     
            //Reemplazamos la I y i
            $cadena = str_replace(
            array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
            array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
            $cadena );
     
            //Reemplazamos la O y o
            $cadena = str_replace(
            array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
            array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
            $cadena );
     
            //Reemplazamos la U y u
            $cadena = str_replace(
            array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
            array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
            $cadena );
     
            //Reemplazamos la N, n, C y c
            $cadena = str_replace(
            array('Ñ', 'ñ', 'Ç', 'ç',',','.',';',':','&'),
            array('N', 'n', 'C', 'c','','','','','y'),
            $cadena
            );
            return $cadena;

    }

    //formato para valores moenetarios
    function formatMoney($cantidad){
        $cantidad = number_format($cantidad, 2, SPD, SPM);
        return $cantidad;
    }

    function meses(){
        $meses =['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        return $meses;
    }

    /**
    * @param string $url direccion de endpoint para obetener data
    * @return json $data en formato json
    */ #formatear a json peticion tipo api
    function api($url){
        $dataJson = file_get_contents($url);
        $data = json_decode($dataJson, true);
        json_encode($data, JSON_UNESCAPED_UNICODE);
        return $data;
    }

    #Funcion que permite enviar correo mediante phpmailer
    function enviarMail($data, $template){
        require 'libraries/PHPMailer/src/Exception.php';
        require 'libraries/PHPMailer/src/PHPMailer.php';
        require 'libraries/PHPMailer/src/SMTP.php';

        try{
            //variables para config
            $mailSender=SENDMAILER;
            $pass=ACCESSWORD;
            //$myHost="smtp.gmail.com";
            $myHost="smtp.office365.com";
            //$myHost="mail.hetacombe.com.mx";
            $puerto= "587";
            $deParte=$data['nombre'];
            $SMTP_Auth=true;
            $seguridad="STARTTLS";
            ob_start();
            require_once('views/_layouts/emails/'.$template.'.php');
            $mensaje = ob_get_clean();
            
            //config
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug=0;
            //$mail->Debugoutput = 'html';
            $mail->Host = $myHost;
            $mail->Port = $puerto; 
            $mail->SMTPAuth =$SMTP_Auth;      
            $mail->SMTPSecure =$seguridad;  
            $mail->Username = $mailSender;
            $mail->Password =$pass;  
            //receptores y remitentes
            $mail->setFrom($mailSender, $deParte);
            $mail->addAddress(EMAIL, $data['nombre']);
            //contenido de lemail
            $mail->isHTML(true);
            $mail->Subject =$data['asunto'];
            $mail->Body = $mensaje;
            
            if ($mail->send())
                return true;
                else
                return false;
        }catch(Exception $e){
        }
    }

    //mostar si un producto es favorito en las galerias, productos relacionados y busquedas
    function isFav($idUser, $idPr){
        require_once('models/ProductosModel.php');
        $model = new ProductosModel();
        if(empty($idUser)){
            echo'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
            </svg>';
            die();
        }
        $favorite =$model->favActive($idUser, $idPr);
        //se genera el html para regresarlo a la vista
        if($favorite==1){
            echo'<svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
            </svg>';
        }else{
            echo'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
            </svg>';
        }
    }

    