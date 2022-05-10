<?php




class Church_Account_model extends CI_Model {
  public $status = '201';
  public $message = 'no church account found';

    function __construct(){
        parent::__construct();
       }
 
       public function get_ChurchAccount(){
        $query = $this->db->select("COUNT(*) as num")->get("tbl_church_account_number");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
     }

     function churchaccountsListing(){
        $this->db->select('tbl_church_account_number.*');
        $this->db->from('tbl_church_account_number');
        $this->db->order_by('account_name','ASC');
        $query = $this->db->get();
        $result = $query->result();
        $this->status = 'ok';
        return $result;
    }

    function checkNumberExists($account_number, $id = 0)
    {
        //echo $name . " and ". $group;
        $this->db->select("account_number");
        $this->db->from("tbl_church_account_number");
        $this->db->where("Account_number", $account_number);
        if($id != 0){
            $this->db->where("id !=", $id);
        }
        $query = $this->db->get();
        //var_dump($query->result()); die;
        return $query->result();
    }
    function addNewChurchAccount($info)
    {
      if(empty($this->checkNumberExists($info['account_number']))){
        $this->db->trans_start();
        $this->db->insert('tbl_church_account_number', $info);
        $this->db->trans_complete();
        $this->status = 'ok';
        $this->message = 'Account Details added successfully';
      }else{
        $this->status = 'error';
        $this->message = 'Account Number already exists';
      }
    }

    function delete_church_Account($id){
        $this->db->where('id', $id);
        $this->db->delete('tbl_church_account_number');
         $this->status = 'ok';
         $this->message = 'Account deleted successfully.';
    }
  
}

?>