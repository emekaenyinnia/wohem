<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');
require APPPATH . '/libraries/BaseController.php';

class Church_Account extends BaseController {

 public function __construct ()
 {  
    parent::__construct();
    $this->isLoggedIn();
    $this->load->model('Church_Account_model');
    // $this->session_check();
     
    // $this->session->unset_flashdata('success');
 }

//  public function session_check ()
// {
//     $this->load->library('session');
//      if(empty($this->session->flashdata('success'))){
//     echo "empty";
//     }
//        else{
//         $this->session->set_flashdata('success', '');
//     echo 'not empty';
//     }
// }
 public function index(){
    $data['Church_Account'] = $this->Church_Account_model->churchaccountsListing();
    $this->load->template('churchaccount/listing', $data); // this will load the view file
}
    public function loadchurchaccount(){
        $Church_Account = $this->Church_Account_model->churchaccountsListing();
        echo json_encode(array("status" => "ok","Church Account" => $Church_Account));
    }

    public function newChurchAccount()
    {
        $this->load->template('churchaccount/new', []); // this will load the view file
    }
    public function savenewchurchaccount ()
    {     
        $this->load->library('session');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('account_name','Account name ','trim|required|xss_clean');
        $this->form_validation->set_rules('account_bank','Bank ','trim|required|xss_clean');
        $this->form_validation->set_rules('account_number','Account number ','trim|required|xss_clean|max_length[10]|min_length[10]', 
        array('max_length' => 'invalid account number',
        'min_length' => 'invalid account number' ));
        if($this->form_validation->run() == FALSE)
        {   
            $this->session->set_flashdata('error', "check your account number detail if it's less or more than 10 digit");
            redirect('newChurchAccount');
            exit;
        }
        else
        {
                        $account_name = $this->input->post('account_name');
                        $account_number = $this->input->post('account_number');
                        $account_bank = $this->input->post('account_bank');
                        $info = array(
                                'account_name' => $account_name,
                                'account_number' => $account_number,
                                'account_bank' =>$account_bank
                        );

                        $this->Church_Account_model->addNewChurchAccount($info);
                        if($this->Church_Account_model->status == "ok")
                        {
                                $this->session->set_flashdata('success', $this->Church_Account_model->message);
                        }
                        else
                        {
                                $this->session->set_flashdata('error', $this->Church_Account_model->message);
                        }
                        echo 'good';
          redirect('newChurchAccount');
          exit;
        }
    }
        function deleteChurchAccount($id=0)
        {
        $this->load->library('session');
        $this->Church_Account_model->delete_Church_Account($id);
        if($this->Church_Account_model->status == "ok")
        {
            $this->session->set_flashdata('success', $this->Church_Account_model->message);
        }
        else
        {
            $this->session->set_flashdata('error', $this->Church_Account_model->message);
        }
        redirect('churchaccountsListing');
        }

}

?>