<?php
include_once '../crudservice/config/Database.php';
include_once '../crudservice/models/user.php';


class User{
    private $conn;
    private $table = 'user';

    public $id;
    public $name;
    public $email;
    public $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create() {
      // Create query
      try {
        //code...
        $check_table = $this->conn->prepare("SHOW TABLES LIKE 'user'");
        $check_table->execute();
        if ($check_table->rowCount() > 0) {

          $check_user_stmt  = $this->conn->prepare("SELECT email FROM ". $this->table  ." WHERE email = :email");

          $check_user_stmt->bindParam(':email', $this->email);

          $check_user_stmt->execute();

          $check_user_result = $check_user_stmt->fetchAll();

          if(count($check_user_result) > 0){
            echo json_encode(
              array('message' => 'User with this email exists already')
              );
              return false;
          }else{
            $query = 'INSERT INTO ' . $this->table . ' SET name = :name, email = :email, password = :password ';
  
            // Prepare statement
            $stmt = $this->conn->prepare($query);
      
            // Clean data
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));
      
            // Bind data
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->execute();
          // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
      
            return true;
          }
        }else{
          $create_user_table = 'CREATE TABLE IF NOT EXISTS user'. '(
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
        )';

        $create_user_stmt = $this->conn->prepare($create_user_table);

        $create_user_stmt->execute();
        
        $query = 'INSERT INTO ' . $this->table . ' SET name = :name, email = :email, password = :password ';

          // Prepare statement
        $stmt = $this->conn->prepare($query);
  
        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
  
        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->execute();
      // Print error if something goes wrong
        return true;
        }
      } catch (\Throwable $th) {
        //throw $th;
        echo $th;
        return false;
      }
  }

    public function createBook($author, $title, $useremail) {
      // Create query
      try {
          //code...
          $check_table = $this->conn->prepare("SHOW TABLES LIKE 'books'");
          if ($check_table->rowCount() > 0) {
            $query = 'INSERT INTO ' . 'books' . ' SET title = :title, author = :author, useremail = :useremail';
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':author', $author);
            $stmt->bindParam(':useremail', $useremail);
            
            $stmt->execute();
            return true;
          }else{
            $create_books_table = 'CREATE TABLE IF NOT EXISTS books'. '(
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(255) NOT NULL,
                    author VARCHAR(255) NOT NULL,
                    useremail VARCHAR(255) NOT NULL
                )';
            $create_books_stmt = $this->conn->query($create_books_table);
            $create_books_stmt->execute();

            $query = 'INSERT INTO ' . 'books' . ' SET title = :title, author = :author, useremail = :useremail';
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':author', $author);
            $stmt->bindParam(':useremail', $useremail);
            
            $stmt->execute();

            return true;
          }
        } catch (\Throwable $th) {
          //throw $th;
          echo $th;
        }
      }

  public function viewBooks($useremail){
    try {
      //code...
      $view_books_query = 'SELECT id, title, author
      FROM books
      WHERE useremail = :useremail';

      $stmt = $this->conn->prepare($view_books_query);

      $stmt->bindParam(':useremail', $useremail);

      $stmt->execute();

      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      $response = array();
      foreach ($results as $index => $row) {
        $response[$index] = array(
        'id' => $row['id'],
        'title' => $row['title'],
        'author' => $row['author']
    );
    }

    echo(json_encode($response));

    } catch (\Throwable $th) {
      //throw $th;
      echo($th);
    }
  }

  public function deleteBook($useremail, $id){
    try {
      //code...
      $delete_query = 'DELETE FROM books WHERE id = :id AND useremail = :useremail';
  
      $stmt = $this->conn->prepare($delete_query);
  
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':useremail', $useremail);
  
      $stmt->execute();
  
      return true;
    } catch (\Throwable $th) {
      //throw $th;
      echo $th;
      return false;
    }
  }

  public function updateBookTitle($useremail, $id, $title){
    try {
      //code...
      $update_book_title_query = 'UPDATE books SET title = :title WHERE id = :id AND useremail = :useremail';

      $stmt = $this->conn->prepare($update_book_title_query);

      $stmt->bindParam(':title', $title);
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':useremail', $useremail);

      $stmt->execute();

      return true;

    }catch (\Throwable $th) {
      //throw $th;
      echo $th;
      return false;
    }
  }

  public function updateBookAuthor($useremail,$id, $author){
    try {
      //code...
      $update_book_author_query = 'UPDATE books SET author = :author WHERE id = :id and useremail = :useremail';

      $stmt = $this->conn->prepare($update_book_author_query);

      $stmt->bindParam(':author', $author);
      $stmt->bindParam(':id', $id);
      $stmt->bindParam(':useremail', $useremail);

      $stmt->execute();

      return true;
    } catch (\Throwable $th) {
      //throw $th;
      echo $th;
      return false;
    }
  }
}