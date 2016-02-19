<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Purchases extends CI_Controller{
	function __construct(){
		parent::__construct();
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
		$this->load->library('form_validation');
        $this->load->model('purchases_model');
        $this->load->database();
        $this->load->library('Datatables');
        $this->load->library('Branchname');
	}

	function parts(){
        $data['parts'] = $this->purchases_model->getPurchasePartsDetails();
        // echo '<pre>';
        // print_r($data['parts']);exit;
		$meta['page_title'] = 'Spare Parts Details';
        $data['page_title'] = "Spare Parts Details";
        $this->load->view('commons/header',$meta);
        $this->load->view('parts',$data);
        $this->load->view('commons/footer');
	}

	function viewPart($id = NULL){
		$data['purchase_parts'] = $this->purchases_model->getPurchaseParts($id);
		$meta['page_title'] = 'Purchase Spare Parts Details';
        $data['page_title'] = "Purchase Spare Parts Details";
        $this->load->view('commons/header',$meta);
        $this->load->view('view_purchase_parts',$data);
        $this->load->view('commons/footer');
	}

	function add_part(){
		// validation for purchase part
		$this->form_validation->set_rules('po_no','Purchase Order Number','trim|required');
		$this->form_validation->set_rules('part_shipping','Part Shipping','trim|required');
		$this->form_validation->set_rules('warehouse_id','Warehouse','trim|required|callback_check_warehouse');
		$this->form_validation->set_rules('vendor_ref','Vendor Reference','trim|required|callback_check_vendor');
		$this->form_validation->set_rules('expected_date','Expected Date','trim|required');
		$this->form_validation->set_rules('order_date','Order Date','trim|required');
		$this->form_validation->set_rules('ship_via','Ship Via','trim|required|callback_check_ship');
		$this->form_validation->set_rules('ship_to','Ship To','trim|required');
		$this->form_validation->set_rules('total_amt','Total Amount','trim');

		if($this->form_validation->run() == true){
			$expdate = $this->input->post('expected_date');
			$exp_date = explode('/',$expdate);
			$exp_date_real = $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];

			$order_date = $this->input->post('order_date');
			$orderdate = explode('/',$order_date);
			$order_date_real = $orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
            
            $warehouse_id = $this->input->post('warehouse_id');
			// array of dataPart
			$dataPart = array(
                'po_no'			            => $this->input->post('po_no'),
				'vendor_reference'			=> $this->input->post('vendor_ref'),
                'warehouse_id'  			=> $this->input->post('warehouse_id'),
				'ship_instruction'			=> $this->input->post('part_shipping'),
				'expected_date'				=> $exp_date_real,
				'order_date'				=> $order_date_real,
				'ship_via'					=> $this->input->post('ship_via'),
				'ship_to'					=> $this->input->post('ship_to'),
				'total'						=> $this->input->post('grand_total'),
                'user'                      =>  USER_ID,
				'creation_time'				=> date('Y-m-d H:m:s'),
			);

			// echo '<pre>';
			// print_r($dataPart);exit;
			$noOfDetails = $this->input->post('seq');

			$partDetails = explode(',',$noOfDetails);
			foreach($partDetails as $i){
				//array of dataPartItems
				$dataPartItems = array(
					'part_id'			=> $this->input->post("parts_product_id".$i),
					'description'   	=> $this->input->post("description".$i),
					'part_quantity'		=> $this->input->post("parts_product_qty".$i),
					'customs'			=> $this->input->post("parts_product_customs".$i),
					'freight'			=> $this->input->post("parts_product_freight".$i),
					'cost'				=> $this->input->post("parts_product_cost".$i),
					'service_tax'   	=> $this->input->post("service_tax".$i),
					'part_recieved'		=> $this->input->post("parts_received".$i),
					'sub_total'			=> $this->input->post("sub_total".$i),
					'creation_time'		=> date('Y-m-d H:m:s'),
				);
				$items[] =$dataPartItems;
			}

			// echo '<pre>';
			// print_r($items);exit;
		}
		if(($this->form_validation->run() == true) && $this->purchases_model->addPurchasePart($dataPart, $items, $warehouse_id)){
			$this->session->set_flashdata('success','Purchase Part added successfully.');
			redirect('purchases/parts','refresh');

		}else{
            $branch = $this->purchases_model->getBranchCode(DEFAULT_BRANCH);
            $data['vendor'] = $this->purchases_model->getVendor(DEFAULT_BRANCH);
            $rowID = $this->purchases_model->getRowId();
            $last_id = $rowID;
            $rest = substr("$last_id", -4);  
            $insert_id = "$rest" + 1;
            $ars = sprintf("%04d", $insert_id);
            $po_no = 'P'.date('y').$branch->branch_code.$ars;
            $data['po_no'] = array('name' => 'po_no',
				'id' => 'po_no',
				'type' => 'text',
                'class'=> 'form-control',
				'value' => $this->form_validation->set_value('po_no',$po_no),
			);
            $data['errors'] = $this->form_validation->error_array();
			$data['warehouses'] = $this->purchases_model->getWarehouses();
			$data['parts'] = $this->purchases_model->getParts();
			$meta['page_title'] = 'Add Purchase Spare Parts';
	        $data['page_title'] = "Add Purchase Spare Parts";
	        $this->load->view('commons/header',$meta);
	        $this->load->view('add_part',$data);
	        $this->load->view('commons/footer');
		}
	}
    
    function edit_part($id = NULL){
        // validation for purchase part
        $this->form_validation->set_rules('po_no','Purchase Order Number','trim|required');
		$this->form_validation->set_rules('part_shipping','Part Shipping','trim|required');
        $this->form_validation->set_rules('warehouse_id','Warehouse','trim|required|callback_check_warehouse');
		$this->form_validation->set_rules('vendor_ref','Vendor Reference','trim|required|callback_check_vendor');
		$this->form_validation->set_rules('expected_date','Expected Date','trim|required');
		$this->form_validation->set_rules('order_date','Order Date','trim|required');
		$this->form_validation->set_rules('ship_via','Ship Via','trim|required|callback_check_ship');
		$this->form_validation->set_rules('ship_to','Ship To','trim|required');
		$this->form_validation->set_rules('total_amt','Total Amount','trim');

		if($this->form_validation->run() == true){
			$expdate = $this->input->post('expected_date');
			$exp_date = explode('/',$expdate);
            $exp_date_real = $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];

			$order_date = $this->input->post('order_date');
			$orderdate = explode('/',$order_date);
			$order_date_real = $orderdate[2].'-'.$orderdate[1].'-'.$orderdate[0];
            
            $warehouse_id = $this->input->post('warehouse_id');
			// array of dataPart
			$dataPart = array(
                'po_no'			            => $this->input->post('po_no'),
				'vendor_reference'			=> $this->input->post('vendor_ref'),
				'warehouse_id'  			=> $this->input->post('warehouse_id'),
				'ship_instruction'			=> $this->input->post('part_shipping'),
				'expected_date'				=> $exp_date_real,
				'order_date'				=> $order_date_real,
				'ship_via'					=> $this->input->post('ship_via'),
				'ship_to'					=> $this->input->post('ship_to'),
				'total'						=> $this->input->post('grand_total'),
                'user'                      =>  USER_ID,
				'creation_time'				=> date('Y-m-d H:m:s'),
			);

			// echo '<pre>';
			// print_r($dataPart);exit;
			$noOfDetails = $this->input->post('seq');

			$partDetails = explode(',',$noOfDetails);
			foreach($partDetails as $i){
				//array of dataPartItems
				$dataPartItems = array(
					'part_id'			=> $this->input->post("parts_product_id".$i),
                    'description'   	=> $this->input->post("description".$i),
					'part_quantity'		=> $this->input->post("parts_product_qty".$i),
					'customs'			=> $this->input->post("parts_product_customs".$i),
					'freight'			=> $this->input->post("parts_product_freight".$i),
					'cost'				=> $this->input->post("parts_product_cost".$i),
                    'service_tax'   	=> $this->input->post("service_tax".$i),
					'part_recieved'		=> $this->input->post("parts_received".$i),
					'sub_total'			=> $this->input->post("sub_total".$i),
					'creation_time'		=> date('Y-m-d H:m:s'),
				);
				$items[] =$dataPartItems;
			}

			// echo '<pre>';
			// print_r($items);exit;
		}
		if(($this->form_validation->run() == true) && $this->purchases_model->editPurchasePart($dataPart,$items,$warehouse_id,$id)){
			$this->session->set_flashdata('success','Purchase Part edited successfully.');
			redirect('purchases/parts','refresh');

		}else{
            $data['errors'] = $this->form_validation->error_array();
            $data['vendor'] = $this->purchases_model->getVendor(DEFAULT_BRANCH);
            $data['warehouses'] = $this->purchases_model->getWarehouses();
			$data['parts'] = $this->purchases_model->getParts();
            $data['purchase_part'] = $this->purchases_model->getPurchaseParts($id);
            // echo '<pre>';
            // print_r($data['purchase_part']);exit;
            $data['po_no'] = array('name' => 'po_no',
				'id' => 'po_no',
				'type' => 'text',
                'class'=> 'form-control',
				'value' => $this->form_validation->set_value('po_no',$data['purchase_part'][0]->po_no),
			);
            $count = 1;
            foreach($data['purchase_part'] as $row){
                $count = $count+1;
            }
            $data['seq_row'] = $count;
            $data['id'] = $id;
			$meta['page_title'] = 'Edit Purchase Spare Parts';
	        $data['page_title'] = "Edit Purchase Spare Parts";
	        $this->load->view('commons/header',$meta);
	        $this->load->view('edit_part',$data);
	        $this->load->view('commons/footer');
		}
    }
    
    function check_warehouse(){
        if($this->input->post('warehouse_id') == '0'){
            $this->form_validation->set_message('check_warehouse','Please select warehouse.');
            return false;
        }
        return true;
    }
    
    function check_vendor(){
        if($this->input->post('vendor_ref') == '0'){
            $this->form_validation->set_message('check_vendor','Please select vendor.');
            return false;
        }
        return true;
    }
    
    function check_ship(){
        if($this->input->post('ship_via') == '0'){
            $this->form_validation->set_message('check_ship','Please select ship via.');
            return false;
        }
        return true;
    }
    
    function delete_part($id = NULL){
        if($this->purchases_model->delete_part($id)){
            $this->session->set_flashdata('success','Purchase part deleted successfully.');
            redirect('purchases/parts','refresh');
        }
        return false;
    }

	function getParts(){
		$id = $this->input->post('part_id');
		$part_details = $this->purchases_model->getPartDetail($id);
		echo json_encode($part_details);
	}
}
?>