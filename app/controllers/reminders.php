<?php

//reminders controller

class Reminders extends Controller{

  public function index(){
    // echo "Reminders";
    $reminder = $this->model('Reminder');
    $list_of_reminders = $reminder->get_all_reminders();

    // code for debug
    // print_r($list_of_reminders);
    // die;
    
    $this->view('reminders/index', ['reminders' => $list_of_reminders]);
  }

  public function create(){
    $reminder = $this->model('Reminder');
    $list_of_reminders = $reminder->get_all_reminders();
    $this->view('reminders/create');
  }

  public function update($id){
    // echo "Update reminder with id: " . $id;
    $reminder = $this->model('Reminder');
    $reminderDetails = $reminder->get_reminder_by_id($id);
    // echo "reminderDetails: ";
    // print_r($reminderDetails); 
    $this->view('reminders/update', ['reminder' => $reminderDetails]);
  }


  public function create_reminder(){
     $subject = $_REQUEST['subject'];
    //check if subject is empty
    if(empty($subject)){
      $this->view('reminders/create');
    }

    //check if $_SESSION['userid'] is set
    if(!isset($_SESSION['userid'])){
      header('Location: /login');
    }


    //call model create_reminder
    $reminder = $this->model('Reminder');
    $status = $reminder->create_reminder($_SESSION['userid'], $subject);

    header('Location: /reminders/index');
    
  }

  //update_reminder
  public function update_reminder($id){
    // echo "Update reminder";

    //check id
    if(empty($id)){
      header('Location: /reminders/index');
    }
    
    $subject = $_REQUEST['subject'];
    //check if subject is empty
    if(empty($subject)){
      $this->view('reminders/update', ['reminder' => $reminderDetails]);
    }

    //call model update_reminder
    $reminder = $this->model('Reminder');
    $status = $reminder->update_reminder($id, $subject);

    // echo "status: " . $status;

    //go to reminders page
    header('Location: /reminders/index');
    
  }

  //delete_reminder
  public function delete($id){
    // echo "Delete reminder";

    //check id
    if(empty($id)){
      header('Location: /reminders/index');
    }
    
    $reminder = $this->model('Reminder');
    $status = $reminder->delete_reminder($id);

    //go to reminders page
    header('Location: /reminders/index');
    
  }
}

  