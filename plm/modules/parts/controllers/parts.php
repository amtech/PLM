<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Parts extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->library('form_validation');
        $this->load->model('parts_model');
        $this->load->database();
        $this->load->library('Datatables');
        $this->load->library('upload');
        $this->load->library('Branchname');
    }
    
    function index(){
        $data['parts'] = $this->parts_model->getParts();
        // echo '<pre>';
        // print_r($data['parts']);exit;
        $meta['page_title'] = 'Spare Parts Details';
        $data['page_title'] = "Spare Parts Details";
        $this->load->view('commons/header',$meta);
        $this->load->view('index',$data);
        $this->load->view('commons/footer');
    }
    
    function view($part_id)
    {
        $id = $part_id;
        $part_details = $this->parts_model->getPartById($part_id);
        // echo '<pre>';
        // print_r($brand_details);exit;
        $data['id'] = $part_id;
        $data['parts'] = $part_details;
        $meta['page_title'] = 'View Spare Part';
        $data['page_title'] = "View Spare Part";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
        
    }
    
    function add(){
        // validation for brand
        $this->form_validation->set_rules('brand_id', 'Brand', 'trim|required|callback_check_brand');
        $this->form_validation->set_rules('code', 'Code', 'trim|required|is_unique[parts.code]');
        $this->form_validation->set_rules('name', 'Part Name', 'trim|required');
        $this->form_validation->set_rules('part_desc', 'Brand Description', 'trim');
        $this->form_validation->set_rules('serial_no', 'Serial Number', 'trim');
        $this->form_validation->set_rules('cost', 'Cost', 'trim|required');
        // $this->form_validation->set_rules('price', 'Price', 'trim|required');
        $this->form_validation->set_rules('alert_qty', 'Alert Quantity', 'trim|numeric');
        
        if($this->form_validation->run() == true){
            $count = $this->db->from('parts');
            $query = $this->db->get();
            $rowcount = $query->num_rows();
            if($rowcount == 0)
            {
                $rowcount = $rowcount + 1;
            }
            
            if($_FILES['image']['size'] > 0)
            {
                $ext1 = end(explode(".", $_FILES['image']['name']));
                $file_name = $this->input->post('name')."-".$rowcount.".".$ext1;
                $image_path = realpath(APPPATH."../assets/uploads/parts/");
                $config1 = array(
                'upload_path' => $image_path,
                'allowed_types' => "gif|jpg|png|jpeg",
                'overwrite' => TRUE,
                'file_name' => $file_name
                );
                // echo '<pre>';
                // print_r($config1);
                $this->upload->initialize($config1);
                if($this->upload->do_upload('image'))
                {
                    $data1 = array('image' => $this->upload->data());
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
                $data1['image']['file_name'] = "";
            }
            $dataParts = array(
                'brand_id'          =>  $this->input->post('brand_id'),
                'code'              =>  $this->input->post('code'),
                'name'              =>  $this->input->post('name'),
                'desc'              =>  $this->input->post('part_desc'),
                'serial_no'         =>  $this->input->post('serial_no'),
                'cost'              =>  $this->input->post('cost'),
                // 'price'              =>  $this->input->post('price'),
                'alert_quantity'    =>  $this->input->post('alert_qty'),
                'image'             =>  $data1['image']['file_name'],
                'user'              =>  USER_ID,
                'creation_time'     =>  date("Y-m-d h:m:s"),
            );
            // echo '<pre>';
            // print_r($dataParts);exit;
        }
        
        if($this->form_validation->run() == true && $this->parts_model->addPart($dataParts)){
            $this->session->set_flashdata('success', 'Spare Part added successfully.');
            redirect('parts','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['brand'] = $this->parts_model->getBrands();
            $meta['page_title'] = 'Add Spare Part';
            $data['page_title'] = "Add Spare Part";
            $this->load->view('commons/header',$meta);
            $this->load->view('add',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function edit($id = NULL){
        // validation for brand
        $this->form_validation->set_rules('brand_id', 'Brand', 'trim|required|callback_check_brand');
        $this->form_validation->set_rules('code', 'Code', 'trim|required');
        $this->form_validation->set_rules('part_name', 'Part Name', 'trim|required');
        $this->form_validation->set_rules('part_desc', 'Brand Description', 'trim');
        $this->form_validation->set_rules('serial_no', 'Serial Number', 'trim');
        $this->form_validation->set_rules('cost', 'Cost', 'trim|required');
        // $this->form_validation->set_rules('price', 'Price', 'trim|required');
        $this->form_validation->set_rules('alert_qty', 'Alert Quantity', 'trim|numeric');
        
        if($this->form_validation->run() == true){
            if($_FILES['image']['size'] > 0)
            {
                $ext1 = end(explode(".", $_FILES['image']['name']));
                $file_name = $this->input->post('part_name')."-".$id.".".$ext1;
                $image_path = realpath(APPPATH."../assets/uploads/parts/");
                $config1 = array(
                'upload_path' => $image_path,
                'allowed_types' => "gif|jpg|png|jpeg",
                'overwrite' => TRUE,
                'file_name' => $file_name
                );
                $this->upload->initialize($config1);
                if($this->upload->do_upload('image'))
                {
                    $data1 = array('image' => $this->upload->data());
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
                $data1['image']['file_name'] = $this->input->post('image_edit');
            }
            $dataParts = array(
                'brand_id'          =>  $this->input->post('brand_id'),
                'code'              =>  $this->input->post('code'),
                'name'              =>  $this->input->post('part_name'),
                'desc'              =>  $this->input->post('part_desc'),
                'serial_no'         =>  $this->input->post('serial_no'),
                'cost'              =>  $this->input->post('cost'),
                // 'price'              =>  $this->input->post('price'),
                'alert_quantity'    =>  $this->input->post('alert_qty'),
                'image'             =>  $data1['image']['file_name'],
                'user'              =>  USER_ID,
                'updation_time'     =>  date("Y-m-d h:m:s"),
            );
            // echo '<pre>';
            // print_r($dataParts);exit;
        }
        
        if($this->form_validation->run() == true && $this->parts_model->editPart($dataParts, $id)){
            $this->session->set_flashdata('success', 'Spare Part edited successfully.');
            redirect('parts','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['brand'] = $this->parts_model->getBrands();
            $data['parts'] = $this->parts_model->getPartById($id);
            // echo '<pre>';
            // print_r($data['brand']);exit;
            $data['id'] = $id;
            $meta['page_title'] = 'Edit Spare Part';
            $data['page_title'] = "Edit Spare Part";
            $this->load->view('commons/header',$meta);
            $this->load->view('edit',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function delete($id = NULL){
        if($this->parts_model->delete($id)){
            $this->session->set_flashdata('success', 'Spare Part deleted successfully.');
            redirect('parts','refresh');
        }
        return false;
    }
    
    function alert(){
        $data['alerts'] = $this->parts_model->getAlerts();
        $meta['page_title'] = "Spare Parts Alert";
        $data['page_title'] = "Spare Parts Alert";
        $this->load->view('commons/header', $meta);
        $this->load->view('alerts', $data);
        $this->load->view('commons/footer');
    }
    
    function check_brand(){
        if($this->input->post('brand_id') == '0'){
            $this->form_validation->set_message('check_brand','Please select brand.');
            return false;
        }
        return true;
    }
    
    function upload_csv(){
        // validation for upload
        $this->form_validation->set_rules('brand_id','Branch','trim|required|callback_check_brand');
        // validation for file
        if (empty($_FILES['csv']['name']))
        {
            $this->form_validation->set_rules('csv', 'Csv', 'required');
        }
        
        if($this->form_validation->run() == true){
            $config['upload_path'] = 'assets/uploads/csv/';
            $config['allowed_types'] = 'csv'; 
            $config['max_size'] = '200';
            $config['overwrite'] = TRUE; 
            // $file_name = $this->input->post('csv');
            $this->upload->initialize($config);
            // var_dump($this->upload->data('csv'));exit;
            if( ! $this->upload->do_upload('csv')){
                
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('message', $error);
				redirect("parts/upload_csv", 'refresh');
			}
            $csv = $this->upload->file_name;
            
            $arrResult = array();
            $handle = fopen("assets/uploads/csv/".$csv, "r");
            if( $handle ) {
			while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
			$arrResult[] = $row;
			}
			fclose($handle);
			}
            $titles = array_shift($arrResult);
            $tempAr = array('brand_id'=>$this->input->post('brand_id'));
            $keys = array('code', 'name', 'description', 'serial_no', 'cost', 'alert');
            
            $final = array();
            foreach($arrResult as $key => $value){
                $final[] = array_combine($keys, $value);
            }
            foreach($final as $val){
                $finalOne[] = array_merge($tempAr,$val);
            }
            
            $rw=2;
            foreach($finalOne as $csv_pr) {
					$brand[] = $csv_pr['brand_id'];
					$code[] = $csv_pr['code'];
					$name[] = $csv_pr['name'];
					$description[] = $csv_pr['description'];
					$serial[] = $csv_pr['serial_no'];
					$cost[] = $csv_pr['cost'];
					$alert[] = $csv_pr['alert'];
                $rw++;	
			}
            
            $ikeys = array('brand_id', 'code', 'name', 'desc', 'serial_no', 'cost', 'alert_quantity');
		
			$items = array();
			foreach ( array_map(null, $brand, $code, $name, $description, $serial, $cost,$alert) as $ikey => $value ) {
				$items[] = array_combine($ikeys, $value);
			}
			// echo '<pre>';
            // print_r($items);exit;
            $final = $this->mres($items);
        }
        
        if($this->form_validation->run() == true && $this->parts_model->add_parts($final))
		{ 
			$this->session->set_flashdata('message', 'Parts uploaded successfully.');
			redirect('parts', 'refresh');
		}else{
            $data['errors'] = $this->form_validation->error_array();
            $data['brand'] = $this->parts_model->getBrands();
            $data['page_title'] = "Upload Spare Parts By CSV";
            $meta['page_title'] = "Upload Spare Parts By CSV";
            $this->load->view('commons/header',$meta);
            $this->load->view('upload',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function mres($q) {
		if(is_array($q))
			foreach($q as $k => $v)
				$q[$k] = $this->mres($v); //recursive
		elseif(is_string($q))
			$q = mysql_real_escape_string($q);
		return $q;
	}
}
?>