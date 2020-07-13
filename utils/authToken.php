<?php

namespace auth;

//Importación de la librería JWT.
use \Firebase\JWT\JWT;

class AuthToken {
    
    //Semilla que utilizaremos para generar nuestro token. Puede ser cualquier tipo de String.
    private static $key = "EfLqOk80TJhDAXnWecXtcn1VpjnNzBjT";
    //TIpo de algoritmo que implementaremos para la encriptación y decriptación de nuestro token.
    //En este caso, JWT trabaja con el algoritmo HS256.
    private static $encrypt = ['HS256'];
    //Variable sin usar.
    private static $audit = null;

    //Funcion para llevar a cabo la generación de nuestro token
    //la cual toma como parametro información sobre la cual generaremos el token.
    public static function generateToken($data) {
        //Almacenamos la función time en una variable, la cual utilizaremos para determinar la duración de nuestro token.
        $time = time();

        //Array en el cual almacenaremos los parametros para poder generar nuestro token.
        $token = [
            //Parametro 'exp': Determinamos la duración de nuestro token haciendo uso de la variable time
            //definida previamente.
            //60*60 = 3600s (1 hora).
            'exp' => $time + (60*60),
            
            //Parametro 'aud': Este parametro es utilizado para asignar al token un 'dueño' que en este caso seria nuestra pc.
            'aud' => self::aud(),

            //Parametro 'data': La información que cargará el token consigo mismo. 
            'data' => $data
        ];

        
        //Mandamos llamar la función encode perteneciente a la clase JWT, pasandole como parametro nuestros parametros
        //y la semilla con la que generará el token.
        //Al mismo tiempo retornamos el resultado que nos da el llamado de esta función, que en este caso sería el token generado.
        return JWT::encode($token, self::$key);
    }

    //Funcion para decodificar nuestro token, tomando como parametro el token generado por la funcion signIn();
    public static function decodeToken($token) {
        //Llamamos a la funcion decode perteneciente a la clase JWT, pasando como parametro el token a decodificar,
        //la semilla con la que se generó el token y el algoritmo con el que estamos trabajando (HS256).
        //Asi mismo, accedemos al parametro data del JSON que nos genera al momento de desencriptarlo, todo esto mientras retornandolo el resultado.
        return JWT::decode($token, self::$key, self::$encrypt)->data;
    }

    //Funcion para validar el token.
    public static function validateToken($token) {

        //Encerramos todo en un bloque try/catch para poder obtener el error arrojado cuando se obtenga un token invalido.
        try {
            //Creamos una variable audit donde almacenaremos la decodificación y extracción del parametro 'aud' del token recibido.
            $audit  = JWT::decode($token, self::$key, self::$encrypt)->aud;
            //Si el parametro 'aud' es valido, mandamos un mensaje indicandolo.
            if($audit === self::aud()) {
                //return "Valido";
                return true;
            } else {
                //De no serlo, mandamos un mensaje indicandolo.
                //return "No valido";
                return false;
            }
        //Obtenemos el error que se formula al momento de recibir un token no valido.    
        } catch (Exception $e) {
            //return "No valido";
            return false;
        }
    }

    private static function aud() {


        //Variable $aud para poder almacenar la ip del cliente.
        $aud = '';

        //Verificamos que la IP del cliente exista.
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //De ser así, almacenamos la IP en nuestra variable $aud.
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        
        //De fallar, podemos intentar obtenerla de este modo
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //De encontrarse la IP, la almacenamos en nuestra variable $aud.
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        //Si ninguna de las peticiones anteriores arroja la IP del cliente
        //podemos obtenerla con una tercera forma.    
        } else  {
            //Si encuentra la IP, la almacena en $aud.
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        //Hacemos uso de HTTP_USER_AGENT para pedirle al navegador del que se
        //ejecutó la petición que se identifique.
        //El resultado lo concatenamos a nuestra variable $aud.
        $aud .= @$_SERVER['HTTP_USER_AGENT'];

        //Llamamos a la función 'gethostname()' para obtener el nombre del host
        //del que se ejecutó la petición. Posteriormente, lo concatenamos a nuestra variable $aud.
        $aud .= gethostname();

        //Una vez tengamos lista nuestra variable $aud, procedemos a encriptarla
        //con la función sha1(), la cual se encarga de producir un hash con toda la información
        //que almacenamos en el $aud.
        return sha1($aud);
    }
}

?>