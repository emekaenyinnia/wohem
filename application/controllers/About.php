<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations
 */
class About extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('About_model');
        $this->load->library('user_agent');
        $this->isLoggedIn();
        
    }

    public function About() 
    {
        $data['data'] = $this->About_model->AboutChurch();
        $this->load->template('about/list', $data); 
    }
    public function editAbout()
    {
        $data['data'] = $this->About_model->AboutChurchBody();
        $this->load->template('about/edit', $data); 
    }

    public function UpdateAboutChurch()
    {   
        $info = [];
        $message =$this->input->post('message');
        $this->load->library('session');
        $this->load->library('form_validation');
        if(!empty($_FILES['thumbnail']['name'])){
            $upload = $this->upload_thumbnail('./uploads/churchimages');

            if($upload[0]=='ok'){
               $image = $upload[1];
            }else{
                $this->session->set_flashdata('error', $upload[1]);
                redirect('/about/EditAbout');
                return;
            }
        }
        if(empty($message))
        {
                $this->session->set_flashdata('error', " fields can't be left empty");
             return   redirect('about/EditAbout');
        }
        else{
        $message =$this->input->post('message');
        $body = 	$this->cleanup($message);
        $info = array(
            'body' => $body,
            'image' => $image
           );
        $this->About_model->Update_About_Church($info);
			}

				if($this->About_model->status == "success")
				{
						$this->session->set_flashdata('success', $this->About_model->message);
				}
				else
				{
						$this->session->set_flashdata('error', $this->About_model->message);
				}

                return   redirect('about/EditAbout');
    }

    public function upload_thumbnail($uploadpath){
        $path = $_FILES['thumbnail']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $new_name = time().".".$ext;

        $config['file_name'] = $new_name;
        $config['upload_path']          = $uploadpath;
        $config['max_size']             = 10000;
        $config['allowed_types']        = 'jpg|png|jpeg|PNG';
        $config['overwrite'] = TRUE; //overwrite thumbnail


        //var_dump($config);

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('thumbnail'))
        {
                //$error = array('error' => $this->upload->display_errors());
                return ['error',strip_tags($this->upload->display_errors())];
        }
        else{
                $image_data = $this->upload->data();
                return ['ok',$new_name];
        }
    }
    public function cleanup($data)
	{	
		 	 $data = $this->security->xss_clean($data);
			$data = strip_tags($data);
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            $data = strip_tags($data);
            $data = preg_replace('/\xc2\xa0/', " ", $data);
            // $data = preg_replace('\r\n', " ", $data);
			return $data;
	}
} 
  



?>
