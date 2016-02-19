<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Warehouses_model extends CI_Model{
    function __construct(){
        // code that publicly accessed in this class
    }
    
    function getWarehouses(){
        $q = $this->db->select('warehouses.id as ID,branch.branch_name,warehouse_name,warehouse_desc')
            ->from('warehouses')
            ->join('branch','branch.id = warehouses.branch_id')
            ->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function addWarehouse($data = array()){
        if($this->db->insert('warehouses',$data)){
            return true;
        }
        return false;
    }
    
    function getBranch(){
        $q = $this->db->get_where('branch');
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getWarehouseById($id = NULL){
        $q = $this->db->get_where('warehouses',array('id'=>$id));
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;   
    }
    
    function editWarehouse($data = array() , $id = NULL){
        $this->db->where('id',$id);
        if($this->db->update('warehouses',$data)){
            return true;
        }
        return false;
    }
    
    function delete($id = NULL){
        if($this->db->delete('warehouses',array('id'=>$id))){
            return true;
        }
        return false;
    }
    
    function getBranchById($id = NULL){
        $q = $this->db->get_where('branch',array('id'=>$id));
        // return $this->db->last_query();exit;
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
}
?>