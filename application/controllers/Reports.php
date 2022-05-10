<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');
require APPPATH . '/libraries/BaseController.php';

class Reports extends BaseController {

 public function __construct ()
 {  
    parent::__construct();
    $this->isLoggedIn();
    $this->load->model('Report_model');
 }

 public function index(){
    $data['report_issue'] = $this->Report_model->reportsListing();
    $this->load->template('reportissue/listing', $data); // this will load the view file
}
  
function deleteReport($id=0)
{
  $this->load->library('session');
  $this->Report_model->delete_Report($id);
  if($this->Report_model->status == "ok")
  {
      $this->session->set_flashdata('success', $this->Report_model->message);
  }
  else
  {
      $this->session->set_flashdata('error', $this->Report_model->message);
  }
     redirect('Reports');
}
}

?>
