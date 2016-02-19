<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Vendor extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->library('Branchname');
        $this->load->library('form_validation');
        $this->load->model('vendor_model');
        $this->load->database();
    }
    
    function index(){
        $data['vendors'] = $this->vendor_model->getVendors();
        // echo '<pre>';
        // print_r($data['vendors']);exit;
        $meta['page_title'] = 'Vendor Details';
        $data['page_title'] = "Vendor Details";
        $this->load->view('commons/header',$meta);
        $this->load->view('index',$data);
        $this->load->view('commons/footer');
    }
    
    function add(){
        // validation vendor
        $this->form_validation->set_rules('branch_id','Branch','trim|required|callback_check_branch');
        $this->form_validation->set_rules('company_name','Company Name','trim|required');
        $this->form_validation->set_rules('address','Address','trim|required');
        $this->form_validation->set_rules('contact_person','Contact Person','trim|required');
        $this->form_validation->set_rules('fax','Fax','trim');
        $this->form_validation->set_rules('telephone','Telephone','trim');
        $this->form_validation->set_rules('mobile','Mobile','trim|required');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');
        
        if($this->form_validation->run() == true){
            $data = array(
                'branch_id'         => $this->input->post('branch_id'),
                'company_name'      => $this->input->post('company_name'),
                'address'           => $this->input->post('address'),
                'contact_person'    => $this->input->post('contact_person'),
                'fax'               => $this->input->post('fax'),
                'telephone'         => $this->input->post('telephone'),
                'mobile'            => $this->input->post('mobile'),
                'email'             => $this->input->post('email'),
                'creation_time'     => date('Y-m-d H:m:s'),
            );
            // echo '<pre>';
            // print_r($data);exit;
        }
        
        if(($this->form_validation->run() == true) && $this->vendor_model->addVendor($data)){
            $this->session->set_flashdata('success','Vendor added successfully.');
            redirect('vendor','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['branch'] = $this->vendor_model->getBranch();
            $data['page_title'] = "Add Vendor";
            $meta['page_title'] = "Add Vendor";
            $this->load->view('commons/header',$meta);
            $this->load->view('add',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function edit($id = NULL){
        if($id){
            // validation vendor
            $this->form_validation->set_rules('branch_id','Branch','trim|required|callback_check_branch');
            $this->form_validation->set_rules('company_name','Company Name','trim|required');
            $this->form_validation->set_rules('address','Address','trim|required');
            $this->form_validation->set_rules('contact_person','Contact Person','trim|required');
            $this->form_validation->set_rules('fax','Fax','trim');
            $this->form_validation->set_rules('telephone','Telephone','trim');
            $this->form_validation->set_rules('mobile','Mobile','trim|required');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email');
            
            if($this->form_validation->run() == true){
                $data = array(
                    'branch_id'         => $this->input->post('branch_id'),
                    'company_name'      => $this->input->post('company_name'),
                    'address'           => $this->input->post('address'),
                    'contact_person'    => $this->input->post('contact_person'),
                    'fax'               => $this->input->post('fax'),
                    'telephone'         => $this->input->post('telephone'),
                    'mobile'            => $this->input->post('mobile'),
                    'email'             => $this->input->post('email'),
                    'creation_time'     => date('Y-m-d H:m:s'),
                );
                // echo '<pre>';
                // print_r($data);exit;
            }
            
            if(($this->form_validation->run() == true) && $this->vendor_model->editVendor($data,$id)){
                $this->session->set_flashdata('success','Vendor updated successfully.');
                redirect('vendor','refresh');
            }else{
                $data['errors'] = $this->form_validation->error_array();
                $data['branch'] = $this->vendor_model->getBranch();
                $data['id'] = $id;
                $data['vendor'] = $this->vendor_model->getVendorByID($id);
                $data['page_title'] = "Update Vendor";
                $meta['page_title'] = "Update Vendor";
                $this->load->view('commons/header',$meta);
                $this->load->view('edit',$data);
                $this->load->view('commons/footer');
            }
        }else{
            show_404();
        }
    }
    
    function view($id = NULL){
        $data['vendor'] = $this->vendor_model->getVendorByID($id);
        if(!empty($data['vendor'])){
            // $data['vendor'] = $this->vendor_model->getVendorByID($id);
            $data['page_title'] = "View Vendor";
            $meta['page_title'] = "View Vendor";
            $this->load->view('commons/header',$meta);
            $this->load->view('view',$data);
            $this->load->view('commons/footer');
        }else{
            show_404();
        }
    }
    
    function check_branch(){
        if($this->input->post('branch_id') == '0'){
            $this->form_validation->set_message('check_branch','Please select branch.');
            return false;
        }
        return true; 
    }
}
?>