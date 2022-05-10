<?php


class Report_model extends CI_Model {

    public $status = 'error';
    public $message = 'Error processing requested operation';
    
    function __construct(){
        parent::__construct();
       }
 
       public function get_Reports(){
        $query = $this->db->select("COUNT(*) as num")->get("tbl_reports");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
     }

    
 
     public function meetPastorInfo ($name, $messagebox)
     {
         $data = array('name' => $name, 'discription' => $messagebox);
         $this->db->trans_start();
         $this->db->insert('tbl_reports', $data);
         $this->db->trans_complete();
         $this->status = "success"; 
         $this->message = "Your issue has been sent  .";
     }
     function reportsListing(){
        $this->db->select('tbl_reports.*');
        $this->db->from('tbl_reports');
        $this->db->order_by('name','ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function delete_Report($id){
        $this->db->where('id', $id);
        $this->db->delete('tbl_reports');
         $this->status = 'ok';
         $this->message = 'Report deleted successfully.';
    }
  
}

?>