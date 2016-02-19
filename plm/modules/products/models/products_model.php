<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Products_model extends CI_Model{
    function __construct(){
        // code that publicly accessed in this class
    }
    function addProduct($data = array()){
        if($this->db->insert('products',$data)){
            return true;
        }
        return false;
    }
    
    function getProducts(){
        $q = $this->db->select('products.id as ID,brand.brand_name as brand,categories.category_name,model_name,serial_no,products.customer_name')
        ->from('products')
        ->join('brand','brand.id = products.brand_id')
        ->join('categories','categories.id = products.category_id')
        ->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
	
	function getAgeOfMachine($id = NULL){
		$query = $this->db->query("SELECT datediff(CURDATE(),creation_time)as age_machine from products where id = $id");
		if($query->num_rows() > 0){
			foreach ($query->result() as $row)
			{
			   return $row->age_machine;
			}
		}
		return false;
	}
    
    function getProductById($id = NULL){
        $q = $this->db->select('products.*,brand.brand_name,categories.category_name')->from('products')
            ->join('brand','brand.id = products.brand_id')
            ->join('categories','categories.id = products.category_id')
            // ->join('sub_categories','sub_categories.id = products.sub_category_id')
            ->where('products.id',$id)
            ->get();
        // echo $this->db->last_query();exit;    
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;   
    }
    
    function editProduct($data = array() , $id = NULL){
        $this->db->where('id',$id);
        if($this->db->update('products',$data)){
            return true;
        }
        return false;
    }
    
    function delete($id = NULL){
        if($this->db->delete('products',array('id'=>$id))){
            return true;
        }
        return false;
    }
    
    function getBrands(){
        $q = $this->db->get('brand');
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getCategories(){
        $q = $this->db->get('categories');
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getSubCategories(){
        $q = $this->db->get('sub_categories');
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function add_products($data = array()){
        if($this->db->insert_batch('products', $data)) {
			return true;
		} else {
			return false;
		}
    }
}
?>