<?php




class Meetings_model extends CI_Model {

    function __construct(){
        parent::__construct();
       }
 
       public function get_Meetings(){
        $query = $this->db->select("COUNT(*) as num")->get("tbl_meet_pastor");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
     }

     function meetingsListing(){
        $this->db->select('tbl_meet_pastor.*');
        $this->db->from('tbl_meet_pastor');
        $this->db->order_by('name','ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function delete_Meeting($id){
        $this->db->where('id', $id);
        $this->db->delete('tbl_meet_pastor');
         $this->status = 'ok';
         $this->message = 'Meeting deleted successfully.';
    }
  
}

?>