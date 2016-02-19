<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Ledger extends CI_Controller 
{
    
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
		$this->load->model('ledger_model');
		$this->load->library('Datatables');
        $this->load->library('Branchname');
	}
    
    function index()
    {
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $data['ledgers'] = $this->ledger_model->getLedgers();
        // echo '<pre>';
        // print_r($data['ledgers']);exit;
        $meta['page_title'] = 'Ledger Details';
		$data['page_title'] = "Ledger details";
		$this->load->view('commons/header',$meta);
		$this->load->view('index',$data);
		$this->load->view('commons/footer');
    }
    
    function view($ledger_id)
    {
        $id = $ledger_id;
        $ledger_details = $this->ledger_model->getledgerWithJoin($ledger_id);
        /*echo '<pre>';
        print_r($ledger_details);exit;*/
        $data['id'] = $ledger_id;
        $data['ledger'] = $ledger_details;
        $meta['page_title'] = 'View Ledger';
        $data['page_title'] = "View Ledger";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
        
    }
    
    function add()
    {
        //ledger form validation
        /* ==============VALIDATION FOR SELECTBOX branch ================ */
        $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
        $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
        /* --------------*/
        /* ==============VALIDATION FOR SELECTBOX type ================ */
        $this->form_validation->set_rules('type','Type','required|callback_check_default1');
        $this->form_validation->set_message('check_default1', 'You need to select type other than the default.');
        /* --------------*/
        $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
        /* ==============VALIDATION FOR SELECTBOX group ================ */
        $this->form_validation->set_rules('accountgroup','Account Group','required|callback_check_default2');
        $this->form_validation->set_message('check_default2', 'You need to select account group other than the default.');
        /* --------------*/
        
        $this->form_validation->set_rules('opening_balance', 'Opening Balance', 'trim|xss_clean');
        $this->form_validation->set_rules('closing_balance', 'Closing Balance', 'trim|xss_clean');
        
        if ($this->form_validation->run() == true)
        {
            $ledgerDetail = array(
                    'branch_id'	=>	$this->input->post('branch'),
                    'type'        =>  $this->input->post('type'),
                    'title'   =>  strtoupper($this->input->post('title')),
                    'accountgroup_id'   =>  $this->input->post('accountgroup'),
                    'opening_balance'          =>  $this->input->post('opening_balance'),
                    'closing_balance'          =>  $this->input->post('closing_balance'),
                    'user'                  =>  USER_ID,
                    'creation_time'     =>  date("Y-m-d h:m:s"),
                );
               // echo '<pre>';
               // print_r($ledgerDetail);exit;
        }
        
        if ( ($this->form_validation->run() == true) && $this->ledger_model->addLedger($ledgerDetail))
		{  
			$this->session->set_flashdata('success', 'Ledger added successfully.');
			redirect("ledger",'refresh');
		}
		else
		{  
            $data['errors'] = $this->form_validation->error_array();
            $data['branch'] = $this->ledger_model->getBranch();
            $data['accountgroup'] = $this->ledger_model->getAccountGroup();
			$meta['page_title'] = 'Add Ledger';
            $data['page_title'] = "Add Ledger";
            $this->load->view('commons/header', $meta);
            $this->load->view('add', $data);
            $this->load->view('commons/footer');
		
		}	
	}
    
    public function edit($ledger_id)
    {
        $id = $ledger_id;
        
        if($post = $this->input->post())
        {
            //ledger form validation
            /* ==============VALIDATION FOR SELECTBOX branch ================ */
            $this->form_validation->set_rules('branch','Branch','required|callback_check_default');
            $this->form_validation->set_message('check_default', 'You need to select branch other than the default.');
            /* --------------*/
            /* ==============VALIDATION FOR SELECTBOX type ================ */
            $this->form_validation->set_rules('type','Type','required|callback_check_default1');
            $this->form_validation->set_message('check_default1', 'You need to select type other than the default.');
            /* --------------*/
            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
            /* ==============VALIDATION FOR SELECTBOX group ================ */
            $this->form_validation->set_rules('accountgroup','Account Group','required|callback_check_default2');
            $this->form_validation->set_message('check_default2', 'You need to select account group other than the default.');
            /* --------------*/
            
            $this->form_validation->set_rules('opening_balance', 'Opening Balance', 'trim|xss_clean');
            $this->form_validation->set_rules('closing_balance', 'Closing Balance', 'trim|xss_clean');
            
            if ($this->form_validation->run() == true)
            {
                $ledgerDetail = array(
                    'branch_id'	=>	$this->input->post('branch'),
                    'type'        =>  $this->input->post('type'),
                    'title'   =>  strtoupper($this->input->post('title')),
                    'accountgroup_id'   =>  $this->input->post('accountgroup'),
                    'opening_balance'          =>  $this->input->post('opening_balance'),
                    'closing_balance'          =>  $this->input->post('closing_balance'),
                    'user'                      =>  USER_ID,
                    'updation_time'     =>  date("Y-m-d h:m:s"),
                );
               // echo '<pre>';
               // print_r($ledgerDetail);exit;
            }
            if ( ($this->form_validation->run() == true) && $this->ledger_model->updateLedger($ledgerDetail,$id))
            {  
                $this->session->set_flashdata('success', 'Ledger edited successfully.');
                redirect("ledger",'refresh');
            }
            else
            {  
                $data['errors'] = $this->form_validation->error_array();
                $ledger_details = $this->ledger_model->getledgerById($ledger_id);
                $data['branch'] = $this->ledger_model->getBranch();
                $data['accountgroup'] = $this->ledger_model->getAccountGroup();
                /*echo '<pre>';
                print_r($ledger_details);exit;*/
                $data['id'] = $ledger_id;
                $data['ledger'] = $ledger_details;
                $meta['page_title'] = 'Edit ledger';
                $data['page_title'] = "Edit ledger";
                $this->load->view('commons/header', $meta);
                $this->load->view('edit', $data);
                $this->load->view('commons/footer');
            
            }
        }
        else
        {
            $data['errors'] = $this->form_validation->error_array();
            $ledger_details = $this->ledger_model->getledgerById($ledger_id);
            $data['branch'] = $this->ledger_model->getBranch();
            $data['accountgroup'] = $this->ledger_model->getAccountGroup();
            /*echo '<pre>';
            print_r($ledger_details);exit;*/
            $data['id'] = $ledger_id;
            $data['ledger'] = $ledger_details;
            $meta['page_title'] = 'Edit ledger';
            $data['page_title'] = "Edit ledger";
            $this->load->view('commons/header', $meta);
            $this->load->view('edit', $data);
            $this->load->view('commons/footer');
        }
    }
    
    public function delete($ledger_id)
    {
        $id = $ledger_id;
        if($this->ledger_model->deleteLedger($id))
        {
            $this->session->set_flashdata('success', 'Ledger deleted successfully.');
            redirect("ledger",'refresh');
        }
    }
    
    function check_default($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    
    function check_default1($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    
    function check_default2($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    
    function getAccountGroup(){
        $type = $this->input->post('id');
        $branch_id = $this->input->post('branch_id');
        $acc_group = $this->ledger_model->getAccountGroupByLedger($type,$branch_id);
        echo json_encode($acc_group);
    }
}
?>