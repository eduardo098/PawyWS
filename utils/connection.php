<?php

namespace dbc;

include ("./utils/headers.php");

class Connection {
    public static function conn () {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $db = "pawydb";

        return mysqli_connect($servername, $username, $password, $db);

    }

    public static function verificar(){
        if(self::conn()->connect_errno){
            print_r("Error de conexión");
            return false;
        }else{
            return true;
        }
    }


    public static function registrar($query) {
        $resultado = mysqli_query(self::conn(), $query);
        if($resultado) {
            return true;
        } else {
            return false;
        }
    }

    public static function login($query){
        $resultado = mysqli_query(self::conn(), $query);
        if($resultado) {
            $pass = mysqli_fetch_object($resultado);
            return $pass;
        } else {
            return false;
        }
    }

    public static function consultaID($query){
        $resultado = mysqli_query(self::conn(), $query);
        $res = mysqli_fetch_object($resultado);
        return $res;
    }

    public static function getData($query) {
        $resultado = mysqli_query(self::conn(), $query);
        while($row = mysqli_fetch_object($resultado)){
            $result[]=$row;
        }
        return $result;
    }

    public static function getSingleData($query) {
        $resultado = mysqli_query(self::conn(), $query);
        $res = mysqli_fetch_object($resultado);
        return $res;
    }
    
}