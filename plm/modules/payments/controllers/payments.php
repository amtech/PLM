<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Payments extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->library('form_validation');
        $this->load->model('payments_model');
        $this->load->database();
        $this->load->library('Datatables');
        $this->load->library('Branchname');
    }
    
    function index(){
        $meta['page_title'] = 'Payments Details';
        $data['page_title'] = "Payments Details";
        $this->load->view('commons/header',$meta);
        $this->load->view('index',$data);
        $this->load->view('commons/footer');
    }
    
    function paymentDetails(){
        $this->datatables->select('payments.id,payment_voucher_date,ledger.title,purchase_id,payment_amount,paid_amount,mode_of_receipt')
        ->unset_column('payments.id')
        ->from('payments')
        ->join('ledger','ledger.id = payments.payment_ledger_id');
        // ->add_column("Actions", "<a href='view/$1'><i class='fa fa-eye'></i></a> ", "reciepts.id");
        
        echo $this->datatables->generate();
    }
    
    function add(){
        // validation
        // validation
        $this->form_validation->set_rules('payment_voucher_date','Payment Date','trim|required');
        $this->form_validation->set_rules('from','From Ledger','trim|required|callback_check_fromLedger');
        $this->form_validation->set_rules('to','To Ledger','trim|required|callback_check_toLedger');
        $this->form_validation->set_rules('purchase_id','Purchase','trim');
        $this->form_validation->set_rules('payment_amount_paid','Amount Paid','trim|required|numeric');
        
        if($this->form_validation->run() == true){
            $type = 'P';
            $transaction_date = date('Y-m-d');
            $transaction_ref = '';
            if($this->input->post('mode_of_receipt')){
                $c_date = explode('/',$this->input->post('cheque_date'));
                $cheque_date = $c_date[2].'-'.$c_date[1].'-'.$c_date[0];
                $cheque_no = $this->input->post('cheque_no');
                $bank_name = $this->input->post('bank_name');
            }else{
                $cheque_date = '';
                $cheque_no = '';
                $bank_name = '';
            }
            
            $d = explode('/',$this->input->post('payment_voucher_date'));
            $d_date = $d[2].'-'.$d[1].'-'.$d[0];
            $dataPayment = array(
                'payment_voucher_date'      => $d_date,
                'payment_ledger_id'         => $this->input->post('from'),
                'purchase_id'               => $this->input->post('purchase_id'),
                'payment_amount'            => $this->input->post('amount_payable'),
                'paid_amount'               => $this->input->post('payment_amount_paid'),
                'description'               => $this->input->post('description'),
                'mode_of_receipt'           => $this->input->post('mode_of_receipt'),
                'user'                      =>  USER_ID,
                'status'                    => 1
            );
            // echo $cheque_date;
            // echo '<pre>';
            // print_r($dataPayment);exit;
            
            $transaction_header = array(
                'transaction_date'      => $transaction_date,
                'purchase_id'           => $this->input->post('purchase_id'),
                'type'                  => $type,
                'amount_payable'        => $this->input->post('amount_payable'),
                'amount_paid'           => $this->input->post('payment_amount_paid'),
                'voucher_date'          => $d_date,
                'mode'                  => $this->input->post('mode_of_receipt'),
                'cheque_date'           => $cheque_date,
                'cheque_no'             => $cheque_no,
                'bank_name'             => $bank_name,
                'from_account'          => $this->input->post('from'),
                'to_account'            => $this->input->post('to'),
                'narration'             => $this->input->post('description'),
                'transaction_ref'       => $transaction_ref,
                'user'                  => USER_ID,
                'voucher_status'        => 1,
            );
            // echo '<pre>';
            // print_r($transaction_header);exit;
        }
        
        if(($this->form_validation->run() == true) && $this->payments_model->addPayment($dataPayment,$transaction_header)){
            $this->session->set_flashdata('success','Payment added successfully.');
            redirect('payments','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $data['ledgers'] = $this->payments_model->getLedgers();
            $data['purchases'] = $this->payments_model->getPurchases();
            // $data['inv_no'] = $this->payments_model->getInvNo();
            $meta['page_title'] = 'Add Payment';
            $data['page_title'] = "Add Payment";
            $this->load->view('commons/header',$meta);
            $this->load->view('add',$data);
            $this->load->view('commons/footer');
        }
    }
    
    function check_fromLedger(){
        if($this->input->post('from') == '0'){
            $this->form_validation->set_message('check_fromLedger','Please select from account.');
            return false;
        }
        return true;
    }
    
    function check_toLedger(){
        if($this->input->post('to') == '0'){
            $this->form_validation->set_message('check_toLedger','Please select to account.');
            return false;
        }
        return true;
    }
    
    function getAmountPayableInv(){
        $purchase_id = $this->input->post('purchase_id');
        $purchases = $this->payments_model->getPurchaseByID($purchase_id);
        echo json_encode($purchases);
    }
}
?>