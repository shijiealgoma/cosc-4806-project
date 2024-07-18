<?php

class User {

    public $username;
    public $password;
    public $auth = false;

    public function __construct() {
        
    }

    public function test () {
      $db = db_connect();
      $statement = $db->prepare("select * from users;");
      $statement->execute();
      $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

     
      
      return $rows;
    }

    public function authenticate($username, $password) {
   
      
      
        /*
         * if username and password good then
         * $this->auth = true;
         */
		$username = strtolower($username);
		$db = db_connect();
        $statement = $db->prepare("select * from users WHERE username = :name;");
        $statement->bindValue(':name', $username);
        $statement->execute();
        $rows = $statement->fetch(PDO::FETCH_ASSOC);
		
		if (password_verify($password, $rows['password'])) {
            // echo "Login success";
            //loginLog
            $this->loginLog($username, 1, "sucessfully logged in");
      
			$_SESSION['auth'] = 1;
			$_SESSION['username'] = ucwords($username);
            $_SESSION['userid'] = $rows['id'];

            // echo "user id: " . $_SESSION['userid'];
            
			unset($_SESSION['failedAuth']);
            unset($_SESSION['lastFailedAuthTime']);
            unset($_SESSION['admin']);


        
            //if user is admin, set admin to true
            if ($rows['username'] == "admin"){
                $_SESSION['admin'] = true;
            }else{
                $_SESSION['admin'] = false;
            }

            // echo "admin status: " . $_SESSION['admin'];
                
            
			header('Location: /home');
			die;
		} else {
            // echo "Login failed";
            //loginLog
            $this->loginLog($username, 0, "failed to login");
            
          
            if(isset($_SESSION['failedAuth'])) {
                $_SESSION['failedAuth'] ++; //increment
                $_SESSION['lastFailedAuthTime'] = time();
            
            } else {
                $_SESSION['failedAuth'] = 1;
                $_SESSION['lastFailedAuthTime'] = time();
            }

            // echo "<br>Login attempts: " . $_SESSION['failedAuth'];
            
            header('Location: /login');
            die;
        }
    }


    public function checkIfUserIndatabase($username) {
        $db = db_connect();
        $statement = $db->prepare("select * from users WHERE username = :name;");
        $statement->bindValue(':name', $username);
        $statement->execute();
        $rows = $statement->fetch(PDO::FETCH_ASSOC);

        //if user is in database, return true
        return $rows;
    }


    public function createAccount($username, $password) {
        $db = db_connect();
        $statement = $db->prepare("INSERT INTO users (username, password) VALUES (:name, :pass);");
        $statement->bindValue(':name', $username);
        $statement->bindValue(':pass', $password);
        $statement->execute();
    }


    public function loginLog($username, $status, $message){
     
      
      //Create a log table in your database and log all login attempts (good and bad). 
      //You'll need to log username, attempt (good, bad), and time

    // echo "Log login name: " . $username . " status: " . $status . " msg: ". $message . "<br>";
    try {

        $db = db_connect();
        
        $statement = $db->prepare("INSERT INTO login_log (user, status, message, time) VALUES (:user, :status, :message, :time);");
        $statement->bindValue(':user', $username);
        $statement->bindValue(':status', $status, PDO::PARAM_INT);
        $statement->bindValue(':message', $message);
        $statement->bindValue(':time', date('Y-m-d H:i:s'));
        
        // echo "Before execute";
        
        $executeResult = $statement->execute();
        
        // echo "After execute";
        
        // if ($executeResult) {
        //   echo "Log entry created successfully.";
        // } else {
        //   echo "Failed to create log entry.";
        // }
        
        // if ($statement->rowCount() > 0) {
        //     echo "Log entry inserted successfully.";
        // } else {
        //     echo "No log entry was inserted.";
        // }

    } catch (PDOException $e) {
          // echo "Error: " . $e->getMessage();
    }
      
      
    }


  

}
