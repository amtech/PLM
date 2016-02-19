<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Settings_model extends CI_Model{
    function __construct(){
    	parent::__construct();
    }

    function getSettingById($id = NULL){
    	$q = $this->db->get_where('settings',array('id'=>$id));
    	if($q->num_rows() > 0){
    		return $q->row();
    	}
    	return false;
    }

    function updateSettings($data = array(), $id = NULL){
    	$this->db->where('id',$id);
    	if($this->db->update('settings',$data)){
    		return true;
    	}
    	return false;
    }
    
    function getDiscounts(){
        $q = $this->db->select('id,discount_type,value')
        ->from('discount')
        ->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }

    function addDiscount($data = array()){
    	if($this->db->insert('discount',$data)){
    		return true;
    	}
    	return false;
    }

    function getDiscountById($id = NULL){
    	$q = $this->db->get_where('discount',array('id'=>$id));
    	if($q->num_rows() > 0){
    		return $q->row();
    	}
    	return true;
    }

    function editDiscount($data = array(), $id = NULL){
    	$this->db->where('id',$id);
    	if($this->db->update('discount',$data)){
    		return true;
    	}
    	return false;
    }

    function deleteDiscount($id = NULL){
    	if($this->db->delete('discount',array('id'=>$id))){
    		return true;
    	}
    	return false;
    }
}
?>