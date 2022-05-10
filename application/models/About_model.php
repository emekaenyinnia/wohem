<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class About_model extends CI_Model
{
  public $status = 'error';
  public $message = 'Something went wrong';

    function AboutChurch()
    {
      $this->db->select('tbl_about.*');
      $this->db->from('tbl_about');
      $query = $this->db->get();
      $result = $query->result();
      foreach ($result as $res) {
        $res->image = base_url()."uploads/churchimages/".$res->image;
      }
      return $result;
    }
    function AboutChurchBody()
    {
      $this->db->select('tbl_about.*');
      $this->db->from('tbl_about');
      $this->db->where('id', 1);
      $query = $this->db->get();
      return $query->row();
    }
    
    function Update_About_Church($info)
    {
        $this->db->where('id', 1);
        $this->db->update('tbl_about', $info);
        $this->status = 'success';
        $this->message = 'About Wohem edited successfully';
      }

}
