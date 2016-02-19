<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Sales_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function getSalesParts(){
        $q = $this->db->select('sale_part.id,po_no,date,ship_date,ship_via,ship_to,customers.name,discount_value,total,status')
            ->from('sale_part')
            ->join('customers','customers.id = sale_part.customer_id')
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
        // $q = $this->db->get_where('parts',array('branch_id'=>DEFAULT_BRANCH));
        $q = $this->db->get('parts');
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getCode($id = NULL){
        $q = $this->db->get_where('parts',array('id'=>$id));
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                return $row->code;
            }
        }
        return false;
    }
    
    function getCustomers(){
        $q = $this->db->get_where('customers',array('branch_id'=>DEFAULT_BRANCH));
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getPartDetail($id = NULL){
		$q = $this->db->get('parts');
		if($q->num_rows() > 0){
			return $q->result_array();
		}
		return false;
	}
    
    function getDiscounts(){
        $q = $this->db->get_where('discount',array('discount_type'=>DEFAULT_DISCOUNT));
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
	
	public function getSalesById($id = NULL){
		$this->db->join('customers','customers.id = sale_part.customer_id');
		$q = $this->db->select('sale_part.*,customers.name,customers.address')->from('sale_part')->where('sale_part.id',$id)->get();
		if($q->num_rows() > 0){
			return $q->row();
		}
		return FALSE;
	}
	
	public function getSaleItemById($id = NULL){
		$this->db->join('parts','parts.id = sale_part_items.sale_part_id');
		$q = $this->db->select('sale_part_items.*, parts.code')->from('sale_part_items')->where('sale_part_id',$id)->get();
		if($q->num_rows() > 0){
			foreach($q->result() as $row){
				$row1[] = $row;
			}
			return $row1;
		}
		return FALSE;
	}
    
    public function updateProductQuantity($product_id, $warehouse_id, $quantity)
	{

		// update the product with new details
		if($this->addQuantity($product_id, $warehouse_id, $quantity))
		{
			return true;
		} 
			
			return false;
	}
    
    public function addQuantity($product_id, $warehouse_id, $quantity) 
	{
		
		if($this->getProductQuantity($product_id, $warehouse_id)) {
			
		$warehouse_quantity = $this->getProductQuantity($product_id, $warehouse_id);	
		$old_quantity = $warehouse_quantity['quantity'];		
		$new_quantity = $old_quantity - $quantity;
					
			if($this->updateQuantity($product_id, $warehouse_id, $new_quantity)){
				return TRUE;
			}
			
		}// else {
						
			// if($this->insertQuantity($product_id, $warehouse_id, -$quantity)){
				// return TRUE;
			// }
		// }
		
		return FALSE;

	}
    
    public function updateQuantity($product_id, $warehouse_id, $quantity)
	{	

			$productData = array(
				'quantity'	     			=> $quantity
			);
		
		//$this->db->where('product_id', $id);		
		if($this->db->update('warehouse_items', $productData, array('part_id' => $product_id, 'warehouse_id' => $warehouse_id))) {
			return true;
		} else {
			return false;
		}
	}
    
    public function getProductQuantity($product_id, $warehouse) 
	{
        $q = $this->db->get_where('warehouse_items', array('part_id' => $product_id, 'warehouse_id' => $warehouse), 1); 
		
		  if( $q->num_rows() > 0 )
		  {
            // echo '<pre>';
            // print_r($q->row_array());exit;
			return $q->row_array(); //$q->row();
		  } 
		
		  return FALSE;
		
	}
    
    function addSalePart($data = array(), $items = array(), $warehouse_id){
        if($this->db->insert('sale_part',$data)){
            $sale_part_id = $this->db->insert_id();
            
            foreach($items as $idata){
				$this->updateProductQuantity($idata['part_id'], $warehouse_id, $idata['quantity']);
			}
            
            $addOn = array('sale_part_id' => $sale_part_id);
			end($addOn);
			foreach ( $items as &$var ) {
				$var = array_merge($addOn, $var);
			}
			if($this->db->insert_batch('sale_part_items', $items)){
				return true;
			}
        }
    }
    
    function getSalePartByID($id = NULL){
        $q = $this->db->select('sale_part.*,sale_part_items.*')
            ->from('sale_part')
            ->join('sale_part_items','sale_part_items.sale_part_id = sale_part.id')
            ->where('sale_part.id',$id)
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
    
    public function getAllInvoiceItems($sale_id) 
	{
		$this->db->order_by('id', 'asc');
		$q = $this->db->get_where('sale_part_items', array('sale_part_id' => $sale_id));
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
    
    function editSalePart($data1 = array(), $items = array(), $warehouse_id, $id = NULL){
        // echo '<pre>';
        // print_r($data);exit;
        if($old_items = $this->getAllInvoiceItems($id)){
            foreach($old_items as $data){
                $item_id = $data->id;
                $item_qiantity = $data->quantity;
                $part_id = $data->part_id;
                $pr_qty_details = $this->getProductQuantity($part_id, $warehouse_id);
                $pr_qty = $pr_qty_details['quantity'];
                $qty = $pr_qty + $item_qiantity;
            
                $this->updateQuantity($part_id, $warehouse_id, $qty);
            }
        }
        
        $this->db->where('id', $id);
        if($this->db->update('sale_part', $data1) && $this->db->delete('sale_part_items', array('sale_part_id' => $id))){
            
            foreach($items as $idata){
                $this->updateProductQuantity($idata['part_id'], $warehouse_id, $idata['quantity']);
            }
            
            $addOn = array('sale_part_id' => $id);
                end($addOn);
                foreach ( $items as &$var ) {
                        $var = array_merge($addOn, $var);
                }
        
        
            if($this->db->insert_batch('sale_part_items', $items)) {
                return true;
            }
        }
    }
    
    function getWarehouses(){
        $q = $this->db->get_where('warehouses',array('branch_id'=>DEFAULT_BRANCH));
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function delete_part($id = NULL){
        if($this->db->delete('sale_part',array('id'=>$id)) && $this->db->delete('sale_part_items',array('sale_part_id' => $id))){
            return true;
        }
        return false;
    }
    
    function getQuantity($part_id = NULL, $warehouse_id = NULL){
        $q = $this->db->select('warehouse_items.*')
            ->from('warehouse_items')
            ->where('part_id',$part_id)
            ->where('warehouse_id',$warehouse_id)
            ->get();
        if($q->num_rows() > 0){
            return $q->row();
        }
        return FALSE;
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
        $q = $this->db->get('sale_part');
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                // return $row->id;
            }
            return $row->id;
        }
        return false;
    }
}
?>