<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Services extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->library('form_validation');
        $this->load->model('services_model');
        $this->load->database();
        $this->load->library('Datatables');
        $this->load->library('upload');
        $this->load->library('Branchname');
    }
    
    function index(){
        $data['services'] = $this->services_model->getServices();
        // echo '<pre>';
        // print_r($data['services']);exit;
        $meta['page_title'] = "Services Details";
        $data['page_title'] = "Services Details";
        $this->load->view('commons/header',$meta);
        $this->load->view('index',$data);
        $this->load->view('commons/footer');
    }
    
    function view($id = NULL){
        $data['parts'] = $this->services_model->getParts();
        $data['records'] = $this->services_model->getRecords();
        $data['technician'] = $this->services_model->getTechnician();
        $data['services'] = $this->services_model->getServiceByID($id);
        $data['service_part'] = $this->services_model->getServicePartByID($id);
        $meta['page_title'] = 'View Service';
        $data['page_title'] = "View Service";
        $this->load->view('commons/header',$meta);
        $this->load->view('view',$data);
        $this->load->view('commons/footer');
    }
    
    function add(){
        // validation for services
        $this->form_validation->set_rules('record_id','Record','trim|required|callback_check_record');
        $this->form_validation->set_rules('service_date','Service Date','trim|required');
        $this->form_validation->set_rules('warranty','Warranty','trim|required|callback_check_warranty');
        $this->form_validation->set_rules('working_hour','Working Hour','trim|required');
        $this->form_validation->set_rules('technician_name','Technician Name','trim|required');
        $this->form_validation->set_rules('service_report_no','Service Report No','trim|required');
        $this->form_validation->set_rules('job_status','Job Status','trim');
        $this->form_validation->set_rules('remark_note','Remark Note','trim');
        $this->form_validation->set_rules('part_needed','Part Needed','trim');
        if (empty($_FILES['service_report']['name']))
        {
            $this->form_validation->set_rules('service_report', 'Service Report', 'required');
        }
        
        if($this->form_validation->run() == true){
            $count = $this->db->from('services');
            $query = $this->db->get();
            $rowcount = $query->num_rows();
            if($rowcount == 0)
            {
                $rowcount = $rowcount + 1;
            }
            
            if($_FILES['service_report']['size'] > 0)
			{
                $ext1 = end(explode(".", $_FILES['service_report']['name']));
                $file_name = "service_report-".$rowcount.".".$ext1;
                $image_path = realpath(APPPATH."../assets/uploads/services/");
                $config1 = array(
				'upload_path' => $image_path,
				'allowed_types' => "gif|jpg|png|jpeg",
				'overwrite' => TRUE,
				'file_name' => $file_name
				);
                // echo '<pre>';
                // print_r($config1);
                $this->upload->initialize($config1);
                if($this->upload->do_upload('service_report'))
				{
					$data1 = array('service_report' => $this->upload->data());
                }
				else
				{
                    // echo '<pre>';    
					$error = array('error' => $this->upload->display_errors());
                    // print_r($error);
					$this->load->view('add', $error);
				}
            }
            
            $s_date = explode('/',$this->input->post('service_date'));
            $original_s_date = $s_date[2].'-'.$s_date[1].'-'.$s_date[0];
            $dataService = array(
                'record_id'             => $this->input->post('record_id'),
                'service_date'          => $original_s_date,
                'warranty'              => $this->input->post('warranty'),
                'working_hour'          => $this->input->post('working_hour'),
                'technician_name'       => $this->input->post('technician_name'),
                'service_report_no'     => $this->input->post('service_report_no'),
                'job_status'            => $this->input->post('job_status'),
                'remark_note'           => $this->input->post('remark_note'),
                'remarks'               => $this->input->post('editor1'),
                'part_needed'           => $this->input->post('part_needed'),
                'parts_total'           => $this->input->post('parts_total'),
                'service_report'        => $data1['service_report']['file_name'],
                'service_charge'        => $this->input->post('service_charge'),
                'total'                 => $this->input->post('total'),
                'user'                  =>  USER_ID,
                'creation_time'         => date('Y-m-d H:m:s'),
            );
            
            // echo '<pre>';
            // print_r($dataService);exit;
            
            $noOfDetails = $this->input->post('seq');
            $partDetails = explode(',',$noOfDetails);
            if(!empty($partDetails)){
                foreach($partDetails as $i){
                    //array of dataPartItems
                    $original_o_date = '';
                    if($this->input->post("order_date".$i) == ''){
                        $original_o_date = '';
                    }else{
                        $o_date = explode('/',$this->input->post("order_date".$i));
                        $original_o_date = $o_date[2].'-'.$o_date[1].'-'.$o_date[0];
                    }
                    $original_a_date = '';
                    if($this->input->post("arrival_date".$i) == ''){
                        $original_a_date = '';
                    }else{
                        $a_date = explode('/',$this->input->post("arrival_date".$i));
                        $original_a_date = $a_date[2].'-'.$a_date[1].'-'.$a_date[0];
                    }
                    $original_d_date = '';
                    if($this->input->post("delivery_date".$i) == ''){
                        $original_d_date = '';
                    }else{
                        $d_date = explode('/',$this->input->post("delivery_date".$i));
                        $original_d_date = $d_date[2].'-'.$d_date[1].'-'.$d_date[0];
                    }
                    
                    $dataPartItems = array(
                        'part_id'			    => $this->input->post("parts_id".$i),
                        'service_record_id'		=> $this->input->post("record_id"),
                        'quantity'		        => $this->input->post("quantity".$i),
                        'price'			        => $this->input->post("price".$i),
                        'supplied_condition'    => $this->input->post("supply_condition".$i),
                        'available_stock'       => $this->input->post("stock_status".$i),
                        'order_date'            => $original_o_date,
                        'estimate_arrival_date' => $original_a_date,
                        'delivery_date'         => $original_d_date,
                        'description'           => $this->input->post("description".$i),
                        'sub_total'			    => $this->input->post("sub_total".$i),
                        'creation_time'		    => date('Y-m-d H:m:s'),
                    );
                    $items[] = $dataPartItems;
                }
            }
            // echo '<pre>';
            // print_r($items);exit;
        }
        
        if(($this->form_validation->run() == true) && $this->services_model->addService($dataService, $items)){
            $this->session->set_flashdata('success','Service added successfully.');
            redirect('services','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['parts'] = $this->services_model->getParts();
            $data['records'] = $this->services_model->getRecords();
            // echo '<pre>';
            // print_r($data['records']);exit;
            // $data['technician'] = $this->services_model->getTechnician();
            $meta['page_title'] = 'Add Service';
            $data['page_title'] = "Add Service";
            $this->load->view('commons/header',$meta);
            $this->load->view('add',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function edit($id = NULL){
        // validation for services
        $this->form_validation->set_rules('record_id','Record','trim|required|callback_check_record');
        $this->form_validation->set_rules('service_date','Service Date','trim|required');
        $this->form_validation->set_rules('warranty','Warranty','trim|required|callback_check_warranty');
        $this->form_validation->set_rules('working_hour','Working Hour','trim|required');
        $this->form_validation->set_rules('technician_name','Technician Name','trim|required');
        $this->form_validation->set_rules('service_report_no','Service Report No','trim|required');
        $this->form_validation->set_rules('job_status','Job Status','trim');
        $this->form_validation->set_rules('remark_note','Remark Note','trim');
        $this->form_validation->set_rules('part_needed','Part Needed','trim');
        
        if($this->form_validation->run() == true){
            if($_FILES['service_report']['size'] > 0)
			{
                $ext1 = end(explode(".", $_FILES['service_report']['name']));
                $file_name = "service_report-".$id.".".$ext1;
                $image_path = realpath(APPPATH."../assets/uploads/services/");
                $config1 = array(
				'upload_path' => $image_path,
				'allowed_types' => "gif|jpg|png|jpeg",
				'overwrite' => TRUE,
				'file_name' => $file_name
				);
                // echo '<pre>';
                // print_r($config1);
                $this->upload->initialize($config1);
                if($this->upload->do_upload('service_report'))
				{
					$data1 = array('service_report' => $this->upload->data());
                }
				else
				{
                    // echo '<pre>';    
					$error = array('error' => $this->upload->display_errors());
                    // print_r($error);
					$this->load->view('add', $error);
				}
            }else{
                $data1['service_report']['file_name'] = $this->input->post('service_report_edit');
            }
            
            $s_date = explode('/',$this->input->post('service_date'));
            $original_s_date = $s_date[2].'-'.$s_date[1].'-'.$s_date[0];
            $dataService = array(
                'record_id'             => $this->input->post('record_id'),
                'service_date'          => $original_s_date,
                'warranty'              => $this->input->post('warranty'),
                'working_hour'          => $this->input->post('working_hour'),
                'technician_name'       => $this->input->post('technician_name'),
                'service_report_no'     => $this->input->post('service_report_no'),
                'job_status'            => $this->input->post('job_status'),
                'remark_note'           => $this->input->post('remark_note'),
                'remarks'               => $this->input->post('editor1'),
                'part_needed'           => $this->input->post('part_needed'),
                'parts_total'           => $this->input->post('parts_total'),
                'service_report'        => $data1['service_report']['file_name'],
                'service_charge'        => $this->input->post('service_charge'),
                'total'                 => $this->input->post('total'),
                'user'                  =>  USER_ID,
                'updation_time'         => date('Y-m-d H:m:s'),
            );
            
            // echo '<pre>';
            // print_r($dataService);exit;
            
            $noOfDetails = $this->input->post('seq');
            $partDetails = explode(',',$noOfDetails);
            
            foreach($partDetails as $i){
                //array of dataPartItems
                $o_date = explode('/',$this->input->post("order_date".$i));
                $original_o_date = $o_date[2].'-'.$o_date[1].'-'.$o_date[0];
                
                $a_date = explode('/',$this->input->post("arrival_date".$i));
                $original_a_date = $a_date[2].'-'.$a_date[1].'-'.$a_date[0];
                
                $d_date = explode('/',$this->input->post("delivery_date".$i));
                $original_d_date = $d_date[2].'-'.$d_date[1].'-'.$d_date[0];
                
				$dataPartItems = array(
                    'part_id'			    => $this->input->post("parts_id".$i),
                    'service_record_id'		=> $this->input->post("record_id"),
					'quantity'		        => $this->input->post("quantity".$i),
					'price'			        => $this->input->post("price".$i),
					'supplied_condition'    => $this->input->post("supply_condition".$i),
					'available_stock'       => $this->input->post("stock_status".$i),
					'order_date'            => $original_o_date,
					'estimate_arrival_date' => $original_a_date,
					'delivery_date'         => $original_d_date,
					'description'           => $this->input->post("description".$i),
					'sub_total'			    => $this->input->post("sub_total".$i),
					'updation_time'		    => date('Y-m-d H:m:s'),
				);
				$items[] = $dataPartItems;
            }
            // echo '<pre>';
            // print_r($items);exit;
        }
        
        if(($this->form_validation->run() == true) && $this->services_model->editService($dataService, $items, $id)){
            $this->session->set_flashdata('success','Service edited successfully.');
            redirect('services','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['parts'] = $this->services_model->getParts();
            $data['records'] = $this->services_model->getRecords();
            // echo '<pre>';
            // print_r($data['records']);exit;
            $data['technician'] = $this->services_model->getTechnician();
            $data['services'] = $this->services_model->getServiceByID($id);
            $data['service_part'] = $this->services_model->getServicePartByID($id);
            // echo '<pre>';
            // print_r($data['service_part']);exit;
            $count = 1;
            if(!empty($data['services'])){
                foreach($data['services'] as $row){
                    $count = $count+1;
                }
            }
            $data['seq_row'] = $count;
            // echo '<pre>';
            // print_r($data['services']);exit;
            $data['id'] = $id;
            $meta['page_title'] = 'Edit Service';
            $data['page_title'] = "Edit Service";
            $this->load->view('commons/header',$meta);
            $this->load->view('edit',$data);
            $this->load->view('commons/footer');
        }
    }
    
    // function check_technician(){
        // if($this->input->post('technician_id') == '0'){
            // $this->form_validation->set_message('check_technician','Please select technician.');
            // return false;
        // }
        // return true;
    // }
    
    function check_warranty(){
        if($this->input->post('warranty') == '0'){
            $this->form_validation->set_message('check_warranty','Please select warranty.');
            return false;
        }
        return true;
    }
    
    function check_record(){
        if($this->input->post('record_id') == ''){
            $this->form_validation->set_message('check_record','Please select record.');
            return false;
        }
        return true;
    }
}
?>