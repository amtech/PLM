<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->library('form_validation');
        $this->load->model('products_model');
        $this->load->database();
        $this->load->library('Datatables');
        $this->load->library('upload');
        $this->load->library('Branchname');
    }
    
    function index(){
        $data['products'] = $this->products_model->getProducts();
        // echo '<pre>';
        // print_r($data['products']);exit;
        $meta['page_title'] = 'Reference Equipments Details';
        $data['page_title'] = "Reference Equipments Details";
        $this->load->view('commons/header',$meta);
        $this->load->view('index',$data);
        $this->load->view('commons/footer');
    }
    
    function view($product_id)
    {
        $id = $product_id;
        $product_details = $this->products_model->getProductById($product_id);
        // echo '<pre>';
        // print_r($product_details);exit;
        $data['id'] = $product_id;
        $data['products'] = $product_details;
        $meta['page_title'] = 'View Reference Equipment';
        $data['page_title'] = "View Reference Equipment";
        $this->load->view('commons/header', $meta);
        $this->load->view('view', $data);
        $this->load->view('commons/footer');
        
    }
    
    function add(){
        // validation for products
        $this->form_validation->set_rules('brand_id', 'Brand', 'trim|required|callback_check_brand');
        $this->form_validation->set_rules('category_id', 'Category', 'trim|required|callback_check_category');
        $this->form_validation->set_rules('sub_category_id', 'Category', 'trim|required');
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
        $this->form_validation->set_rules('model_name', 'Model Name', 'trim|required');
        $this->form_validation->set_rules('serial_no', 'Serial Number', 'trim');
        $this->form_validation->set_rules('cost', 'Cost', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim');
        $this->form_validation->set_rules('alert_qty', 'Alert Quantity', 'trim|numeric');
        
        if($this->form_validation->run() == true){
            $count = $this->db->from('products');
            $query = $this->db->get();
            $rowcount = $query->num_rows();
            if($rowcount == 0)
            {
                $rowcount = $rowcount + 1;
            }
            
            if($_FILES['image']['size'] > 0)
			{
                $ext1 = end(explode(".", $_FILES['image']['name']));
                $file_name = $this->input->post('model_name')."-".$rowcount.".".$ext1;
                $image_path = realpath(APPPATH."../assets/uploads/products/");
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
            $dataProduct = array(
                'brand_id'          =>  $this->input->post('brand_id'),
                'category_id'       =>  $this->input->post('category_id'),
                'sub_category_id'   =>  $this->input->post('sub_category_id'),
                'customer_name'     =>  $this->input->post('customer_name'),
                'model_name'        =>  $this->input->post('model_name'),
                'serial_no'         =>  $this->input->post('serial_no'),
                'cost'              =>  $this->input->post('cost'),
                'price'             =>  $this->input->post('price'),
                'alert_quantity'    =>  $this->input->post('alert_qty'),
                'image'             =>  $data1['image']['file_name'],
                'user'              =>  USER_ID,
                'creation_time'     =>  date("Y-m-d h:m:s"),
            );
            // echo '<pre>';
            // print_r($dataProduct);exit;
        }
        
        if($this->form_validation->run() == true && $this->products_model->addProduct($dataProduct)){
            $this->session->set_flashdata('success', 'Equipment added successfully.');
            redirect('products','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['categories'] = $this->products_model->getCategories();
            $data['sub_categories'] = $this->products_model->getSubCategories();
            $data['brands'] = $this->products_model->getBrands();
			// echo '<pre>';
            // print_r($data['brands']);exit;
            $meta['page_title'] = 'Add Reference Equipment';
            $data['page_title'] = "Add Reference Equipment";
            $this->load->view('commons/header',$meta);
            $this->load->view('add',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function edit($id = NULL){
        // validation for brand
        $this->form_validation->set_rules('brand_id', 'Brand', 'trim|required|callback_check_brand');
        $this->form_validation->set_rules('category_id', 'Category', 'trim|required|callback_check_category');
        $this->form_validation->set_rules('sub_category_id', 'Category', 'trim');
		$this->form_validation->set_rules('customer_name', 'Customer Name', 'trim|required');
        $this->form_validation->set_rules('model_name', 'Model Name', 'trim|required');
        $this->form_validation->set_rules('serial_no', 'Serial Number', 'trim');
        $this->form_validation->set_rules('cost', 'Cost', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim');
        $this->form_validation->set_rules('alert_qty', 'Alert Quantity', 'trim|numeric');
        
        if($this->form_validation->run() == true){
            if($_FILES['image']['size'] > 0)
            {
                $ext1 = end(explode(".", $_FILES['image']['name']));
                $file_name = $this->input->post('model_name')."-".$id.".".$ext1;
                $image_path = realpath(APPPATH."../assets/uploads/products/");
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
            $dataProduct = array(
                'brand_id'          =>  $this->input->post('brand_id'),
                'category_id'       =>  $this->input->post('category_id'),
                'sub_category_id'   =>  $this->input->post('sub_category_id'),
                'customer_name'     =>  $this->input->post('customer_name'),
                'model_name'        =>  $this->input->post('model_name'),
                'serial_no'         =>  $this->input->post('serial_no'),
                'cost'              =>  $this->input->post('cost'),
                'price'             =>  $this->input->post('price'),
                'alert_quantity'    =>  $this->input->post('alert_qty'),
                'image'             =>  $data1['image']['file_name'],
                'user'              =>  USER_ID,
                'updation_time'     =>  date("Y-m-d h:m:s"),
            );
            // echo '<pre>';
            // print_r($dataProduct);exit;
        }
        
        if($this->form_validation->run() == true && $this->products_model->editProduct($dataProduct, $id)){
            $this->session->set_flashdata('success', 'Equipment edited successfully.');
            redirect('products','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['categories'] = $this->products_model->getCategories();
            $data['sub_categories'] = $this->products_model->getSubCategories();
            $data['brands'] = $this->products_model->getBrands();
            $data['products'] = $this->products_model->getProductById($id);
            // echo '<pre>';
            // print_r($data['brand']);exit;
            $data['id'] = $id;
            $meta['page_title'] = 'Edit Reference Equipment';
            $data['page_title'] = "Edit Reference Equipment";
            $this->load->view('commons/header',$meta);
            $this->load->view('edit',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function delete($id = NULL){
        if($this->products_model->delete($id)){
            $this->session->set_flashdata('success', 'Equipment deleted successfully.');
            redirect('products','refresh');
        }
        return false;
    }
    
    function check_brand(){
        if($this->input->post('brand_id') == '0'){
            $this->form_validation->set_message('check_brand','Please select brand.');
            return false;
        }
        return true;
    }
    function check_category(){
        if($this->input->post('category_id') == '0'){
            $this->form_validation->set_message('check_category','Please select category.');
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
    
    function upload_csv(){
        // validation for upload
        $this->form_validation->set_rules('brand_id','Brand','trim|required|callback_check_brand');
        $this->form_validation->set_rules('cat_id', 'Category', 'trim|xss_clean');
        $this->form_validation->set_rules('subcat_id', 'Sub Category', 'trim');
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
				redirect("products/upload_csv", 'refresh');
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
            $tempAr = array('brand_id'=>$this->input->post('brand_id'), 'category_id'=>$this->input->post('cat_id'), 'sub_category_id'=>$this->input->post('subcat_id'));
            
            $keys = array('customer_name','model_name', 'serial_no', 'cost', 'alert');
            
            $final = array();
            foreach($arrResult as $key => $value){
                $final[] = array_combine($keys, $value);
            }
            foreach($final as $val){
                $finalOne[] = array_merge($tempAr,$val);
            }
            // echo '<pre>';
            // print_r($finalOne);exit;
            $rw=2;
            foreach($finalOne as $csv_pr) {
					$brand[] = $csv_pr['brand_id'];
					$cat[] = $csv_pr['category_id'];
					$sub_cat[] = $csv_pr['sub_category_id'];
					$customer_name[] = $csv_pr['customer_name'];
					$model_name[] = $csv_pr['model_name'];
					$serial_no[] = $csv_pr['serial_no'];
					$cost[] = $csv_pr['cost'];
					$alert[] = $csv_pr['alert'];
                $rw++;	
			}
            
            $ikeys = array('brand_id', 'category_id', 'sub_category_id', 'customer_name','model_name', 'serial_no', 'cost','alert_quantity');
		
			$items = array();
			foreach ( array_map(null, $brand, $cat, $sub_cat, $customer_name,$model_name, $serial_no, $cost,$alert) as $ikey => $value ) {
				$items[] = array_combine($ikeys, $value);
			}
			// echo '<pre>';
            // print_r($items);exit;
            $final = $this->mres($items);
        }
        
        if($this->form_validation->run() == true && $this->products_model->add_products($final))
		{ 
			$this->session->set_flashdata('success_message', 'Success');
			redirect('products', 'refresh');
		}else{
            $data['errors'] = $this->form_validation->error_array();
            $data['brand'] = $this->products_model->getBrands();
            $data['category'] = $this->products_model->getCategories();
            $data['sub_cat'] = $this->products_model->getSubCategories();
            $data['page_title'] = "Upload Reference Equipment By CSV";
            $meta['page_title'] = "Upload Reference Equipment By CSV";
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