<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');
require APPPATH . '/libraries/BaseController.php';

class Testimonies extends BaseController {

 public function __construct ()
 {  
    parent::__construct();
    $this->isLoggedIn();
    $this->load->model('Testimony_model');
 }

 
 public function index(){
    $data['testimonies'] = $this->Testimony_model->testimoniesListing();
    $this->load->template('testimonies/listing', $data); // this will load the view file
}
public function loadTestimonies(){
    $Testimonies = $this->Testimony_model->testimoniesListing();
    echo json_encode(array("status" => "ok","Testimonies" => $Testimonies));
}

function deleteTestimony($id=0)
{
  $this->load->library('session');
  $this->Testimony_model->delete_testimony($id);
  if($this->Testimony_model->status == "ok")
  {
      $this->session->set_flashdata('success', $this->Testimony_model->message);
  }
  else
  {
      $this->session->set_flashdata('error', $this->Testimony_model->message);
  }
     redirect('testimoniesListing');
}
}

?>