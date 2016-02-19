<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Reciepts extends CI_Controller{
    function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
        $this->load->library('form_validation');
        $this->load->model('reciepts_model');
        $this->load->database();
        $this->load->library('Datatables');
        $this->load->library('Branchname');
    }
    
    function index(){
        $meta['page_title'] = 'Reciepts Details';
        $data['page_title'] = "Reciepts Details";
        $this->load->view('commons/header',$meta);
        $this->load->view('index',$data);
        $this->load->view('commons/footer');
    }
    
    function recieptDetails(){
        $this->datatables->select('reciepts.id,receipt_voucher_date,ledger.title,invoice_no,sale_id,receipt_amount,paid_amount,mode_of_receipt')
        ->unset_column('reciepts.id')
        ->from('reciepts')
        ->join('ledger','ledger.id = reciepts.reciept_ledger_id');
        // ->add_column("Actions", "<a href='view/$1'><i class='fa fa-eye'></i></a> ", "reciepts.id");
        
        echo $this->datatables->generate();
    }
    
    function add(){
        // validation
        $this->form_validation->set_rules('receipt_voucher_date','Reciept Date','trim|required');
        $this->form_validation->set_rules('from','From Ledger','trim|required|callback_check_fromLedger');
        $this->form_validation->set_rules('to','To Ledger','trim|required|callback_check_toLedger');
        $this->form_validation->set_rules('sale_id','Sales','trim');
        $this->form_validation->set_rules('service_id','Service','trim');
        $this->form_validation->set_rules('amount_payable','Amount payble','trim');
        $this->form_validation->set_rules('receipt_amount_paid','Amount Paid','trim|required|numeric');
        
        if($this->form_validation->run() == true){
            $type = 'R';
            $transaction_date = date('Y-m-d');
            $transaction_ref = '';
            $c_date = explode('/',$this->input->post('cheque_date'));
            $cheque_date = $c_date[2].'-'.$c_date[1].'-'.$c_date[0];
            $cheque_no = $this->input->post('cheque_no');
            $bank_name = $this->input->post('bank_name');
            
            $d = explode('/',$this->input->post('receipt_voucher_date'));
            $d_date = $d[2].'-'.$d[1].'-'.$d[0];
            $dataReciept = array(
                'receipt_voucher_date'      => $d_date,
                'reciept_ledger_id'         => $this->input->post('from'),
                'invoice_no'                => $this->input->post('inv_no'),
                'sale_id'                   => $this->input->post('sale_id'),
                'service_id'                => $this->input->post('service_id'),
                'receipt_amount'            => $this->input->post('amount_payable'),
                'paid_amount'               => $this->input->post('receipt_amount_paid'),
                'description'               => $this->input->post('description'),
                'mode_of_receipt'           => $this->input->post('mode_of_receipt'),
                'user'                      =>  USER_ID,
                'status'                    => 1
            );
            // echo '<pre>';
            // print_r($dataReciept);exit;
            
            $transaction_header = array(
                'transaction_date'      => $transaction_date,
                'sale_id'               => $this->input->post('sale_id'),
                'service_id'            => $this->input->post('service_id'),
                'type'                  => $type,
                'amount_payable'        => $this->input->post('amount_payable'),
                'amount_paid'           => $this->input->post('receipt_amount_paid'),
                'voucher_date'          => $d_date,
                'mode'                  => $this->input->post('mode_of_receipt'),
                'cheque_date'           => $cheque_date,
                'cheque_no'             => $cheque_no,
                'bank_name'             => $bank_name,
                'from_account'          => $this->input->post('from'),
                'to_account'            => $this->input->post('to'),
                'narration'             => $this->input->post('description'),
                'transaction_ref'       => $transaction_ref,
                'voucher_status'        => 1,
            );
            // echo '<pre>';
            // print_r($transaction_header);exit;
        }
        
        if(($this->form_validation->run() == true) && $this->reciepts_model->addReciept($dataReciept, $transaction_header)){
            $this->session->set_flashdata('success','Reciept added successfully.');
            redirect('reciepts','refresh');
        }else{
            $data['errors'] = $this->form_validation->error_array();
            $branch = $this->reciepts_model->getBranchCode(DEFAULT_BRANCH);
            $rowID = $this->reciepts_model->getRowId();
            $last_id = $rowID;
            $rest = substr("$last_id", -4);  
            $insert_id = "$rest" + 1;
            $ars = sprintf("%04d", $insert_id);
            $data['inv_no'] = 'INV'.date('y').$branch->branch_code.$ars;
            // $data['inv_no'] = $this->reciepts_model->getInvNo();
            // echo '<pre>';
            // print_r($data['inv_no']);exit;
            $data['ledger'] = $this->reciepts_model->getLedger();
            $data['sales'] = $this->reciepts_model->getSales();
            $data['services'] = $this->reciepts_model->getServices();
            // echo '<pre>';
            // print_r($data['to']);exit;
            $meta['page_title'] = 'Add Reciept';
            $data['page_title'] = "Add Reciept";
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
    
    function check_sale(){
        if($this->input->post('sale_id') == '0'){
            $this->form_validation->set_message('check_sale','Please select sale.');
            return false;
        }
        return true;
    }
    
    function getAmountPayable(){
        $sale_id = $this->input->post('sale_id');
        $amt = $this->reciepts_model->getAmount($sale_id);
        echo json_encode($amt);
    }
    
    function getServiceAmountPayable(){
        $service_id = $this->input->post('service_id');
        $amt = $this->reciepts_model->getServiceAmount($service_id);
        echo json_encode($amt);
    }
    
    
}
?>