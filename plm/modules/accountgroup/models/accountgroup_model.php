<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Accountgroup_model extends CI_Model{
    
    function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
	}
    
    function getAccountGroup(){
        $q = $this->db->select('account_group.id,branch.branch_name as branchName,group_title,category,opening_balance')
        //->unset_column('account_group.id')
        ->from('account_group')
        ->join('branch','branch.id = account_group.branch_id','INNER')
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
    
    public function addAccountGroup($accountgroupDetail=array())
    {
        // accountgroup data
        $accountgroupData = array(
            'branch_id'         =>  $accountgroupDetail['branch_id'],
            'group_title'       =>  $accountgroupDetail['group_title'],
            'category'          =>  $accountgroupDetail['category'],
            'user'              =>  USER_ID,
            'opening_balance'   =>  $accountgroupDetail['opening_balance'],
            'creation_time'     =>  $accountgroupDetail['creation_time'],
        );
        
        // echo '<pre>';
        // print_r($accountgroupData);exit;
        
        if($this->db->insert('account_group', $accountgroupData)) {
			$accountgroup_id = $this->db->insert_id();
			return true;
		}
        return false;
    }
    
    public function getAccountGroupWithJoin($id)
    {
        $this->db->select('AG.*,b.branch_name');
        $this->db->from('account_group AS AG');// I use aliasing make joins easier
        $this->db->join('branch AS b', 'b.id = AG.branch_id', 'INNER');
        $this->db->where('AG.id',$id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getAccountGroupById($id)
    {
        $q = $this->db->get_where('account_group', array('id' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function updateAccountGroup($accountgroupDetail,$id)
    {
        //echo $id;exit;
        //accountgroup data
		$accountgroupData = array(
            'branch_id'         =>  $accountgroupDetail['branch_id'],
            'group_title'       =>  $accountgroupDetail['group_title'],
            'category'          =>  $accountgroupDetail['category'],
            'user'              =>  USER_ID,
            'opening_balance'   =>  $accountgroupDetail['opening_balance'],
            'updation_time'     =>  $accountgroupDetail['updation_time'],
        );
        /*echo '<pre>';
        print_r($accountgroupData);exit;*/
		
		$this->db->where('id', $id);
		if($this->db->update('account_group', $accountgroupData)) {
				return true;
		}
		return false;
    }
    
    public function getBranch()
    {
        $this->db->select('id,branch_name');
		$branch = $this->db->get('branch');
		return $array = $branch->result_array();
    }
    
    public function deleteAccountGroup($id)
    {
        if($this->db->delete('account_group', array('id' => $id))) {
			return true;
	    }
			
		return FALSE;
    }
}
?>