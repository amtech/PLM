<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Records extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->library('form_validation');
        $this->load->model('records_model');
        $this->load->database();
        $this->load->library('Datatables');
        $this->load->library('upload');
        $this->load->library('Branchname');
    }
    
    function index(){
        $data['records'] = $this->records_model->getRecords();
        // echo '<pre>';
        // print_r($data['records']);exit;
        $meta['page_title'] = 'Records';
        $data['page_title'] = "Records";
        $this->load->view('commons/header',$meta);
        $this->load->view('index',$data);
        $this->load->view('commons/footer');
    }
    
    function view($id){
        $data['records'] = $this->records_model->getRecordById($id);
        $data['products'] = $this->records_model->getProducts();
        $data['customers'] = $this->records_model->getCustomers();
        // echo '<pre>';
        // print_r($data['records']);exit;
        $data['id'] = $id;
        $meta['page_title'] = 'Records';
        $data['page_title'] = "Records";
        $this->load->view('commons/header',$meta);
        $this->load->view('view',$data);
        $this->load->view('commons/footer');
    }
    
    function service_history($id = NULL){
        // echo $id;exit;
        $data['service_history'] = $this->records_model->getServiceHistoryByID($id);
        // echo '<pre>';
        // print_r($data['service_history']);exit;
        $meta['page_title'] = 'View Service History';
        $data['page_title'] = "View Service History";
        $this->load->view('commons/header',$meta);
        $this->load->view('view_service_history',$data);
        $this->load->view('commons/footer');
    }
    
    function parts_history($id = NULL){
        // echo $id;exit;
        $data['parts_history'] = $this->records_model->getPartsHistoryByID($id);
        // echo '<pre>';
        // print_r($data['parts_history']);exit;
        $meta['page_title'] = 'View Parts History';
        $data['page_title'] = "View Parts History";
        $this->load->view('commons/header',$meta);
        $this->load->view('view_parts_history',$data);
        $this->load->view('commons/footer');
    }
    
    function add(){
        // validation for records
        $this->form_validation->set_rules('ro_no','Record Number','trim|required');
        $this->form_validation->set_rules('product_id','Product','trim|required|callback_check_product');
        $this->form_validation->set_rules('customer_id','Product','trim|required|callback_check_customer');
        $this->form_validation->set_rules('report','Report','trim');
        $this->form_validation->set_rules('status','Status','trim');
        
        //warrenty
        $this->form_validation->set_rules('warrenty_type','Warenty Type','trim|required');
        $this->form_validation->set_rules('starting_date','Starting Date','trim|required');
        $this->form_validation->set_rules('duration_months','Duration Months','trim|required');
        $this->form_validation->set_rules('duration_hours','Duration Hours','trim|required');
        $this->form_validation->set_rules('expiry_date','Expiry Date','trim|required');
        
        //Technical Data
        $this->form_validation->set_rules('manufacture1','Manufacture','trim');
        $this->form_validation->set_rules('manufacture2','Manufacture','trim');
        $this->form_validation->set_rules('manufacture3','Manufacture','trim');
        $this->form_validation->set_rules('manufacture4','Manufacture','trim');
        $this->form_validation->set_rules('manufacture5','Manufacture','trim');
        
        $this->form_validation->set_rules('model1','Model','trim');
        $this->form_validation->set_rules('model2','Model','trim');
        $this->form_validation->set_rules('model3','Model','trim');
        $this->form_validation->set_rules('model4','Model','trim');
        $this->form_validation->set_rules('model5','Model','trim');
        
        $this->form_validation->set_rules('serial_no1','Serial','trim');
        $this->form_validation->set_rules('serial_no2','Serial','trim');
        $this->form_validation->set_rules('serial_no3','Serial','trim');
        $this->form_validation->set_rules('serial_no4','Serial','trim');
        $this->form_validation->set_rules('serial_no5','Serial','trim');
        
        $this->form_validation->set_rules('manufacture_date1','Manufacture Date','trim');
        $this->form_validation->set_rules('manufacture_date2','Manufacture Date','trim');
        $this->form_validation->set_rules('manufacture_date3','Manufacture Date','trim');
        $this->form_validation->set_rules('manufacture_date4','Manufacture Date','trim');
        $this->form_validation->set_rules('manufacture_date5','Manufacture Date','trim');
		
		// commissioning_report
		$this->form_validation->set_rules('commission_date','Commission Date','required|trim');
		$this->form_validation->set_rules('technician_name','Technician Name','required|trim');
		$this->form_validation->set_rules('report_no','Report Number','required|trim');
        
        if($this->form_validation->run() == true){
            $del_date = explode('/',$this->input->post('delivery_date'));
            $original_del_date = $del_date[2].'-'.$del_date[1].'-'.$del_date[0];
            if($this->input->post('commission_date') == ''){
				
			}else{
				$com_date = explode('/',$this->input->post('commission_date'));
				$original_com_date = $com_date[2].'-'.$com_date[1].'-'.$com_date[0];
			}
			
			$count = $this->db->from('records');
            $query = $this->db->get();
            $rowcount = $query->num_rows();
            if($rowcount == 0)
            {
                $rowcount = $rowcount + 1;
            }
            
            if($_FILES['commission_report']['size'] > 0)
			{
                $ext1 = end(explode(".", $_FILES['commission_report']['name']));
                $file_name = "commission-".$rowcount.".".$ext1;
                $image_path = realpath(APPPATH."../assets/uploads/commissions/");
                $config1 = array(
				'upload_path' => $image_path,
				'allowed_types' => "gif|jpg|png|jpeg",
				'overwrite' => TRUE,
				'file_name' => $file_name
				);
                // echo '<pre>';
                // print_r($config1);
                $this->upload->initialize($config1);
                if($this->upload->do_upload('commission_report'))
				{
					$data1 = array('commission_report' => $this->upload->data());
                }
				else
				{
                    // echo '<pre>';    
					$error = array('error' => $this->upload->display_errors());
                    // print_r($error);
					$this->load->view('add', $error);
				}
            }
            else
            {
                $data1['commission_report']['file_name'] = "";
            }
            
            if($_FILES['delivery_note']['size'] > 0)
			{
                $ext2 = end(explode(".", $_FILES['delivery_note']['name']));
                $file_name1 = "delivery_note-".$rowcount.".".$ext2;
                $image_path1 = realpath(APPPATH."../assets/uploads/delivery_notes/");
                $config2 = array(
				'upload_path' => $image_path1,
				'allowed_types' => "gif|jpg|png|jpeg",
				'overwrite' => TRUE,
				'file_name' => $file_name1
				);
                $this->upload->initialize($config2);
                if($this->upload->do_upload('delivery_note'))
				{
					$data2 = array('delivery_note' => $this->upload->data());
                }
				else
				{
                    // echo '<pre>';    
					$error = array('error' => $this->upload->display_errors());
                    // print_r($error);
					$this->load->view('add', $error);
				}
            }
            else
            {
                $data2['delivery_note']['file_name'] = "";
            }
			
            $dataRecord = array(
                'ro_no'             	=> $this->input->post('ro_no'),
                'product_id'        	=> $this->input->post('product_id'),
                'brand_id'        		=> $this->input->post('brand_id'),
                'customer_id'       	=> $this->input->post('customer_id'),
                'delivery_date'     	=> $original_del_date,
                'report'            	=> $this->input->post('report'),
                'status'            	=> $this->input->post('status'),
				'commission_date'		=> $original_com_date,
				'technician_name'		=> $this->input->post('technician_name'),
				'report_no'				=> $this->input->post('report_no'),
				'commission_report'  	=> $data1['commission_report']['file_name'],
                'delivery_note'         => $data2['delivery_note']['file_name'],
                'user_id'           	=> USER_ID,
                'user_name'         	=> USER_NAME,
                'creation_time'     	=> date('Y-m-d H:m:s'),
            );
            
            // echo '<pre>';
            // print_r($dataRecord);exit;
            
            $start_date = explode('/',$this->input->post('starting_date'));
            $original_start_date = $start_date[2].'-'.$start_date[1].'-'.$start_date[0];
            
            $expiry_date = explode('/',$this->input->post('expiry_date'));
            $original_expiry_date = $expiry_date[2].'-'.$expiry_date[1].'-'.$expiry_date[0];
            
            $dataWarrenty = array(
                'warranty_type'     => $this->input->post('warrenty_type'),
                'starting_date'     => $original_start_date,
                'duration_months'   => $this->input->post('duration_months'),   
                'duration_hours'    => $this->input->post('duration_hours'),    
                'expiry_date'       => $original_expiry_date,
                'creation_time'     => date('Y-m-d H:m:s'),
            );
            
            // print_r($dataWarrenty);exit;
            for($i=1;$i<=5;$i++){
            	$original_manu_date = '';
            	if($this->input->post('manufacture_date'.$i) == "" || $this->input->post('manufacture_date'.$i) == NULL){
            		$original_manu_date == '0000-00-00';
            	}else{
                	$manu_date = explode('/',$this->input->post('manufacture_date'.$i));
                	$original_manu_date = $manu_date[2].'-'.$manu_date[1].'-'.$manu_date[0];
                }
                
                $dataTechnical = array(
                    'feature_decscription'      => $this->input->post('description'.$i),
                    'manufacture'               => $this->input->post('manufacture'.$i),
                    'model'                     => $this->input->post('model'.$i),
                    'serial_number'             => $this->input->post('serial_no'.$i),
                    'date_of_manufacture'       => $original_manu_date,
                    'creation_time'             => date('Y-m-d H:m:s'),
                );
                $items[] = $dataTechnical;
            }
			// print_r($items);exit;
        }
        if(($this->form_validation->run() == true) && $this->records_model->addRecord($dataRecord,$dataWarrenty,$items)){
            $this->session->set_flashdata('success','Record created successfully.');
            redirect('records','refresh');
        }else{
            $branch = $this->records_model->getBranchCode(DEFAULT_BRANCH);
            $rowID = $this->records_model->getRowId();
            $last_id = $rowID;
            $rest = substr("$last_id", -4);  
            $insert_id = "$rest" + 1;
            $ars = sprintf("%04d", $insert_id);
            $ro_no = 'R'.date('y').$branch->branch_code.$ars;
            $data['ro_no'] = array('name' => 'ro_no',
				'id' => 'ro_no',
				'type' => 'text',
                'class'=> 'form-control',
				'value' => $this->form_validation->set_value('ro_no',$ro_no),
			);
            
            $data['brand'] = $this->records_model->getBrands();
            $data['errors'] = $this->form_validation->error_array();
            $data['products'] = $this->records_model->getProducts();
            $data['customers'] = $this->records_model->getCustomers();
            $meta['page_title'] = 'Add Records';
            $data['page_title'] = "Add Records";
            $this->load->view('commons/header',$meta);
            $this->load->view('add',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function edit($id){
        // validation for records
        $this->form_validation->set_rules('ro_no','Record Number','trim|required');
        $this->form_validation->set_rules('product_id','Product','trim|required|callback_check_product');
        $this->form_validation->set_rules('customer_id','Product','trim|required|callback_check_customer');
        $this->form_validation->set_rules('report','Report','trim');
        $this->form_validation->set_rules('status','Status','trim');
        
        //warrenty
        $this->form_validation->set_rules('warrenty_type','Warenty Type','trim|required');
        $this->form_validation->set_rules('starting_date','Starting Date','trim|required');
        $this->form_validation->set_rules('duration_months','Duration Months','trim|required');
        $this->form_validation->set_rules('duration_hours','Duration Hours','trim|required');
        $this->form_validation->set_rules('expiry_date','Expiry Date','trim|required');
        
        //Technical Data
        $this->form_validation->set_rules('manufacture1','Manufacture','trim');
        $this->form_validation->set_rules('manufacture2','Manufacture','trim');
        $this->form_validation->set_rules('manufacture3','Manufacture','trim');
        $this->form_validation->set_rules('manufacture4','Manufacture','trim');
        $this->form_validation->set_rules('manufacture5','Manufacture','trim');
        
        $this->form_validation->set_rules('model1','Model','trim');
        $this->form_validation->set_rules('model2','Model','trim');
        $this->form_validation->set_rules('model3','Model','trim');
        $this->form_validation->set_rules('model4','Model','trim');
        $this->form_validation->set_rules('model5','Model','trim');
        
        $this->form_validation->set_rules('serial_no1','Serial','trim');
        $this->form_validation->set_rules('serial_no2','Serial','trim');
        $this->form_validation->set_rules('serial_no3','Serial','trim');
        $this->form_validation->set_rules('serial_no4','Serial','trim');
        $this->form_validation->set_rules('serial_no5','Serial','trim');
        
        $this->form_validation->set_rules('manufacture_date1','Manufacture Date','trim');
        $this->form_validation->set_rules('manufacture_date2','Manufacture Date','trim');
        $this->form_validation->set_rules('manufacture_date3','Manufacture Date','trim');
        $this->form_validation->set_rules('manufacture_date4','Manufacture Date','trim');
        $this->form_validation->set_rules('manufacture_date5','Manufacture Date','trim');
        
        if($this->form_validation->run() == true){
            $del_date = explode('/',$this->input->post('delivery_date'));
            $original_del_date = $del_date[2].'-'.$del_date[1].'-'.$del_date[0];
            
            if($this->input->post('commission_date') == ''){
				
			}else{
				$com_date = explode('/',$this->input->post('commission_date'));
				$original_com_date = $com_date[2].'-'.$com_date[1].'-'.$com_date[0];
			}
			
			if($_FILES['commission_report']['size'] > 0)
			{
                $ext1 = end(explode(".", $_FILES['commission_report']['name']));
                $file_name = "commission-".$id.".".$ext1;
                $image_path = realpath(APPPATH."../assets/uploads/commissions/");
                $config1 = array(
				'upload_path' => $image_path,
				'allowed_types' => "gif|jpg|png|jpeg",
				'overwrite' => TRUE,
				'file_name' => $file_name
				);
                // echo '<pre>';
                // print_r($config1);
                $this->upload->initialize($config1);
                if($this->upload->do_upload('commission_report'))
				{
					$data1 = array('commission_report' => $this->upload->data());
                }
				else
				{
                    // echo '<pre>';    
					$error = array('error' => $this->upload->display_errors());
                    // print_r($error);
					$this->load->view('add', $error);
				}
            }
            else
            {
                $data1['commission_report']['file_name'] = $this->input->post('c_report');
            }
            
            if($_FILES['delivery_note']['size'] > 0)
			{
                $ext2 = end(explode(".", $_FILES['delivery_note']['name']));
                $file_name1 = "delivery_note-".$id.".".$ext2;
                $image_path1 = realpath(APPPATH."../assets/uploads/delivery_notes/");
                $config2 = array(
				'upload_path' => $image_path1,
				'allowed_types' => "gif|jpg|png|jpeg",
				'overwrite' => TRUE,
				'file_name' => $file_name1
				);
                $this->upload->initialize($config2);
                if($this->upload->do_upload('delivery_note'))
				{
					$data2 = array('delivery_note' => $this->upload->data());
                }
				else
				{
                    // echo '<pre>';    
					$error = array('error' => $this->upload->display_errors());
                    // print_r($error);
					$this->load->view('add', $error);
				}
            }
            else
            {
                $data2['delivery_note']['file_name'] = $this->input->post('c_delivery');;
            }
			
            $dataRecord = array(
                'ro_no'             	=> $this->input->post('ro_no'),
                'product_id'        	=> $this->input->post('product_id'),
				'brand_id'        		=> $this->input->post('brand_id'),
                'customer_id'      	 	=> $this->input->post('customer_id'),
                'delivery_date'     	=> $original_del_date,
                'report'            	=> $this->input->post('report'),
                'status'            	=> $this->input->post('status'),
				'commission_date'		=> $original_com_date,
				'technician_name'		=> $this->input->post('technician_name'),
				'report_no'				=> $this->input->post('report_no'),
				'commission_report'  	=> $data1['commission_report']['file_name'],
                'delivery_note'         => $data2['delivery_note']['file_name'],
                'user_id'           	=> USER_ID,
                'user_name'         	=> USER_NAME,
                'creation_time'     	=> date('Y-m-d H:m:s'),
            );
            
            // echo '<pre>';
            // print_r($dataRecord);exit;
            
            $start_date = explode('/',$this->input->post('starting_date'));
            $original_start_date = $start_date[2].'-'.$start_date[1].'-'.$start_date[0];
            
            $expiry_date = explode('/',$this->input->post('expiry_date'));
            $original_expiry_date = $expiry_date[2].'-'.$expiry_date[1].'-'.$expiry_date[0];
            
            $dataWarrenty = array(
                'warranty_type'     => $this->input->post('warrenty_type'),
                'starting_date'     => $original_start_date,
                'duration_months'   => $this->input->post('duration_months'),   
                'duration_hours'    => $this->input->post('duration_hours'),    
                'expiry_date'       => $original_expiry_date,
                'updation_time'     => date('Y-m-d H:m:s'),
            );
            
            // print_r($dataWarrenty);exit;
            for($i=1;$i<=5;$i++){
				$original_manu_date = '';
				if($this->input->post('manufacture_date'.$i) == ''){
					
				}else{
					$manu_date = explode('/',$this->input->post('manufacture_date'.$i));
					$original_manu_date = $manu_date[2].'-'.$manu_date[1].'-'.$manu_date[0];
				}
                
                $dataTechnical = array(
                    'feature_decscription'      => $this->input->post('description'.$i),
                    'manufacture'               => $this->input->post('manufacture'.$i),
                    'model'                     => $this->input->post('model'.$i),
                    'serial_number'             => $this->input->post('serial_no'.$i),
                    'date_of_manufacture'       => $original_manu_date,
                    'updation_time'             => date('Y-m-d H:m:s'),
                );
                $items[] = $dataTechnical;
            }
        }
        if(($this->form_validation->run() == true) && $this->records_model->editRecord($dataRecord,$dataWarrenty,$items,$id)){
            $this->session->set_flashdata('success','Record updated successfully.');
            redirect('records','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
			$data['brand'] = $this->records_model->getBrands();
            $data['products'] = $this->records_model->getProducts();
            $data['customers'] = $this->records_model->getCustomers();
            $data['records'] = $this->records_model->getRecordById($id);
            // echo '<pre>';
            // print_r($data['records'][0]->ro_no);exit;
            $data['ro_no'] = array('name' => 'ro_no',
				'id' => 'ro_no',
				'type' => 'text',
                'class'=> 'form-control',
				'value' => $this->form_validation->set_value('ro_no',$data['records'][0]->ro_no),
			);
            $data['id'] = $id;
            // echo '<pre>';
            // print_r($data['record']);exit;
            $meta['page_title'] = 'Edit Records';
            $data['page_title'] = "Edit Records";
            $this->load->view('commons/header',$meta);
            $this->load->view('edit',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function delete($id){
        // echo $id;
        if($this->records_model->delete($id)){
            $this->session->set_flashdata('success','Record deleted successfully.');
            redirect('records','refresh');
        }
        return false;
    }
    
    function commissions(){
        $data['commission'] = $this->records_model->getCommission();
        $meta['page_title'] = 'Commissioning Reports';
        $data['page_title'] = "Commissioning Reports";
        $this->load->view('commons/header',$meta);
        $this->load->view('commissions',$data);
        $this->load->view('commons/footer');
    }
    
    function completed(){
        $data['commission'] = $this->records_model->getCompletedCommission();
        $meta['page_title'] = 'Completed Commissioning Reports';
        $data['page_title'] = "Completed Commissioning Reports";
        $this->load->view('commons/header',$meta);
        $this->load->view('completed',$data);
        $this->load->view('commons/footer');
    }
    
    function pending(){
        $data['commission'] = $this->records_model->getPendingCommission();
        $meta['page_title'] = 'Pending Commissioning Reports';
        $data['page_title'] = "Pending Commissioning Reports";
        $this->load->view('commons/header',$meta);
        $this->load->view('pending',$data);
        $this->load->view('commons/footer');
    }
    
    function view_commission($id){
        $data['records'] = $this->records_model->getRecordsWithCommission();
        $data['technician'] = $this->records_model->getTechnician();
        $data['commission'] = $this->records_model->getCommissionByID($id);
        $meta['page_title'] = 'View Commissioning Reports';
        $data['page_title'] = "View Commissioning Reports";
        $this->load->view('commons/header',$meta);
        $this->load->view('view_commission',$data);
        $this->load->view('commons/footer');
    }
    
    function add_commission(){
        // validation for commission report
        $this->form_validation->set_rules('date','Commission Date','trim|required');
        $this->form_validation->set_rules('record_id','Record','trim|required|callback_check_record');
        $this->form_validation->set_rules('technician_id','Technician','trim');
        $this->form_validation->set_rules('report_no','Report No','trim|required');
        $this->form_validation->set_rules('commission_report','Commission Report','trim');
        $this->form_validation->set_rules('delivery_note','Delivery Note','trim');
        
        if($this->form_validation->run() == true){
            $count = $this->db->from('commission');
            $query = $this->db->get();
            $rowcount = $query->num_rows();
            if($rowcount == 0)
            {
                $rowcount = $rowcount + 1;
            }
            
            if($_FILES['commission_report']['size'] > 0)
			{
                $ext1 = end(explode(".", $_FILES['commission_report']['name']));
                $file_name = "commission-".$rowcount.".".$ext1;
                $image_path = realpath(APPPATH."../assets/uploads/commissions/");
                $config1 = array(
				'upload_path' => $image_path,
				'allowed_types' => "gif|jpg|png|jpeg",
				'overwrite' => TRUE,
				'file_name' => $file_name
				);
                // echo '<pre>';
                // print_r($config1);
                $this->upload->initialize($config1);
                if($this->upload->do_upload('commission_report'))
				{
					$data1 = array('commission_report' => $this->upload->data());
                }
				else
				{
                    // echo '<pre>';    
					$error = array('error' => $this->upload->display_errors());
                    // print_r($error);
					$this->load->view('add', $error);
				}
            }
            else
            {
                $data1['commission_report']['file_name'] = "";
            }
            
            if($_FILES['delivery_note']['size'] > 0)
			{
                $ext2 = end(explode(".", $_FILES['delivery_note']['name']));
                $file_name1 = "delivery_note-".$rowcount.".".$ext2;
                $image_path1 = realpath(APPPATH."../assets/uploads/delivery_notes/");
                $config2 = array(
				'upload_path' => $image_path1,
				'allowed_types' => "gif|jpg|png|jpeg",
				'overwrite' => TRUE,
				'file_name' => $file_name1
				);
                $this->upload->initialize($config2);
                if($this->upload->do_upload('delivery_note'))
				{
					$data2 = array('delivery_note' => $this->upload->data());
                }
				else
				{
                    // echo '<pre>';    
					$error = array('error' => $this->upload->display_errors());
                    // print_r($error);
					$this->load->view('add', $error);
				}
            }
            else
            {
                $data2['delivery_note']['file_name'] = "";
            }
            $date = explode('/',$this->input->post('date'));
            $commission_date = $date[2].'-'.$date[1].'-'.$date[0];
            $dataCommission = array(
                'commission_date'       => $commission_date,
                'record_id'             => $this->input->post('record_id'),
                'technician_name'       => $this->input->post('technician_name'),
                'report_no'             => $this->input->post('report_no'),   
                'commissioning_report'  => $data1['commission_report']['file_name'],
                'delivery_note'         => $data2['delivery_note']['file_name']
            );
            
            // echo '<pre>';
            // print_r($dataCommission);exit;
        }
        
        if(($this->form_validation->run() == true) && $this->records_model->addCommission($dataCommission)){
            $this->session->set_flashdata('success','Commissioning Report added successfully.');
            redirect('records/commissions','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['records'] = $this->records_model->getRecordsWithCommission();
            // $data['technician'] = $this->records_model->getTechnician();
            $meta['page_title'] = 'Add Commission';
            $data['page_title'] = "Add Commission";
            $this->load->view('commons/header',$meta);
            $this->load->view('add_commission',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function edit_commission($id = NULL){
        // validation for commission report
        $this->form_validation->set_rules('date','Commission Date','trim|required');
        $this->form_validation->set_rules('record_id','Record','trim|required|callback_check_record');
        $this->form_validation->set_rules('technician_id','Technician','trim');
        $this->form_validation->set_rules('report_no','Report No','trim|required');
        $this->form_validation->set_rules('commission_report','Commission Report','trim');
        $this->form_validation->set_rules('delivery_note','Delivery Note','trim');
        
        if($this->form_validation->run() == true){
            if($_FILES['commission_report']['size'] > 0)
			{
                $ext1 = end(explode(".", $_FILES['commission_report']['name']));
                $file_name = "commission-".$id.".".$ext1;
                $image_path = realpath(APPPATH."../assets/uploads/commissions/");
                $config1 = array(
				'upload_path' => $image_path,
				'allowed_types' => "gif|jpg|png|jpeg",
				'overwrite' => TRUE,
				'file_name' => $file_name
				);
                // echo '<pre>';
                // print_r($config1);
                $this->upload->initialize($config1);
                if($this->upload->do_upload('commission_report'))
				{
					$data1 = array('commission_report' => $this->upload->data());
                }
				else
				{
                    // echo '<pre>';    
					$error = array('error' => $this->upload->display_errors());
                    // print_r($error);
					$this->load->view('add', $error);
				}
            }
            else
            {
                $data1['commission_report']['file_name'] = $this->input->post('c_report');
            }
            
            if($_FILES['delivery_note']['size'] > 0)
			{
                $ext2 = end(explode(".", $_FILES['delivery_note']['name']));
                $file_name1 = "delivery_note-".$id.".".$ext2;
                $image_path1 = realpath(APPPATH."../assets/uploads/delivery_notes/");
                $config2 = array(
				'upload_path' => $image_path1,
				'allowed_types' => "gif|jpg|png|jpeg",
				'overwrite' => TRUE,
				'file_name' => $file_name1
				);
                $this->upload->initialize($config2);
                if($this->upload->do_upload('delivery_note'))
				{
					$data2 = array('delivery_note' => $this->upload->data());
                }
				else
				{
                    // echo '<pre>';    
					$error = array('error' => $this->upload->display_errors());
                    // print_r($error);
					$this->load->view('add', $error);
				}
            }
            else
            {
                $data2['delivery_note']['file_name'] = $this->input->post('c_delivery');;
            }
            $date = explode('/',$this->input->post('date'));
            $commission_date = $date[2].'-'.$date[1].'-'.$date[0];
            
            $dataCommission = array(
                'commission_date'       => $commission_date,
                'record_id'             => $this->input->post('record_id'),
                'technician_name'       => $this->input->post('technician_name'),
                'report_no'             => $this->input->post('report_no'),   
                'commissioning_report'  => $data1['commission_report']['file_name'],
                'delivery_note'         => $data2['delivery_note']['file_name']
            );
            
            // echo '<pre>';
            // print_r($dataCommission);exit;
        }
        
        if(($this->form_validation->run() == true) && $this->records_model->editCommission($dataCommission,$id)){
            $this->session->set_flashdata('success','Commissioning Report edited successfully.');
            redirect('records/commissions','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['records'] = $this->records_model->getRecordsWithCommission();
            // $data['technician'] = $this->records_model->getTechnician();
            $data['commission'] = $this->records_model->getCommissionByID($id);
            // echo '<pre>';
            // print_r($data['commission']);exit;
            $data['id'] = $id;
            $meta['page_title'] = 'Edit Commission';
            $data['page_title'] = "Edit Commission";
            $this->load->view('commons/header',$meta);
            $this->load->view('edit_commission',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function check_product(){
        if($this->input->post('product_id') == '0'){
            $this->form_validation->set_message('check_product','Please select product.');
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
    
    function getTechnician(){
        $record_id = $this->input->post('record_id');
        $tech = $this->records_model->getTechnician($record_id);
        echo json_encode($tech);
    }
    
    function check_record(){
        if($this->input->post('record_id') == '0'){
            $this->form_validation->set_message('check_record','Please select Record.');
            return false;
        }
        return true;
    }
    
    function delete_commission($id){
        if($this->records_model->delete_commission($id)){
            $this->session->set_flashdata('success','Commissioning Report deleted successfully.');
            redirect('records/commissions','refresh');
        }
        return false;
    }
    
    function getProducts(){
        if($this->input->post('id')){
            $brand_id = $this->input->post('id');
            $data = $this->records_model->getProductsByBrand($brand_id);
            echo json_encode($data);
        }
    }
}
?>