<?php

include ("./utils/headers.php");
require "vendor/autoload.php";

use DBC\Connection as dbc;
use AUTH\AuthToken as auth;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postdata = file_get_contents("php://input");
    $post = json_decode($postdata);

    @$token = $post->token; 
    @$option = $post->option;

    if(auth::validateToken($token)) {
        $tokenData = auth::decodeToken($token);
        
        $id = $tokenData->id;
        $email = $tokenData->email;

        switch($option) {
            case "profile":
                $query = dbc::getSingleData("SELECT * FROM vw_perfil");
                echo json_encode($query);
            break;
            case "orders":
            break;
        }
    }
}
