<?php

class Login extends Controller {

    public function index() {		
			session_start();
			
	    $this->view('login/index');
    }
    
    public function verify(){
			
			
			$username = $_REQUEST['username'];
			$password = $_REQUEST['password'];
		
			$user = $this->model('User');
			$user->authenticate($username, $password); 
    }

		public function getuser(){
			$user = $this->model('User');
			$res = $user->test();

			return $res;
		}

		public function checkFailed(){}

}
