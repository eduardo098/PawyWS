<?php

include ("./utils/headers.php");
require "vendor/autoload.php";

use DBC\Connection as dbc;
use AUTH\AuthToken as auth;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postdata = file_get_contents("php://input");
    $post = json_decode($postdata);

    @$token = $post->token;
    @$cat = $post->categoria;
    @$option = $post->option;

    if(auth::validateToken($token)) {

        switch($option) {
            case "product":
                $query = dbc::getData("SELECT * FROM vw_productos");
                echo json_encode($query, JSON_INVALID_UTF8_IGNORE);
            break;    
            case "productID":
                $query = dbc::getData("SELECT * FROM vw_productos WHERE categoria = '".$cat."'");
                echo json_encode($query, JSON_INVALID_UTF8_IGNORE);
            break;
            case "category":
                $query = dbc::getData("SELECT * FROM vw_categorias");
                echo json_encode($query, JSON_INVALID_UTF8_IGNORE);
            break;
        }
    }
}
