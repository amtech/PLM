<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Categories_model extends CI_Model{
    function __construct(){
        // code that publicly accessed in this class
    }
    
    function getCategories(){
        $q = $this->db->select('id,category_name,category_desc')
        ->from('categories')
        ->get();
        
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getSubCategories(){
        $q = $this->db->select('sub_categories.id as ID,categories.category_name,sub_category_name,sub_cat_desc')
        ->from('sub_categories')
        ->join('categories','categories.id = sub_categories.category_id')
        ->get();
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function addCategory($data = array()){
        if($this->db->insert('categories',$data)){
            return true;
        }
        return false;
    }
    function addSubCategory($data = array()){
        if($this->db->insert('sub_categories',$data)){
            return true;
        }
        return false;
    }
    
    function getCategoryById($id = NULL){
        $q = $this->db->get_where('categories',array('id'=>$id));
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;   
    }
    function getSubCategoryByID($id = NULL){
        $q = $this->db->get_where('sub_categories',array('id'=>$id));
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;   
    }
    
    function editCategory($data = array() , $id = NULL){
        $this->db->where('id',$id);
        if($this->db->update('categories',$data)){
            return true;
        }
        return false;
    }
    function editSubCategory($data = array() , $id = NULL){
        $this->db->where('id',$id);
        if($this->db->update('sub_categories',$data)){
            return true;
        }
        return false;
    }
    
    function delete($id = NULL){
        if($this->db->delete('categories',array('id'=>$id))){
            return true;
        }
        return false;
    }
    function delete_sub($id = NULL){
        if($this->db->delete('sub_categories',array('id'=>$id))){
            return true;
        }
        return false;
    }
    
    function getCategory(){
        $q = $this->db->get('categories');
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
}
?>