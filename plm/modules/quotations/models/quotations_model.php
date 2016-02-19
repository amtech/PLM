<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Quotations_model extends CI_Model{
    function __construct(){
    	parent::__construct();
        // code that publicly accessed in this class
    }
    
    function getQuotes(){
        $q = $this->db->select('quotations.id,branch.branch_name,quotation_date,validity,customers.name,total')
		->from('quotations')
        ->join('branch','branch.id = quotations.branch_id')
        ->join('customers','customers.id = quotations.customer_id')
        ->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }

    function getParts(){
        $q = $this->db->get('parts');
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }

    function getDiscount(){
        $q = $this->db->get_where('discount',array('discount_type'=>DEFAULT_DISCOUNT));
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }

    function getBranch(){
    	$q = $this->db->get('branch');
    	if($q->num_rows() > 0){
    		foreach($q->result() as $row){
    			$row1[] = $row;
    		}
    		return $row1;
    	}
    	return false;
    }

    function getCustomers(){
    	$q = $this->db->get('customers');
    	if($q->num_rows() > 0){
    		foreach ($q->result() as $row) {
    			$row1[] = $row;
    		}
    		return $row1;
    	}
    	return false;
    }

    function addCustomer($data = array()){
        if($this->db->insert('customers',$data)){
            return true;
        }
        return false;
    }
    
    function addQuotations($data = array(), $items){
        if($this->db->insert('quotations',$data)){
			$quotation_id = $this->db->insert_id();
            
            $rev_quote = array_merge($data,array('quotation_id' => $quotation_id));
            $this->db->insert('revised_quotations',$rev_quote);
            
            $addOn = array('quotation_id' => $quotation_id);
			end($addOn);
			foreach ( $items as &$var ) {
				$var = array_merge($addOn, $var);
			}
			if($this->db->insert_batch('quotation_items', $items) && $this->db->insert_batch('rev_quotation_items', $items)){
				return true;
			}
		}
		return false;
    }
    
    function getPartDetail($id = NULL){
		$q = $this->db->get_where('parts',array('id'=>$id));
		if($q->num_rows() > 0){
			return $q->result_array();
		}
		return false;
	}
    
    function getQuotationById($id){
        $this->db->join('branch','branch.id = quotations.branch_id');
        $this->db->join('customers','customers.id = quotations.customer_id');
        $q = $this->db->select('quotations.*,branch.*,customers.name,customers.contact_person')->from('quotations')->where('quotations.id',$id)->get();
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
    
    function getQuoteItemsByID($id = NULL){
        $this->db->where('quotation_id',$id);
        $this->db->join('parts','parts.id = quotation_items.part_id');
		$q = $this->db->select('quotation_items.*,parts.code')->from('quotation_items')->get();
        // $q = $this->db->get('quotation_items');
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getRevisedQuotationById($id){
        $q = $this->db->select('revised_quotations.*,branch.branch_name,customers.name,rev_quotation_items.*,parts.name as part_name')->from('revised_quotations')
            ->join('branch','branch.id = revised_quotations.branch_id')
            ->join('customers','customers.id = revised_quotations.customer_id')
            ->join('rev_quotation_items','rev_quotation_items.quotation_id = revised_quotations.id')
            ->join('parts','parts.id = rev_quotation_items.part_id')
            // ->join('discount','discount.id = rev_quotation_items.discount_type')
            ->where('revised_quotations.id',$id)
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
    
    function editQuote($data,$items,$id){
        // $this->db->where('id', $id);
        if($this->db->insert('revised_quotations', $data)){
            $id1 = $this->db->insert_id();
            $addOn = array('quotation_id' => $id1);
            end($addOn);
            
            foreach ( $items as &$var ) {
                    $var = array_merge($addOn, $var);
            }
        
            if($this->db->insert_batch('rev_quotation_items', $items)) {
                return true;
            }
        }
        return false;
    }
    
    function delete($id = NULL){
        if($this->db->delete('quotations',array('id'=>$id))){
            if($this->db->delete('quotation_items',array('quotation_id'=>$id))){
                return true;
            }
        }
        return false;
    }
    
    function getRevQuotes($id = NULL){
        $q = $this->db->get_where('revised_quotations',array('quotation_id'=>$id));
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
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
        $q = $this->db->get('quotations');
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