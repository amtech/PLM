<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Brand_model extends CI_Model{
    function __construct(){
        // code that publicly accessed in this class
    }
    
    function getBrands(){
        $q = $this->db->select('id,brand_name,brand_desc')
        ->from('brand')
        ->get();
        
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function addBrand($data = array()){
        if($this->db->insert('brand',$data)){
            return true;
        }
        return false;
    }
    
    function getBrandById($id = NULL){
        $q = $this->db->get_where('brand',array('id'=>$id));
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;   
    }
    
    function editBrand($data = array() , $id = NULL){
        $this->db->where('id',$id);
        if($this->db->update('brand',$data)){
            return true;
        }
        return false;
    }
    
    function delete($id = NULL){
        if($this->db->delete('brand',array('id'=>$id))){
            return true;
        }
        return false;
    }
}
?>