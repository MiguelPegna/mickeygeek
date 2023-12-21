<?php
    class PanelModel extends Mysql{
        private $name;
        private $tipo;
        private $categoria;
        private $seccion;
        private $size;
        private $color;
        private $stock;
        private $precio;
        private $descripcion;
        private $url;

        private $img;
        private $id; //id para photo

        private $idPr; //id producto
        
        private $anho; 
        private $mes;

        private $idU; //id user
        private $mail; //mail
        private $estado; //estado
        private $rol; //rol

        private $idS; //section
        private $idO; //orden

        private $gallery; //orden

        public function __construct(){
            parent::__construct();
        }

        ////////////////////////////////////////////
        //METODOS PARA LA VISTA PRINCIPAL DEL PANEL
        ////////////////////////////////////////////
        //total de usuarios  registrados
        public function countUsers(){
            $sql="SELECT COUNT(*) AS total FROM users;";
            $request = $this->select($sql);
            return $request;
        }

        //total de productos
        public function countProducts(){
            $sql="SELECT COUNT(*) AS total FROM products;";
            $request = $this->select($sql);
            return $request;
        }

        //total de ventas
        public function countOrders(){
            $sql="SELECT COUNT(*) AS total FROM orders;";
            $request = $this->select($sql);
            return $request;
        }

        //total de entregas pendientes //no en uso
        public function countPendientes(){
            $sql="SELECT COUNT(*) AS total FROM orders WHERE order_status=1;";
            $request = $this->select($sql);
            return $request;
        }

        //total de ganancias
        public function countGanancias(){
            $sql="SELECT SUM(order_total) AS ganancias FROM orders;";
            $request = $this->select($sql);
            return $request;
        }

        //Ultimas 5 compras
        public function lastOrders(){
            $sql="SELECT order_id, order_total, order_ticket, user_name FROM orders 
            INNER JOIN users ON order_user = user_id ORDER BY order_id DESC LIMIT 5;";
            $request = $this->select_all($sql);
            return $request;
        }

        //mejores clientes
        public function topClients(){
            $sql="SELECT user_id, user_name, SUM(sale_quantity) AS compras FROM sales 
            INNER JOIN users ON sale_user = user_id GROUP BY user_id ORDER BY compras DESC LIMIT 5;";
            $request = $this->select_all($sql);
            return $request;
        }

        //productos más vendidos
        public function topProducts(){
            $sql="SELECT product_id, product_titulo, product_category, SUM(sale_quantity) AS ventas FROM sales 
            INNER JOIN products ON sale_product = product_id GROUP BY product_id ORDER BY ventas DESC LIMIT 5;";
            $request = $this->select_all($sql);
            return $request;
        }

        //consultas para generar graficas del panel
        //ventas por mes
        public function selectVentasMes(int $anho, int $mes){
            $this->anho= $anho;
            $this->mes =$mes;
            
            $totalVentas= 0;
            $arrDias = [];
            $dias = cal_days_in_month(CAL_GREGORIAN, $this->mes, $this->anho);
            $numDia=1;
            for($i=0; $i< $dias; $i++){
                $date = date_create($this->anho. '-'. $this->mes.'-'. $numDia);
                $dateVenta = date_format($date, 'Y-m-d');

                $sql="SELECT DAY(order_created_at) AS dia, COUNT(order_id) AS cantidad, SUM(order_total) AS total 
                    FROM orders WHERE DATE(order_created_at) ='$dateVenta'";
                $ventaDia = $this->select($sql);
                $ventaDia['dia'] = $numDia;
                $ventaDia['total'] = $ventaDia['total'] == '' ? 0 : $ventaDia['total'];
                $totalVentas = $totalVentas + $ventaDia['total'];
                array_push($arrDias, $ventaDia);
                $numDia ++;
            }
            $meses = meses();
            $arrData = ['anho'=> $this->anho, 'mes' => $meses[intval($this->mes -1)], 'total'=>$totalVentas, 'ventas'=> $arrDias];
            return $arrData;
        }

        //pagos anuales
        public function selectVentasAnho(int $anho){
            $this->anho= $anho;
            $arrVentas = [];
            $arrMeses = meses();
            for($i=1; $i<=12; $i++){
                $arrData = ['anho'=>'', 'numMes'=>'', 'mes'=>'', 'venta'=>''];
                $sql="SELECT $this->anho AS anho, $i AS mes, SUM(order_total) AS venta FROM orders 
                    WHERE MONTH(order_created_at) =$i AND YEAR(order_created_at)=$this->anho
                    GROUP BY MONTH(order_created_at);";
                $ventaMes = $this->select($sql);
                $arrData['mes'] = $arrMeses[$i-1];
                if(empty($ventaMes)){
                    $arrData['anho'] = $this->anho;
                    $arrData['numMes'] = $i;
                    $arrData['venta'] = 0;
                }
                else{
                    $arrData['anho'] = $ventaMes['anho'];
                    $arrData['numMes'] = $ventaMes['mes'];
                    $arrData['venta'] = $ventaMes['venta'];
                }
                array_push($arrVentas, $arrData);
            }//end for
            $arrAnual = ['anho'=>$this->anho, 'meses'=> $arrVentas];
            return $arrAnual;
        }

        ////////////////////////////////////////////
        //METODOS PARA LA VISTA PRINCIPAL DE USUARIOS
        ////////////////////////////////////////////
        //Mostar lista de usuarios registrados
        public function selectUsers(){
            //$sql="SELECT user_id as id, user_name as nombre, user_email as email, user_state as estado FROM users ORDER BY user_id DESC;";
            $sql="SELECT user_id AS id, user_name AS nombre, user_email AS email, user_state AS estado, SUM(order_user) as compras FROM users LEFT JOIN orders ON order_user = user_id GROUP BY user_id DESC;";
            $request = $this->select_all($sql);
            return $request;
        }//end method

        //consultar info de usuario
        public function selectUser(int $idUser){
            $this->idU = $idUser;
            $sql="SELECT user_id, user_name, user_email, user_rol, user_state FROM users WHERE user_id = $this->idU";
            $request = $this->select($sql);
            return $request;
        }

        //actualizar info de usuario
        public function updateUser($idUser, $name, $mail, $rol, $estado){
            $this->idU= $idUser;
            $this->name= $name;
            $this->mail =$mail;
            $this->rol =$rol;
            $this->estado =$estado;
            //se verifica que el usuario exista y sea diferente su email al de otros usuarios registrados
            $query ="SELECT user_name, user_email FROM users WHERE user_email='$this->mail' AND user_id != $this->idU";
            $response = $this->select($query);

            if($response){
                $return = 0;
            }
            else{
                //si existe el usuario y el email no lo tiene asignado ningún usuario se actualiza la información del usuario
                $sql= "UPDATE users SET user_name=? ,user_email=?, user_rol=?, user_state=? WHERE user_id= $this->idU;";
                $arrData = array($this->name, $this->mail, $this->rol, $this->estado);
                $request= $this->update($sql, $arrData);
                $return = 1;
            }
            return $return;
        }//end method

        ////////////////////////////////////////////
        //METODOS PARA LA VISTA PRINCIPAL DE PRODUCTOS
        ////////////////////////////////////////////
        //mostrar lista de productos registrados
        public function selectProducts(){
            //$sql="SELECT product_id as id, product_titulo as titulo, product_category as categoria, product_section as seccion, product_url as url, product_status as estado FROM products ORDER BY product_id DESC;";
            $sql="SELECT product_id as id, product_titulo as titulo, product_category as categoria, section_name as seccion, product_url as url, product_status as estado, SUM(sale_quantity) as ventas FROM products 
                INNER JOIN sections ON product_section = section_id
                LEFT JOIN sales ON sale_product = product_id 
                GROUP BY product_id DESC;";
            $request = $this->select_all($sql);
            return $request;
        }//end method

        //inactivar o activar producto
        public function deleteProduct(int $idPr){
            $this->idPr = $idPr;
            $return='';
            $sql ="SELECT product_status FROM products WHERE product_id= $this->idPr";
            $request= $this->select($sql);
            if($request['product_status'] == 1){
                $sql = "UPDATE products SET product_status=? WHERE product_id= $this->idPr";
                $arrData = [0];
                $query= $this->update($sql, $arrData);
                if($query){
                    $return=0; //se ejecuto la consulta de borrrar
                }
            }
            else if($request['product_status'] ==0){
                $sql = "UPDATE products SET product_status=? WHERE product_id= $this->idPr";
                $arrData = [1];
                $query= $this->update($sql, $arrData);
                if($query){
                    $return=1; //se ejecuto la consulta de borrrar
                }
            }
            return $return;
        }

        //consultar el ultimo id de producto registrado
        public function selectIdProduct(){
            $sql="SELECT MAX(product_id) AS id FROM products;";
            $request = $this->select($sql);
            return $request;
        }
        //consultas las secciones
        public function selectComboSections(){
            $sql="SELECT * FROM sections WHERE section_status=1";
            $request= $this->select_all($sql);
            return $request;
        }

        //agregar nuevo producto a la tienda
        public function insertProduct(string $name, string $tipo, int $seccion, string $color, int $stock, int $precio, string $descripcion, string $url){
            $this->name= $name;
            $this->tipo =$tipo;
            $this->seccion =$seccion;
            $this->color =$color;
            $this->stock =$stock;
            $this->precio =$precio;
            $this->descripcion =$descripcion;
            $this->url =$url;
            //$this->categoria =$categoria;
            //$this->size =$size;
            //se verifica si hay una url repetida
            $sql="SELECT product_url FROM products WHERE product_url = '$this->url';";
            $request = $this->select($sql);
            //Si la respuesta es nula la url no existe en la base de datos y se guarda la info del producto
            if(empty($request)){
                $sql= "INSERT INTO products(product_titulo, product_type, product_description, product_color, product_stock, product_price, product_url, product_section) VALUES(?,?,?,?,?,?,?,?);";
                $arrData = array($this->name, $this->tipo, $this->descripcion, $this->color, $this->stock, $this->precio, $this->url, $this->seccion);
                $request= $this->insert($sql, $arrData);
                $request ? $return =$request : $return=0;
            }
            else{
                return $return =0;
            }
            return $return;
        }

        //insertar info de foto de producto a la DB
        public function insertPhoto(int $idP, string $imgName){
            $this->id= $idP;
            $this->img =$imgName;

            $sql= "INSERT INTO photos(photo_product, photo_pic) VALUES(?,?);";
            $arrData = array($this->id, $this->img);
            $request= $this->insert($sql, $arrData);
            return $request;
        }//end method

        //consultar producto para editarlo
        public function selectProduct($id, $url){
            $this->id = $id;
            $this->url = $url;
            $sql="SELECT * FROM products 
            INNER JOIN sections ON product_section = section_id WHERE product_id = $this->id AND product_url='$this->url';";
            $request = $this->select($sql);
            return $request;
        }

        //total de veces que se ha vendido producto
        public function countVentaProducto($idPr){
            $this->idPr = $idPr;
            $sql="SELECT SUM(sale_quantity) AS total FROM sales WHERE sale_product=$this->idPr;";
            $request = $this->select($sql);
            return $request;
        }

        //consultar imagen del producto para mostrarla en vista de editar producto
        public function selectPhoto($idPr){
            $this->idPr = $idPr;
            $sql="SELECT photo_id, photo_product, photo_pic FROM photos WHERE photo_product = $this->idPr;";
            $request = $this->select_all($sql);
            return $request;
        }

        //borrar foto de producto tambien borra imagen cuando se crea el producto
        public function deletePhoto(int $idP, string $foto){
            $this->id= $idP;
            $this->img = $foto;
            $sql ="SELECT photo_id FROM photos WHERE photo_product= $this->id AND photo_pic= '$this->img';";
            $request= $this->select_all($sql);
            if($request){
                $sql = "DELETE FROM photos WHERE photo_product= $this->id AND photo_pic= '$this->img';";
                $request= $this->delete($sql);
                if($request){
                    $request=1; //se ejecuto la consulta de borrrar
                }
            }
            else{
                $request= 0; //este producto ya se habia borrado con anterioridad
            }
            return $request;
        }

        //actualizar registro 
        public function updateProduct(int $idPr, string $name, string $tipo, int $seccion, string $color, int $stock, int $precio, string $descripcion, string $url){
            $this->idPr = $idPr;
            $this->name= $name;
            $this->tipo =$tipo;
            $this->seccion =$seccion;
            $this->color =$color;
            $this->stock =$stock;
            $this->precio =$precio;
            $this->descripcion =$descripcion;
            $this->url =$url;

            $sql="SELECT * FROM products WHERE product_id= $this->idPr";
            $request=$this->select($sql);

            if($request){
                $sql="UPDATE products SET  product_titulo=?, product_type =?, product_section=?, product_color =?, product_stock =?, product_price =?, product_description=?, product_url =? WHERE product_id= $this->idPr";
                $arrData= array($this->name, $this->tipo, $this->seccion, $this->color, $this->stock, $this->precio, nl2br($this->descripcion), $this->url);
                $request= $this->update($sql, $arrData);
            }
            else{
                $request= 0;
            }
            return $request;
        }

        ////////////////////////////////////////////
        //METODOS PARA LA VISTA PRINCIPAL DE VENTAS
        ////////////////////////////////////////////
        //ventas hechas para mostrar en data tables
        public function selectVentas(){
            $sql="SELECT order_id as id, user_name as nombre, order_operation as operacion, order_total as total, order_status as estado FROM orders 
            INNER JOIN users ON order_user = user_id ORDER BY order_id DESC;";
            $request = $this->select_all($sql);
            return $request;
        }

        //seleccionar venta para ventana modal
        public function selectOrder($idOrder){
            $this->id = $idOrder;

            $sql ="SELECT user_email, order_user, order_operation, order_ticket, order_subtotal, order_envio, order_total, order_status, date_format(order_created_at ,'%d/%m/%Y') as order_fecha,
                adress_receptor, adress_cp, adress_estado, adress_localidad, adress_colonia, adress_calle, adress_numero, adress_numeroInt, adress_telefono FROM orders
                INNER JOIN adresses ON order_adress = adress_id 
                INNER JOIN users ON order_user = user_id WHERE order_id= $this->id";
            $request = $this->select($sql);
            return $request;
        }

        //seleccionar productos de la venta para ventana modal
        public function selectOrderItems($idOrder){
            $this->id = $idOrder;

            $sql ="SELECT product_titulo, sale_quantity, sale_size, sale_category, sale_total FROM sales
            INNER JOIN products ON sale_product = product_id 
            INNER JOIN orders ON sale_order = order_id WHERE order_id= $this->id";
            $request = $this->select_all($sql);
            return $request;
        }

        //Cambiar el estado del pedido de no entregado a entregado y viceversa
        public function completeOrder($idO){
            $this->idO = $idO;
            $return='';
            $sql ="SELECT order_status FROM orders WHERE order_id= $this->idO";
            $request= $this->select($sql);
            if($request['order_status'] == 1){
                $sql = "UPDATE orders SET order_status=? WHERE order_id= $this->idO";
                $arrData = [0];
                $query= $this->update($sql, $arrData);
                if($query){
                    $return=0; //se ejecuto la consulta de borrrar
                }
            }
            else if($request['order_status'] ==0){
                $sql = "UPDATE orders SET order_status=? WHERE order_id= $this->idO";
                $arrData = [1];
                $query= $this->update($sql, $arrData);
                if($query){
                    $return=1; //se ejecuto la consulta de borrrar
                }
            }
            return $return;
        }

        ////////////////////////////////////////////
        //METODOS PARA LA VISTA PRINCIPAL DE SECCIONES
        ////////////////////////////////////////////
        //consultar secciones
        public function selectSections(){
            //$sql="SELECT * FROM sections ORDER BY section_name ASC";
            $sql="SELECT section_id AS id, section_name AS section, section_img AS img, section_status AS estado, COUNT(product_section) as productos FROM sections LEFT JOIN products ON product_section = section_id GROUP BY section_id DESC;";
            $request = $this->select_all($sql);
            return $request;
        }
        //consultar seccion para modal
        public function selectSection($id){
            $this->id = $id;
            $sql="SELECT * FROM sections WHERE section_id=$this->id";
            $request = $this->select($sql);
            return $request;
        }

        //insertar nueva seccion DB
        public function insertSection($name, $url, $img){
            $this->name= $name;
            $this->url =$url;
            $this->img =$img;
            //se verifica si hay una sección repetida
            $sql="SELECT section_name FROM sections WHERE section_name='$this->name' AND section_url = '$this->url';";
            $request = $this->select($sql);
            //Si la respuesta es nula la url no existe en la base de datos y se guarda la info del producto
            if(empty($request)){
                $sql= "INSERT INTO sections(section_name, section_url, section_img) VALUES(?,?,?);";
                $arrData = array($this->name, $this->url, $this->img);
                $request= $this->insert($sql, $arrData);
                $request ? $return =1 : $return=0;
            }
            else{
                return $return =0;
            }
            return $return;
        }//end method

        //actualizar info de seccion
        public function updateSection($idS, $name, $url, $img){
            $this->idS= $idS;
            $this->name= $name;
            $this->url =$url;
            $this->img =$img;
            
            $query ="SELECT section_name, section_url FROM sections WHERE section_url='$this->url' AND section_id != $this->idS";
            $response = $this->select($query);

            if($response){
                $return = 0;
            }
            else{
                $sql= "UPDATE sections SET section_name=? ,section_url=?, section_img=? WHERE section_id=?;";
                $arrData = array($this->name, $this->url, $this->img, $this->idS);
                $request= $this->update($sql, $arrData);
                $return = 1;
            }
            return $return;
        }//end method

        //inactivar seccion
        public function deleteSection($idS){
            $this->idS = $idS;
            $return='';
            $sql ="SELECT section_status FROM sections WHERE section_id= $this->idS";
            $request= $this->select($sql);
            if($request['section_status'] == 1){
                $sql = "UPDATE sections SET section_status=? WHERE section_id= $this->idS";
                $arrData = [0];
                $query= $this->update($sql, $arrData);
                if($query){
                    $return=0; //se ejecuto la consulta de borrrar
                }
            }
            else if($request['section_status'] ==0){
                $sql = "UPDATE sections SET section_status=? WHERE section_id= $this->idS";
                $arrData = [1];
                $query= $this->update($sql, $arrData);
                if($query){
                    $return=1; //se ejecuto la consulta de borrrar
                }
            }
            return $return;
        }

        ////////////////////////////////////////////
        //METODOS PARA LA VISTA PRINCIPAL DE BANNERS
        ////////////////////////////////////////////
        //consultar secciones
        public function selectBanners(){
            //$sql="SELECT * FROM sections ORDER BY section_name ASC";
            $sql="SELECT banner_id AS id, banner_name AS banner, banner_img AS img, banner_status AS estado, banner_gallery AS galeria FROM banners ORDER BY banner_gallery ASC;";
            $request = $this->select_all($sql);
            return $request;
        }
        //consultar seccion para modal
        public function selectBanner($id){
            $this->id = $id;
            $sql="SELECT * FROM banners WHERE banner_id=$this->id";
            $request = $this->select($sql);
            return $request;
        }

        //insertar nueva seccion DB
        public function insertBanner($name, $gallery, $img){
            $this->name= $name;
            $this->gallery =$gallery;
            $this->img =$img;

            $sql= "INSERT INTO banners(banner_name, banner_gallery, banner_img) VALUES(?,?,?);";
            $arrData = array($this->name, $this->gallery, $this->img);
            $request= $this->insert($sql, $arrData);
            $request ? $return =1 : $return=0;
            
            return $return;
        }//end method

        //actualizar info de seccion
        public function updateBanner($idS, $name, $gallery, $img){
            $this->idS= $idS;
            $this->name= $name;
            $this->gallery =$gallery;
            $this->img =$img;
            
            $sql= "UPDATE banners SET banner_name=? ,banner_img=?, banner_gallery=? WHERE banner_id=?;";
            $arrData = array($this->name, $this->img, $this->gallery, $this->idS);
            $request= $this->update($sql, $arrData);
            $return = 1;
            
            return $return;
        }//end method

        //inactivar banner
        public function deleteBanner($idS){
            $this->idS = $idS;
            $return='';
            $sql ="SELECT banner_status FROM banners WHERE banner_id= $this->idS";
            $request= $this->select($sql);
            if($request['banner_status'] == 1){
                $sql = "UPDATE banners SET banner_status=? WHERE banner_id= $this->idS";
                $arrData = [0];
                $query= $this->update($sql, $arrData);
                if($query){
                    $return=0; //se ejecuto la consulta de borrrar
                }
            }
            else if($request['banner_status'] ==0){
                $sql = "UPDATE banners SET banner_status=? WHERE banner_id= $this->idS";
                $arrData = [1];
                $query= $this->update($sql, $arrData);
                if($query){
                    $return=1; //se ejecuto la consulta de borrrar
                }
            }
            return $return;
        }

        /*
        SIN USO ACTUAL CODIGO DE PRUEBA
        //actualizar foto de seccion a la DB
        public function updateSectionPhoto($idS, $imgName){
            $this->id= $idS;
            $this->img =$imgName;

            $sql= "UPDATE sections SET section_img =? WHERE section_id=?;";
            $arrData = array($this->img, $this->id);
            $request= $this->update($sql, $arrData);
            return $request;
        }//end method
        */
    }
?>