<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Warehouses extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->library('form_validation');
        $this->load->model('warehouses_model');
        $this->load->database();
        $this->load->library('Datatables');
        $this->load->library('Branchname');
    }
    
    function index(){
        $data['warehouses'] = $this->warehouses_model->getWarehouses();
        // echo '<pre>';
        // print_r($data['warehouses']);exit;
        $meta['page_title'] = 'Warehouse Details';
        $data['page_title'] = "Warehouse Details";
        $this->load->view('commons/header',$meta);
        $this->load->view('index',$data);
        $this->load->view('commons/footer');
    }
    
    function view($warehouse_id)
    {
        $warehouse_details = $this->warehouses_model->getWarehouseById($warehouse_id);
        // echo '<pre>';
        // print_r($warehouse_details);exit;
        $data['id'] = $warehouse_id;
        $data['warehouses'] = $warehouse_details;
        $meta['page_title'] = 'View Warehouse';
        $data['page_title'] = "View Warehouse";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
        
    }
    
    function add(){
        // validation for brand
        $this->form_validation->set_rules('branch_id', 'Branch', 'trim|required|callback_check_branch');
        $this->form_validation->set_rules('warehouse_name', 'Warehouse Name', 'trim|required');
        $this->form_validation->set_rules('warehouse_desc', 'Warehouse Description', 'trim');
        
        if($this->form_validation->run() == true){
            $dataWarehouse = array(
                'branch_id'         =>  $this->input->post('branch_id'),
                'warehouse_name'    =>  $this->input->post('warehouse_name'),
                'warehouse_desc'    =>  $this->input->post('warehouse_desc'),
                'user'              =>  USER_ID,
                'creation_time'     =>  date("Y-m-d h:m:s"),
            );
            // echo '<pre>';
            // print_r($dataWarehouse);exit;
        }
        
        if($this->form_validation->run() == true && $this->warehouses_model->addWarehouse($dataWarehouse)){
            $this->session->set_flashdata('success', 'Warehouse added successfully.');
            redirect('warehouses','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['branch'] = $this->warehouses_model->getBranch();
            $meta['page_title'] = 'Add Warehouse';
            $data['page_title'] = "Add Warehouse";
            $this->load->view('commons/header',$meta);
            $this->load->view('add',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function edit($id = NULL){
        // validation for brand
        $this->form_validation->set_rules('branch_id', 'Branch', 'trim|required|callback_check_branch');
        $this->form_validation->set_rules('warehouse_name', 'Warehouse Name', 'trim|required');
        $this->form_validation->set_rules('warehouse_desc', 'Warehouse Description', 'trim');
        
        if($this->form_validation->run() == true){
            $dataWarehouse = array(
                'branch_id'         =>  $this->input->post('branch_id'),
                'warehouse_name'    =>  $this->input->post('warehouse_name'),
                'warehouse_desc'    =>  $this->input->post('warehouse_desc'),
                'user'              =>  USER_ID,
                'updation_time'     =>  date("Y-m-d h:m:s"),
            );
            // echo '<pre>';
            // print_r($dataWarehouse);exit;
        }
        
        if($this->form_validation->run() == true && $this->warehouses_model->editWarehouse($dataWarehouse, $id)){
            $this->session->set_flashdata('success', 'Warehouse edited successfully.');
            redirect('warehouses','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['branch'] = $this->warehouses_model->getBranch();
            $data['warehouses'] = $this->warehouses_model->getWarehouseById($id);
            $data['id'] = $id;
            $meta['page_title'] = 'Edit Warehouse';
            $data['page_title'] = "Edit Warehouse";
            $this->load->view('commons/header',$meta);
            $this->load->view('edit',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function delete($id = NULL){
        if($this->warehouses_model->delete($id)){
            $this->session->set_flashdata('success', 'Warehouse deleted successfully.');
            redirect('warehouses','refresh');
        }
        return false;
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