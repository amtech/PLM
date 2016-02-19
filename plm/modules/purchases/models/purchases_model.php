<?php
class Purchases_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
    
    function getPurchasePartsDetails(){
        $q = $this->db->select('purchase_parts.id,vendor.company_name,po_no,expected_date,order_date,ship_via,ship_to,total')
		->from('purchase_parts')
        ->join('vendor','vendor.id = purchase_parts.vendor_reference')
        ->get();
        if($q->num_rows() > 0){
			foreach($q->result() as $row){
				$row1[] = $row;
			}
			return $row1;
		}
		return false;
    }
    
    function getVendor($branch_id = NULL){
        $this->db->where('branch_id',$branch_id);
        $q = $this->db->get('vendor');
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

	function getPartDetail($id = NULL){
		$q = $this->db->get_where('parts',array('id'=>$id));
		if($q->num_rows() > 0){
			return $q->result_array();
		}
		return false;
	}
    
    public function getProductQuantity($part_id, $warehouse) 
	{
		$q = $this->db->get_where('warehouse_items', array('part_id' => $part_id, 'warehouse_id' => $warehouse), 1); 
		
		  if( $q->num_rows() > 0 )
		  {
			return $q->row_array(); //$q->row();
		  } 
		
		  return FALSE;
		
	}
    
    public function updateQuantity($part_id, $warehouse_id, $quantity)
	{	

			$productData = array(
				'quantity'	     			=> $quantity
			);
		
		//$this->db->where('product_id', $id);		
		if($this->db->update('warehouse_items', $productData, array('part_id' => $part_id, 'warehouse_id' => $warehouse_id))) {
			return true;
		} else {
			return false;
		}
	}
    
    public function insertQuantity($part_id, $warehouse_id, $quantity)
	{	

			// Product data
			$productData = array(
				'part_id'   	     		=> $part_id,
				'warehouse_id'   			=> $warehouse_id,
				'quantity' 					=> $quantity
			);
            
            // echo '<pre>';
            // print_r($productData);exit;

		if($this->db->insert('warehouse_items', $productData)) {
			return true;
		} else {
			return false;
		}
	}
    
    public function updatePartQuantity($part_id, $quantity, $warehouse_id, $product_cost, $customs, $freight)
	{

		// update the product with new details
		if($this->updatePrice($part_id, $product_cost, $quantity, $customs, $freight) && $this->addQuantity($part_id, $warehouse_id, $quantity))
		{
			return true;
		} 
			
			return false;
	}
    
    public function updatePrice($id, $cost, $quantity, $customs, $service_tax)
	{
		//following calculation changes 
        // $unit_price = ((($cost * $quantity) + (((($cost * $quantity) + $freight) * 5)/100)) + (10*(($cost * $quantity) + (5*($cost * $quantity)+$freight)/100)/100))/$quantity;
        $unit_price = (($cost * $quantity) + $customs + $service_tax)/$quantity;
		// Part data 
		$productData = array(
		    'price' 	=> $unit_price
		);
		
		$this->db->where('id', $id);
		if($this->db->update('parts', $productData)) {
			return true;
		} 
			
			return false;

	}
    
    function addQuantity($part_id, $warehouse_id, $quantity){
        //check if entry exist then update else insert
		if($this->getProductQuantity($part_id, $warehouse_id)) {
			
		$warehouse_quantity = $this->getProductQuantity($part_id, $warehouse_id);	
		$old_quantity = $warehouse_quantity['quantity'];		
		$new_quantity = $old_quantity + $quantity;
					
			if($this->updateQuantity($part_id, $warehouse_id, $new_quantity)){
				return TRUE;
			}
			
		} else {
						
			if($this->insertQuantity($part_id, $warehouse_id, $quantity)){
				return TRUE;
			}
		}
		
		return FALSE;
    }

	function addPurchasePart($dataParts = array(), $items = array(), $warehouse_id = NULL){
		if($this->db->insert('purchase_parts',$dataParts)){
			$purchase_part_id = $this->db->insert_id();
            
            foreach($items as $data){
				$this->updatePartQuantity($data['part_id'], $data['part_quantity'], $warehouse_id, $data['cost'], $data['customs'], $data['service_tax']);
			}

			$addOn = array('purchase_part_id' => $purchase_part_id);
			end($addOn);
			foreach ( $items as &$var ) {
				$var = array_merge($addOn, $var);
			}
			if($this->db->insert_batch('purchase_part_items', $items)){
				return true;
			}
		}
		return false;
	}

	function getPurchaseParts($id = NULL){
		$this->db->select('purchase_parts.*,purchase_part_items.*,parts.name as part_name');
		$this->db->from('purchase_parts');
		$this->db->join('purchase_part_items','purchase_part_items.purchase_part_id = purchase_parts.id');
		$this->db->join('parts','parts.id = purchase_part_items.part_id');
		$this->db->where('purchase_parts.id',$id);
		$q = $this->db->get();
		// echo $this->db->last_query();exit;
		// $q = $this->db->get_where('purchase_parts',array('id'=>$id));
		if($q->num_rows() > 0){
			foreach($q->result() as $row){
				$row1[] = $row;
			}
			return $row1;
		}
		return false;
	}
    
    public function getAllInventoryItems($purchase_id) 
	{
		$this->db->order_by('id', 'asc');
		$q = $this->db->get_where('purchase_part_items', array('purchase_part_id' => $purchase_id));
		if($q->num_rows() > 0) {
			foreach (($q->result()) as $row) {
				$data[] = $row;
			}
				
			return $data;
		}
	}
    
    public function getInventoryByID($id)
	{

		$q = $this->db->get_where('purchase_parts', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
    
    public function getItemByID($id)
	{

		$q = $this->db->get_where('purchase_part_items', array('id' => $id), 1); 
		  if( $q->num_rows() > 0 )
		  {
			return $q->row();
		  } 
		
		  return FALSE;

	}
    
    function editPurchasePart($dataParts = array(), $items = array(), $warehouse_id = NULL, $id = NULL){
        
        $old_items = $this->getAllInventoryItems($id);
        // echo '<pre>';
        // print_r($old_items);exit;
		$old_inv = $this->getInventoryByID($id);
        // echo '<pre>';
        // print_r($old_inv);exit;
		foreach($old_items as $data){
			$item_id = $data->id;
			$item_details = $this->getItemByID($item_id);
            $item_qiantity = $item_details->part_quantity;
			$part_id = $data->purchase_part_id;
			$pr_qty_details = $this->getProductQuantity($part_id, $old_inv->warehouse_id);
            $pr_qty = $pr_qty_details['quantity'];
			$qty = $pr_qty - $item_qiantity;
			
			$this->updateQuantity($part_id, $old_inv->warehouse_id, $qty);
		}
        
        $this->db->where('id', $id);
        if($this->db->update('purchase_parts', $dataParts) && $this->db->delete('purchase_part_items', array('purchase_part_id' => $id))){
            
            foreach($items as $data){
				$this->updatePartQuantity($data['part_id'], $warehouse_id, $data['part_quantity']);
			}
            
            $addOn = array('purchase_part_id' => $id);
                end($addOn);
                foreach ( $items as &$var ) {
                        $var = array_merge($addOn, $var);
                }
        
        
            if($this->db->insert_batch('purchase_part_items', $items)) {
                return true;
            }
        }
    }
    
    function getWarehouses(){
        $q = $this->db->get_where('warehouses',array('branch_id'=>DEFAULT_BRANCH));
        if($q->num_rows()>0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function delete_part($id = NULL){
        if($this->db->delete('purchase_parts',array('id'=>$id)) && $this->db->delete('purchase_part_items',array('purchase_part_id'=>$id))){
            return true;
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
        $q = $this->db->get('purchase_parts');
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