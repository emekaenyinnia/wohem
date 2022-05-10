<?php




class Testimony_model extends CI_Model {

    function __construct(){
        parent::__construct();
       }
 
       public function get_Testimonies(){
        $query = $this->db->select("COUNT(*) as num")->get("tbl_testimony");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
     }

     function testimoniesListing(){
        $this->db->select('tbl_testimony.*');
        $this->db->from('tbl_testimony');
        $this->db->order_by('name','ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function delete_testimony($id){
        $this->db->where('id', $id);
        $this->db->delete('tbl_testimony');
         $this->status = 'ok';
         $this->message = 'Testimony deleted successfully.';
    }
  
}

?>