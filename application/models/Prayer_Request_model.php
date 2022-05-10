<?php




class Prayer_Request_model extends CI_Model {

    function __construct(){
        parent::__construct();
       }
 
       public function get_total_Prayer_Request(){
        $query = $this->db->select("COUNT(*) as num")->get("tbl_prayer_pequest");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
     }

     function prayerRequestListing(){
        $this->db->select('tbl_prayer_request.*');
        $this->db->from('tbl_prayer_request');
 
        $this->db->order_by('name','ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function delete_Prayer_Request($id){
        $this->db->where('id', $id);
        $this->db->delete('tbl_prayer_request');
         $this->status = 'ok';
         $this->message = 'Prayer Request deleted successfully.';
    }
  
}

?>