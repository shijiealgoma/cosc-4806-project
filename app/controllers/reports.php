<?php

class Reports extends Controller {

    public function index() {
      
      if (isset($_SESSION['admin']) && $_SESSION['admin']){

        $admin = $this->model('Admin');
        $list_of_reminders = $admin->get_all_reminders();
        $most_id = $admin->get_most_reminders();

        $most_username = $admin->get_username_by_id($most_id["user_id"]);

        $total_login = $admin->get_total_logins();

        $max_logins = max(array_column($total_login, 'total_logins'));

        $this->view('reports/index', 
                    ['reminders' => $list_of_reminders,
                      'most_username' => $most_username,
                      'most_id' => $most_id,
                      'total_login' => $total_login,
                      'max_logins' => $max_logins,
                    ]);
        
      }else{
        header('Location: /home');
      }
    }

}
