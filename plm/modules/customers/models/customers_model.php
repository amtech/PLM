<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Customers_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function getCustomers(){
        $q = $this->db->select('customers.id,branch.branch_name,name,customers.city,country,customers.mobile,customers.email')
        ->from('customers')
        ->join('branch','branch.id = customers.branch_id')
        ->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getBranch(){
        $q = $this->db->get('branch');
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function addCustomers($data = array()){
        if($this->db->insert('customers',$data)){
            return true;
        }
        return false;
    }
    function editCustomers($data = array(), $id = NULL){
        $this->db->where('id',$id);
        if($this->db->update('customers',$data)){
            return true;
        }
        return false;
    }
    
    function getCustomerById($id = NULL){
        $q = $this->db->get_where('customers',array('id'=>$id));
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
    
    function getBranchById($id = NULL){
        $q = $this->db->get_where('branch',array('id'=>$id));
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
    
    function checkSalesEntry($id = NULL){
        $q = $this->db->get_where('sale_part',array('customer_id'=>$id));
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            return true;
        }
        return false;
    }
    
    function checkQuotationsEntry($id = NULL){
        $q = $this->db->get_where('quotations',array('customer_id'=>$id));
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            return true;
        }
        return false;
    }
    
    function delete($id = NULL){
        if($this->db->delete('customers',array('id'=>$id))){
            return true;
        }
        return false;
    }
    
    function add_customer($data = array()){
        if($this->db->insert_batch('customers', $data)) {
			return true;
		} else {
			return false;
		}
    }
}
?>