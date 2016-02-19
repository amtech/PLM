<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ledger_model extends CI_Model{
    
    function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
	}
    
    function getLedgers(){
        $q = $this->db->select('ledger.id,branch.branch_name as branchName,type,title,account_group.group_title as groupTitle,ledger.opening_balance,closing_balance')
        ->from('ledger')
        ->join('branch','branch.id = ledger.branch_id','INNER')
        ->join('account_group','account_group.id = ledger.accountgroup_id','INNER')
        ->get();
        
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    public function addLedger($ledgerDetail=array())
    {
        // ledger data
        $ledgerData = array(
            'branch_id'   =>  $ledgerDetail['branch_id'],
            'type'        =>  $ledgerDetail['type'],
            'title'   =>  $ledgerDetail['title'],
            'accountgroup_id'   =>  $ledgerDetail['accountgroup_id'],
            'opening_balance'          =>  $ledgerDetail['opening_balance'],
            'closing_balance'          =>  $ledgerDetail['closing_balance'],
            'creation_time'          =>  $ledgerDetail['creation_time'],
        );
        
        // echo '<pre>';
        // print_r($ledgerData);exit;
        
        if($this->db->insert('ledger', $ledgerData)) {
			$ledger_id = $this->db->insert_id();
			return true;
		}
        return false;
    }
    
    public function getledgerWithJoin($id)
    {
        $this->db->select('L.*,B.branch_name,A.group_title');
        $this->db->from('ledger AS L');// I use aliasing make joins easier
        $this->db->join('branch AS B', 'B.id = L.branch_id', 'INNER');
        $this->db->join('account_group AS A', 'A.id = L.accountgroup_id', 'INNER');
        $this->db->where('L.id',$id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getledgerById($id)
    {
        $q = $this->db->get_where('ledger', array('id' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function updateLedger($ledgerDetail,$id)
    {
        // echo $id;exit;
        //ledger data
		$ledgerData = array(
            'branch_id'   =>  $ledgerDetail['branch_id'],
            'type'        =>  $ledgerDetail['type'],
            'title'   =>  $ledgerDetail['title'],
            'accountgroup_id'   =>  $ledgerDetail['accountgroup_id'],
            'opening_balance'          =>  $ledgerDetail['opening_balance'],
            'closing_balance'          =>  $ledgerDetail['closing_balance'],
            'updation_time'          =>  $ledgerDetail['updation_time'],
        );
        // echo '<pre>';
        // print_r($ledgerData);exit;
		
		$this->db->where('id', $id);
		if($this->db->update('ledger', $ledgerData)) {
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
    
    public function getAccountGroup()
    {
        $this->db->select('id,group_title');
		$this->db->from('account_group');
        $this->db->where('branch_id',DEFAULT_BRANCH);
        $acc_group = $this->db->get();
		return $array = $acc_group->result_array();
    }
    
    public function deleteLedger($id)
    {
        if($this->db->delete('ledger', array('id' => $id))) {
			return true;
	    }
			
		return FALSE;
    }
    
    function getAccountGroupByLedger($type = NULL, $branch_id = NULL){
        if($type == 'Income'){
            $not_in = array('Expense');
        }else{
            $not_in = array('Income');        	
        }
        $this->db->select('*');
        $this->db->from('account_group');
        // $this->db->where('category',$type);
        $this->db->where_not_in('category',$not_in);
        $this->db->where('branch_id',$branch_id);
        $q = $this->db->get();
        // return $this->db->last_query();
        if($q->num_rows() > 0){
            return $q->result_array();
        }
        return false;
    }
}
?>