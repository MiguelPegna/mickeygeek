<?php 

    class Mysql extends DB_connection{

        public static function verifyJustTable(string $table){
            $database = DB_NAME;
            $attach = DB_connection::connect();
            //validar existencia de tablas
            return $attach->query("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '$database' AND table_name='$table'")->fetchall(PDO::FETCH_OBJ);
        }

        public static function verifyTable(string $table, array $columns){
            $database = DB_NAME;
            $attach = DB_connection::connect();
            //validar existencia de tablas
            $verify = $attach->query("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '$database' AND table_name='$table'")->fetchall(PDO::FETCH_OBJ);
            if(empty($verify)){
                return null;
            }
            else{
                //validar solicitud de columnas totales *
                //if($columns[0]=='*'){
                if($columns==null || $columns[0]=='*'){
                    array_shift($columns); //quitar el primer elemento del arreglo [0]

                }
                //validar existencia de columnas en la tabla
                $sum=0;
                foreach($verify as $key => $value){
                    $sum += in_array($value->item, $columns);
                }
                return $sum == count($columns) ? $verify : null;
            }
        }

        //Consultas para el proyecto
        //insertar un registro
        public static function insert(string $query, array $values){
            $attach = DB_connection::connect();
            $insert = $attach->prepare($query);
            foreach($values as $key => $value){
                if($key >0){
                    $insert->bindParam(":".$key, $values[$key], PDO::PARAM_STR);
                }
            }
            try{
                $satisfy = $insert->execute($values);
                if($satisfy){
                    $lastInsert = $attach->lastInsertId();
                }
                else{
                    $lastInsert =0;
                }
            }catch(PDOException $e){
                return null;
            }
            //se retorna el ultimo reg agregado a la DB para su uso inmediato
            return $lastInsert;
        }

        //Buscar un registro
        public static function select(string $query){
            $attach = DB_connection::connect();
            $result = $attach->prepare($query);
            try{
                $result->execute();
            }catch(PDOException $e){
                return null;
            }
            $data = $result->fetch(PDO::FETCH_ASSOC);
            return $data;
        }

        //devuelve todos los registros
        public static function select_all(string $query){
            $attach = DB_connection::connect();
            $result = $attach->prepare($query);
            try{
                $result->execute();
            }catch(PDOException $e){
                return null;
            }
            $data = $result->fetchall(PDO::FETCH_ASSOC);
            return $data;
        }

        //devuelve todos los registros con enlace con parametros--Consulta API
        public static function select_filter(string $query, array $filter, array $eqValues){
            $attach = DB_connection::connect();
            $result = $attach->prepare($query);
            foreach($filter as $key => $value){
                $result->bindParam(":".$value, $eqValues[$key], PDO::PARAM_STR);
            }
            try{
                $result->execute();
            }catch(PDOException $e){
                return null;
            }
            $data = $result->fetchall(PDO::FETCH_ASSOC);
            return $data;
        }

        //devuelve todos los registros haciendo busqueda con parametros--Consulta API
        public static function select_filter_search(string $query, array $filter, array $search){
            $attach = DB_connection::connect();
            $result = $attach->prepare($query);
            foreach($filter as $key => $value){
                if($key >0){
                    $result->bindParam(":".$value, $search[$key], PDO::PARAM_STR);
                }
            }
            try{
                $result->execute();
            }catch(PDOException $e){
                return null;
            }
            $data = $result->fetchall(PDO::FETCH_ASSOC);
            return $data;
        }

        //actualiza registros
        public static function update(string $query, array $values){
            $attach = DB_connection::connect();
            //dep($this->strQuery);return;
            $update = $attach->prepare($query);
            $satisfy = $update->execute($values);
            return $satisfy;
        }

        //guardar tokens para uso de api en DB
        public static function insertToken(string $query){
            $attach = DB_connection::connect();
            $update = $attach->prepare($query);
            $satisfy = $update->execute();
            return $satisfy;
        }

        //eliminar registros
        public function delete(string $query){
            $attach = DB_connection::connect();
            $result = $attach->prepare($query);
            $drop = $result->execute();
            return $drop;
        }

        //generar token de autentificacion
        public static function jwt(int $id, string $email){
            //generar token
            $time = time();
            $token = [
                'iat' => $time,     //tiempo en que inicia el token
                'exp' => $time + 84600,   //segundos en un dia
                'data' => [
                    'id' => $id,
                    'email' => $email
                ]
            ];
            return $token;
        }

        //validar token para hacer cambios en DB
        public function validateToken($token){
            //se comprueba existencia de token en DB y se llama el tiempo de expiracion del token
            $attach = DB_connection::connect();
            $sql="SELECT tokenExpire FROM users WHERE token= '$token';";
            $checkToken = $attach->prepare($sql);
            try{
                $checkToken->execute();
            }catch(PDOException $e){
                return null;
            }
            $data = $checkToken->fetchall(PDO::FETCH_ASSOC);
            //data=user_api_token_exp representa la fecha de expiracion del token
            if($data){
                //dep($data);return;
                $time= time();
                $exp = implode(',', $data[0]);  //pasar el array de la expiracion a string
                intval($exp);  //convertir el string a int
               
                //se comprueba que el token todavia es vigente
                if($exp > $time){
                    //se manda estado de verdadero como 1 para poder relizar la peticon via token
                    $tokenState=1;
                    return $tokenState;
                }
                else{
                    //si el token ha expirado se manda la respuesta
                    $json = [
                        'status' => 303,
                        'data' => 'Error: Token has expired'
                    ];            
                    echo json_encode($json, http_response_code($json['status']));
                    return;
                }
                //$tokenState = $data > $time ? $tokenState=1 : $tokenState=0;
            }
            else{
                //si el token que se recibe no se encuentra en la DB
                $json = [
                    'status' => 403,
                    'data' => 'Error: Token No-auth'
                ];            
                echo json_encode($json, http_response_code($json['status']));
                return;
            }
            //return $tokenState;
        }//end method
    }