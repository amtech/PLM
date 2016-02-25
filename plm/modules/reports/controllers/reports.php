<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reports extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model('reports_model');
        $this->load->library('Datatables');
        $this->load->library('upload');
        $this->load->library('Branchname');
    }
    
    function inventory(){
        // validation
        $this->form_validation->set_rules('inventory','Inventory','trim|required|callback_check_inventory');
        
        if($this->form_validation->run() == true){
            if($this->input->post('inventory') == '1'){
                $data['errors'] = $this->form_validation->error_array();
                $data['records'] = $this->reports_model->getInventoryValueation();
                $meta['page_title'] = "Inventory Valueation Reports";
                $data['page_title'] = "Inventory Valueation Reports";
                $this->load->view('commons/header',$meta);
                $this->load->view('inventory',$data);
                $this->load->view('commons/footer');
            }
            
            if($this->input->post('inventory') == '2'){
                $data['errors'] = $this->form_validation->error_array();
                $data['records1'] =  $this->reports_model->getInventoryValueation();
                $meta['page_title'] = "Inventory Valueation By Item";
                $data['page_title'] = "Inventory Valueation By Item";
                $this->load->view('commons/header',$meta);
                $this->load->view('inventory',$data);
                $this->load->view('commons/footer');
            }
        }else{
            $data['errors'] = $this->form_validation->error_array();
            // echo '<pre>';
            // print_r($data['records']);exit;
            $meta['page_title'] = "Inventory Reports";
            $data['page_title'] = "Inventory Reports";
            $this->load->view('commons/header',$meta);
            $this->load->view('inventory',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function check_inventory(){
        if($this->input->post('inventory') == '0'){
            $this->form_validation->set_message('check_inventory','Please select inventory.');
            return false;
        }
        return true;
    }
    // function purchase_order(){
        // $data['records'] = $this->reports_model->getPurchaseOrder();
        // $data['records1'] =  $this->reports_model->getPurchaseOrderPending();
        // // echo '<pre>';
        // // print_r($data['records1']);exit;
        // $meta['page_title'] = "Purchase Reports";
        // $data['page_title'] = "Purchase Reports";
        // $this->load->view('commons/header',$meta);
        // $this->load->view('purchase_order',$data);
        // $this->load->view('commons/footer');
    // }
    
    function purchase_order(){
        // validation
        $this->form_validation->set_rules('from','From Date','trim|xss_clean');
        $this->form_validation->set_rules('to','To Date','trim|xss_clean');
        
        if($this->form_validation->run() == true){
            $from = $this->input->post('from');
            $from_arr = explode('/',$from);
            $from_date = $from_arr[2].'-'.$from_arr[1].'-'.$from_arr[0];
            
            $to = $this->input->post('to');
            $to_arr = explode('/',$to);
            $to_date = $to_arr[2].'-'.$to_arr[1].'-'.$to_arr[0];
            $data = array(
                'from'  => $from_date,
                'to'    => $to_date,
            );
        }
        if(($this->form_validation->run() == true) && $data['date_wise_purchase'] = $this->reports_model->getDateWisePurchase($data)){
            // echo '<pre>';
            // print_r($data['date_wise_purchase']);exit;
            $meta['page_title'] = "Client Purchase Reports";
            $data['page_title'] = "Client Purchase Reports";
            $this->load->view('commons/header',$meta);
            $this->load->view('purchase_order',$data);
            $this->load->view('commons/footer');
        }else{
            $data['records'] = $this->reports_model->getPurchaseOrder();
            $meta['page_title'] = "Client Purchase Reports";
            $data['page_title'] = "Client Purchase Reports";
            $this->load->view('commons/header',$meta);
            $this->load->view('purchase_order',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function stock_vendor(){
        // validation
        if($this->input->post('vendor') == '0'){
            $data['vendor'] = $this->reports_model->getVendor();
            $data['inv_vendor'] = $this->reports_model->getStockByVendor();
            $meta['page_title'] = "Purchase From Vendor Report";
            $data['page_title'] = "Purchase From Vendor Report";
            $this->load->view('commons/header',$meta);
            $this->load->view('stock_vendor',$data);
            $this->load->view('commons/footer');
        }else{
            $data['vendor'] = $this->reports_model->getVendor();
            $id = $this->input->post('vendor');
            $data['inv_vendor'] = $this->reports_model->getStockByVendorID($id);
            $meta['page_title'] = "Purchase From Vendor Report";
            $data['page_title'] = "Purchase From Vendor Report";
            $this->load->view('commons/header',$meta);
            $this->load->view('stock_vendor',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function equipment_brand(){
        $data['data'] = $this->reports_model->getEquipmentsByBrand();
        // echo '<pre>';
        // print_r($data['data']);exit;
        $data['page_title'] = "Equipments Brand";
        $meta['page_title'] = "Equipments Brand";
        $this->load->view('commons/header',$meta);
        $this->load->view('equipment_brand',$data);
        $this->load->view('commons/footer');
    }
	
	function customer_equipment(){
		$data['equip'] = $this->reports_model->getEquipmentByCustomer();
		// echo '<pre>';
		// print_r($data['equip']);exit;
		$data['page_title'] = "Customer Equipments";
        $meta['page_title'] = "Customer Equipments";
        $this->load->view('commons/header',$meta);
        $this->load->view('customer_equipment',$data);
        $this->load->view('commons/footer');
	}
}
?>