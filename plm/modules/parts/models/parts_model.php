<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Parts_model extends CI_Model{
    function __construct(){
        // code that publicly accessed in this class
    }
    
    function getParts(){
        $q = $this->db->select('parts.id,code,name,desc,alert_quantity')
        ->from('parts')->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function addPart($data = array()){
        if($this->db->insert('parts',$data)){
            return true;
        }
        return false;
    }
    
    function getPartById($id = NULL){
        $q = $this->db->get_where('parts',array('id'=>$id));
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;   
    }
    
    function editPart($data = array() , $id = NULL){
        $this->db->where('id',$id);
        if($this->db->update('parts',$data)){
            return true;
        }
        return false;
    }
    
    function delete($id = NULL){
        if($this->db->delete('parts',array('id'=>$id))){
            return true;
        }
        return false;
    }
    
    function getBrands(){
        $q = $this->db->get('brand');
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getAlerts(){
        $q = $this->db->select('parts.id,code,name,desc,warehouse_items.quantity,alert_quantity')
        ->from('parts')
        ->join('warehouse_items','warehouse_items.part_id = parts.id')
        ->where('parts.alert_quantity >= warehouse_items.quantity', NULL)
        ->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function add_parts($data = array()){
        if($this->db->insert_batch('parts', $data)) {
			return true;
		} else {
			return false;
		}
    }
	
	function getPurchaseOrderQTY($id = NULL){
		$query = $this->db->query("SELECT SUM(part_quantity) as PO_QTY from purchase_part_items where part_id = $id");
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				return $row->PO_QTY;
			}
		}
		return false;
	}
	
	function getSalesOrderQTY($id = NULL){
		$query = $this->db->query("SELECT SUM(quantity) as SO_QTY from sale_part_items where part_id = $id");
		if($query->num_rows() > 0){
			foreach($query->result() as $row){
				return $row->SO_QTY;
			}
		}
		return false;
	}
	
	function getOnHandQTY($id = NULL){
		$q = $this->db->query("SELECT quantity FROM warehouse_items where part_id = $id");
		if($q->num_rows() > 0){
			foreach($q->result() as $row){
				return $row->quantity;
			}
		}
		return false;
	}
}
?>