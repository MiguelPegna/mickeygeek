<?php
    class PanelController extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            //session_regenerate_id(true);
            if(empty($_SESSION['login']) OR ROL_ACCESS != $_SESSION['userData']['user_rol']){
                header('location: ../home');
				die();
			}
        }
        ////////////////////////////////////////////
        //LLAMADO DE VISTAS DEL PANEL
        ////////////////////////////////////////////
        //Vista principal del panel
        public function panel ($params){
            if(empty($_SESSION['login']) OR ROL_ACCESS != $_SESSION['userData']['user_rol']){
                header('location: ../home');
				die();
			}
            $data['page_id'] = 'p_panel';
            $data['page_title'] = '.:Hetacombe ~ Panel:.';
            $data['page_name'] = 'panel';
            $data['count_users'] = $this->model->countUsers();
            $data['count_products'] = $this->model->countProducts();
            $data['count_orders'] = $this->model->countOrders();
            $data['count_ganancias'] = $this->model->countGanancias();
            $data['count_pendientes'] = $this->model->countPendientes();
            $data['last_orders'] = $this->model->lastOrders();
            $data['top_clients'] = $this->model->topClients();
            $data['top_products'] = $this->model->topProducts();
            $data['page_scripts']='<script src="https://code.highcharts.com/highcharts.js"></script>
                <script src="https://code.highcharts.com/modules/series-label.js"></script>
                <script src="https://code.highcharts.com/modules/exporting.js"></script>
                <script src="https://code.highcharts.com/modules/export-data.js"></script>
                <script src="'.libraries().'datepicker/jquery-ui.min.js"></script>
                <script src="'.publicDocs().'js/panel/panel.js"></script>';
            $anho = date('Y');
            $mes = date('m');
            $data['ventas_mes'] = $this->model->selectVentasMes($anho, $mes);
            $data['ventas_anho'] = $this->model->selectVentasAnho($anho);
            $this->views->getView($this, 'panel', $data);
        }

        //vista de usuarios
        public function users ($params){
            if(empty($_SESSION['login']) OR ROL_ACCESS != $_SESSION['userData']['user_rol']){
                header('location: ../home');
				die();
			}
            $data['page_id'] = 'p_panel-usuarios';
            $data['page_modulo'] = 'panel';
            $data['page_num'] = 2;
            $data['page_title'] = '.:Lista de Usuarios:.';
            $data['page_name'] = 'usuarios';
            $data['page_scripts']='
            <script src="https://flowbite.com/docs/flowbite.min.js?v=1.6.5a"></script>';
            $this->views->getView($this, 'users', $data);
        }

        //vista de productos
        public function productos ($params){
            if(empty($_SESSION['login']) OR ROL_ACCESS != $_SESSION['userData']['user_rol']){
                header('location: ../home');
				die();
			}
            $data['page_id'] = 'p_panel-productos';
            $data['page_modulo'] = 'panel';
            $data['page_title'] = '.:Lista de Productos:.';
            $data['page_name'] = 'listado';
            $data['page_scripts']='
            <script src="https://flowbite.com/docs/flowbite.min.js?v=1.6.5a"></script>';
            $this->views->getView($this, 'listado', $data);
        }

        //vista para agregar productos
        public function addProduct ($params){
            if(empty($_SESSION['login']) OR ROL_ACCESS != $_SESSION['userData']['user_rol']){
                header('location: ../home');
				die();
			}
            $data['page_id'] = 'p_add';
            $data['page_title'] = '.:Agregar Producto:.';
            $data['page_name'] = 'agregar';
            $data['idP'] = $this->model->selectIdProduct();
            $data['sections'] = $this->model->selectComboSections();
            $data['page_scripts']='<script src="'.url_full().'libraries/tinymce/tinymce.min.js"></script>
            <script src="'.publicDocs().'js/panel/add.js"></script>';
            $this->views->getView($this, 'add', $data);
        }

        //vista para editar producto
        public function edit($params){
            if(empty($_SESSION['login']) OR ROL_ACCESS != $_SESSION['userData']['user_rol']){
                header('location: ../home');
				die();
			}
            //se pasa los parametros a un array
			$producto = explode(',', $params);
			//se conviete en int la primera posicion del array para obtener el id
			$id = intval($producto[0]);
			//se convierte en string la 2da posicion del array para obtener la url
			$url = strClean($producto[1]);

            $data['page_id'] = 'p_edit';
            $data['page_title'] = '.: :.';
			$data['producto'] = $this->getProduct($id, $url);
			$data['ventas'] = $this->model->countVentaProducto($id);
			$data['pic'] = $this->model->selectPhoto($id);
			$data['sections'] = $this->model->selectComboSections();
            $data['page_name'] = 'editar';
            //$data['idP'] = $this->model->selectIdProduct();
            $data['page_scripts']='<script src="'.url_full().'libraries/tinymce/tinymce.min.js"></script>
            <script src="'.publicDocs().'js/panel/edit.js"></script>';
            $this->views->getView($this, 'edit', $data);
            
        }

        //vista para ver ventas
        public function ventas ($params){
            if(empty($_SESSION['login']) OR ROL_ACCESS != $_SESSION['userData']['user_rol']){
                header('location: ../home');
				die();
			}
            $data['page_id'] = 'p_panel-ventas';
            $data['page_modulo'] = 'panel';
            $data['page_title'] = '.:Lista de Ventas:.';
            $data['page_name'] = 'ventas';
            $data['page_scripts']='
            <script src="https://flowbite.com/docs/flowbite.min.js?v=1.6.5a"></script>';
            $this->views->getView($this, 'ventas', $data);
        }
        //vista para ver secciones
        public function secciones ($params){
            if(empty($_SESSION['login']) OR ROL_ACCESS != $_SESSION['userData']['user_rol']){
                header('location: ../home');
				die();
			}
            $data['page_id'] = 'p_panel-secciones';
            $data['page_modulo'] = 'panel';
            $data['page_title'] = '.:Lista de Secciones:.';
            $data['page_name'] = 'secciones';
            $data['page_scripts']='
            <script src="https://flowbite.com/docs/flowbite.min.js?v=1.6.5a"></script>';
            $this->views->getView($this, 'sections', $data);
        }
        //vista para ver banners
        public function banners ($params){
            if(empty($_SESSION['login']) OR ROL_ACCESS != $_SESSION['userData']['user_rol']){
                header('location: ../home');
				die();
			}
            $data['page_id'] = 'p_panel-banners';
            $data['page_modulo'] = 'panel';
            $data['page_title'] = '.:Lista de Banners:.';
            $data['page_name'] = 'banners';
            $data['page_scripts']='
            <script src="https://flowbite.com/docs/flowbite.min.js?v=1.6.5a"></script>';
            $this->views->getView($this, 'banners', $data);
        }

        ////////////////////////////////////////////
        //METODOS DE CONTROLADOR PARA PANEL
        ////////////////////////////////////////////
        //grafica de ventas por mes
        public function grahpPerDay(){
            if($_POST){
                $graph =1;
                $nFecha = str_replace(' ','', $_POST['fecha']);
                $arrFecha = explode('-', $nFecha);
                $mes = $arrFecha[0];
                $anho = $arrFecha[1];
                $pagos = $this->model->selectVentasMes($anho, $mes);
                $script = getFile('_templates/graphs/graficas', $pagos);
                echo $script;
                die();
            }
        }

        //grafica de ventas por anuales
        public function grahpPerYear(){
            if($_POST){
                $graph =2;
                $anho = intval($_POST['anho']);
                $pagos = $this->model->selectVentasAnho($anho);
                $script = getFile('_templates/graphs/graficas', $pagos);
                echo $script;
                die();
            }

        }

        ////////////////////////////////////////////
        //METODOS DE CONTROLADOR PARA USUARIOS
        ////////////////////////////////////////////
        //obtener usuarios para datatable
        public function getUsers(){
            $arrData = $this->model->selectUsers();
            for($i=0; $i<count($arrData); $i++){
                if($arrData[$i]['compras'] ==null){
                    $arrData[$i]['compras'] = 0;
                }   
                if($arrData[$i]['estado'] != 0){
                    $arrData[$i]['estado']='<span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"> Activo </span>';
                }
                else{
                    $arrData[$i]['estado']='<span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100"> Inactivo </span>';
                }      
                $arrData[$i]['actions'] ='<div>  
                <button data-bs-toggle="modal" data-bs-target="#editUser" onclick="fntEditUser();" title="EDITAR USUARIO" class="btnEditUser mt-1 mb-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" rl="'.$arrData[$i]['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</button>
                </div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }
        //obtener info de usuario para mostrara en modal
        public function getUser($idUser){
			$id = intval(strClean($idUser));
			if($id > 0){
				$arrData = $this->model->selectUser($id);
				if(empty($arrData))
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

        //Actualizar registro de producto
        public function refreshUser(){
            //dep($_POST);return;
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['idUser']) || empty($_POST['name']) || empty($_POST['email']) || empty($_POST['rol']) || empty($_POST['estado']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios.');
                }
                #Se comprueba dirección de correo valida 
                else if(!esMail($_POST['email'])){
                    $arrResponse= array('status' => false, 'msg' => 'Escribe una dirección de correo valida.');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $idUser = intval($_POST['idUser']);
                    $name =  ucwords(strtolower(strClean($_POST['name'])));
		    	    $email = strtolower(strClean($_POST['email']));
		    	    $rol = intval($_POST['rol']);
		    	    $estado = intval($_POST['estado']);

                    $request_update = $this->model->updateUser($idUser, $name, $email, $rol, $estado);
                    if($request_update == 1){
                        $arrResponse = ['status' => true, 'msg' => 'La info de usuario se ha actualizado correctamente'];
                    }
                    else if($request_update == 0){
                        $arrResponse = ['status' => false, 'msg' => 'Ingresa otra dirección de correo'];
                    }
                    else{
                        $arrResponse = ['status' => false, 'msg' => 'No fue posible actualizar la informacion del usuario, intenta nuevamente'];
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
        }//end method

        ////////////////////////////////////////////
        //METODOS DE CONTROLADOR PARA PRODUCTOS
        ////////////////////////////////////////////
        //mostrar todos los productos de la DB en datatable
        public function getProducts(){
            $arrData = $this->model->selectProducts();
            for($i=0; $i<count($arrData); $i++){  
                if($arrData[$i]['ventas'] ==null){
                    $arrData[$i]['ventas'] = 0;
                }       
                if($arrData[$i]['estado'] == 1){
                    $arrData[$i]['actions'] ='<div>  
                    <a href="edit/'.$arrData[$i]['id'].'/'.$arrData[$i]['url'].'" title="EDITAR PRODUCTO" class="mt-3 mb-2 bEditPr text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" role="button" rl="'.$arrData[$i]['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <button onclick="return fntProduct();" title="PRODUCTO ACTIVO" role="button" class="mt-3 mb-2 btnProduct text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" rl="'.$arrData[$i]['id'].'"><span class="fa fa-toggle-on"></span></button>
                    </div>';
                }
                else{
                    $arrData[$i]['actions'] ='<div>  
                    <a href="edit/'.$arrData[$i]['id'].'/'.$arrData[$i]['url'].'" title="EDITAR PRODUCTO" class="mt-3 mb-2 bEditPr text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" role="button" rl="'.$arrData[$i]['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <button onclick="return fntProduct();" title="PRODUCTO INACTIVO" role="button" class="mt-3 mb-2 btnProduct text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" rl="'.$arrData[$i]['id'].'"><span class="fa fa-toggle-off"></span></button>                    </div>';
                }
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }
        //inactivar o activar producto
        public function dropProduct(){
            if($_POST){
                $idPr = intval($_POST['idPr']);
                $requestDel = $this->model->deleteProduct($idPr);
                if($requestDel ==0){
                    $arrResponse = array('status' => true, 'msg' => 'El producto ha sido inactivado');
                }
                else if($requestDel ==1){
                    $arrResponse = array('status' => true, 'msg' => 'El producto ha sido activado');
                }
                else{
                    $arrResponse = array('status' => false, 'msg' => 'Error al ejecutar la acción');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }//end method

        //agregar nuevo producto a la DB
        public function setProduct(){
            //dep($_FILES['photos']);return;
            if($_POST){
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['titulo']) || empty($_POST['tipo']) || empty($_POST['seccion'])|| empty($_POST['color'])|| empty($_POST['stock'])|| empty($_POST['precio']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios.');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $name =  ucwords(strtolower(strClean($_POST['titulo'])));
		    	    $tipo = strtolower(strClean($_POST['tipo']));
		    	    $seccion = intval($_POST['seccion']);
		    	    $color = strClean(ucwords(strtolower($_POST['color'])));
		    	    $stock = intval($_POST['stock']);
		    	    $precio = intval($_POST['precio']);
		    	    $descripcion = strClean($_POST['descripcion']);
		    	    //$categoria =  strClean($_POST['categoria']);
		    	    //$size = strClean($_POST['size']);

                    //se convierte el titulo del producto a la url del mismo
                    $url = strtolower(removeChars(str_replace(' ', '-', $name)));
                    //se revisa los archivos que vienen del files
                    $foto = $this->verifyFiles($_FILES['photos']);
                    //si $foto es diferente a la img por defecto
                    if($foto !='001.jpg'){
                        //se sube imagenes al host
                        $images = $this->uploadImg($foto);
                    }
                    //si foto o images existen se agrega la informacion del producto a la DB
                    if($foto || $images){
                        //se registra la informacion del producto a la db
                        $request_pr = $this->model->insertProduct($name, $tipo, $seccion, $color, $stock, $precio, $descripcion, $url);
                    }
                    //obtenemos el id del producto recien agregado para asignarlo como fk a las imagenes del producto
                    $imgPrId = $request_pr;
                    //si se registra la info del producto y se subio imagen se registra la info de la imagen del producto
                    if($images){
                        $request_img = $this->setPhoto($imgPrId, $images);
                    }
                    else{
                        //si se registra la info del producto pero no se subio imagen se registra la info de la imagen del producto
                        $request_img = $this->setPhoto($imgPrId, $foto);
                    }
                    //
                    if($request_img != 0){
                        $arrResponse = ['status' => true, 'msg' => 'Producto agregado correctamente a la tienda. Ya está disponible', 'idPr'=> $request_pr];
                    }
                    //else if($request_pr == 0){
                    //    $arrResponse = ['status' => false, 'msg' => 'El nombre de producto ya esta asignado, asigna otro o agrega un número al nombre'];
                    //}
                    else{
                        $arrResponse = ['status' => false, 'msg' => 'No fue posible realizar el registro, intenta nuevamente'];
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
        }//end method

        //verificar los archivos que se mandan
        public function verifyFiles($files){
            $extension = ['', 'image/png', 'image/jpeg', 'image/jpg', 'image/svg+xml', 'image/webp'];
            //convertir bytes a Unidades de almacenamiento de archivo
            $MB = pow(1024, 2);  // = 1MB en bytes
            //ponemos el limite máximo que debe pesar cada archivo en MB
            $docSize= $MB * 10;
            //si el files viene vacio se le asigna la imagen por defecto
            if($_FILES['photos']['error'][0]>0){
                //si viene vacio se asigna imagen por defecto
                return $files='001.jpg';
            }
            //verificamos los archivos y evitamos que suba cualquier documento si alguno pesa mas de 10MB
            foreach ($files['tmp_name'] as $key => $value){
                if($files['size'][$key] > $docSize){
                    $arrResponse = array('status' => false, 'msg' => 'La imagen no puede pesar más de 10MB ●︿●');
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                    exit();
                }
            }
            //se vuelve a recorrer el $_files ahora validando que se suba archivo con extension valida
            foreach ($files['tmp_name'] as $key => $value){
                if(!in_array($files['type'][$key], $extension)){  
                    $arrResponse = array('status' => false, 'msg' => 'Solo se aceptan archivos jpg, jpeg, png, svg o webp'); 
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                    exit();     
                }
            } //fin Foreach
            //se termina las verificaciones y se devuelve el file como valido para usarlo
            return $files;
        }

        //Subir archivos al host
        public function uploadImg($imagen){
            //se crea un array para guardar los nombres de los archivos y subirlos a la DB
            $namesImg =[];
            foreach ($_FILES['photos']['tmp_name'] as $key => $value){
                $fileName = $imagen['name'][$key];
                $imgName = 'img_'.rand(1, 365).'_'.base64_encode($fileName);
                //se obtiene la extencion del archivo
                $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                //se limpia el string de caracteres especiales
                $imgName = str_replace(["+", "/", "="], "", $imgName).'.'.$ext;
                //se sube el archivo al host
                $uploadImage =  uploadPhoto($imagen['tmp_name'][$key], $imgName);
                array_push($namesImg, $imgName);
            }
            //si se sube el archivo retornamos el nombre para guardarlo a la DB
            if($uploadImage){
                return $namesImg;
            }
            else{
                //si hay error al subir imagen mandamos mensaje
                $arrResponse =['status' => false, 'msg' => 'Error al subir imagen'];
                sleep(2); //para que se vea mamalona la carga
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }  
        }//end method

        //Agregar info de foto a la DB
        public function setPhoto($idP, $images){
            //se comprueba si el imgName es la imagen por defecto
            if(!is_array($images)){
                //al no ser un array se reg en DB de forma directa la info poniendo la img por defecto
                $requestImg = $this->model->insertPhoto($idP, $images);
            }
            else{
                //caso contrario el user si subio img entonces hacemos un ciclo para recorrer y reg info en la DB
                for($i=0;$i<count($images); $i++){
                    $requestImg = $this->model->insertPhoto($idP, $images[$i]);
                }
            }
            //si la info se agrega se retorna la variable
            if($requestImg){
                return $requestImg;
            }
            else{
                $arrResponse =['status' => false, 'msg' => 'No se pudo agregar información de img a la DB'];
            }
            sleep(2); //para que se vea mamalona la carga
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

        }//end method

        //mostrar producto de la DB en la vista edit
        public function getProduct($id, $url){
			if($id > 0 or $id ==null){
				$arrData = $this->model->selectProduct($id, $url);
				if(empty($arrData))
				{
					header('Location:'.url_full());
					//$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
                    //$arrImg = $this->model->selectPhoto($id);
                    //if(count($arrImg) >0){
                    //    for($i=0; $i < count($arrImg); $i++){
                    //        $arrImg[$i]['url_photo'] = publicDocs().'img/catalogo/'.$arrImg[$i]['photo_pic'];
                    //    }
                    //}
                    //$arrData['images'] = $arrImg;
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				return $arrResponse;
				//echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			//die();
		}

        //obtener imagenes de producto para vista de edit js
        public function getPhotos($id){
			if($id > 0 or $id ==null){
				if(empty($id))
				{
					header('Location:'.url_full());
					//$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
                    $arrImg = $this->model->selectPhoto($id);
                    if(count($arrImg) >0){
                        for($i=0; $i < count($arrImg); $i++){
                            $arrImg[$i]['url_photo'] = publicDocs().'img/catalogo/'.$arrImg[$i]['photo_pic'];
                        }
                    }
                    $arrData['images'] = $arrImg;
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				//return $arrResponse;
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			//die();
		}

        //Actualizar registro de producto
        public function refreshProduct(){
            //dep($_POST);return;
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['idPr']) || empty($_POST['titulo']) || empty($_POST['tipo']) || empty($_POST['seccion'])|| empty($_POST['color'])|| empty($_POST['stock'])|| empty($_POST['precio'])|| empty($_POST['descripcion']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios.');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $idPr = intval($_POST['idPr']);
                    $name =  ucwords(strtolower(strClean($_POST['titulo'])));
		    	    $tipo = strtolower(strClean($_POST['tipo']));
		    	    $seccion = intval($_POST['seccion']);
		    	    $color = strClean($_POST['color']);
		    	    $stock = strClean($_POST['stock']);
		    	    $precio = intval(strClean($_POST['precio']));
		    	    $descripcion = strClean($_POST['descripcion']);
		    	    //$categoria =  strClean($_POST['categoria']);
		    	    //$size = strClean($_POST['size']);
                    //se convierte el titulo del producto a la url del mismo
                    $url = strtolower(removeChars(str_replace(' ', '-', $name)));
                    
                    //se revisa los archivos que vienen del files
                    $foto = $this->verifyFiles($_FILES['photos']);
                    //si se regresa la imagen por defecto indica q el usuario no subio ningun archivo
                    if($foto =='001.jpg'){
                        //se setea la foto por defecto
                        $foto='001.jpg';
                    }
                    else{
                        //se sube imagenes al host
                        $images = $this->uploadImg($foto);
                    }
                    //si se subio nueva imagen se registra la info de la imagen del producto en DB
                    if(isset($images) ){
                        $request_img = $this->setPhoto($idPr, $images);
                    }
                    //si usuario borra todas las imagenes previas del producto asignamos la img por defecto
                    $searchImg = $this->model->selectPhoto($idPr);
                    //si variable viene vacía no hay img asociada al producto
                    if(empty($searchImg)){
                        //se asigna imagen por defecto al producto si no tiene umagen asignada
                        $request_img = $this->setPhoto($idPr, $foto);
                    }
                    //se actualiza la info del producto en la DB
                    $request_update = $this->model->updateProduct($idPr, $name, $tipo, $seccion, $color, $stock, $precio, $descripcion, $url);
                    if($request_update == 1){
                        $arrResponse = ['status' => true, 'msg' => 'La info del producto se ha actualizado correctamente'];
                    }
                    else if($request_update == 0){
                        $arrResponse = ['status' => false, 'msg' => 'El nombre de producto ya esta asignado, asigna otro o agrega un número al nombre'];
                    }
                    else{
                        $arrResponse = ['status' => false, 'msg' => 'No fue posible actualizar la informacion del producto, intenta nuevamente'];
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
        }//end method

        //eliminar foto de la DB y servidor
        public function dropPhoto(){
            //dep($_POST);return;
            if($_POST){
                if(empty($_POST['idP']) || empty($_POST['photo'])){
                    $arrResponse = ['status'=> false, 'message'=>'Datos incorrectos'];
                }
                else{
                    $idP = intval($_POST['idP']);
                    $foto = strClean($_POST['photo']);
                    $requestImg = $this->model->deletePhoto($idP, $foto);
                }
                if($requestImg==1){
                    $deleteImg =  dropFile($foto);
                    $arrResponse = ['status' => true, 'msg'=> 'Imagen borrada correctamente'];
                }
                else{
                    $arrResponse =['status' => false, 'msg' => 'Error al borrar imagen'];
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();

        }//end method

        ////////////////////////////////////////////
        //METODOS DE CONTROLADOR PARA VENTAS
        ////////////////////////////////////////////
        //obtener ventas para datatable
        public function getVentas(){
            $arrData = $this->model->selectVentas();
            for($i=0; $i<count($arrData); $i++){
                $arrData[$i]['total'] = SMONEY.formatMoney($arrData[$i]['total']);
                if($arrData[$i]['estado'] == 1){
                    $arrData[$i]['actions'] ='<div>  
                    <button data-bs-toggle="modal" data-bs-target="#viewCompra" onclick="fntViewCompra();" title="DETALLE COMPRA" class="btnViewCompra mt-1 mb-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" rl="'.$arrData[$i]['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></button>
                    <button onclick="return fntOrderEstado();" title="Cliente no ha recibido producto" role="button" class="mt-1 mb-1 btnOrder text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" rl="'.$arrData[$i]['id'].'"><span class="fa fa-truck"></span></button>
                    </div>';
                }
                else{
                    $arrData[$i]['actions'] ='<div>  
                    <button data-bs-toggle="modal" data-bs-target="#viewCompra" onclick="fntViewCompra();" title="DETALLE COMPRA" class="btnViewCompra mt-1 mb-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" rl="'.$arrData[$i]['id'].'"><i class="fa fa-eye" aria-hidden="true"></i></button>
                    <button onclick="return fntOrderEstado();" title="Cliente ha recibido producto" role="button" class="mt-1 mb-1 btnOrder text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" rl="'.$arrData[$i]['id'].'"><span class="fa fa-truck"></span></button>
                    </div>';
                }
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

        //Cambiar el estado del pedido de no entregado a entregado y viceversa
        public function estateOrder(){
            if($_POST){
                $idOrder = intval($_POST['idOrder']);
                $requestDel = $this->model->completeOrder($idOrder);
                if($requestDel ==0){
                    $arrResponse = array('status' => true, 'msg' => 'La entrega del pedido se ha realizado completamente');
                }
                else if($requestDel ==1){
                    $arrResponse = array('status' => true, 'msg' => 'La entrega del pedido todavia se encuentra pendiente');
                }
                else{
                    $arrResponse = array('status' => false, 'msg' => 'Error al ejecutar la acción');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }//end method

        //obtener info de compra para mostrara en modal
        public function getOrder($idOrder){
            if(empty($_SESSION['login']) OR ROL_ACCESS != $_SESSION['userData']['user_rol']){
                header('location: ../panel');
				die();
			}
			$id = intval(strClean($idOrder));
			if($id > 0){
				$arrData = $this->model->selectOrder($id);
				if(empty($arrData))
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
                    $arrData['order_subtotal'] = SMONEY.formatMoney($arrData['order_subtotal']);
                    $arrData['order_envio'] = SMONEY.formatMoney($arrData['order_envio']);
                    $arrData['order_total'] = SMONEY.formatMoney($arrData['order_total']);
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

        //obtener los productos de la compra para mostrara en modal
        public function getOrderItems($idOrder){
			$id = intval(strClean($idOrder));
			if($id > 0){
				$arrData = $this->model->selectOrderItems($id);
				if(empty($arrData))
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
                    for($i = 0; $i < count($arrData); $i++){
                        $arrData[$i]['sale_total'] = SMONEY.formatMoney($arrData[$i]['sale_total']);
                    }
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

        ////////////////////////////////////////////
        //METODOS DE CONTROLADOR PARA SECCIONES
        ////////////////////////////////////////////
        //obtener secciones del sitio
        public function getSections(){
            $arrData = $this->model->selectSections();
            for($i=0; $i<count($arrData); $i++){  
                $arrData[$i]['img'] = '<img src="'.publicDocs().'img/icons/sections/'.$arrData[$i]['img'].'" class="bg-blue-50 border border-sky-500 rounded-full" width="50" heigth="50" loading="lazy">';
                if($arrData[$i]['estado'] == 1){
                    $arrData[$i]['actions'] ='<div>  
                    <button data-bs-toggle="modal" data-bs-target="#editSection" onclick="fntEditSection();" title="EDITAR SECCIÓN" class="btnEditSection mt-1 mb-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" rl="'.$arrData[$i]['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    <button onclick="return fntSectionEstado();" title="Sección activa" role="button" class="mt-1 mb-1 btnSection text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" rl="'.$arrData[$i]['id'].'"><span class="fa fa-toggle-on"></span></button>
                    </div>';
                }
                else{
                    $arrData[$i]['actions'] ='<div>  
                    <button data-bs-toggle="modal" data-bs-target="#editSection" onclick="fntEditSection();" title="EDITAR SECCIÓN" class="btnEditSection mt-1 mb-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" rl="'.$arrData[$i]['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    <button onclick="return fntSectionEstado();" title="Sección inactiva" role="button" class="mt-1 mb-1 btnSection text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" rl="'.$arrData[$i]['id'].'"><span class="fa fa-toggle-off"></span></button>
                    </div>';
                }
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

        //activar o inactivar sección
        public function estateSection(){
            if($_POST){
                $idSection = intval($_POST['idSection']);
                $requestDel = $this->model->deleteSection($idSection);
                if($requestDel ==0){
                    $arrResponse = array('status' => true, 'msg' => 'Esta sección se ha inactivado');
                }
                else if($requestDel ==1){
                    $arrResponse = array('status' => true, 'msg' => 'Esta sección se encuentra activa nuevamente');
                }
                else{
                    $arrResponse = array('status' => false, 'msg' => 'Error al ejecutar la acción');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }//end method

        //obtener info de seccion para mostrara en modal
        public function getSection($idSection){
			$id = intval(strClean($idSection));
			if($id > 0){
				$arrData = $this->model->selectSection($id);
				if(empty($arrData))
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

        //Agregar nueva sección
        public function setSection(){
            //dep($_FILES);return;
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['nvaSection']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios.');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $section =  ucwords(strtolower(strClean($_POST['nvaSection'])));
                    //se convierte el titulo de la seccion a la url del mismo
                    $url = strtolower(removeChars(str_replace(' ', '-', $section)));
                    //imagen
                    $foto = $_FILES['foto2'];
                    if(($foto['name'] !='')){
                        $name = strtolower(removeChars(str_replace(' ', '-', $section)));
                        $imgName = $name;
                        //se obtiene la extension del archivo
                        $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
                        //se limpia el string de caracteres especiales
                        $imgName = str_replace(["+", "/", "="], "", $imgName).'.'.$ext;
                    }
                    else{
                        $imgName='_section.svg';
                    }
                    //dep($imgName);return;
                    $request_insert = $this->model->insertSection($section, $url, $imgName);
                    if($request_insert ==1){
                        if($imgName != '_section.svg'){
                            $uploadImage =  uploadSectionPhoto($foto, $imgName);
                        }
                        $arrResponse = ['status' => true, 'msg' => 'Sección creada correctamente'];
                    }
                    else if($request_insert == 0){
                        $arrResponse = ['status' => false, 'msg' => 'Ya hay una sección con el mismo nombre'];
                    }
                    else{
                        $arrResponse = ['status' => false, 'msg' => 'No fue posible agregar la información, intenta nuevamente'];
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
        }//end method

        //Actualizar info de sección
        public function refreshSection(){
            //dep($_POST);return;
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['idSection']) || empty($_POST['section']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios.');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $idSection = intval($_POST['idSection']);
                    $imgActual = strClean($_POST['imagen']);
                    $section =  ucwords(strtolower(strClean($_POST['section'])));
                    //se convierte el titulo de la seccion a la url del mismo
                    $url = strtolower(removeChars(str_replace(' ', '-', $section)));
                    //imagen
                    $foto = $_FILES['foto'];
                    if(($foto['name'] !='')){
                        $name = strtolower(removeChars(str_replace(' ', '-', $section)));
                        $imgName = $name;
                        //se obtiene la extension del archivo
                        $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
                        //se limpia el string de caracteres especiales
                        $imgName = str_replace(["+", "/", "="], "", $imgName).'.'.$ext;
                        //si se sube imagen nueva se borra la anterior del serv si es distinta ala de por defecto
                        if ($imgActual != '_section.svg'){
                            $deleteImg =  dropFileSection($imgActual);
                        }
                    }
                    else{
                        $imgName=$imgActual;
                    }
                    //dep($imgName);return;
                    $request_update = $this->model->updateSection($idSection, $section, $url, $imgName);
                    if($request_update == 1){
                        if($imgName != $imgActual){
                            $uploadImage =  uploadSectionPhoto($foto, $imgName);
                        }
                        $arrResponse = ['status' => true, 'msg' => 'La info de la sección se ha actualizado correctamente'];
                    }
                    else if($request_update == 0){
                        $arrResponse = ['status' => false, 'msg' => 'Ya hay una sección con el mismo nombre'];
                    }
                    else{
                        $arrResponse = ['status' => false, 'msg' => 'No fue posible actualizar la información del producto, intenta nuevamente'];
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
        }//end method

        ////////////////////////////////////////////
        //METODOS DE CONTROLADOR PARA BANNERS
        ////////////////////////////////////////////
        //obtener secciones del sitio
        public function getBanners(){
            $arrData = $this->model->selectBanners();
            for($i=0; $i<count($arrData); $i++){  
                $arrData[$i]['img'] = '<img src="'.publicDocs().'img/banners/'.$arrData[$i]['img'].'" class="bg-blue-50 border border-sky-500 rounded-full" width="50" heigth="50" loading="lazy">';
                if($arrData[$i]['galeria']==1){
                    $arrData[$i]['galeria']='Principal';
                }
                else if($arrData[$i]['galeria']==2){
                    $arrData[$i]['galeria']='Secundario';
                }

                if($arrData[$i]['estado'] == 1){
                    $arrData[$i]['actions'] ='<div>  
                    <button data-bs-toggle="modal" data-bs-target="#editBanner" onclick="fntEditBanner();" title="EDITAR BANNER" class="btnEditBanner mt-1 mb-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" rl="'.$arrData[$i]['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    <button onclick="return fntBannerEstado();" title="Banner activo" role="button" class="mt-1 mb-1 btnBanner text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" rl="'.$arrData[$i]['id'].'"><span class="fa fa-toggle-on"></span></button>
                    </div>';
                }
                else{
                    $arrData[$i]['actions'] ='<div>  
                    <button data-bs-toggle="modal" data-bs-target="#editSection" onclick="fntEditBanner();" title="EDITAR BANNER" class="btnEditSection mt-1 mb-1 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" rl="'.$arrData[$i]['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    <button onclick="return fntBannerEstado();" title="Banner inactivo" role="button" class="mt-1 mb-1 btnBanner text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" rl="'.$arrData[$i]['id'].'"><span class="fa fa-toggle-off"></span></button>
                    </div>';
                }
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

        //activar o inactivar sección
        public function estateBanner(){
            if($_POST){
                $idBanner = intval($_POST['idBanner']);
                $requestDel = $this->model->deleteBanner($idBanner);
                if($requestDel ==0){
                    $arrResponse = array('status' => true, 'msg' => 'Este banner se ha inactivado');
                }
                else if($requestDel ==1){
                    $arrResponse = array('status' => true, 'msg' => 'Este banner se encuentra activa nuevamente');
                }
                else{
                    $arrResponse = array('status' => false, 'msg' => 'Error al ejecutar la acción');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }//end method

        //obtener info de seccion para mostrara en modal
        public function getBanner($idSection){
			$id = intval(strClean($idSection));
			if($id > 0){
				$arrData = $this->model->selectBanner($id);
				if(empty($arrData))
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

        //Agregar nueva sección
        public function setBanner(){
            //dep($_FILES);return;
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['newBanner']) || empty($_POST['newSlider'])){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios.');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $banner =  ucwords(strtolower(strClean($_POST['newBanner'])));
                    $slider =  intval($_POST['newSlider']);
                    //imagen
                    $foto = $_FILES['foto2'];
                    if(($foto['name'] !='')){
                        $name = strtolower(removeChars(str_replace(' ', '-', $banner)));
                        $imgName = $name;
                        //se obtiene la extension del archivo
                        $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
                        //se limpia el string de caracteres especiales
                        $imgName = str_replace(["+", "/", "="], "", $imgName).'.'.$ext;
                    }
                    else{
                        $imgName='_default.jpg';
                    }
                    //dep($imgName);return;
                    $request_insert = $this->model->insertBanner($banner, $slider, $imgName);
                    if($request_insert ==1){
                        if($imgName != '_default.jpg'){
                            $uploadImage =  uploadBannerPhoto($foto, $imgName);
                        }
                        $arrResponse = ['status' => true, 'msg' => 'Banner agregado correctamente'];
                    }
                    else if($request_insert == 0){
                        $arrResponse = ['status' => false, 'msg' => 'Ya hay un banner con el mismo nombre'];
                    }
                    else{
                        $arrResponse = ['status' => false, 'msg' => 'No fue posible agregar la información, intenta nuevamente'];
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
        }//end method

        //Actualizar info de sección
        public function refreshBanner(){
            //dep($_POST);return;
            if($_POST){
                //Revalidación de los datos enviados
                #REvisamos que los datos del  formulario esten completos
                if (empty($_POST['idBanner']) || empty($_POST['banner']) || empty($_POST['slider']) ){
                    $arrResponse= array('status' => false, 'msg' => 'Todos los campos son obligatorios.');
                }
                else{
                    //declaracion de variables recibidas por POST
                    $idBanner = intval($_POST['idBanner']);
                    $banner =  ucwords(strtolower(strClean($_POST['banner'])));
                    $slider = intval($_POST['slider']);
                    $imgActual = strClean($_POST['imagen']);
                    //imagen
                    $foto = $_FILES['foto'];
                    if(($foto['name'] !='')){
                        $name = strtolower(removeChars(str_replace(' ', '-', $banner)));
                        $imgName = $name;
                        //se obtiene la extension del archivo
                        $ext = pathinfo($foto['name'], PATHINFO_EXTENSION);
                        //se limpia el string de caracteres especiales
                        $imgName = str_replace(["+", "/", "="], "", $imgName).'.'.$ext;
                        //si se sube imagen nueva se borra la anterior del serv si es distinta ala de por defecto
                        if ($imgActual != '_default.jpg'){
                            $deleteImg =  dropFileSection($imgActual);
                        }
                    }
                    else{
                        $imgName=$imgActual;
                    }
                    //dep($imgName);return;
                    $request_update = $this->model->updateBanner($idBanner, $banner, $slider, $imgName);
                    if($request_update == 1){
                        if($imgName != $imgActual){
                            $uploadImage =  uploadBannerPhoto($foto, $imgName);
                        }
                        $arrResponse = ['status' => true, 'msg' => 'Banner actualizado correctamente'];
                    }
                    else if($request_update == 0){
                        $arrResponse = ['status' => false, 'msg' => 'Ya hay un banner con el mismo nombre'];
                    }
                    else{
                        $arrResponse = ['status' => false, 'msg' => 'No fue posible actualizar la información del producto, intenta nuevamente'];
                    }
                } //end else post
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            } //end if POST
            die();
        }//end method
        
    }//end class
?>