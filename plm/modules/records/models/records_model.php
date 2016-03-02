<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Records_model extends CI_Model{
    function __construct(){
    	parent::__construct();
        // code that publicly accessed in this class
    }
    
    function getProducts(){
        $q = $this->db->get('products');
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
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
    
    function getCustomers(){
        $q = $this->db->get('customers');
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function addRecord($record,$warrenty,$items){
        if($this->db->insert('records',$record)){
            $record_id = $this->db->insert_id();
            $dataWarrenty = array(
                'record_id'         => $record_id,
                'warranty_type'     => $warrenty['warranty_type'],
                'starting_date'     => $warrenty['starting_date'],
                'duration_months'   => $warrenty['duration_months'],   
                'duration_hours'    => $warrenty['duration_hours'],    
                'expiry_date'       => $warrenty['expiry_date'],
                'creation_time'     => $warrenty['creation_time'],
            );
            if($this->db->insert('warranty',$dataWarrenty)){
                $addOn = array('record_id' => $record_id);
                end($addOn);
                foreach ( $items as &$var ) {
                    $var = array_merge($addOn, $var);
                }
                if($this->db->insert_batch('technical_data', $items)){
                    return true;
                }
            }
        }
    }
    
    function getRecordById($id){
        $q = $this->db->select('records.*,warranty.*,technical_data.*')
            ->from('records')
            ->join('warranty','warranty.record_id = records.id')
            ->join('technical_data','technical_data.record_id = records.id')
            ->where('records.id',$id)
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
        $q = $this->db->select('records.ro_no as RO_NO,records.id,brand.brand_name,categories.category_name,products.model_name,products.serial_no,products.model_name,customers.name,delivery_date,records.status')
		->from('records')
        ->join('products','products.id = records.product_id')
        ->join('categories','categories.id = products.category_id')
        ->join('brand','brand.id = products.brand_id')
        ->join('customers','customers.id = records.customer_id')
        ->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function editRecord($record,$warrenty,$items,$id){
        $this->db->where('id',$id);
        if($this->db->update('records',$record) && $this->db->delete('technical_data',array('record_id'=>$id))){
            $this->db->where('record_id',$id);
            if($this->db->update('warranty',$warrenty)){
                $addOn = array('record_id' => $id);
                end($addOn);
                foreach ( $items as &$var ) {
                    $var = array_merge($addOn, $var);
                }
                if($this->db->insert_batch('technical_data', $items)){
                    return true;
                }
            }
        }
    }
    
    function delete($id){
        if($this->db->delete('records',array('id'=>$id)) && $this->db->delete('warranty',array('record_id'=>$id)) && $this->db->delete('technical_data',array('record_id'=>$id))){
            return true;
        }
        return false;
    }
    
    function getServiceHistoryByID($id = NULL){
        $q = $this->db->select('records.id,services.*')
            ->from('records')
            ->join('services','services.record_id = records.id')
            ->where('records.id',$id)
            ->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getPartsHistoryByID($id = NULL){
        $q = $this->db->select('records.id,service_parts.*,parts.code,services.service_report_no')
            ->from('records')
            ->join('service_parts','service_parts.service_record_id = records.id')
            ->join('parts','parts.id = service_parts.part_id')
            ->join('services','services.id = service_parts.service_id')
            ->where('records.id',$id)
            ->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getRecordsWithCommission(){
        $q = $this->db->select('records.id,records.ro_no,products.serial_no')
            ->from('records')
            ->join('products','products.id = records.product_id')
            ->where('report',0)
            ->where('status','completed')
            ->get();
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function addCommission($data = array()){
        if($this->db->insert('commission',$data)){
            return true;
        }
        return false;
    }
    
    function getCommission(){
        $q = $this->db->select('commission.*,records.ro_no')
            ->from('commission')
            ->join('records','records.id = commission.record_id')
            // ->join('services','services.record_id = records.id')
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
    function getCompletedCommission(){
        $q = $this->db->select('commission.*,records.ro_no,services.technician_name')
            ->from('commission')
            ->join('records','records.id = commission.record_id')
            ->join('services','services.record_id = records.id')
            ->where('records.report',0)
            ->where('records.status','completed')
            ->get();
        
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                $row1[] = $row;
            }
            return $row1;
        }
        return false;
    }
    
    function getPendingCommission(){
        $q = $this->db->select('records.*')
            ->from('records')
            // // ->join('records','records.id = commission.record_id')
            // // ->join('services','services.record_id = records.id')
            // ->where('records.report',1)
            ->where('records.status','pending')
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
    
    function getCommissionByID($id){
        $q = $this->db->select('commission.*,records.ro_no')
            ->from('commission')
            // ->join('users','users.id = commission.technician_id')
            ->join('records','records.id = commission.record_id')
            ->where('commission.id',$id)
            ->get();
        if($q->num_rows() > 0){
            return $q->row();
        }
        return false;
    }
    
    function editCommission($data,$id){
        $this->db->where('id',$id);
        if($this->db->update('commission',$data)){
            return true;
        }
        return false;
    }
    
    function delete_commission($id){
        if($this->db->delete('commission',array('id'=>$id))){
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
        $q = $this->db->get('records');
        if($q->num_rows() > 0){
            foreach($q->result() as $row){
                // return $row->id;
            }
            return $row->id;
        }else{
            return  false;
        }
    }
    
    function getProductsByBrand($id = NULL){
        $q = $this->db->get_where('products',array('brand_id'=>$id));
        if($q->num_rows() > 0){
            return $q->result_array();
        }
        return false;
    }
    
    function getTechnician($id = NULL){
        $q = $this->db->select('services.technician_name')
            ->from('records')
            ->join('services','services.record_id = records.id')
            ->where('records.id',$id)
            ->get();
        if($q->num_rows() > 0){
            return $q->result_array();
        }
        return false;
    }
}
?>