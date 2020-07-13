<?php

include ("./utils/headers.php");
require "vendor/autoload.php";

use DBC\Connection as dbc;
use AUTH\AuthToken as auth;

$postdata = file_get_contents("php://input");
$post = json_decode($postdata);

@$email = $post->email;
@$password = $post->password;


if ($query = dbc::login("SELECT * FROM tbl_usuario WHERE email = '" . $email . "'")) {
    if(md5($password) == $query->password) {
        $token = auth::generateToken([
            'id' => $query->id,
            'email' => $query->email
        ]);
    
        $dataProvider = ['success'=>1, 'token' => $token];
        echo json_encode($dataProvider);
    } else {
        echo json_encode(["success"=>0]);
    }
} else {
    echo json_encode(["success"=>0]);
}

/*
if(md5($password) == $query->password) {

    $token = auth::signIn([
        'id' => $query->id,
        'email' => $query->email
    ]);

    $dataProvider = ['success'=>1, 'token' => $token];
    echo json_encode($dataProvider);
} else {
    echo json_encode(["success"=>0]);
}*/