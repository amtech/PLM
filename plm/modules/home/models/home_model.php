<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
	}
    
    function updateBranch($user_id = NULL, $branch_id = NULL){
        $this->db->where('id',$user_id);
        if($this->db->update('users',array('branch_id'=>$branch_id))){
            if($this->db->update('settings',array('default_branch_id'=>$branch_id))){
                return true;
            }
        }
        return false;
    }
}

/* End of file home_model.php */ 
/* Location: ./sma/modules/home/models/home_model.php */
