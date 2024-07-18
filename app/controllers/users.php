<?php

class Users extends Controller {

    public function index() {		 
      $userModel = $this->model('User');
      $users = $userModel->test();

      $this->view('users/index', ['users' => $users]);
    }

    public function getuser(){
      $user = $this->model('User');
      $res = $user->test();

      return $res;
    }


}
