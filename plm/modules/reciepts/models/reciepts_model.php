<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Reciepts_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function getLedger(){
        $q = $this->db->select('ledger.*')->from('ledger')->where_in('type',array('Income','Assets'))->where('branch_id',DEFAULT_BRANCH)->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getSales(){
        $q = $this->db->get('sale_part');
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getServices(){
        $q = $this->db->get('services');
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getInvNo(){
        $q = $this->db->get('reciepts');
        if($q->num_rows() == 0){
            return 1;
        }else{
            return ($q->num_rows())+1;
        }
    }
    
    function getAmount($id = NULL){
        $q = $this->db->select('sale_part.total')
            ->from('sale_part')
            ->where('id',$id)
            ->get();
            
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
    
    function getServiceAmount($id = NULL){
        $q = $this->db->select('services.total')
            ->from('services')
            ->where('id',$id)
            ->get();
            
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
    
    function addReciept($data = array(), $transaction){
        
        if($this->db->insert('reciepts',$data)){
            $receipt_id = $this->db->insert_id();
            // return true;
            
            $transaction_header_data = array(
                'transaction_date'      => $transaction['transaction_date'],
                'sale_id'               => $transaction['sale_id'],
                'service_id'            => $transaction['service_id'],
                'type'                  => $transaction['type'],
                'amount_payable'        => $transaction['amount_payable'],
                'amount_paid'           => $transaction['amount_paid'],
                'voucher_no'            =>  $receipt_id,
                'voucher_date'          => $transaction['voucher_date'],
                'mode'                  => $transaction['mode'],
                'cheque_date'           => $transaction['cheque_date'],
                'cheque_no'             => $transaction['cheque_no'],
                'bank_name'             => $transaction['bank_name'],
                'from_account'          => $transaction['from_account'],
                'to_account'            => $transaction['to_account'],
                'narration'             => $transaction['narration'],
                'transaction_ref'       => $transaction['transaction_ref'],
                'user'                  => USER_ID,
                'voucher_status'        => $transaction['voucher_status'],
            );
            
            if($this->db->insert('transaction_header',$transaction_header_data)){
                $transaction_id = $this->db->insert_id();
                
                //transaction detail debit
                $transaction_credit_data = array(
                    'transaction_id'            => $transaction_id,
                    'voucher_type'              => 'C',
                    'voucher_no'                => $receipt_id,
                    'ledger_no'                 => $transaction['to_account'],
                    'dr_amount'                 => $transaction['amount_paid'],
                    'voucher_status'            => $transaction['voucher_status'],
                );
                $this->db->insert('transaction_detail',$transaction_credit_data);
                
                //transaction detail credit
                $transaction_debit_data = array(
                    'transaction_id'            => $transaction_id,
                    'voucher_type'              => 'D',
                    'voucher_no'                => $receipt_id,
                    'ledger_no'                 => $transaction['from_account'],
                    'cr_amount'                 => $transaction['amount_paid'],
                    'voucher_status'            => $transaction['voucher_status'],
                );
                $this->db->insert('transaction_detail',$transaction_debit_data);
                return true;
            }
        }
        return false;
    }
    
    function getBranchCode($id = NULL){
        $q = $this->db->get_where('branch',array('id'=>$id));
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
    
    function getRowId(){
        $q = $this->db->get('reciepts');
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                // return $row->id;
            }
            return $row->id;
        }else{
            return  false;
        }
    }
}
?>