<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Vendor_model extends CI_model{
    public function __construct(){
        parent::__construct();
    }
    
    function getVendors(){
        $q = $this->db->get('vendor');
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
    
    function addVendor($data = array()){
        if($this->db->insert('vendor',$data)){
            return true;
        }
        return false;
    }
    
    function getVendorByID($id = NULL){
        $q = $this->db->get_where('vendor',array('id'=>$id));
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
    
    function editVendor($data = array(), $id = NULL){
        $this->db->where('id',$id);
        if($this->db->update('vendor',$data)){
            return true;
        }
        return false;
    }
}
?>