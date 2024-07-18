<?php

class Create extends Controller {

    public function index() {
      //start session
      session_start();
      
      $errorMessage = isset($_SESSION['error']) ? $_SESSION['error'] : '';
      unset($_SESSION['error']);
      unset($_SESSION['success']);
	    $this->view('create/index');
    }

    public function verify(){
      $username = $_REQUEST['username'];
      $password = $_REQUEST['password'];
      $repassword = $_REQUEST['repassword'];


      //print above for debug
      // echo "username: " . $username . "<br>";
      // echo "password: " . $password . "<br>";
      // echo "repassword: " . $repassword. "<br>";
      

        
      if (empty($username) || empty($password) || empty($repassword)){
        $_SESSION['error'] = "Please fill out all fields";
        header('Location: /create');
        die();
        
      }else if ($password !== $repassword) {
        

          // echo "Passwords do not match!";
        
          // Store error message in session
          $_SESSION['error'] = "Passwords do not match!";

          // Redirect to login page
          $this->view('create/index');
        
      }else if (strlen($password) < 5){

          // echo "Password must be at least 5 characters long!";
        
          // Store error message in session
          $_SESSION['error'] = "Password must be at least 5 characters long!";

          // Redirect to login page
          $this->view('create/index');
      }else{

          
          $user = $this->model('User');
          
          //check if username already exists
          if($user->checkIfUserIndatabase($username)){
            // echo "Username already exists!";
            $_SESSION['error'] = "Username already exists!";
            $this->view('create/index');
          }else{
            $user->createAccount($username, password_hash($password, PASSWORD_DEFAULT));
            // echo "Account created!";
            $_SESSION['success'] = "Account created!";

            //unset error
            unset($_SESSION['error']);
            
            $this->view('create/index');
          }
      }
      

      // $user = $this->model('User');
      // $user->authenticate($username, $password); 
    }
  
}
