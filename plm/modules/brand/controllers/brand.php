<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Brand extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->library('form_validation');
        $this->load->model('brand_model');
        $this->load->database();
        $this->load->library('Datatables');
        $this->load->library('Branchname');
    }
    
    function index(){
        $data['brands'] = $this->brand_model->getBrands();
        // echo '<pre>';
        // print_r($data['brands']);exit;
        $meta['page_title'] = 'Brand Details';
        $data['page_title'] = "Brand Details";
        $this->load->view('commons/header',$meta);
        $this->load->view('index',$data);
        $this->load->view('commons/footer');
    }
    
    function view($brand_id)
    {
        $id = $brand_id;
        $brand_details = $this->brand_model->getBrandById($brand_id);
        // echo '<pre>';
        // print_r($brand_details);exit;
        $data['id'] = $brand_id;
        $data['brand'] = $brand_details;
        $meta['page_title'] = 'View Brand';
        $data['page_title'] = "View Brand";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
        
    }
    
    function add(){
        // validation for brand
        $this->form_validation->set_rules('brand_name', 'Brand Name', 'trim|required');
        $this->form_validation->set_rules('brand_desc', 'Brand Description', 'trim');
        
        if($this->form_validation->run() == true){
            $dataBrand = array(
                'brand_name'    =>  $this->input->post('brand_name'),
                'brand_desc'    =>  $this->input->post('brand_desc'),
                'user'          =>  USER_ID,
                'creation_time' =>  date("Y-m-d h:m:s"),
            );
            // echo '<pre>';
            // print_r($dataBrand);exit;
        }
        
        if($this->form_validation->run() == true && $this->brand_model->addBrand($dataBrand)){
            $this->session->set_flashdata('success', 'Brand added successfully.');
            redirect('brand','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $meta['page_title'] = 'Add Brand';
            $data['page_title'] = "Add Brand";
            $this->load->view('commons/header',$meta);
            $this->load->view('add',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function edit($id = NULL){
        // validation for brand
        $this->form_validation->set_rules('brand_name', 'Brand Name', 'trim|required');
        $this->form_validation->set_rules('brand_desc', 'Brand Description', 'trim');
        
        if($this->form_validation->run() == true){
            $dataBrand = array(
                'brand_name'    =>  $this->input->post('brand_name'),
                'brand_desc'    =>  $this->input->post('brand_desc'),
                'user'          =>  USER_ID,
                'updation_time' =>  date("Y-m-d h:m:s"),
            );
            // echo '<pre>';
            // print_r($dataBrand);exit;
        }
        
        if($this->form_validation->run() == true && $this->brand_model->editBrand($dataBrand, $id)){
            $this->session->set_flashdata('success', 'Brand edited successfully.');
            redirect('brand','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['brand'] = $this->brand_model->getBrandById($id);
            // echo '<pre>';
            // print_r($data['brand']);exit;
            $data['id'] = $id;
            $meta['page_title'] = 'Edit Brand';
            $data['page_title'] = "Edit Brand";
            $this->load->view('commons/header',$meta);
            $this->load->view('edit',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function delete($id = NULL){
        if($this->brand_model->delete($id)){
            $this->session->set_flashdata('success', 'Brand deleted successfully.');
            redirect('brand','refresh');
        }
        return false;
    }
}
?>