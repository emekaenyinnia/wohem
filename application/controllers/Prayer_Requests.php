<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');
require APPPATH . '/libraries/BaseController.php';

class Prayer_Requests extends BaseController {

 public function __construct ()
 {  
    parent::__construct();
    $this->isLoggedIn();
    $this->load->model('Prayer_Request_model');
 }

 
 public function index(){
    $data['Prayer_Request'] = $this->Prayer_Request_model->prayerRequestListing();
    $this->load->template('PrayerRequests/listing', $data); // this will load the view file
}
public function loadprayerRequest(){
    $Prayer_Request = $this->Prayer_Request_model->prayerRequestListing();
    echo json_encode(array("status" => "ok","Prayer Request" => $Prayer_Request));
}

function deletePrayerRequest($id=0)
{
  $this->load->library('session');
  $this->Prayer_Request_model->delete_Prayer_Request($id);
  if($this->Prayer_Request_model->status == "ok")
  {
      $this->session->set_flashdata('success', $this->Prayer_Request_model->message);
  }
  else
  {
      $this->session->set_flashdata('error', $this->Prayer_Request_model->message);
  }
  redirect('prayerRequestListing');
}
}

?>