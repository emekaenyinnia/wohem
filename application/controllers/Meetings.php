<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');
require APPPATH . '/libraries/BaseController.php';

class Meetings extends BaseController {

 public function __construct ()
 {  
    parent::__construct();
    $this->isLoggedIn();
    $this->load->model('Meetings_model');
 }

 
 public function index(){
    $data['Meetings'] = $this->Meetings_model->meetingsListing();
    $this->load->template('meetings/listing', $data); // this will load the view file
}
public function loadMeetings(){
    $Meetings= $this->Meetings_model->meetingsListing();
    echo json_encode(array("status" => "ok","Meetings" => $Meetings));
}

function deleteMeeting($id=0)
{
  $this->load->library('session');
  $this->Meetings_model->delete_Meeting($id);
  if($this->Meetings_model->status == "ok")
  {
      $this->session->set_flashdata('success', $this->Meetings_model->message);
  }
  else
  {
      $this->session->set_flashdata('error', $this->Meetings_model->message);
  }
     redirect('meetingsListing');
}
}

?>