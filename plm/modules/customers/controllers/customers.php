<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Customers extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->library('form_validation');
        $this->load->model('customers_model');
        $this->load->database();
        $this->load->library('Datatables');
        $this->load->library('upload');
        $this->load->library('Branchname');
    }
    
    function index(){
        $data['customers'] = $this->customers_model->getCustomers();
        // echo '<pre>';
        // print_r($data['customers']);exit;
        $meta['page_title'] = 'Customers Details';
        $data['page_title'] = "Customers Details";
        $this->load->view('commons/header',$meta);
        $this->load->view('index',$data);
        $this->load->view('commons/footer');
    }
    
    function view($id = NULL){
        $data['customers'] = $this->customers_model->getCustomerById($id);
        // $data['branch'] = $this->customers_model->getBranch();
        $meta['page_title'] = 'Add Customer';
        $data['page_title'] = "Add Customer";
        $this->load->view('commons/header',$meta);
        $this->load->view('view',$data);
        $this->load->view('commons/footer');
    }
    
    function add(){
        // validation for customers
        $this->form_validation->set_rules('branch_id','Branch','trim|required|callback_check_branch');
        $this->form_validation->set_rules('customer_name','Name','trim|required');
        $this->form_validation->set_rules('address','Address','trim|required');
        $this->form_validation->set_rules('city','City','trim|required');
        $this->form_validation->set_rules('country','Country','trim|required');
        $this->form_validation->set_rules('telephone','Telephone','trim');
        $this->form_validation->set_rules('fax','Fax','trim');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');
        $this->form_validation->set_rules('contact_person','Contact Person','trim|required');
        $this->form_validation->set_rules('title','Title','trim');
        $this->form_validation->set_rules('mobile','Mobile','trim|required');
        
        if($this->form_validation->run() == true){
            $dataCustomer = array(
                'branch_id'             => $this->input->post('branch_id'),
                'name'                  => $this->input->post('customer_name'),
                'address'               => $this->input->post('address'),
                'city'                  => $this->input->post('city'),
                'country'               => $this->input->post('country'),
                'telephone'             => $this->input->post('telephone'),
                'fax'                   => $this->input->post('fax'),
                'email'                 => $this->input->post('email'),
                'contact_person'        => $this->input->post('contact_person'),
                'title'                 => $this->input->post('title'),
                'mobile'                => $this->input->post('mobile'),
                'user'                  =>  USER_ID,
                'creation_time'         =>  date("Y-m-d h:m:s"),
            );
            // echo '<pre>';
            // print_r($dataCustomer);exit;
        }
        
        if(($this->form_validation->run() == true) && $this->customers_model->addCustomers($dataCustomer)){
            $this->session->set_flashdata('success','Customer added successfully.');
            redirect('customers','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['branch'] = $this->customers_model->getBranch();
            $meta['page_title'] = 'Add Customer';
            $data['page_title'] = "Add Customer";
            $this->load->view('commons/header',$meta);
            $this->load->view('add',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function edit($id = NULL){
        // validation for customers
        $this->form_validation->set_rules('branch_id','Branch','trim|required|callback_check_branch');
        $this->form_validation->set_rules('customer_name','Name','trim|required');
        $this->form_validation->set_rules('address','Address','trim|required');
        $this->form_validation->set_rules('city','City','trim|required');
        $this->form_validation->set_rules('country','Country','trim|required');
        $this->form_validation->set_rules('telephone','Telephone','trim');
        $this->form_validation->set_rules('fax','Fax','trim');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');
        $this->form_validation->set_rules('contact_person','Contact Person','trim|required');
        $this->form_validation->set_rules('title','Title','trim');
        $this->form_validation->set_rules('mobile','Mobile','trim|required');
        
        if($this->form_validation->run() == true){
            $dataCustomer = array(
                'branch_id'             => $this->input->post('branch_id'),
                'name'                  => $this->input->post('customer_name'),
                'address'               => $this->input->post('address'),
                'city'                  => $this->input->post('city'),
                'country'               => $this->input->post('country'),
                'telephone'             => $this->input->post('telephone'),
                'fax'                   => $this->input->post('fax'),
                'email'                 => $this->input->post('email'),
                'contact_person'        => $this->input->post('contact_person'),
                'title'                 => $this->input->post('title'),
                'mobile'                => $this->input->post('mobile'),
                'user'                  =>  USER_ID,
                'updation_time'         =>  date("Y-m-d h:m:s"),
            );
            // echo '<pre>';
            // print_r($dataCustomer);exit;
        }
        
        if(($this->form_validation->run() == true) && $this->customers_model->editCustomers($dataCustomer,$id)){
            $this->session->set_flashdata('success','Customer edited successfully.');
            redirect('customers','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['id'] = $id;
            $data['customers'] = $this->customers_model->getCustomerById($id);
            // echo '<pre>';
            // print_r($data['customers']);exit;
            $data['branch'] = $this->customers_model->getBranch();
            $meta['page_title'] = 'Add Customer';
            $data['page_title'] = "Add Customer";
            $this->load->view('commons/header',$meta);
            $this->load->view('edit',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function check_branch(){
        if($this->input->post('branch_id') == '0'){
            $this->form_validation->set_message('check_branch','Please select branch.');
            return false;
        }
        return true;
    }
    
    function delete($id = NULL){
        if($this->customers_model->checkSalesEntry($id)){
            $this->session->set_flashdata('success','Customer cannot be deleted because some sales entry of this customer exists.');
            redirect('customers','refresh');
        }else if($this->customers_model->checkQuotationsEntry($id)){
            $this->session->set_flashdata('success','Customer cannot be deleted because some quotation entry of this customer exists.');
            redirect('customers','refresh');
        }else{
            if($this->customers_model->delete($id)){
                $this->session->set_flashdata('success','Customer deleted successfully.');
                redirect('customers','refresh');
            }
        }
    }
    
    function upload_csv(){
        // validation for upload
        $this->form_validation->set_rules('branch_id','Branch','trim|required|callback_check_branch');
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
				redirect("customers/upload_csv", 'refresh');
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
            $tempAr = array('branch_id'=>$this->input->post('branch_id'));
            $keys = array('customer_name', 'address','city', 'country', 'mobile', 'email','contact_person','title');
            
            $final = array();
            foreach($arrResult as $key => $value){
                $final[] = array_combine($keys, $value);
            }
            foreach($final as $val){
                $finalOne[] = array_merge($tempAr,$val);
            }
            
            $rw=2;
            foreach($finalOne as $csv_pr) {
					$branch[] = $csv_pr['branch_id'];
					$cust_name[] = $csv_pr['customer_name'];
                    $address[] = $csv_pr['address'];
					$city[] = $csv_pr['city'];
					$country[] = $csv_pr['country'];
					$mobile[] = $csv_pr['mobile'];
					$email[] = $csv_pr['email'];
					$contact_person[] = $csv_pr['contact_person'];
					$title[] = $csv_pr['title'];
                $rw++;	
			}
            
            $ikeys = array('branch_id', 'name', 'address','city', 'country', 'mobile', 'email','contact_person','title');
		
			$items = array();
			foreach ( array_map(null, $branch, $cust_name, $address,$city, $country, $mobile, $email,$contact_person,$title) as $ikey => $value ) {
				$items[] = array_combine($ikeys, $value);
			}
			// echo '<pre>';
            // print_r($items);exit;
            $final = $this->mres($items);
        }
        
        if($this->form_validation->run() == true && $this->customers_model->add_customer($final))
		{ 
			$this->session->set_flashdata('success_message', 'Success');
			redirect('customers', 'refresh');
		}else{
            $data['errors'] = $this->form_validation->error_array();
            $data['branch'] = $this->customers_model->getBranch();
            $data['page_title'] = "Upload Customer By CSV";
            $meta['page_title'] = "Upload Customer By CSV";
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