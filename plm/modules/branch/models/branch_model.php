<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Branch_model extends CI_Model{
    
    function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
	}
    
    function getBranches(){
        $q = $this->db->select('id,branch_name,branch_code,po_box,postal_code,city,telephone,mobile,email,incharge')
        ->from('branch')
        ->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    public function addBranch($branchDetail=array())
    {
        // branch data
        // $branchData = array(
            // 'branch_name'   =>  $branchDetail['branch_name'],
            // 'branch_code'   =>  $branchDetail['branch_code'],
            // 'po_box'        =>  $branchDetail['po_box'],
            // 'postal_code'   =>  $branchDetail['postal_code'],
            // 'city'          =>  $branchDetail['city'],
            // 'telephone'     =>  $branchDetail['telephone'],
            // 'mobile'        =>  $branchDetail['mobile'],
            // 'email'         =>  $branchDetail['email'],
            // 'incharge'      =>  $branchDetail['incharge'],
            // 'currency_code' =>  $branchDetail['currency_code'],
            // 'user'          =>  USER_ID,
            // 'creation_time' =>  $branchDetail['creation_time'],
        // );
        
        /*echo '<pre>';
        print_r($branchData);exit;*/
        
        if($this->db->insert('branch', $branchDetail)) {
			$branch_id = $this->db->insert_id();
			return true;
		}
        return false;
    }
    
    public function getBranchById($id)
    {
        $q = $this->db->get_where('branch', array('id' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function updateBranch($branchDetail = array(),$id = NULL)
    {
        //echo $id;exit;
        //branch data
		// $branchData = array(
			// 'branch_name'   =>  $branchDetail['branch_name'],
            // 'branch_code'   =>  $branchDetail['branch_code'],
            // 'po_box'        =>  $branchDetail['po_box'],
            // 'postal_code'   =>  $branchDetail['postal_code'],
            // 'city'          =>  $branchDetail['city'],
            // 'telephone'     =>  $branchDetail['telephone'],
            // 'mobile'        =>  $branchDetail['mobile'],
            // 'email'         =>  $branchDetail['email'],
            // 'incharge'      =>  $branchDetail['incharge'],
            // 'currency_code' =>  $branchDetail['currency_code'],
            // 'user'          =>  USER_ID,
			// 'account_name'	=> 	$branchDetail['account_name'],
			// 'account_no'	=> 	$branchDetail['account_no'],
			// 'iban'			=> 	$branchDetail['iban'],
			// 'bank_name'		=> 	$branchDetail['bank_name'],
			// 'swift_code'	=> 	$branchDetail['swift_code'],
            // 'updation_time' =>  $branchDetail['updation_time'],
		// );
        // echo '<pre>';
        // print_r($branchData);exit;
		
		$this->db->where('id', $id);
		if($this->db->update('branch', $branchDetail)) {
				// echo $this->db->last_query();exit;
				return true;
		}
		return false;
    }
    
    public function deleteBranch($id)
    {
        if($this->db->delete('branch', array('id' => $id))) {
			return true;
	    }
			
		return FALSE;
    }
}
?>