<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Categories extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->library('form_validation');
        $this->load->model('categories_model');
        $this->load->database();
        $this->load->library('Datatables');
        $this->load->library('Branchname');
    }
    
    function index(){
        $data['categories'] = $this->categories_model->getCategories();
        // echo '<pre>';
        // print_r($data['categories']);exit;
        $meta['page_title'] = 'Category Details';
        $data['page_title'] = "Category Details";
        $this->load->view('commons/header',$meta);
        $this->load->view('index',$data);
        $this->load->view('commons/footer');
    }
    
    function sub_categories(){
        $data['sub_categories'] = $this->categories_model->getSubCategories();
        // echo '<pre>';
        // print_r($data['sub_categories']);exit;
        $meta['page_title'] = 'Sub Category Details';
        $data['page_title'] = "Sub Category Details";
        $this->load->view('commons/header',$meta);
        $this->load->view('sub_categories',$data);
        $this->load->view('commons/footer');
    }
    
    function view($category_id)
    {
        $id = $category_id;
        $category_details = $this->categories_model->getCategoryById($category_id);
        // echo '<pre>';
        // print_r($brand_details);exit;
        $data['id'] = $category_id;
        $data['categories'] = $category_details;
        $meta['page_title'] = 'View Category';
        $data['page_title'] = "View Category";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
        
    }
    
    function view_sub($sub_category_id)
    {
        $id = $sub_category_id;
        $sub_category_details = $this->categories_model->getSubCategoryById($sub_category_id);
        // echo '<pre>';
        // print_r($brand_details);exit;
        $data['id'] = $sub_category_id;
        $data['sub_categories'] = $sub_category_details;
        $meta['page_title'] = 'View Sub Category';
        $data['page_title'] = "View Sub Category";
        $this->load->view('commons/header', $meta);
        $this->load->view('view_sub', $data);
        $this->load->view('commons/footer');
        
    }
    
    function add(){
        // validation for brand
        $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');
        $this->form_validation->set_rules('category_desc', 'Category Description', 'trim');
        
        if($this->form_validation->run() == true){
            $dataCategory = array(
                'category_name'     =>  $this->input->post('category_name'),
                'category_desc'     =>  $this->input->post('category_desc'),
                'user'              =>  USER_ID,
                'creation_time'     =>  date("Y-m-d h:m:s"),
            );
            // echo '<pre>';
            // print_r($dataCategory);exit;
        }
        
        if($this->form_validation->run() == true && $this->categories_model->addCategory($dataCategory)){
            $this->session->set_flashdata('success', 'Category added successfully.');
            redirect('categories','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $meta['page_title'] = 'Add Category';
            $data['page_title'] = "Add Category";
            $this->load->view('commons/header',$meta);
            $this->load->view('add',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function edit($id = NULL){
        // validation for brand
        $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required');
        $this->form_validation->set_rules('category_desc', 'Category Description', 'trim');
        
        if($this->form_validation->run() == true){
            $dataCategory = array(
                'category_name'     =>  $this->input->post('category_name'),
                'category_desc'     =>  $this->input->post('category_desc'),
                'user'              =>  USER_ID,
                'updation_time'     =>  date("Y-m-d h:m:s"),
            );
            // echo '<pre>';
            // print_r($dataCategory);exit;
        }
        
        if($this->form_validation->run() == true && $this->categories_model->editCategory($dataCategory, $id)){
            $this->session->set_flashdata('success', 'Category edited successfully.');
            redirect('categories','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['categories'] = $this->categories_model->getCategoryById($id);
            // echo '<pre>';
            // print_r($data['brand']);exit;
            $data['id'] = $id;
            $meta['page_title'] = 'Edit Category';
            $data['page_title'] = "Edit Category";
            $this->load->view('commons/header',$meta);
            $this->load->view('edit',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function delete($id = NULL){
        if($this->categories_model->delete($id)){
            $this->session->set_flashdata('success', 'Category deleted successfully.');
            redirect('categories','refresh');
        }
        return false;
    }
    
    function add_sub_category(){
        // validation for brand
        $this->form_validation->set_rules('category_id', 'Category', 'trim|required|callback_check_category');
        $this->form_validation->set_rules('sub_category_name', 'Sub Category Name', 'trim|required');
        $this->form_validation->set_rules('sub_category_desc', 'Sub Category Description', 'trim');
        
        if($this->form_validation->run() == true){
            $dataSubCategory = array(
                'category_id'            =>  $this->input->post('category_id'),
                'sub_category_name'      =>  $this->input->post('sub_category_name'),
                'sub_cat_desc'           =>  $this->input->post('sub_category_desc'),
                'user'                   =>  USER_ID,
                'creation_time'          =>  date("Y-m-d h:m:s"),
            );
            // echo '<pre>';
            // print_r($dataSubCategory);exit;
        }
        
        if($this->form_validation->run() == true && $this->categories_model->addSubCategory($dataSubCategory)){
            $this->session->set_flashdata('success', 'Sub Category added successfully.');
            redirect('categories/sub_categories','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['categories'] = $this->categories_model->getCategory();
            $meta['page_title'] = 'Add Sub Category';
            $data['page_title'] = "Add Sub Category";
            $this->load->view('commons/header',$meta);
            $this->load->view('add_sub',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function edit_sub_category($id = NULL){
        // validation for brand
        $this->form_validation->set_rules('category_id', 'Category', 'trim|required|callback_check_category');
        $this->form_validation->set_rules('sub_category_name', 'Sub Category Name', 'trim|required');
        $this->form_validation->set_rules('sub_category_desc', 'Sub Category Description', 'trim');
        
        if($this->form_validation->run() == true){
            $dataSubCategory = array(
                'category_id'            =>  $this->input->post('category_id'),
                'sub_category_name'      =>  $this->input->post('sub_category_name'),
                'sub_cat_desc'           =>  $this->input->post('sub_category_desc'),
                'user'                   =>  USER_ID,
                'updation_time'          =>  date("Y-m-d h:m:s"),
            );
            // echo '<pre>';
            // print_r($dataSubCategory);exit;
        }
        
        if($this->form_validation->run() == true && $this->categories_model->editSubCategory($dataSubCategory,$id)){
            $this->session->set_flashdata('success', 'Sub Category edited successfully.');
            redirect('categories/sub_categories','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['categories'] = $this->categories_model->getCategory();
            $data['sub_categories'] = $this->categories_model->getSubCategoryByID($id);
            $data['id'] = $id;
            $meta['page_title'] = 'Edit Sub Category';
            $data['page_title'] = "Edit Sub Category";
            $this->load->view('commons/header',$meta);
            $this->load->view('edit_sub',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function check_category(){
        if($this->input->post('category_id') == '0'){
            $this->form_validation->set_message('check_category','Please select category.');
            return false;
        }
        return true;
    }
    
    function delete_sub($id = NULL){
        if($this->categories_model->delete_sub($id)){
            $this->session->set_flashdata('success', 'Sub Category deleted successfully.');
            redirect('categories/sub_categories','refresh');
        }
        return false;
    }
}
?>