<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
		$this->load->library('form_validation');
		$this->load->library('Ion_auth');
		$this->security->csrf_verify(); 
		$this->load->model('home_model');
		$this->load->library('Datatables');
		$this->load->library('Branchname');
		
	}
	
   function index()
   {
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login');
        }
        else
		{
            $meta['page_title'] = 'Home';
            $data['page_title'] = "Home";
            $this->load->view('commons/header', $meta);
            $this->load->view('index', $data);
            $this->load->view('commons/footer');
		}
   	}
    
    function updateAdminBranch(){
        $branch_id = $this->input->post('branch_id');
        echo $update = $this->home_model->updateBranch(USER_ID,$branch_id);
    }
}
 