<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Custom_config{
    public $this;
    public function __construct()
    {
		$this->cc = & get_instance();
		$this->cc->db->select('*');
		$this->cc->db->from('general_config'); 
        $query = $this->cc->db->get();
        $results = $query->result();
		if($results){
			foreach($results  as $result){
				if($result->config_var != '')
					$this->cc->config->set_item($result->config_var, $result->config_value);
			}
		}
		
		
    }
    
}