<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Settings extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->library('form_validation');
        $this->load->model('settings_model');
        $this->load->database();
        $this->load->library('Datatables');
        $this->load->library('upload');
        $this->load->library('Branchname');
    }

    function index(){
        $id = 1;
        // validation for settings
        $this->form_validation->set_rules('system_name','System Name','trim|required|max_length[10]');
        // $this->form_validation->set_rules('currency_code','Currency Code','trim|required');
        $this->form_validation->set_rules('default_discount','Default Discount','trim|required|callback_check_discount');

        if($this->form_validation->run() == true){
            // code for logo
            if($_FILES['logo']['size'] > 0)
            {
                $ext1 = end(explode(".", $_FILES['logo']['name']));
                $file_name = $this->input->post('system_name');
                $image_path = realpath(APPPATH."../assets/uploads/logo/");
                $config1 = array(
                    'upload_path' => $image_path,
                    'allowed_types' => "gif|jpg|png|jpeg",
                    'overwrite' => TRUE,
                    'file_name' => $file_name
                );
                // echo '<pre>';
                // print_r($config1);
                $this->upload->initialize($config1);
                if($this->upload->do_upload('logo'))
                {
                    $data1 = array('logo' => $this->upload->data());
                }
                else
                {
                    // echo '<pre>';    
                    $error = array('error' => $this->upload->display_errors());
                    // print_r($error);
                    $this->load->view('index', $error);
                }
            }
            else
            {
                $data1['logo']['file_name'] = LOGO;
            }

            $dataSetting = array(
                'system_name'           => $this->input->post('system_name'),
                'logo'                  => $data1['logo']['file_name'],
                // 'currency_code'         => strtoupper($this->input->post('currency_code')),
                'quotation_prefix'      => strtoupper($this->input->post('quotation_prefix')),
                'default_discount'      => $this->input->post('default_discount'),
            );            
            // echo '<pre>';
            // print_r($dataSetting);exit; 
        }

        if(($this->form_validation->run() == true) && $this->settings_model->updateSettings($dataSetting,$id)){
            $this->session->set_flashdata('success','Settings updated successfully.');
            redirect('settings','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            // $data['discount'] = $this->settings_model->getDiscount();
            $data['settings'] = $this->settings_model->getSettingById($id);
            $data['id'] = $id;
            $meta['page_title'] = 'System Settings';
            $data['page_title'] = "System Settings";
            $this->load->view('commons/header',$meta);
            $this->load->view('index',$data);
            $this->load->view('commons/footer');
        }
    }

    function check_discount(){
        if($this->input->post('default_discount') == '0'){
            $this->form_validation->set_message('check_discount','Please select discount type.');
            return false;
        }
        return true;
    }

    function discount(){
        $data['discounts'] = $this->settings_model->getDiscounts();
        $meta['page_title'] = 'Discounts';
        $data['page_title'] = "Discounts";
        $this->load->view('commons/header',$meta);
        $this->load->view('discount',$data);
        $this->load->view('commons/footer');
    }

    function discount_view($id = NULL){
        // echo $id;exit;
        $data['discount'] = $this->settings_model->getDiscountById($id);
        $data['id'] = $id;
        $meta['page_title'] = 'View Discount';
        $data['page_title'] = "View Discounts";
        $this->load->view('commons/header',$meta);
        $this->load->view('discount_view',$data);
        $this->load->view('commons/footer');
    }
    
    function add_discount(){
        // validation for discount type
        $this->form_validation->set_rules('discount','Discount Type','trim|requires|callback_check_type');
        $this->form_validation->set_rules('discount_value','Discount Value','trim|requires');

        if($this->form_validation->run() == true){
            $dataDiscount = array(
                'discount_type'     => $this->input->post('discount'),
                'value'             => $this->input->post('discount_value'),
                'creation_time'     => date('Y-m-d H:m:s')
            );
            // echo '<pre>';
            // print_r($dataDiscount);exit;
        }

        if(($this->form_validation->run() == true && $this->settings_model->addDiscount($dataDiscount))){
            $this->session->set_flashdata('success','Discount added successfully.');
            redirect('settings/discount','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $meta['page_title'] = 'Add Discount';
            $data['page_title'] = "Add Discount";
            $this->load->view('commons/header',$meta);
            $this->load->view('add_discount',$data);
            $this->load->view('commons/footer');
        }
    }

    function edit_discount($id = NULL){
        // validation for discount type
        $this->form_validation->set_rules('discount','Discount Type','trim|requires|callback_check_type');
        $this->form_validation->set_rules('discount_value','Discount Value','trim|requires');

        if($this->form_validation->run() == true){
            $dataDiscount = array(
                'discount_type'     => $this->input->post('discount'),     
                'value'             => $this->input->post('discount_value'),
                'updation_time'     => date('Y-m-d H:m:s')
            );
            // echo '<pre>';
            // print_r($dataDiscount);exit;
        }

        if(($this->form_validation->run() == true && $this->settings_model->editDiscount($dataDiscount,$id))){
            $this->session->set_flashdata('success','Discount edited successfully.');
            redirect('settings/discount','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['discount'] = $this->settings_model->getDiscountById($id);
            $data['id'] = $id;
            $meta['page_title'] = 'Edit Discount';
            $data['page_title'] = "Edit Discount";
            $this->load->view('commons/header',$meta);
            $this->load->view('dicount_edit',$data);
            $this->load->view('commons/footer');
        }
    }

    function delete_discount($id = NULL){
        if($this->settings_model->deleteDiscount($id)){
            $this->session->set_flashdata('success','Discount deleted successfully.');
            redirect('settings/discount','refresh');
        }
    }

    function check_type(){
        if($this->input->post('discount') == '0'){
            $this->form_validation->set_message('check_type','Please select dicount type');
            return false;
        }
        return true;
    }
}
?>