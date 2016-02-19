<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Payments_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function getLedgers(){
        $q = $this->db->select('*')->from('ledger')->where('type','Expense')->where('branch_id',DEFAULT_BRANCH)->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getPurchases(){
        $q = $this->db->get('purchase_parts');
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getPurchaseByID($purchase_id){
        $q = $this->db->select('purchase_parts.total')
            ->from('purchase_parts')
            ->where('id',$purchase_id)
            ->get();
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
    
    function addPayment($data = array(), $transaction = array() ){
        if($this->db->insert('payments',$data)){
            $payment_id = $this->db->insert_id();
            
            $transaction_header_data = array(
                'transaction_date'      => $transaction['transaction_date'],
                'purchase_id'           => $transaction['purchase_id'],
                'type'                  => $transaction['type'],
                'amount_payable'        => $transaction['amount_payable'],
                'amount_paid'           => $transaction['amount_paid'],
                'voucher_no'            =>  $payment_id,
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
                $transaction_debit_data = array(
                    'transaction_id'            => $transaction_id,
                    'voucher_type'              => 'D',
                    'voucher_no'                => $payment_id,
                    'ledger_no'                 => $transaction['from_account'],
                    'dr_amount'                 => $transaction['amount_paid'],
                    'voucher_status'            => $transaction['voucher_status'],
                );
                $this->db->insert('transaction_detail',$transaction_debit_data);
                
                //transaction detail credit
                $transaction_credit_data = array(
                    'transaction_id'            => $transaction_id,
                    'voucher_type'              => 'C',
                    'voucher_no'                => $payment_id,
                    'ledger_no'                 => $transaction['to_account'],
                    'cr_amount'                 => $transaction['amount_paid'],
                    'voucher_status'            => $transaction['voucher_status'],
                );
                $this->db->insert('transaction_detail',$transaction_credit_data);
                return true;
            }
        }
        return false;
    }
}
?>