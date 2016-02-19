<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Branchname {
    public function __construct(){
        $CI =& get_instance();
        $CI->load->helper('url');
        $CI->load->library('session');
        $CI->load->database();
    }
    public function getBranchName($id = NULL)
    {
        $CI =& get_instance();
        $CI->load->database();
        $q = $CI->db->get_where('branch',array('id'=>$id));
        // return $CI->db->last_query();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                return $row->branch_name;
            }
        }
        return false;
    }
    
    public function getBranches(){
        $CI =& get_instance();
        $CI->load->database();
        $q = $CI->db->get('branch');
        // return $CI->db->last_query();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
}

/* End of file Someclass.php */