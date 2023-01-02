<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function checkJWT() {
    // Get the request header
    $env = parse_ini_file('.env');

    $headers = getallheaders();

    $secret = $env['JWT_SECRET_KEY'];

    if (isset($headers['x-access-token'])) {
        // Get the JWT from the header
        $jwt = $headers['x-access-token'];
        // Decode the JWT
        $decoded = JWT::decode($jwt, new Key($secret, 'HS256'));
        
        $value = (array) $decoded;
        return $value['email'];
    }else{
        echo json_encode(
            array(
                'message' => "Header is not present",
            )
            );
    }
}