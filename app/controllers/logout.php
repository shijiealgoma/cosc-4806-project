<?php

class Logout extends Controller {

    public function index() {		
	    session_start();
        
        $_SESSION = array();
        unset($_SESSION['admin']);
        
        session_destroy();
        header('location:/login');
    }
}