<?php
    class RegisterController extends Controllers{
        public function __construct(){
			parent::__construct();
            //se declara inicio de sesion
			session_start();
            session_regenerate_id(true);
		}
        /**
        * funcion para generar la vista principal del controlador 
        * @var array $params se recibe parametros para el uso en la vista
        * @return array $info array para usar en la vista
        */
        public function register ($params){
            $info['page_id'] = 'p_register';
            $info['meta_description'] = 'Registro, crear cuenta';
            $info['page_title'] = EMPRESA;
            $info['page_name'] = 'register';
            $info['page_scripts'] = getScript('register/register', 'js');
            //$info['page_scripts']='';
            $this->views->getView($this, '../'. METATAGS, $info);
            $this->views->getView($this, '../'. HEADER, $info);
            $this->views->getView($this, 'register', $info);
            $this->views->getView($this, '../'. FOOTER, $info);
        }

        /**
        * funcion para generar la vista principal del controlador 
        * @return array $response array con la respuesta de la request
        */
        public function store(){
            if($_POST){
                //validacion del formulario por backend
                if(isFormEmpty($_POST)){
                    $response = ['status' => false, 'msg' => 'Todos los campos son obligatorios.'];
                }
                else if(!isMail($_POST['email'])){
                    $response = ['status' => false, 'msg' => 'Introduce un email valido.'];
                }
                else if(strcmp($_POST['password'], $_POST['password1']) !== 0){
                    $response = ['status' => false, 'msg' => 'Las contraseñas no coinciden.'];
                }
                else if(strlen($_POST['password']) < 8 || strlen($_POST['password1']) < 8){
                    $response = ['status' => false, 'msg' => 'La contraseña debe ser minimo de 8 caracteres.'];
                }
                else{
                    //declaracion de variables recibidas por POST
                    $name = $_POST['name'];
                    $email = strtolower($_POST['email']);
                    $pass = $_POST['password'];
                    //hashear el password que estara eb DB
                    $passDB = hashPass($pass);
                    //Se envia la peticion para hacer el registro a la DB
                    $request = $this->model->setUser($name, $email, $passDB);
                    if($request){
                        $response = ['status' => true, 'msg' => 'Registro completado'];
                    }
                    else if($request === 0){
                        $response = ['status' => false, 'msg' => 'Inicia sesión o trata con otro e-mail'];
                    }
                    else{
                        $response = ['status' => false, 'msg' => 'No fue posible realizar el registro, intenta nuevamente'];
                    }
                }
                echo json_encode($response, JSON_UNESCAPED_UNICODE);
            }
            die();
        }//end method

    }//end class