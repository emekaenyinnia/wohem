<?php

class Booking extends CI_Model {
    public $status = 'error';
    public $message = 'Error processing requested operation';

    public function meetPastorInfo ($name, $time, $date)
    {
        $data = array('name' => $name,'time' => $time, 'date' => $date);
        $this->db->trans_start();
        $this->db->insert('tbl_meet_pastor', $data);
        $this->db->trans_complete();
        $this->status = "success";
        $this->message = "Your meeting has been placed .";
    }

    public  function Store_Booking (string $name, string $guestormember, string $messagebox, string $audio, string $video , string $booking_type)
    {
        $data = array('name' => $name,'guestormember' => $guestormember, 'messagebox' => $messagebox, 'audio' => $audio, 'video' => $video);
        $this->db->trans_start();
        $this->db->insert($booking_type, $data);
        $this->db->trans_complete();
        $this->status = "success";
        $this->message =  $booking_type=== "tbl_testimony" ? "Your testimony has been sent  ." : "Your prayer request has been sent" ;
        
    }

}
?>