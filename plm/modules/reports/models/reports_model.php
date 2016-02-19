<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Reports_model extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    function getInventoryValueation(){
        $q = $this->db->select('parts.*,warehouse_items.quantity,warehouses.warehouse_name')
            ->from('parts')
            ->join('warehouse_items','warehouse_items.part_id = parts.id')
            ->join('warehouses','warehouses.id = warehouse_items.warehouse_id')
            ->get();
        
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getPurchaseOrder(){
        $q = $this->db->select('purchase_parts.*,purchase_part_items.*,parts.*,warehouses.warehouse_name,warehouse_items.quantity')
            ->from('purchase_parts')
            ->join('purchase_part_items','purchase_part_items.purchase_part_id = purchase_parts.id')
            ->join('parts','parts.id = purchase_part_items.part_id')
            ->join('warehouses','warehouses.id = purchase_parts.warehouse_id')
            ->join('warehouse_items','warehouse_items.part_id = parts.id')
            // ->where('purchase_part_items.part_recieved','yes')
            ->get();
        
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }

    function getDateWisePurchase($data = array()){
        $from = $data['from'];
        $to = $data['to'];
        $this->db->where("order_date BETWEEN '$from' AND '$to'");
        $q = $this->db->select('purchase_parts.*,purchase_part_items.*,parts.*,warehouses.warehouse_name,warehouse_items.quantity')
            ->from('purchase_parts')
            ->join('purchase_part_items','purchase_part_items.purchase_part_id = purchase_parts.id')
            ->join('parts','parts.id = purchase_part_items.part_id')
            ->join('warehouses','warehouses.id = purchase_parts.warehouse_id')
            ->join('warehouse_items','warehouse_items.part_id = parts.id')->get();
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getPurchaseOrderPending(){
        $q = $this->db->select('purchase_parts.*,purchase_part_items.*,parts.*,warehouses.warehouse_name,warehouse_items.quantity')
            ->from('purchase_parts')
            ->join('purchase_part_items','purchase_part_items.purchase_part_id = purchase_parts.id')
            ->join('parts','parts.id = purchase_part_items.part_id')
            ->join('warehouses','warehouses.id = purchase_parts.warehouse_id')
            ->join('warehouse_items','warehouse_items.part_id = parts.id')
            ->where('purchase_part_items.part_recieved','no')
            ->get();
        
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    // function getStockOnHand(){
        
    // }
    
    // stock by vendor
    function getStockByVendor(){
        $q = $this->db->select('purchase_parts.*,vendor.contact_person,parts.*,warehouses.warehouse_name,purchase_part_items.part_quantity')
            ->from('purchase_parts')
            ->join('warehouses','warehouses.id = purchase_parts.warehouse_id')
            ->join('vendor','vendor.id = purchase_parts.vendor_reference')
            ->join('purchase_part_items','purchase_part_items.purchase_part_id = purchase_parts.id')
            ->join('parts','parts.id = purchase_part_items.part_id')
            ->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getStockByVendorID($id = NULL){
        $q = $this->db->select('purchase_parts.*,vendor.contact_person,parts.*,warehouses.warehouse_name,purchase_part_items.part_quantity')
            ->from('purchase_parts')
            ->join('warehouses','warehouses.id = purchase_parts.warehouse_id')
            ->join('vendor','vendor.id = purchase_parts.vendor_reference')
            ->join('purchase_part_items','purchase_part_items.purchase_part_id = purchase_parts.id')
            ->join('parts','parts.id = purchase_part_items.part_id')
            ->where('vendor.id',$id)
            ->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getVendor(){
        $q = $this->db->get('vendor');
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getEquipmentsByBrand(){
        $this->db->select('brand.brand_name,count(*) as total')->from('products');
        $this->db->where('`brand_id` IN(SELECT `id` FROM `brand`)',NULL,FALSE);
        $this->db->join('brand','brand.id = products.brand_id');
        $this->db->group_by('products.brand_id');
        $q = $this->db->get();
        // echo $this->db->last_query();exit;
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
}
?>