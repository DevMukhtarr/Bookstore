<?php
include_once '../crudservice/config/Database.php';
include_once '../crudservice/models/user.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Authentication{
    function home(){
        echo("Welcome to crud app");
    }
    function register(){
        try {
            //code...
            error_reporting(0);
            $data = json_decode(file_get_contents('php://input'));
            $name = $data->name;
            $email = $data->email;
            $password = $data->password;
            $encrypted_password = password_hash($password, PASSWORD_BCRYPT);
        
            $database = new Database();
            $db = $database->connect();
    
            if (empty($name) or empty($email) or empty($password)){
                echo json_encode(
                    array('message' => 'All Fields are required')
                  );
                  return false;
                }
        
            $user = new User($db);
        
            $user->name = $name;
            $user->email = $email;
            $user->password = $encrypted_password;
        
            $payload = [
                'email' => $email
            ];
            $env = parse_ini_file('.env');
            $secret = $env['JWT_SECRET_KEY'];
            $jwt = JWT::encode($payload, $secret , 'HS256');
            
            if($user->create()){
                echo json_encode(
                    array(
                        'message' => 'Registration successful',
                        'access_token' => $jwt
                    )
                  );
            }
        } catch (\Throwable $th) {
            //throw $th;
            echo($th);
            echo json_encode(
                array('message' => 'An error occurred')
            );
        }
    }
    function login(){
        try {
            error_reporting(0);
            //code...
            $data = json_decode(file_get_contents('php://input'));
            $email = $data->email;
            $password= $data->password;
    
            $payload = [
                'email' => $email,
                'iat' => time()
            ];
            $env = parse_ini_file('.env');
            $secret = $env['JWT_SECRET_KEY'];
            $jwt = JWT::encode($payload, $secret, 'HS256');
    
            if (empty($email) or empty($password)){
                echo json_encode(
                    array('message' => 'All Fields are required')
                  );
                  return false;
                }
                echo json_encode(
                    array(
                        'message' => "Login successful",
                        'token' => $jwt
                    )
                  );
        }
        catch (\Throwable $th) {
            //throw $th;
            echo($th);
            echo json_encode(
                array('message' => 'An error occurred')
              );
        }
    }
}