<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pdc_model extends CI_Model{
    
    function __construct()
	{
		parent::__construct();
		$this->load->library('Datatables');
        $this->load->library('table');
	}
    
    function getPDC(){
        $q = $this->db->select('pdc.id,branch.branch_name as branchName,date_issue,date_cheque,cheque_no,bank_ref,party_favouring,reason,amount,bank_account_no')
        ->from('pdc')
        ->join('branch','branch.id = pdc.branch_id', 'INNER')
        ->get();
        
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    public function addpdc($pdcDetail=array())
    {
        // pdc data
        $pdcData = array(
            'branch_id'         =>  $pdcDetail['branch_id'],
            'date_issue'        =>  $pdcDetail['date_issue'],
            'date_cheque'       =>  $pdcDetail['date_cheque'],
            'cheque_no'         =>  $pdcDetail['cheque_no'],
            'bank_ref'          =>  $pdcDetail['bank_ref'],
            'party_favouring'   =>  $pdcDetail['party_favouring'],
            'reason'            =>  $pdcDetail['reason'],
            'amount'            =>  $pdcDetail['amount'],
            'bank_account_no'   =>  $pdcDetail['bank_account_no'],
            'payment_from_date' =>  $pdcDetail['payment_from_date'],
            'payment_to_date'   =>  $pdcDetail['payment_to_date'],
            'user'              =>  USER_ID,
            'creation_time'     =>  $pdcDetail['creation_time'],
            
        );
        
        /*echo '<pre>';
        print_r($pdcData);exit;*/
        
        if($this->db->insert('pdc', $pdcData)) {
			$pdc_id = $this->db->insert_id();
			return true;
		}
        return false;
    }
    
    public function getPdcById($id)
    {
        $q = $this->db->get_where('pdc', array('id' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getPdcByIdwithBranch($id)
    {
        $this->db->select('P.*,B.branch_name');
        $this->db->from('pdc AS P');// I use aliasing make joins easier
        $this->db->join('branch AS B', 'B.id = P.branch_id', 'INNER');
        $this->db->where('P.id',$id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function updatePdc($pdcDetail,$id)
    {
        //echo $id;exit;
        //pdc data
		$pdcData = array(
            'branch_id'         =>  $pdcDetail['branch_id'],
            'date_issue'        =>  $pdcDetail['date_issue'],
            'date_cheque'       =>  $pdcDetail['date_cheque'],
            'cheque_no'         =>  $pdcDetail['cheque_no'],
            'bank_ref'          =>  $pdcDetail['bank_ref'],
            'party_favouring'   =>  $pdcDetail['party_favouring'],
            'reason'            =>  $pdcDetail['reason'],
            'amount'            =>  $pdcDetail['amount'],
            'bank_account_no'   =>  $pdcDetail['bank_account_no'],
            'payment_from_date' =>  $pdcDetail['payment_from_date'],
            'payment_to_date'   =>  $pdcDetail['payment_to_date'],
            'user'              =>  USER_ID,
            'updation_time'     =>  $pdcDetail['updation_time'],
        );
        /*echo '<pre>';
        print_r($pdcData);exit;*/
		
		$this->db->where('id', $id);
		if($this->db->update('pdc', $pdcData)) {
				return true;
		}
		return false;
    }
    
    public function deletePdc($id)
    {
        if($this->db->delete('pdc', array('id' => $id))) {
			return true;
	    }
			
		return FALSE;
    }
    
    public function getBranch()
    {
        $this->db->select('id,branch_name');
		$branch = $this->db->get('branch');
		return $array = $branch->result_array();
    }
}
?>