<?php
include_once '../crudservice/config/Database.php';
include_once '../crudservice/models/user.php';
include_once './config/auth.php';

class Maincontroller{
    function addBook(){
    try {
        //code...
        $database = new Database();
        $db = $database->connect();

        $user = new User($db);

        $data = json_decode(file_get_contents('php://input'));
        $useremail = checkJWT();
        $author = $data->author; 
        $title = $data->title;

        if (empty($author) or empty($title)){
            echo json_encode(
                array('message' => 'All Fields are required')
              );
              return false;
            }
            
        // $user->createBook();
        if($user->createBook($author, $title, $useremail)){
            echo json_encode(
                array(
                    'message' => 'New Book Uploaded'
                    )
              );
            }else{
                echo json_encode(
                array(
                    'message' => 'An error occurred'
                    )
              );
            }

    } catch (\Throwable $th) {
        //throw $th;
        echo($th);
        echo("A server error occurred");
    }
}

function viewBooks(){
    try {
            //code...
            $database = new Database();
            $db = $database->connect();

            $user = new User($db);

            $useremail = checkJWT();
            $user->viewBooks($useremail);
        } catch (\Throwable $th) {
            //throw $th;
            echo($th);
            echo("A server error occurred");
        }
    }

    function deleteBook(){
        try {
            //code...
            $database = new Database();
            $db = $database->connect();

            $user = new User($db);

            $data = json_decode(file_get_contents('php://input'));
            $id = $data->id;
            $useremail = checkJWT();
            
            if($user->deleteBook($useremail, $id)){
                echo json_encode(
                    array(
                        'message' => 'Book deleted successfully'
                        )
                  );
                }else{
                    echo json_encode(
                        array(
                            'message' => 'An error occurred'
                        )
                    );
            }
            
        } catch (\Throwable $th) {
            //throw $th;
            echo($th);
            echo("A server error occurred");
        }
    }
    
    function updateBookTitle(){
        try {
            $database = new Database();
            $db = $database->connect();
        
            $user = new User($db);
        
            $data = json_decode(file_get_contents('php://input'));
        
            $useremail = checkJWT();
            $id = $data->id; 
            $title = $data->title;
        
            if (empty($id) or empty($title)){
                echo json_encode(
                    array('message' => 'All Fields are required')
                  );
                }
        
            if($user->updateBookTitle($useremail, $id, $title)){
                echo json_encode(
                    array('message' => 'Title updated successfully')
                  );
                }else{
                    echo json_encode(
                        array('message' => 'An error occurred')
                      );
            }
        } catch (\Throwable $th) {
            //throw $th;
            echo json_encode(
                array('message' => 'An error occurred'. $th)
              );
        }
        }   
    function updateBookAuthor(){
        try {
            //code...
            $data = json_decode(file_get_contents('php://input'));
            
            $database = new Database();
            $db = $database->connect();
            
            $user = new User($db);
    
            $useremail = checkJWT();
            $id = $data->id;
            $author = $data->author;
    
            if(empty($id) or empty($author)){
                echo json_encode(
                    array('message' => 'All Fields are required')
                  );
            }
    
            if($user->updateBookAuthor($useremail, $id, $author)){
                echo json_encode(
                    array('message' => 'Author updated successfully')
                  );
            }else{
                echo json_encode(
                    array('message' => 'An error occurred')
                  );
            }
        } catch (\Throwable $th) {
            echo json_encode(
                array('message' => 'A server error occurred' . $th)
              );
        }
    }
}