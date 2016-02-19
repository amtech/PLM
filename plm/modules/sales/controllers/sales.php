<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Sales extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->library('form_validation');
        $this->load->model('sales_model');
        $this->load->database();
        $this->load->library('Datatables');
        $this->load->library('Branchname');
    }
    
    function parts(){
        $data['parts'] = $this->sales_model->getSalesParts();
        // echo '<pre>';
        // print_r($data['parts']);exit;
        $meta['page_title'] = 'Sale Spare Parts';
        $data['page_title'] = "Sale Spare Parts";
        $this->load->view('commons/header',$meta);
        $this->load->view('parts',$data);
        $this->load->view('commons/footer');
    }
    
    function completeSales(){
        $meta['page_title'] = 'Complete Sales';
        $data['page_title'] = "Complete Sales";
        $this->load->view('commons/header',$meta);
        $this->load->view('complete_sales',$data);
        $this->load->view('commons/footer');
    }
    
    function completeSalesDetails(){
        $this->datatables->select('sale_part.id,date,po_no,ship_date,ship_via,ship_to,customers.name,discount_value,total,status')
		->unset_column('sale_part.id')
		->from('sale_part')
        // ->join('quotation_items','quotation_items.quotation_id = quotations.id')
        ->join('customers','customers.id = sale_part.customer_id')
        ->where('sale_part.status','complete');
        
        echo $this->datatables->generate();
    }
    
    function inCompleteSales(){
        $meta['page_title'] = 'InComplete Sales';
        $data['page_title'] = "InComplete Sales";
        $this->load->view('commons/header',$meta);
        $this->load->view('incomplete_sales',$data);
        $this->load->view('commons/footer');
    }
    
    function inCompleteSalesDetails(){
        $this->datatables->select('sale_part.id,date,po_no,ship_date,ship_via,ship_to,customers.name,discount_value,total,status')
		->unset_column('sale_part.id')
		->from('sale_part')
        // ->join('quotation_items','quotation_items.quotation_id = quotations.id')
        ->join('customers','customers.id = sale_part.customer_id')
        ->where('sale_part.status','incomplete');
        
        echo $this->datatables->generate();
    }
    
    function view_part($id = NULL){
        // echo $id;
        $data['parts'] = $this->sales_model->getParts();
        $data['customers'] = $this->sales_model->getCustomers();
        $data['parts'] = $this->sales_model->getParts();
        $data['discount'] = $this->sales_model->getDiscounts();
        $data['id'] = $id;
        $data['sale_part'] = $this->sales_model->getSalePartByID($id);
        // echo '<pre>';
        // print_r($data['sale_part']);exit;
        $meta['page_title'] = 'View Spare Part';
        $data['page_title'] = "View Spare Part";
        $this->load->view('commons/header',$meta);
        $this->load->view('view_part',$data);
        $this->load->view('commons/footer');
    }
    
    function add_part(){
        //validation for sales part
        $this->form_validation->set_rules('date','Sale Date','trim|required');
        $this->form_validation->set_rules('warehouse_id','Warehouse','trim|required|callback_check_warehouse');
        $this->form_validation->set_rules('po_no','Client Po No','trim|required');
        $this->form_validation->set_rules('quotation_no','Quotation No','trim');
        $this->form_validation->set_rules('payment_terms','Payment Term','trim');
        $this->form_validation->set_rules('ship_date','Ship Date','trim|required');
        $this->form_validation->set_rules('customer_id','Customer','trim|required|callback_check_customer');
        $this->form_validation->set_rules('ship_via','Ship Via','trim|required|callback_check_ship');
        $this->form_validation->set_rules('ship_to','Ship To','trim|required');
        $this->form_validation->set_rules('delivery','Delivery Instruction','trim');
        $this->form_validation->set_rules('discount','Discount','trim');
        $this->form_validation->set_rules('status','Status','trim');
        
        if($this->form_validation->run() == true){
            $s_date = explode('/',$this->input->post('date'));
            $original_s_date = $s_date[2].'-'.$s_date[1].'-'.$s_date[0];
            
            $sh_date = explode('/',$this->input->post('ship_date'));
            $original_sh_date = $sh_date[2].'-'.$sh_date[1].'-'.$sh_date[0];
            
            $warehouse_id = $this->input->post('warehouse_id');
            $dataPart = array(
                'date'          =>  $original_s_date, 
                'warehouse_id'  =>  $warehouse_id, 
                'po_no'         =>  $this->input->post('po_no'),  
                'quotation_no'  =>  $this->input->post('quotation_no'),    
                'payment_terms' =>  $this->input->post('payment_terms'),
                'ship_date'     =>  $original_sh_date,
                'customer_id'   =>  $this->input->post('customer_id'),
                'ship_via'      =>  $this->input->post('ship_via'),
                'ship_to'       =>  $this->input->post('ship_to'),
                'delivery'      =>  $this->input->post('delivery'),
                'discount_type' =>  DEFAULT_DISCOUNT,
                'discount'      =>  $this->input->post('discount'),
                'discount_value'=>  $this->input->post('disc_val'),    
                'total'         =>  $this->input->post('grand_total'),
                'status'        =>  $this->input->post('status'),
                'user'          =>  USER_ID,
                'creation_time' =>  date('Y-m-d H:m:s'),
            );
            // echo '<pre>';
            // print_r($dataPart);exit;
            $noOfDetails = $this->input->post('seq');
            $partDetails = explode(',',$noOfDetails);
            foreach($partDetails as $i){
                // check if product warehouse quantity is less then the quantity of sale
                // no sale process allowed
                $part_id = $this->input->post("parts_id".$i);
                $warehouse_quantity = $this->sales_model->getQuantity($part_id,$warehouse_id);
                $quantity = $this->input->post("quantity".$i);
                if(($warehouse_quantity->quantity) < $quantity){
                    $this->session->set_flashdata('error','Sale is not allowed due to no warehouse stock available');
                    redirect('sales/parts','refresh');
                }else{
                    //array of dataPartItems
                    $dataPartItems = array(
                        'part_id'			=> $part_id,
                        'description'		=> $this->input->post('description'.$i),
                        'quantity'		    => $quantity,
                        'price'			    => $this->input->post("price".$i),
                        'item_received'     => $this->input->post("item_received".$i),
                        'sub_total'			=> $this->input->post("sub_total".$i),
                        'creation_time'     =>  date('Y-m-d H:m:s'),
                    );
                    $items[] = $dataPartItems;
                }
            }
            // print_r($items);
            // exit;
        }
        
        if(($this->form_validation->run() == true) && $this->sales_model->addSalePart($dataPart, $items, $warehouse_id)){
            $this->session->set_flashdata('success','Sale Part added successfully.');
            redirect('sales/parts','refresh');
        }else{
            $branch = $this->sales_model->getBranchCode(DEFAULT_BRANCH);
            $rowID = $this->sales_model->getRowId();
            $last_id = $rowID;
            $rest = substr("$last_id", -4);
            $insert_id = "$rest" + 1;
            $ars = sprintf("%04d", $insert_id);
            $po_no = 'S'.date('y').$branch->branch_code.$ars;
            $data['po_no'] = array('name' => 'po_no',
				'id' => 'po_no',
				'type' => 'text',
                'class'=> 'form-control',
				'value' => $this->form_validation->set_value('po_no',$po_no),
			);
            $data['errors'] = $this->form_validation->error_array();
            $data['warehouses'] = $this->sales_model->getWarehouses();
            $data['parts'] = $this->sales_model->getParts();
            $data['customers'] = $this->sales_model->getCustomers();
            // $data['parts'] = $this->sales_model->getParts();
            $data['discount'] = $this->sales_model->getDiscounts();
            // echo '<pre>';
            // print_r($data['discount']);exit;
            $meta['page_title'] = 'Add Sale Spare Part';
            $data['page_title'] = "Add Sale Spare Part";
            $this->load->view('commons/header',$meta);
            $this->load->view('add_part',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function edit_part($id){
        //validation for sales part
        $this->form_validation->set_rules('date','Sale Date','trim|required');
        $this->form_validation->set_rules('warehouse_id','Warehouse','trim|required|callback_check_warehouse');
        $this->form_validation->set_rules('po_no','Client Po No','trim|required');
        $this->form_validation->set_rules('quotation_no','Quotation No','trim');
        $this->form_validation->set_rules('payment_terms','Payment Term','trim');
        $this->form_validation->set_rules('ship_date','Ship Date','trim|required');
        $this->form_validation->set_rules('customer_id','Customer','trim|required|callback_check_customer');
        $this->form_validation->set_rules('ship_via','Ship Via','trim|required|callback_check_ship');
        $this->form_validation->set_rules('ship_to','Ship To','trim|required');
        $this->form_validation->set_rules('delivery','Delivery Instruction','trim');
        $this->form_validation->set_rules('discount','Discount','trim');
        $this->form_validation->set_rules('status','Status','trim');
        
        if($this->form_validation->run() == true){
            $s_date = explode('/',$this->input->post('date'));
            $original_s_date = $s_date[2].'-'.$s_date[1].'-'.$s_date[0];
            
            $sh_date = explode('/',$this->input->post('ship_date'));
            $original_sh_date = $sh_date[2].'-'.$sh_date[1].'-'.$sh_date[0];
            
            $warehouse_id = $this->input->post('warehouse_id');
            $dataPart = array(
                'date'          =>  $original_s_date, 
                'warehouse_id'  =>  $warehouse_id, 
                'po_no'         =>  $this->input->post('po_no'),  
                'quotation_no'  =>  $this->input->post('quotation_no'),    
                'payment_terms' =>  $this->input->post('payment_terms'),
                'ship_date'     =>  $original_sh_date,
                'customer_id'   =>  $this->input->post('customer_id'),
                'ship_via'      =>  $this->input->post('ship_via'),
                'ship_to'       =>  $this->input->post('ship_to'),
                'delivery'      =>  $this->input->post('delivery'),
                'discount_type' =>  DEFAULT_DISCOUNT,
                'discount'      =>  $this->input->post('discount'),
                'discount_value'=>  $this->input->post('disc_val'),    
                'total'         =>  $this->input->post('grand_total'),
                'status'        =>  $this->input->post('status'),
                'user'          =>  USER_ID,
                'updation_time' =>  date('Y-m-d H:m:s'),
            );
            // echo '<pre>';
            // print_r($dataPart);
            $noOfDetails = $this->input->post('seq');
            $partDetails = explode(',',$noOfDetails);
            foreach($partDetails as $i){
                // check if product warehouse quantity is less then the quantity of sale
                // no sale process allowed
                $part_id = $this->input->post("parts_id".$i);
                $warehouse_quantity = $this->sales_model->getQuantity($part_id,$warehouse_id);
                $quantity = $this->input->post("quantity".$i);
                if(($warehouse_quantity->quantity) < $quantity){
                    $this->session->set_flashdata('error','Sale is not allowed due to no warehouse stock available');
                    redirect('sales/parts','refresh');
                }else{
                    //array of dataPartItems
                    $dataPartItems = array(
                        'part_id'			=> $this->input->post("parts_id".$i),
                        'description'		=> $this->input->post('description'.$i),
                        'quantity'		    => $this->input->post("quantity".$i),
                        'price'			    => $this->input->post("price".$i),
                        'item_received'     => $this->input->post("item_received".$i),
                        'sub_total'			=> $this->input->post("sub_total".$i),
                        'updation_time'     =>  date('Y-m-d H:m:s'),
                    );
                }
				$items[] = $dataPartItems;
            }
            // print_r($items);
            // exit;
        }
        
        if(($this->form_validation->run() == true) && $this->sales_model->editSalePart($dataPart, $items, $warehouse_id, $id)){
            $this->session->set_flashdata('success','Sale Part added successfully.');
            redirect('sales/parts','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['warehouses'] = $this->sales_model->getWarehouses();
            $data['parts'] = $this->sales_model->getParts();
            $data['customers'] = $this->sales_model->getCustomers();
            $data['parts'] = $this->sales_model->getParts();
            $data['discount'] = $this->sales_model->getDiscounts();
            $data['sale_part'] = $this->sales_model->getSalePartByID($id);
            $count = 1;
            foreach($data['sale_part'] as $row){
                $count = $count+1;
            }
            $data['seq_row'] = $count;
            // echo '<pre>';
            // print_r($data['sale_part']);exit;
            $data['id'] = $id;
            $meta['page_title'] = 'Edit Sale Spare Part';
            $data['page_title'] = "Edit Sale Spare Part";
            $this->load->view('commons/header',$meta);
            $this->load->view('edit_part',$data);
            $this->load->view('commons/footer');
        }
    }
	
	function pdf($id = NULL){
		if(is_numeric($id)){
			$sales = $this->sales_model->getSalesById($id);
			$data['sales'] = $sales;
			$sales_items = $this->sales_model->getSaleItemById($id);
			$data['sale_items'] = $sales_items;
			// echo '<pre>';
			// print_r($sales_items);exit;
			// $this->load->view('delivery note', $data);
			$html = $this->load->view('delivery note', $data, true);
	 
			//this the the PDF filename that user will get to download
			$pdfFilePath = "output_pdf_name.pdf";
	 
			//load mPDF library
			$this->load->library('m_pdf');
	 
		   //generate the PDF from the given html
			$this->m_pdf->pdf->WriteHTML($html);
	 
			//download it.
			$this->m_pdf->pdf->Output($pdfFilePath, "D");
		}else{
			show_404();
		}
	}
    
    function check_warehouse(){
        if($this->input->post('warehouse_id') == '0'){
            $this->form_validation->set_message('check_warehouse','Please select warehouse.');
            return false;
        }
        return true;
    }
    
    function check_customer(){
        if($this->input->post('customer_id') == '0'){
            $this->form_validation->set_message('check_customer','Please select customer.');
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
    
    function getParts(){
		$id = $this->input->post('part_id');
		$part_details = $this->sales_model->getPartDetail($id);
		echo json_encode($part_details);
	}
    
    function delete_part($id = NULL){
        // echo $id;
        if($this->sales_model->delete_part($id)){
            $this->session->set_flashdata('success','Sale Part deleted successfully.');
            redirect('sales/parts','refresh');
        }
        return false;
    }
}
?>