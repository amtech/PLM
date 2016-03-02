<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Quotations extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->library('form_validation');
        $this->load->model('quotations_model');
        $this->load->database();
        $this->load->library('Datatables');
        $this->load->library('Branchname');
        $this->load->library('encrypt');
    }
    
    function index(){
        $data['quotations'] = $this->quotations_model->getQuotes();
        // echo '<pre>';
        // print_r($data['quotations']);exit;
        $meta['page_title'] = 'Quotations Details';
        $data['page_title'] = "Quotations Details";
        $this->load->view('commons/header',$meta);
        $this->load->view('index',$data);
        $this->load->view('commons/footer');
    }
    
    function view($id = NULL){
        // echo $id;
        $quotation = $this->quotations_model->getQuotationById($id);
        $data['quotation'] = $quotation;
        $data['quotation_items'] = $this->quotations_model->getQuoteItemsByID($id);
        // echo '<pre>';
        // print_r($data['quotation_items']);exit;
        $meta['page_title'] = 'View Quotation';
        $data['page_title'] = "View Quotation";
        $this->load->view('commons/header',$meta);
        $this->load->view('view',$data);
        $this->load->view('commons/footer');
    }
    
    function view_revised_quotation($id = NULL){
        // echo $id;
        $data['quotation'] = $this->quotations_model->getRevisedQuotationById($id);
        // echo '<pre>';
        // print_r($data['quotation']);exit;
        $meta['page_title'] = 'View Revised Quotation '.$id;
        $data['page_title'] = "View Revised Quotation ".$id;
        $this->load->view('commons/header',$meta);
        $this->load->view('view_revised_quotes',$data);
        $this->load->view('commons/footer');
    }
    
    function add(){
        // validation for quotations
        $this->form_validation->set_rules('branch_id','Branch','trim|required|callback_check_branch');
        $this->form_validation->set_rules('quotation_date','Quotation Date','trim|required');
        $this->form_validation->set_rules('validity','Validity','trim|required');
        $this->form_validation->set_rules('customer_id','Customer','trim|required|callback_check_customer');
        $this->form_validation->set_rules('delivery_place','Delivery Place','trim');
        
        if($this->form_validation->run() == true){
            $q_date = $this->input->post('quotation_date');
            $q_date1 = explode('/',$q_date);
			$q_date_real = $q_date1[2].'-'.$q_date1[1].'-'.$q_date1[0];
            
            // $exp_date = explode('/',$this->input->post('expected_del_time'));
            // print_r($exp_date);
            // $exp_date_real = $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];
            $dataQuotation = array(
                'qo_no'             => $this->input->post('qo_no'),
                'branch_id'         => $this->input->post('branch_id'),
                'quotation_date'    => $q_date_real,
                'customer_id'       => $this->input->post('customer_id'),
                'validity'          => $this->input->post('validity'),
                'expected_time'     => $this->input->post('expected_del_time'),
                'delivery_place'    => $this->input->post('delivery_place'),
                'payment_terms'    	=> $this->input->post('payment_terms'),
                'machine_name'    	=> $this->input->post('machine_name'),
                'comment'           => $this->input->post('comment'),
                'charges'           => $this->input->post('charges'),
                'freight'           => $this->input->post('freight_charges'),
                'total'             => $this->input->post('grand_total'),
                'internal_note'     => $this->input->post('note'),
                'user'              =>  USER_ID,
                'creation_time'     => date('Y-m-d H:m:s'),
            );
            
            // echo '<pre>';
            // print_r($dataQuotation);exit;
            $noOfDetails = $this->input->post('seq');
            $partDetails = explode(',',$noOfDetails);
            
            foreach($partDetails as $i){
				$del_date = $this->input->post('delivery_date'.$i);
				$del_date1 = explode('/',$del_date);
				$del_date_real = $del_date1[2].'-'.$del_date1[1].'-'.$del_date1[0];
                //array of dataPartItems
				$dataPartItems = array(
                    'part_id'			=> $this->input->post("parts_product_id".$i),
                    'description'   	=> $this->input->post("description".$i),
					'quantity'		    => $this->input->post("quantity".$i),
					'price'			    => $this->input->post("unit_price".$i),
					'discount_type'	    => $this->input->post("discount_amount".$i),
                    'discount_value'    => $this->input->post('disc_value'.$i),
                    'total_price'       => $this->input->post('total_price_hidden'.$i),
					'repair_charge'		=> $this->input->post("repair_charge".$i),
					'delivery_date'		=> $del_date_real,
					'sub_total'			=> $this->input->post("sub_total".$i),
					'creation_time'		=> date('Y-m-d H:m:s'),
				);
				$items[] = $dataPartItems;
            }
            // echo '<pre>';
            // print_r($items);exit;
        }
        
        if(($this->form_validation->run() == true) && $this->quotations_model->addQuotations($dataQuotation, $items)){
            $this->session->set_flashdata('success','Quotation added successfully.');
            redirect('quotations','refresh');
        }else{
            $branch = $this->quotations_model->getBranchCode(DEFAULT_BRANCH);
            $rowID = $this->quotations_model->getRowId();
            $last_id = $rowID;
            $rest = substr("$last_id", -4);  
            $insert_id = "$rest" + 1;
            $ars = sprintf("%04d", $insert_id);
            $qo_no = (QUOTATION_PREFIX).date('y').$branch->branch_code.$ars;
            $data['qo_no'] = array('name' => 'qo_no',
				'id' => 'qo_no',
				'type' => 'text',
                'class'=> 'form-control',
				'value' => $this->form_validation->set_value('qo_no',$qo_no),
			);
            $data['errors'] = $this->form_validation->error_array();
            $data['discount'] = $this->quotations_model->getDiscount();
            $data['parts'] = $this->quotations_model->getParts();
            $data['branch'] = $this->quotations_model->getBranch();
            $data['customers'] = $this->quotations_model->getCustomers();
            $meta['page_title'] = 'Add Quotations';
            $data['page_title'] = "Add Quotations";
            $this->load->view('commons/header',$meta);
            $this->load->view('add',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function edit($id = NULL){
        // validation for quotations
        $this->form_validation->set_rules('branch_id','Branch','trim|required|callback_check_branch');
        $this->form_validation->set_rules('quotation_date','Quotation Date','trim|required');
        $this->form_validation->set_rules('validity','Validity','trim|required');
        $this->form_validation->set_rules('customer_id','Customer','trim|required|callback_check_customer');
		$this->form_validation->set_rules('delivery_place','Delivery Place','trim');
        
        if($this->form_validation->run() == true){
            $q_date = $this->input->post('quotation_date');
            $q_date1 = explode('/',$q_date);
			$q_date_real = $q_date1[2].'-'.$q_date1[1].'-'.$q_date1[0];
            
            // $exp_date = explode('/',$this->input->post('expected_del_time'));
            // print_r($exp_date);
            // $exp_date_real = $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];
            
            $dataQuotation = array(
                'quotation_id'      =>  $id,
                'qo_no'             =>  $this->input->post('qo_no'),
                'branch_id'         => $this->input->post('branch_id'),
                'quotation_date'    => $q_date_real,
                'customer_id'       => $this->input->post('customer_id'),
                'validity'          => $this->input->post('validity'),
                'expected_time'     => $this->input->post('expected_del_time'),
				'delivery_place'    => $this->input->post('delivery_place'),
                'comment'           => $this->input->post('comment'),
                'charges'           => $this->input->post('charges'),
				'freight'           => $this->input->post('freight_charges'),
                'total'             => $this->input->post('grand_total'),
                'internal_note'     => $this->input->post('note'),
                'status'            => $this->input->post('status'),
                'user'              =>  USER_ID,
                'updation_time'     => date('Y-m-d H:m:s'),
            );
            
            // echo '<pre>';
            // print_r($dataQuotation);exit;
            $noOfDetails = $this->input->post('seq');
            $partDetails = explode(',',$noOfDetails);
            
            foreach($partDetails as $i){
				$del_date = $this->input->post('delivery_date'.$i);
				$del_date1 = explode('/',$del_date);
				$del_date_real = $del_date1[2].'-'.$del_date1[1].'-'.$del_date1[0];
                //array of dataPartItems
				$dataPartItems = array(
                    'part_id'			=> $this->input->post("parts_product_id".$i),
                    'description'   	=> $this->input->post("description".$i),
					'quantity'		    => $this->input->post("quantity".$i),
					'price'			    => $this->input->post("unit_price".$i),
					'discount_type'	    => $this->input->post("discount_amount".$i),
                    'discount_value'    => $this->input->post('disc_value'.$i),
                    'total_price'       => $this->input->post('total_price_hidden'.$i),
					'repair_charge'		=> $this->input->post("repair_charge".$i),
					'delivery_date'		=> $del_date_real,
					'sub_total'			=> $this->input->post("sub_total".$i),
					'updation_time'		=> date('Y-m-d H:m:s'),
				);
				$items[] = $dataPartItems;
            }
            // echo '<pre>';
            // print_r($items);exit;
        }
        
        if(($this->form_validation->run() == true) && $this->quotations_model->editQuote($dataQuotation,$items,$id)){
            $this->session->set_flashdata('success','Quotation edited successfully.');
            redirect('quotations','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['discount'] = $this->quotations_model->getDiscount();
            $data['parts'] = $this->quotations_model->getParts();
            $data['branch'] = $this->quotations_model->getBranch();
            $data['customers'] = $this->quotations_model->getCustomers();
            $quotation = $this->quotations_model->getQuotationById($id);
            $data['quotation'] = $quotation;
            $data['quotation_items'] = $this->quotations_model->getQuoteItemsByID($quotation->id);
            // echo '<pre>';
            // print_r($data['quotation_items']);exit;
            
            $data['qo_no'] = array('name' => 'qo_no',
				'id' => 'qo_no',
				'type' => 'text',
                'class'=> 'form-control',
				'value' => $this->form_validation->set_value('qo_no',$quotation->qo_no),
			);
            $count = 1;
            foreach($data['quotation_items'] as $row){
                $count = $count+1;
            }
            $data['seq_row'] = $count;
            $data['id'] = $id;
            $meta['page_title'] = 'Edit Quotations';
            $data['page_title'] = "Edit Quotations";
            $this->load->view('commons/header',$meta);
            $this->load->view('edit',$data);
            $this->load->view('commons/footer');
        }
    }
    
    // delete quotation
    function delete($id = NULL){
        if($this->quotations_model->delete($id)){
            $this->session->set_flashdata('success','Quotation deleted successfully.');
            redirect('quotations','refresh');
        }
    }
    
    function add_customer(){
        //set validation rules
        $this->form_validation->set_rules('branch_id', 'Branch', 'trim|required|callback_check_branch');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('telephone', 'Telephone', 'trim');
        $this->form_validation->set_rules('fax', 'Fax', 'trim');
        $this->form_validation->set_rules('email', 'Emaid ID', 'trim|required|valid_email');
        $this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|required');
        $this->form_validation->set_rules('title', 'Title', 'trim');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
        
        //run validation check
        if ($this->form_validation->run() == true)
        {   
            //get the form data
            $dataCustomer = array(
                'branch_id'         => $this->input->post('branch_id'),
                'name'              => $this->input->post('name'),
                'address'           => $this->input->post('address'),
                'city'              => $this->input->post('city'),
                'country'           => $this->input->post('country'),
                'telephone'         => $this->input->post('telephone'),
                'fax'               => $this->input->post('fax'),
                'email'             => $this->input->post('email'),
                'contact_person'    => $this->input->post('contact_person'),
                'title'             => $this->input->post('title'),
                'mobile'            => $this->input->post('mobile'),
                'creation_time'     => date('Y-m-d H:m:s')
            );
        }

        if(($this->form_validation->run() == true) && $this->quotations_model->addCustomer($dataCustomer)){
            // $this->session->set_flashdata('success','Customer added successfully.');
            echo 'YES';
        }else{
            //validation fails
            echo validation_errors();
        }
    }
	
	function pdf($id = NULl){
		if(is_numeric($id)){
			$quotation = $this->quotations_model->getQuotationById($id);
			$data['quotation'] = $quotation;
			$data['quotation_items'] = $this->quotations_model->getQuoteItemsByID($id);
			// echo '<pre>';
			// print_r($data['quotation_items']);exit;
			// $data = [];
			//load the view and saved it into $html variable
			$this->load->view('quotation', $data);
			// $html = $this->load->view('quotation', $data, true);
	 
			// //this the the PDF filename that user will get to download
			// $pdfFilePath = "output_pdf_name.pdf";
	 
			// //load mPDF library
			// $this->load->library('m_pdf');
	 
		   // //generate the PDF from the given html
			// $this->m_pdf->pdf->WriteHTML($html);
	 
			// //download it.
			// $this->m_pdf->pdf->Output($pdfFilePath, "D");
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
    
    function check_customer(){
        if($this->input->post('customer_id') == '0'){
            $this->form_validation->set_message('check_customer','Please select customer.');
            return false;
        }
        return true;
    }
    
    function getParts(){
		$id = $this->input->post('part_id');
		$part_details = $this->quotations_model->getPartDetail($id);
		echo json_encode($part_details);
	}
}
?>