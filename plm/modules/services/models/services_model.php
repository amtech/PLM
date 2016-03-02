<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Services_model extends CI_Model{
    function __construct(){
        // code that publicly accessed in this class
    }
    
    function getServices(){
        $q = $this->db->select('services.id,records.ro_no,service_date,warranty,working_hour,services.technician_name,service_report_no,service_charge,parts_total,total,products.serial_no,products.model_name')
        ->from('services')
        ->join('records','records.id = services.record_id')
		->join('products','records.product_id = products.id')
        ->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getRecords(){
        // $q = $this->db->get('records');
        $q = $this->db->select('distinct(records.id),records.ro_no,products.serial_no')
            ->from('records')
            ->join('products','products.id = records.product_id')
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
    
    function getTechnician(){
        $q = $this->db->select('users.*')
            ->from('users')
            ->join('users_groups','users_groups.user_id = users.id')
            ->join('groups','groups.id = users_groups.group_id')
            ->where('groups.name','technician')
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
    
    function addService($data = array(), $items = array()){
        if($this->db->insert('services',$data)){
            $service_id = $this->db->insert_id();
            
            $addOn = array('service_id' => $service_id);
			end($addOn);
			foreach ( $items as &$var ) {
				$var = array_merge($addOn, $var);
			}
			if($this->db->insert_batch('service_parts', $items)){
				return true;
			}
		}
		return false;
    }
    
    function getServiceByID($id = NULL){
        $q = $this->db->select('services.*')
            ->from('services')
            // ->join('service_parts','service_parts.service_id = services.id')
            ->where('services.id',$id)
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
    
    function getServicePartByID($id = NULL){
        $q = $this->db->select('service_parts.*')
            ->from('service_parts')
            ->where('service_parts.service_id',$id)
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
    
    function editService($data = array(), $items = array(), $id = NULL){
        $this->db->where('id', $id);
        if($this->db->update('services', $data) && $this->db->delete('service_parts', array('service_id' => $id))){
            
            $addOn = array('service_id' => $id);
                end($addOn);
                foreach ( $items as &$var ) {
                        $var = array_merge($addOn, $var);
                }
        
        
            if($this->db->insert_batch('service_parts', $items)) {
                return true;
            }
        }
        return false;
    }
}
?>