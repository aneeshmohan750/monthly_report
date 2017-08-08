<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Handles admin functions.
 *
 * @package		CodeIgniter
 * @subpackage	Models
 * @category	Models
 * @author
 */

// ------------------------------------------------------------------------

class Common_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	 
	function safe_html($input_field)
	{ 
		return htmlspecialchars(trim(strip_tags($input_field)));
	}
	
	function safe_sql($input_field)
	{ 
		return mysql_real_escape_string(trim(strip_tags($input_field)));
	}
	
	
	/**
	 * to send emails to a given email address
	 *
	 * @param Sring $to_email
	 * @param Sring $from
	 * @param Sring $subject
	 * @param Sring $body_content
	 * @param Array $attachment
	 * @param Sring $from_mail
	 * @return Boolean
	 */
	
	
	
	function send_mail($to_email='', $from='', $subject, $body_content, $attachment = array(), $from_mail='', $cc=array(), $bcc=array(), $batch_mode=false, $batch_size=200)
	{
		$this->load->library ('email');
		$this->email->_smtp_auth	= FALSE; 	    
		$this->email->protocol		= "mail";
		//$this->email->smtp_host		= $this->config->item('smtp_host');
		//$this->email->smtp_user		= $this->config->item('smtp_from');
		//$this->email->smtp_pass		= $this->config->item('smtp_password');
		$this->email->mailtype		= $this->config->item('mailtype');
		
		//$this->email->smtp_timeout	= $this->config->item('smtp_timeout');
		//$this->email->smtp_port		= $this->config->item('smtp_port');
		//$this->email->smtp_crypto	= $this->config->item('smtp_crypto');
		$this->email->charset		= $this->config->item('charset');
 		
		$from_name					= ($from=='')?$this->config->item('smtp_from_name'):$from;
		$reply_mail					= ($from_mail=='')?$this->config->item('smtp_from'):$from_mail;
		$this->email->from($reply_mail, $from_name);
		$this->email->to($to_email);
		if(!empty($cc)){
			$this->email->cc($cc);
		}
		if(!empty($bcc)){
			$this->email->bcc($bcc);
		}
		$this->email->reply_to($reply_mail,$from_name);        
		//$this->email->set_mailtype('html');
		$this->email->subject($subject);
		$this->email->message($body_content);
		if($attachment !=''){
			foreach($attachment as $attach ){
				$this->email->attach($attach);
			}
		}
                
		if ($this->email->send ()){
			
 echo $this->email->print_debugger();exit;
		}
		else{
			
 echo $this->email->print_debugger();exit;
		}
	}
			
	/**
	 * get the config value
	 *
	 * @return unknown
	 */
	function get_config_item($conf_name){				
		$query = $this->db->query("SELECT config_value FROM ".$this->db->dbprefix."site_configuration WHERE config_name='".$conf_name."'");
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			if($row->config_value){
				return $row->config_value;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
	
	/**
	 * get the config value
	 *
	 * @return unknown
	 */
	function get_config_script($conf_name){				
		$query = $this->db->query("SELECT config_text FROM ".$this->db->dbprefix."site_configuration WHERE config_name='".$conf_name."'");
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			if($row->config_text){
				return $row->config_text;			
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
	
	/**
	 * to get the url of the post page
	 *
	 * @return String
	 */
	function get_post_url()
	{
		$postURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$postURL .= "s";}
		$postURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$postURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$postURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $postURL;
	}
	
	function prepare_select_box_data( $table, $fields, $where = array(), $insert_null = false,$order_by = '',$other_array = array()){
		
		list($key, $val) 	= explode(',',$fields);
		$key 				= trim($key);
		$val 				= trim($val);
		$order_by			= $order_by ? $order_by : $val;
		$input_array 		= $this->get_data( $table, $fields, $where, $order_by );

		$select_box_array 	= array();
		$total_records 		= count($input_array);
		if($insert_null) {
			$select_box_array[''] = $insert_null===true ? '' : $insert_null;
		}
		for($i = 0; $i < $total_records; $i++){
		 	$select_box_array[$input_array[$i][$key]] = $input_array[$i][$val];
		}
		if (is_array($other_array) and count($other_array) > 0){
			foreach ($other_array as $key => $val){
				$select_box_array[$key]				=	$val;
			}
		}
		return $select_box_array;
	}
	
    function record_count($table) {
        return $this->db->count_all($table);
     }
	
	function get_data( $table, $fields = '*', $where = array(),$order_by = '' ){
		if((is_array($where) && count($where)>0) or (!is_array($where) && trim($where) != '')) $this->db->where($where);
		if($order_by) $this->db->order_by($order_by);
		$this->db->select($fields);
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	function get_limit_data( $table, $fields = '*', $where = array(),$order_by = '',$start='',$limit=''){
		if((is_array($where) && count($where)>0) or (!is_array($where) && trim($where) != '')) $this->db->where($where);
		if($order_by) $this->db->order_by($order_by);
		$this->db->select($fields);
		$this->db->limit($start,$limit);
		$query = $this->db->get($table);
		$data_arr = $query->result_array();
		$data_html =$this->get_data_html($table,$data_arr);
		return $data_html;
	}
	
	function check_selectbox_values($aWhere=array(), $table_name=""){
		if($aWhere){
			$this->db->where($aWhere, "", false); 
		}
		$this->db->select('id');
		$this->db->from( $table_name ); 
		$result   = $this->db->get();
		$result = $result->result_array();
		$array_list = array();
		foreach ($result AS $res):
			$array_list[] = $res['id'];
		endforeach;
		return $array_list;
	}
	 
	function get_custom_data( $table, $fields = '*', $where = array(),$order_by = '' ){
		if((is_array($where) && count($where)>0) or (!is_array($where) && trim($where) != '')) 
		
		$this->db->where($where, "", false); 
		if($order_by) $this->db->order_by($order_by);
		$this->db->select($fields);
		$query = $this->db->get($table);
		return $query->result_array();
	}
	
	/**
	 * function to get the page titles and meta details
	 *
	 * @return unknown
	 */
	function get_page_meta($meta_id){
		$this->db->select('*');			
		$this->db->where('meta_id', $meta_id);			
		$query = $this->db->get("page_meta_details"); 			
		$result = array();
		if($query->row()) {	
			return $query->row();
		} 
		else return false;
	}
	 
	/**
	 * function for file_upload musik_track musik_mix_track
	 */  
	function file_upload($field_name = '',$upload_path = '',$allowed_type = '',$max_size = 1024){  
		if(@$_FILES[$field_name]['name']){
			$file  							=	explode('.', $_FILES[$field_name]['name']); 
			$name  							=	$file[0];
			$upload_path					=	upload_path().$upload_path; 
			
			if (!@$allowed_type){
				$config['allowed_types'] 	=   'gif|jpg|png|jpeg';
			}else{
				$config['allowed_types'] 	=   $allowed_type;
			}
			$config['upload_path'] 			=	$upload_path;
			$config['max_size'] 			=   $max_size;
			$config['remove_spaces'] 		=   TRUE; 
			$file_name						=	str_replace('(','_',$_FILES[$field_name]['name']);
			$file_name						=	str_replace(')','_',$file_name);
			$file_name						=	str_replace('-','_',$file_name);
			$config['file_name']	    	=   time().$file_name;
			
			$this->load->library('upload');
			$this->upload->initialize($config);
			
			//$uplod_result					=	 ;
			$bStatus = false;
			$data = array();
			
			if( $this->upload->do_upload($field_name) ){
				
				$bStatus 	= true;
				
				//echoo('test 1');
				//_print_r($this->upload->data());
				$data 		= array('upload_data' => $this->upload->data());
				//return $data["upload_data"]["file_name"];
			}else{
				//echoo('test 1');
				$bStatus 	= false;
				$data['error_msg'] = $this->upload->display_errors();
			}
			
			return array($bStatus, $data);
			//return false; 
		} 
	}
 
	/**
	 * function to send email
	 *
	 * @return unknown
	 */
	function process_send_mail  ($email, $email_array, $title = '' ,$from_name ='',$from='',$attachment=array(), $mailsubject='')
	{
		$values_array		= array ();			
		$result_array       = $this->common_model->get_mail_content_and_title ($title);
		foreach ($result_array as $key=>$value)
		{
			$mail_subject   = ($mailsubject) ? $mailsubject : $key;
			$email_body     = $value;
		}
		$matches            = array();
		preg_match_all("/\{\%([a-z_A-Z0-9]*)\%\}/",$email_body, $matches);
		$variables_array    = $matches[1];
	
		if (count($variables_array) > 0) 
		foreach (@$variables_array as $key)
		{
			@$values_array[] = @$email_array[$key];
		}
	
		$new_variables_array    = array();
		foreach($variables_array as $variable)
		{
			$new_variables_array[] = '/\{\%'.$variable.'\%\}/';
		}
		$body_content ='';
		$body_content .= preg_replace ($new_variables_array, $values_array, $email_body);		
		
		if ($this->common_model->send_mail($email,$from_name, $mail_subject, $body_content,array(),$from))
			return TRUE;
		else
			return FALSE;
		
	}
	
	// function to get email title and content 
	function get_mail_content_and_title ($message_title = '')
	{
        $this->db->select('subject AS TITLE, content AS BODY_CONTENT');
        $this->db->from('email_templates');
        $this->db->where('title', $message_title);		
        $select_query   = $this->db->get ();
		if (0 < $select_query->num_rows ())
		{
            foreach ($select_query->result() as $row)
            {
                $result_array[$row->TITLE] = $row->BODY_CONTENT;
            }
            return $result_array;
		}
		else
		{
		    return FALSE;
		}
	}
	
	/**
	 * check any user exist
	 */
	function isUser($email)
	{
		$this->db->where('email', $email);
		$this->db->where('status','1');
		$this->db->select('*');
		$this->db->from('user_details');
		$result		= $this->db->get ();
		if ($result->row()){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * check any user exist
	 */
	function getUserbyEmail($email)
	{
		$this->db->where('email', $email);
		$this->db->select('*');
		$this->db->from('user_details');
		$result		= $this->db->get ();
		if ($result->row()){
			return $result->row();   
		}else{
			return false;
		}
	}
	
	/**
	 * get user details
	 *
	 * @return unknown
	 */
	function getCAProfileDetails($id){	
		if(isset ($id) && '' != $id){			
			$this->db->where('user_id',$id);
			$this->db->where('status','1');
			$this->db->select('*');
			$query	=	$this->db->get('user_profile');			
			if($query->row()){
				return $query->row();
			}else{
				return FALSE;
			}
		}else{ 
			return FALSE;
		}		
	}
	
	/**
	 * forgot password
	 */
	function forgot_password($email)
	{
		
		$this->db->where('email', $email);
		$this->db->where('status','1');
		$this->db->select('*');
		$this->db->from('user_details');
		$result_set   				= $this->db->get ();
		if (0 < $result_set->num_rows()){
			$row 					= $result_set->row();   
			
			$forgot_pwd				= random_string('alnum', 10);
			$ret_result['forgot_pwd']	= $forgot_pwd;
			$this->db->set('forgot_pwd', $forgot_pwd);
			$this->db->where('id', $row->id);
			$this->db->update('user_details'); 			
			$ret_result['first_name']	=	$row->first_name;
			$ret_result['last_name']	=	$row->last_name;
			$ret_result['id']		=	$row->id;
			$ret_result['email']	=	$row->email;
			return $ret_result;
		}else{
			return false;
		}
	}
	
	/**
	 * check any user exist
	 */
	function isPenindingUser($email)
	{
		$this->db->where('email', $email);
		$this->db->where('status','2');
		$this->db->select('*');
		$this->db->from('user_details');
		$result		= $this->db->get ();
		if ($result->row()){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * resend_link
	 */
	function resend_link($email)
	{
		$this->db->where('email', $email);
		$this->db->where('status','2');
		$this->db->select('*');
		$this->db->from('user_details');
		$result		= $this->db->get ();
		if ($result->row()){
			return $result->row();   
		}else{
			return false;
		}
		
	}
	
	// Common save
	function save($table, $data){
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	
	// Update
	function update($table, $data, $where){
		 if(!empty($data)){ 
			$this->db->where($where, "", false); 
			$this->db->set ($data);
			if($this->db->update ($table)){
				return TRUE;
			}else{
				return FALSE;
			}
        }
	}
	 
	// Common Delete function
	function delete($table, $where=array()) {
		if(!empty($table)){  
			if( $this->db->delete($table, $where) ){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
	
 /* function create_user(){
    
	$this->db->query("INSERT INTO users (first_name,last_name,username,password,email,status) VALUES('ANEESH','MOHAN','admin',LEFT(MD5(CONCAT(MD5('admin'), 'cloud')), 50),'annesh@websight.net',1)");
  
  }	*/
  
  public function update_contact_segment($contact_id,$segment_arr,$data){
	
	$this->db->where(array("contact_id"=>$contact_id));
	$this->db->where_in("segment_id",$segment_arr);
	$this->db->set($data);
	if($this->db->update("contact_segment_map")){
				return TRUE;
	}else{
				return FALSE;
	}   
	  
  }
  
  public function set_remember_data($remember_token,$user_id){
	
	$this->common_model->update('users',array("remember_token"=>$remember_token),array("id"=>$user_id));
	return true; 
	  
  }
  
  public function check_login_data($remember_me_token){
   
   $credentials = array();	
   $login_data = $this->common_model->get_data('users','*',array("remember_token"=>$remember_me_token));	 
   if($login_data){
	
	$credentials['username'] = $login_data[0]['username'];   
	$credentials['password'] = $login_data[0]['password']; 
   
    return $credentials;
		   
   }
   
   else 
   
   return false;
    
	  
  }
  
  public function get_entity_name($model,$id){
  
     $entity_name=$this->get_data($model,'name',array('id'=>$id));
	 if($entity_name)
	   return $entity_name[0]['name'];
	 else
	   return false;   
	 
   }
   
  
   
  public function get_client_property($id,$field){
  
     $properties=$this->get_data("clients",$field,array('id'=>$id));
	 if($properties)
	   return $properties[0][$field];
	 else
	   return false;   
	 
   } 
  
  public function get_segment_id($name,$client_id=0){
     $segment=$this->get_data("segments",'id',array('name'=>$name,'client_id'=>$client_id));
	 if($segment)	  
	   return $segment[0]['id']; 
	 else
	   return false;   
	 
   }
  
  public function get_site_page_name($page_url,$client_id){
   
   $site_page = $this->get_data('site_page_name_map','page_name',array("page_url"=>$page_url,"client_id"=>$client_id));
   if($site_page and $site_page[0]['page_name']!='')	  
	   return $site_page[0]['page_name']; 
	 else
	   return $page_url;   

  }
  
  public function get_field_name($attr_id,$client_id){
  
     $entity_name=$this->get_data('feedback_form_api_field_map','field_name',array('api_attr_id'=>$attr_id,'client_id'=>$client_id));
	 if($entity_name)
	   return $entity_name[0]['field_name'];
	 else
	   return false;   
	 
   } 
   
  public function get_backup_segmentation_data($segment,$client,$date){
 
	$query=$this->db->query("SELECT email_count  
	                  FROM contact_segmentation  WHERE client_id=".$client." AND segment_id=".$segment." AND month='".$date."'");
					  
    if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
		       $email_count=$row->email_count;
			   return $email_count;		
			}
		  
	    }
    else{
	      return 0; 
	 }					  
	  
	  
  }
  
  public function create_contact_segment_map($query_part){
	
	$query = $this->db->query("INSERT INTO contact_segment_map (contact_id,segment_id,value,create_date,update_date) VALUES ".$query_part."");
	
	return true;  
	   
  }
  public function create_contact_temp($query_part){
	
	
	
	$query = $this->db->query("INSERT INTO contact_temp (client_id,segment_id,value) VALUES ".$query_part."");
	
	return true;  
	   
  }
  
  public function get_message_activity($client_id,$start_date,$end_date){
    
     $query  = $this->db->query("SELECT * FROM message_activity 
	                             WHERE SendDate>='".$start_date."' AND SendDate <='".$end_date."' AND client_id=".$client_id."");
	 
	 return $query->result_array();
 	
	
   
  }
  
  public function get_mail_count_data($client_id){
    
     $query  = $this->db->query("(SELECT DATE_FORMAT(month,'%b-%Y') as label,emails as value 
	                             FROM email_count_log 
								 WHERE client_id=".$client_id." ORDER BY month ASC) 
								 UNION 
								 (SELECT DATE_FORMAT(last_update,'%b-%Y') as label,mail_count as value
								 FROM clients
								 WHERE id=".$client_id.")");
	 
	 return $query->result();
 	
	
   
  }
  
  public function get_mail_count_month_data($client_id,$start_date,$end_date){
    
     $query  = $this->db->query("SELECT SUM(emails) as value 
	                             FROM email_count_log 
								 WHERE client_id=".$client_id." AND
								 month >='".$start_date."'  AND month <='".$end_date."'
								");
	 if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
		       $email_count=$row->value;
			   return $email_count;		
			}
		  
	    }
    else{
	      return 0; 
	 }				
 	
	
   
  }
  
   public function getSegmentation($segment_id,$client_id,$month){
	  
	  
	  //accessing backup data as open balance till july 31 
	   
	   if($client_id==2 or $client_id==3 or $client_id==12 or $client_id==19){
	     
		  if($month=='2016-10-31')
		   
		    $month = '2016-10-01';
	   
	   }
	    
	   if($month<='2016-07-31')
	     $email_count		=	$this->get_backup_segmentation_data($segment_id,$client_id,$month);
	 //echo "<pre>"; print_r($months); echo "</pre>"; exit;
	  else if(($client_id==3) and $month=='2016-09-01'){
	      $email_count		=	$this->get_backup_segmentation_data($segment_id,$client_id,$month);
		 
	  }	
	  else if($month=='2016-10-01' and ($client_id==2 or $client_id==3 or $client_id==12 or $client_id==19) ){
	      $email_count		=	$this->get_backup_segmentation_data($segment_id,$client_id,$month);
		 
	  }	
	 else{
	   
	    $email_count = $this->get_segmentation_data($segment_id,$client_id,$month);
	
		if($email_count==0){
		  $month = date('Y-m-01',strtotime($month));
          $email_count		=	$this->get_backup_segmentation_data($segment_id,$client_id,$month);	
		  
		  }	 
		
		}
	
		
	  return $email_count;
   }
   
  public function get_feedback_fields($client_id){
	
	$query = $this->db->query("SELECT fs.title,fs.api_field_name,fs.field_name,fc.status,fc.id FROM feedback_form_field_set as fs 
	                  LEFT JOIN feedback_form_field_client_rel as fc ON(fs.id=fc.field_id) 
					  WHERE fc.client_id=".$client_id." "); 
	return $query->result();				   
 
  }
  
  public function feedback_active_fields($client_id){
	
	$query = $this->db->query("SELECT fs.title,fs.api_field_name,fs.field_name,fc.status,fc.id FROM feedback_form_field_set as fs 
	                  LEFT JOIN feedback_form_field_client_rel as fc ON(fs.id=fc.field_id) 
					  WHERE fc.client_id=".$client_id." AND fc.status=1 "); 
	return $query->result();				   
 
  }
  
  public function get_allowed_clients($user_id,$allow_ga=0){
	
	$where_cond= '';	
	if($allow_ga==1){	
	  
	  $where_cond = 'AND c.enable_ga_details=1';
	  	  	
	}
		
	$query = $this->db->query("SELECT c.* FROM clients as c 
	                  LEFT JOIN allowed_clients as ac ON(c.id=ac.client_id) 
					  WHERE ac.user_id=".$user_id." ".$where_cond." AND c.status=1 ORDER BY c.name ASC ");
	
	return $query->result();
	  
	  
  }
  
  public function get_segmentation_data($segment,$client,$date){
	
	$date=date('Y-m-t', strtotime($date));
	
	$query=$this->db->query("SELECT count(c.id) as email_count FROM contacts as c LEFT JOIN contact_segment_map as cm ON(c.id=cm.contact_id)  
	                         WHERE c.client_id =".$client." AND cm.segment_id=".$segment." 
							 AND cm.value='Y' AND cm.create_date<='".$date."' AND cm.update_date>='".$date."'  ");
							 
					
							
    if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
		       $email_count=$row->email_count;
			   return $email_count;		
			}
		  
	    }
    else{
	      return 0; 
	 }					  
	  
	  
  }
  
  public function generate_segment_array($header,$client_id){
	 
	 $segment_arr = array();
	
	foreach($header as $value){
	   $value = trim($value);	
	   $segment_id= $this->common_model->get_segment_id($value,0);
			  if(!$segment_id)
			     $segment_id= $this->common_model->get_segment_id($value,$client_id);
	   $segment_arr[$value] = $segment_id;
	  
	}
  
   return $segment_arr;
	  
  }
  
  public function generate_contact_segment_array($client_id,$email){
	
	$query = $this->db->query('SELECT c.email,m.segment_id FROM contacts as c 
	                  LEFT JOIN contact_segment_map as m ON(c.id=m.contact_id) 
					  WHERE c.client_id='.$client_id.' AND c.email="'.$email.'"');
	
	$contact_segment_arr  = array();
	if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
		      
			  $contact_segment_arr[]= $row->segment_id;
			    
			}
		  
	    }
	
	return $contact_segment_arr;
	  
  }
  
  public function search_segment_map($contact_id,$segment_id){
   
   $query = $this->db->query("SELECT segment_id FROM contact_segment_map WHERE contact_id=".$contact_id." AND segment_id=".$segment_id.""); 
   
   if ($query->num_rows() > 0) {
	  
	  return true;
	     
   }
   
   else
   
     return false;
  
  }
  
  public function get_monthly_visit_data($event_id,$client_id,$type){
	
	$prev_year =date('Y')-1;
	$month = date('m');
	$date = $prev_year.'-'.$month.'-01';
						  
	$query = $this->db->query("SELECT DATE_FORMAT(date,'%b-%Y') as label, SUM(visitors_count) as value 
	                          FROM ga_site_visitors WHERE ga_event_id=".$event_id." AND client_id=".$client_id." AND ga_event_entity_name='".$type."' AND date >='".$date."'
							  GROUP BY YEAR(date), MONTH(date)");
	
	  
	return $query->result();  
  }
  
  public function get_monthly_visit_per_day($event_id,$client_id,$type){
	
	$prev_year =date('Y')-1;
	$month = date('m');
	$date = $prev_year.'-'.$month.'-01';
	
	$query = $this->db->query("SELECT DATE_FORMAT(date,'%b-%Y') as label, SUM(visitors_count)/DAY(LAST_DAY(date)) as value  
	                          FROM ga_site_visitors WHERE ga_event_id=".$event_id." AND client_id=".$client_id." AND ga_event_entity_name='".$type."' AND date >='".$date."' 
							  GROUP BY YEAR(date), MONTH(date)");
	
	 if ($query->num_rows() > 0)
	  
	  return $query->result(); 
	
	else
	
	  return false; 
	   
  }
  
  public function get_monthly_visit_data_graph($event_id,$client_id,$type){
	
	
	$prev_year =date('Y')-1;
	$month = date('m');
	$date = $prev_year.'-'.$month.'-01';
	
	$query = $this->db->query("(SELECT DATE_FORMAT(date,'%b-%Y') as label, SUM(visitors_count) as value 
	                          FROM ga_site_visitors WHERE ga_event_id=".$event_id." AND client_id=".$client_id." AND ga_event_entity_name='".$type."' AND date >='".$date."'
							  GROUP BY YEAR(date), MONTH(date)) UNION
							  (SELECT DATE_FORMAT(last_update,'%b-%Y') as label,visitors_count as value 
							  FROM clients
							  WHERE id=".$client_id.")");
	
	  
	return $query->result();  
  }
  
  public function get_referal_data($client_id){
	
	$query = $this->db->query("SELECT ga_event_entity_name as value
	                          FROM ga_site_visitors WHERE ga_event_id=2 AND client_id=".$client_id."
							  GROUP BY ga_event_entity_name");
	  
	return $query->result();  
  }
  
  public function get_referal_visitors($referal_name,$client_id,$month){
   
   
   $month = date('M-Y',strtotime($month));
  
   $query  = $this->db->query("SELECT temp1.ga_event_entity_name,temp1.label,(temp1.value/temp2.value)*100 as percent FROM 
                               (SELECT ga_event_entity_name,DATE_FORMAT(date,'%b-%Y') as label, visitors_count as value 
	                            FROM ga_site_visitors 
	                            WHERE ga_event_id=2 AND client_id=".$client_id.") as temp1 
	                            LEFT JOIN 
								(SELECT DATE_FORMAT(date,'%b-%Y') as label, SUM(visitors_count) as value 
	                            FROM ga_site_visitors 
	                            WHERE ga_event_id=2 AND client_id=".$client_id."
	                            GROUP BY YEAR(date), MONTH(date)) as temp2 ON(temp1.label=temp2.label) 
								WHERE temp1.ga_event_entity_name='".$referal_name."' AND temp1.label='".$month."'");


   return $query->result();  
  
  }
  
  public function get_browser_data($client_id){
	
	$query = $this->db->query("SELECT ga_event_entity_name as value
	                          FROM ga_site_visitors WHERE ga_event_id=3 AND client_id=".$client_id."
							  GROUP BY ga_event_entity_name");
	  
	return $query->result();  
  }
  
  public function get_browser_visitors($browser,$client_id,$month){
   
   $month = date('M-Y',strtotime($month));
   
   $query  = $this->db->query("SELECT temp1.ga_event_entity_name,temp1.label,(temp1.value/temp2.value)*100 as percent FROM 
                               (SELECT ga_event_entity_name,DATE_FORMAT(date,'%b-%Y') as label, visitors_count as value 
	                            FROM ga_site_visitors 
	                            WHERE ga_event_id=3 AND client_id=".$client_id.") as temp1 
	                            LEFT JOIN 
								(SELECT DATE_FORMAT(date,'%b-%Y') as label, SUM(visitors_count) as value 
	                            FROM ga_site_visitors 
	                            WHERE ga_event_id=3 AND client_id=".$client_id."
	                            GROUP BY YEAR(date), MONTH(date)) as temp2 ON(temp1.label=temp2.label) 
								WHERE temp1.ga_event_entity_name='".$browser."' AND temp1.label='".$month."'");
								


   return $query->result();  
  
  }
  
  public function getCountry($client,$month,$position){
   
   $month = date('M-Y',strtotime($month));
   
   $query  = $this->db->query("SELECT temp1.ga_event_entity_name as country,temp1.label,(temp1.value/temp2.value)*100 as percent FROM 
                               (SELECT ga_event_entity_name,DATE_FORMAT(date,'%b-%Y') as label, visitors_count as value 
	                            FROM ga_site_visitors 
	                            WHERE ga_event_id=6 AND client_id=".$client.") as temp1 
	                            LEFT JOIN 
								(SELECT DATE_FORMAT(date,'%b-%Y') as label, SUM(visitors_count) as value 
	                            FROM ga_site_visitors 
	                            WHERE ga_event_id=6 AND client_id=".$client."
	                            GROUP BY YEAR(date), MONTH(date)) as temp2 ON(temp1.label=temp2.label) 
								WHERE  temp1.label='".$month."' GROUP BY temp1.ga_event_entity_name ORDER BY percent DESC LIMIT ".$position.",1");
								
								
   if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
		       $country=$row->country;
			  
			   return $country;		
			}
		  
	    }
    else{
	      return 0; 
	 }			  								
  
  
  
  }
  
  public  function getCountrylastmonthVisit($client,$month){
    
    $query  = $this->db->query("SELECT temp1.ga_event_entity_name as label,ROUND(((temp1.value/temp2.value)*100),2) as value FROM 
                               (SELECT ga_event_entity_name,DATE_FORMAT(date,'%b-%Y') as label, visitors_count as value 
	                            FROM ga_site_visitors 
	                            WHERE ga_event_id=6 AND client_id=".$client.") as temp1 
	                            LEFT JOIN 
								(SELECT DATE_FORMAT(date,'%b-%Y') as label, SUM(visitors_count) as value 
	                            FROM ga_site_visitors 
	                            WHERE ga_event_id=6 AND client_id=".$client."
	                            GROUP BY YEAR(date), MONTH(date)) as temp2 ON(temp1.label=temp2.label) 
								WHERE  temp1.label='".$month."' GROUP BY label ORDER BY value DESC LIMIT 0,6");
								
	
    return $query->result(); 
	
	
  
  }
  
  public function getToppage($client,$month,$position){
  
   $month = date('M-Y',strtotime($month));
   
   $query  = $this->db->query("SELECT temp1.ga_event_entity_name as toppage,temp1.label,(temp1.value/temp2.value)*100 as percent FROM 
                               (SELECT ga_event_entity_name,DATE_FORMAT(date,'%b-%Y') as label, visitors_count as value 
	                            FROM ga_site_visitors 
	                            WHERE ga_event_id=5 AND client_id=".$client.") as temp1 
	                            LEFT JOIN 
								(SELECT DATE_FORMAT(date,'%b-%Y') as label, SUM(visitors_count) as value 
	                            FROM ga_site_visitors 
	                            WHERE ga_event_id=5 AND client_id=".$client."
	                            GROUP BY YEAR(date), MONTH(date)) as temp2 ON(temp1.label=temp2.label) 
								WHERE  temp1.label='".$month."' GROUP BY temp1.ga_event_entity_name ORDER BY percent DESC LIMIT ".$position.",1");
								
								
   if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
		       $toppage=$row->toppage;
			  
			   return $toppage;		
			}
		  
	    }
    else{
	      return ''; 
	 }			  								
  
  
  
  }
  
  public function report_correction($segment_id,$dat){
	
	$query= $this->db->query("SELECT cm.contact_id,cm.create_date,cm.id as map_id FROM contact_segment_map as cm LEFT JOIN contacts as c on(cm.contact_id=c.id) WHERE c.client_id=5 AND   cm.update_date='".$dat."' "); 
	
	 if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
		       $map_id=$row->map_id;
			   $this->common_model->delete('contact_segment_map',array("update_date"=>'2017-03-31'),array("id"=>$map_id));
			  		
			}
		  
	    }
	  
	  
  }
  
  public  function getToppagelastmonthVisit($client,$month){
    
    $query  = $this->db->query("SELECT temp1.ga_event_entity_name as entity_name,sm.page_name as label,ROUND(((temp1.value/temp2.value)*100),2) as value FROM 
                               (SELECT ga_event_entity_name,DATE_FORMAT(date,'%b-%Y') as label, visitors_count as value 
	                            FROM ga_site_visitors 
	                            WHERE ga_event_id=5 AND client_id=".$client.") as temp1 
	                            LEFT JOIN 
								(SELECT DATE_FORMAT(date,'%b-%Y') as label, SUM(visitors_count) as value 
	                            FROM ga_site_visitors 
	                            WHERE ga_event_id=5 AND client_id=".$client."
	                            GROUP BY YEAR(date), MONTH(date)) as temp2 ON(temp1.label=temp2.label)
								LEFT JOIN site_page_name_map as sm ON(temp1.ga_event_entity_name=sm.page_url) 
								WHERE  temp1.label='".$month."' GROUP BY entity_name ORDER BY value DESC LIMIT 0,6");
								
								
								
								
	
    return $query->result(); 
	
	
  
  }
  
  
  public  function getBrowserlastmonthVisit($client,$month){
    
    $query  = $this->db->query("SELECT temp1.ga_event_entity_name as label,ROUND(((temp1.value/temp2.value)*100),2) as value FROM 
                               (SELECT ga_event_entity_name,DATE_FORMAT(date,'%b-%Y') as label, visitors_count as value 
	                            FROM ga_site_visitors 
	                            WHERE ga_event_id=3 AND client_id=".$client.") as temp1 
	                            LEFT JOIN 
								(SELECT DATE_FORMAT(date,'%b-%Y') as label, SUM(visitors_count) as value 
	                            FROM ga_site_visitors 
	                            WHERE ga_event_id=3 AND client_id=".$client."
	                            GROUP BY YEAR(date), MONTH(date)) as temp2 ON(temp1.label=temp2.label) 
								WHERE  temp1.label='".$month."' GROUP BY label ORDER BY value DESC LIMIT 0,4");
								
	
    return $query->result(); 
	
	
  
  }
  
  public function get_site_pages($client_id){
   
   $query = $this->db->query("SELECT ga_event_entity_name,sum(visitors_count) as total 
                              FROM ga_site_visitors 
							  WHERE ga_event_id=5 AND client_id=".$client_id." GROUP BY ga_event_entity_name ORDER BY total DESC LIMIT 0,100");
   return $query->result();
  
  }
  
  public function sync_data(){
    
	 
	 
	 $this->load->library('GoogleAnalyticsAPI');		
	 $date=date('Y-m-t', strtotime('-1 month'));
	 $start_date = date('Y-m-01', strtotime('-1 month'));
	 $sync = false;
	 $clients		=	$this->get_data('clients','*',array('status'=>'1'));	 
	 for($i=0;$i<count($clients);$i++)  {	
	 	 
	   $query = $this->db->query("SELECT * FROM email_count_log WHERE month>='".$start_date."' AND month<='".$date."' AND client_id=".$clients[$i]['id']."");
	   $email_count_log = $query->result(); 
	    
	  
	   if(!$email_count_log){
	   	  	         
		 $mail_count 	= $this->request_soap_mail($clients[$i],$start_date,$date,1,0);		
		 if($mail_count==0)		  
		     $mail_count 	= $this->request_soap_mail($clients[$i],$start_date,$date,1,0);		
		 $this->save("email_count_log",array("client_id"=>$clients[$i]['id'],"month"=>$date,"emails"=>$mail_count,"log_created"=>date("Y-m-d H:m:s")));
		 $sync = true;		
	   
	   }
	   
	 }
	  
	   $ga_clients		=	$this->get_data('clients','*',array('status'=>'1','enable_ga_details'=>'1'));
	   
	   for($i=0;$i<count($ga_clients);$i++)  {	
	   
	   $ga_events  =  $this->get_data('ga_events','*',array('status'=>'1'));
	    
	   for($j=0;$j<count($ga_events);$j++)  {	
	     
		 $query = $this->db->query("SELECT * FROM ga_site_visitors WHERE date>='".$start_date."' AND date<='".$date."' AND client_id=".$ga_clients[$i]['id']."
		                             AND ga_event_id=".$ga_events[$j]['id']."");
	     $ga_site_vistors = $query->result(); 
		 	
	     if(!$ga_site_vistors){	  
	       $this->request_ga_site_visitors($ga_clients[$i],$ga_events[$j]['id'],$start_date,$date);
		   $sync = true;
		   
		 }
	       
	   } 
	   
	  /*$contact_segment = $this->get_data('contact_segmentation','*',array('month'=>$date,'client_id'=>$clients[$i]['id']));
	  if(!$contact_segment){
	    
		
	  
	  }	*/  
	   	  	  
		 	 
	 }
	 
   return $sync;  
  
  }
  
  /*public function sync_data_dummy(){
    
	 
	 
	 $this->load->library('GoogleAnalyticsAPI');		
	
	 $sync = false;
	 	 
	
	      for($i=1;$i<=4;$i++){
	  
	  $date = '2017-'.$i.'-01';
	  
	  $month_end = date('Y-m-t',strtotime($date));
	  $month_start = date('Y-m-01',strtotime($date));
	  $clients		=	$this->get_data('clients','*',array('id'=>29,'status'=>'1'));
	  for($j=1;$j<7;$j++)
	  $this->request_ga_site_visitors($clients[0],$j,$month_start,$month_end);
		
	}
		   $sync = true;
		   
		
	   
	
	
   return $sync;  
  
  }*/
 
 public function sync_previous_ga_data(){
   $this->load->library('GoogleAnalyticsAPI');	
  $ga_events  =  $this->get_data('ga_events','*',array('status'=>'1'));
  
   
	 $start_month=8;
  $start_year=2016; 
  $client_id=30; 
 $ga_clients		=	$this->get_data('clients','*',array('id'=>$client_id, 'status'=>'1','enable_ga_details'=>'1'));

  for($start_mon=$start_month;$start_mon<=12;$start_mon++){
	    
		$start_date = date('Y-m-d',strtotime($start_year.'-'.$start_mon.'-01'));
		$end_date = date('Y-m-t',strtotime($start_date));
	   for($j=0;$j<count($ga_events);$j++)  {	
	     
		 $query = $this->db->query("SELECT * FROM ga_site_visitors WHERE date>='".$start_date."' AND date<='".$end_date."' AND client_id='".$client_id."'
		                             AND ga_event_id=".$ga_events[$j]['id']."");
	     $ga_site_vistors = $query->result(); 
		 	
	     if(!$ga_site_vistors){	  
	       $this->request_ga_site_visitors($ga_clients[0],$ga_events[$j]['id'],$start_date,$end_date);
		   $sync = true;
		   
		 }
	       
	   } 
	   
	   
	
	   
  }
  
  
	 $start_month=1;
  $start_year=2017;  
 
  for($start_mon=$start_month;$start_mon<=12;$start_mon++){
	    
		$start_date = date('Y-m-d',strtotime($start_year.'-'.$start_mon.'-01'));
		$end_date = date('Y-m-t',strtotime($start_date));
		
	   for($j=0;$j<count($ga_events);$j++)  {	
	     
		 $query = $this->db->query("SELECT * FROM ga_site_visitors WHERE date>='".$start_date."' AND date<='".$end_date."' AND client_id='".$client_id."'
		                             AND ga_event_id=".$ga_events[$j]['id']."");
	     $ga_site_vistors = $query->result(); 
		 	
	     if(!$ga_site_vistors){	  
	       $this->request_ga_site_visitors($ga_clients[0],$ga_events[$j]['id'],$start_date,$end_date);
		   $sync = true;
		   
		 }
	       
	   } 
	   
	   
	  
	   
  }
 
  exit;
	   
 }
  
  public function request_ga_site_visitors($client,$event_id,$from_day,$to_day,$type='save') {
   
    if(!$client) return false;
	
	$client_id = '2b46de053fbb7c199b6883dda88e54edc2eb78c9';
	$client_api_email = 'monthly-report@monthly-report-analytics.iam.gserviceaccount.com';
	$account_id = $client['ga_account_id'];
	$private_key = FCPATH.'uploads/secret_key/Monthly-report-analytics-2b46de053fbb.p12';
	
	if (session_status() == PHP_SESSION_NONE) {
    session_start();
     }
	//unset($_SESSION['oauth_access_token']);
	//echo $_SESSION['oauth_access_token']."sasdasd";
	if (isset($_GET['force_oauth'])) {
        $_SESSION['oauth_access_token'] = null;
    }
	
	/*

     *  Step 1: Check if we have an oAuth access token in our session

     *          If we've got $_GET['code'], move to the next step

     */	
    $ga = new GoogleAnalyticsAPI('service');
    if (!isset($_SESSION['oauth_access_token'])) {

        // Go get the url of the authentication page, redirect the client and go get that token!
        
	    		
        $ga->auth->setClientId($client_id); // From the APIs console		
        $ga->auth->setEmail($client_api_email); // From the APIs console		
        $ga->auth->setPrivateKey($private_key);		
        $auth = $ga->auth->getAccessToken();
        
        if ($auth['http_code'] == 200) {

            $accessToken    = $auth['access_token'];
           // $refreshToken   = $auth['refresh_token'];
            $tokenExpires   = $auth['expires_in'];
            $tokenCreated   = time();
            $_SESSION['oauth_access_token'] = $accessToken;
			

        }
		
		
					
    } 
	
	$ga->setAccessToken($_SESSION['oauth_access_token']);
	$ga->setAccountId($account_id);
	
	$defaults = array(
			'start-date' => $from_day,	
			'end-date'   =>  $to_day,
        );
    $ga->setDefaultQueryParams($defaults);
	$params = array(
			'metrics'    => 'ga:visits',
			'dimensions' => 'ga:date',

       );
  
	switch($event_id) {
	 
	 case 1:	   	
	    $visits = $ga->getAudienceStatistics();
		if($type=='array')
		 return $visits;
	   if(isset($visits['totalsForAllResults'])){	 
		foreach($visits['totalsForAllResults'] as $entity_name=>$value){
	  
	     $event_name = str_replace("ga:", "", $entity_name);	  
	     $data =array("ga_event_id"=>$event_id,
	               "client_id"=>$client['id'],
				   "date" => $to_day,
				   "ga_event_entity_name" => $event_name,
				   "visitors_count" => $value ); 	  
	    $this->save("ga_site_visitors",$data);			   	
	
	    }
	   }
		break;
	 
	 case 2:	   	
	   $visits = $ga->getTrafficSources();
	   if($type=='array')
		 return $visits;
	   if(isset($visits['rows'])){	 
		   foreach( $visits['rows'] as $visit){
				
				if($visit[0]=='(none)')
				  $visit[0] ='Direct';
				$data =array("ga_event_id"=>$event_id,
					   "client_id"=>$client['id'],
					   "date" => $to_day,
					   "ga_event_entity_name" => $visit[0],
					   "visitors_count" => $visit[1] ); 	  
				$this->save("ga_site_visitors",$data); 
	
		  }
	  }
	  break;
	 case 3:	   	
	     $visits = $ga->getVisitsBySystemBrowsers();
		 if($type=='array')
		  return $visits;
		 if(isset($visits['rows'])){	 
		 foreach( $visits['rows'] as $visit){
		 
		    $data =array("ga_event_id"=>$event_id,
	               "client_id"=>$client['id'],
				   "date" => $to_day,
				   "ga_event_entity_name" => $visit[0],
				   "visitors_count" => $visit[1] ); 	  
	        $this->save("ga_site_visitors",$data); 

	     }
		}
	    break;
	 /*case 4:	   	
	    $visits = $ga->getAudienceStatistics();	
	    break;*/
	 case 5:	   	
	    $visits = $ga->getContentTopPages();
		if($type=='array')
		  return $visits;
		if(isset($visits['rows'])){  
			foreach( $visits['rows'] as $visit){
			 
				$data =array("ga_event_id"=>$event_id,
					   "client_id"=>$client['id'],
					   "date" => $to_day,
					   "ga_event_entity_name" => $visit[0],
					   "visitors_count" => $visit[1] ); 	  
				$this->save("ga_site_visitors",$data); 
	
			 }	
		}
	    break;
	 case 6:	   	
	     $visits = $ga->getVisitsByCountries();
		 if($type=='array')
		   return $visits;
		 if(isset($visits['rows'])){   
			 foreach( $visits['rows'] as $visit){
			 
				$data =array("ga_event_id"=>$event_id,
					   "client_id"=>$client['id'],
					   "date" => $to_day,
					   "ga_event_entity_name" => $visit[0],
					   "visitors_count" => $visit[1] ); 	  
				$this->save("ga_site_visitors",$data); 
	
			 }
		 }
	    break;
	}
	
  
   return true;
  
  }
  
  public function request_ga_month_site_visitors($client,$from_day,$to_day,$type='count') {
    
	$this->load->library('GoogleAnalyticsAPI');		
	
    if(!$client) return false;
	
	$client_id = '2b46de053fbb7c199b6883dda88e54edc2eb78c9';
	$client_api_email = 'monthly-report@monthly-report-analytics.iam.gserviceaccount.com';
	$account_id = $client['ga_account_id'];
	$private_key = FCPATH.'uploads/secret_key/Monthly-report-analytics-2b46de053fbb.p12';
	if($type=='count')
	  session_start();
	unset($_SESSION['oauth_access_token']);
	
	if (isset($_GET['force_oauth'])) {
        $_SESSION['oauth_access_token'] = null;
    }
	
	/*

     *  Step 1: Check if we have an oAuth access token in our session

     *          If we've got $_GET['code'], move to the next step

     */	
    
    if (!isset($_SESSION['oauth_access_token'])) {

        // Go get the url of the authentication page, redirect the client and go get that token!
        
	    $ga = new GoogleAnalyticsAPI('service');		
        $ga->auth->setClientId($client_id); // From the APIs console		
        $ga->auth->setEmail($client_api_email); // From the APIs console		
        $ga->auth->setPrivateKey($private_key);		
        $auth = $ga->auth->getAccessToken();
        
        if ($auth['http_code'] == 200) {

            $accessToken    = $auth['access_token'];
           // $refreshToken   = $auth['refresh_token'];
            $tokenExpires   = $auth['expires_in'];
            $tokenCreated   = time();
            $_SESSION['oauth_access_token'] = $accessToken;

        }
					
    } 
	
	$ga->setAccessToken($_SESSION['oauth_access_token']);
	$ga->setAccountId($account_id);
	
	$defaults = array(
			'start-date' => $from_day,	
			'end-date'   =>  $to_day,
        );
    $ga->setDefaultQueryParams($defaults);
	$params = array(
			'metrics'    => 'ga:visits',
			'dimensions' => 'ga:date',

       );
 	
	   $visits = $ga->getAudienceStatistics();
	   
	   if($type=='count' ){
		   if(isset($visits['rows'])){
		     foreach($visits['rows'] as $visit){
			   return $visit[3]; 
		     }
		   }
		   else
		     return 0;
		   
	   }
	   else{
		  
		  return $visits;
		   
	   }
	   
  
  }
  
  public function request_segmentation_data($client_id,$listtrak_id) {
   
     $url ='http://passmailapi.azurewebsites.net/Login/Authenticate?UserID=passuser&Password=zKRwX965xEmxgy4ZUJ9r';
     //  Initiate curl
     $ch = curl_init();
    // Disable SSL verification  
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      // Will return the response, if false it print the response
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     // Set the url
     curl_setopt($ch, CURLOPT_URL,$url);
     // Execute
     $result=curl_exec($ch);
    // Closing
     curl_close($ch);

  
    $data= json_decode($result);
	$token = $data[0]->token;
    
	$url =  'http://passmailapi.azurewebsites.net/passmailmaster/GetData?id=268030&DateFrom=2016-06-01&DateTo=2016-06-30&AccesToken='.$token;
	
	//  Initiate curl
     $ch = curl_init();
    // Disable SSL verification
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      // Will return the response, if false it print the response
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     // Set the url
     curl_setopt($ch, CURLOPT_URL,$url);
     // Execute
     $result=curl_exec($ch);
    // Closing
     curl_close($ch);

   
    $data= json_decode($result);
	
	print_r($data);
	exit;
  
  }
  
  public function get_message_details($clients,$start_date,$end_date){
	  
	  
	        $message_output=array();	        
			$message = $this->request_soap_message($clients,$start_date,$end_date);
					
			$delivery_message = $this->request_soap_delivery_message($clients,$start_date,$end_date);
			 			
		    if($delivery_message){
			
			  foreach($delivery_message as $del_mes){
			 
			      $message_id = $del_mes['MsgID'];			 
				  $message_output[$message_id]['Subject'] = $del_mes['Subject'];				  
				  $message_output[$message_id]['SendDate'] = $this->convert_date($del_mes['SendDate']);				  
				  $message_output[$message_id]['DeliverCount'] = $del_mes['DeliverCount'];				  
				  $message_output[$message_id]['BounceCount'] = $del_mes['BounceCount'];				  
				  $message_output[$message_id]['BouncePercent'] = $del_mes['BouncePercent'];				  
				  $message_output[$message_id]['Sent'] = $del_mes['BounceCount']+$del_mes['DeliverCount'];				  
				  $message_output[$message_id]['add_val'] = false;
			  }
		   
		      if($message){
		   	   
			   if(isset($message[0])){
			  
			   foreach($message as $mes){
				   //this 11962283 is misken entry by reeja so it is made hide
			      if(isset($mes['MsgID']) and $mes['MsgID']!='11962283')
			        $message_id = $mes['MsgID'];
			      if(array_key_exists ($message_id,$message_output)){
			 
					  $message_output[$message_id]['RemoveCount'] = $mes['RemoveCount'];				  
					  $message_output[$message_id]['RemovePercent'] = $mes['RemovePercent'];					  
					  $message_output[$message_id]['OpenCount'] = $mes['OpenCount'];					  
					  $message_output[$message_id]['OpenPercent'] = $mes['OpenPercent'];				  
					  $message_output[$message_id]['ReadCount'] = $mes['ReadCount'];					  
					  $message_output[$message_id]['ReadPercent'] = $mes['ReadPercent'];					  
					  $message_output[$message_id]['ClickCount'] = $mes['ClickCount'];					  
					  $message_output[$message_id]['ClickerCount'] = $mes['ClickerCount'];					  
					  $message_output[$message_id]['ClickerPercent'] = $mes['ClickerPercent'];					  
					  $message_output[$message_id]['Ctor'] = round(($mes['ClickerCount']/$mes['OpenCount'])*100,2);					  
					  $message_output[$message_id]['add_val'] = true;
			  
			      }   			
			   }
			   }
			   else{
			   
			      if(isset($message['MsgID']))
			        $message_id = $message['MsgID'];
			      if(array_key_exists ($message_id,$message_output)){
			 
					  $message_output[$message_id]['RemoveCount'] = $message['RemoveCount'];				  
					  $message_output[$message_id]['RemovePercent'] = $message['RemovePercent'];					  
					  $message_output[$message_id]['OpenCount'] = $message['OpenCount'];					  
					  $message_output[$message_id]['OpenPercent'] = $message['OpenPercent'];				  
					  $message_output[$message_id]['ReadCount'] = $message['ReadCount'];					  
					  $message_output[$message_id]['ReadPercent'] = $message['ReadPercent'];					  
					  $message_output[$message_id]['ClickCount'] = $message['ClickCount'];					  
					  $message_output[$message_id]['ClickerCount'] = $message['ClickerCount'];					  
					  $message_output[$message_id]['ClickerPercent'] = $message['ClickerPercent'];					  
					  $message_output[$message_id]['Ctor'] = round(($message['ClickerCount']/$message['OpenCount'])*100,2);					  
					  $message_output[$message_id]['add_val'] = true;
			  
			      }   		
			   
			   
			   }
			   
			  }
			 foreach($message_output as $key=>$val){
			  
			  if($val['add_val']==false){
				  
				unset($message_output[$key]);
			   
			  }
			
			}
				
         }
		 
		 else {
		  
		   //$message_output = $this->get_data('message_activity','*',array('client_id'=>$clients['id']));
		    $message_output = $this->common_model->get_message_activity($clients['id'],$start_date,$end_date);
		 	 
		 }
	  
	  //$html	= $this->load->view('message_details', $data, true);
	  return  $message_output;
	
  }
  
  public function convert_date($string){
    
	$arr = explode('T',$string);	
	$format_date =  date('Y-m-d',strtotime($arr[0]));
	return $format_date;
  
  
  }	
  
  public function ReportMessageLinkClickDetails($client,$message_id){	  
		
		$message_output=array();	        
		$messageLinkClickDetails = $this->request_soap_ReportMessageLinkClickDetails($client,$message_id);		
		return $messageLinkClickDetails;
		
  }
  
  public function ReportMessageContactOpen($client,$message_id,$send_date){	  
		
		$sendDate = date('Y-m-d',strtotime($send_date));         
		$messageContactOpenCount = $this->request_soap_ReportRangeMessageContactOpenDetails($client,$message_id,$sendDate);		
		return $messageContactOpenCount;
		
  }
  
  public function request_soap_mail($client,$from_day,$to_day,$page=1,$mail_count){
	
	if(!$client) return false;
	if(empty($client['api_username']) || empty($client['api_password']) || empty($client['api_list_id']) ){
		return 'api credentials are missing!!';
	}
	$url 			= 'https://webservices.listrak.com/v31/IntegrationService.asmx?op=ReportSubscribedContacts';	
	$soap_request 	= 'http://webservices.listrak.com/v31/ReportSubscribedContacts';
	$api_username   = $client['api_username'];
	$api_password   = $client['api_password'];
	$api_list_id    = $client['api_list_id'];
	
	$start_date		= $this->input->post('start_date')?$this->input->post('start_date'):$from_day;
	$end_date		= $this->input->post('end_date')?$this->input->post('end_date'):$to_day;
							
	/*$xml_string 	= '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Header>
    <WSUser xmlns="http://webservices.listrak.com/v31/">
      <UserName>'.$api_username.'</UserName>
      <Password>'.$api_password.'</Password>
    </WSUser>
  </soap:Header>
  <soap:Body>
    <ReportRangeSubscribedContacts xmlns="http://webservices.listrak.com/v31/">
      <ListID>'.$api_list_id.'</ListID>
      <StartDate>'.$from_day.'</StartDate>
      <EndDate>'.$to_day.'</EndDate>
      <Page>'.$page.'</Page>
    </ReportRangeSubscribedContacts>
  </soap:Body>
</soap:Envelope>'; */ 		

    $xml_string 	= '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Header>
    <WSUser xmlns="http://webservices.listrak.com/v31/">
      <UserName>'.$api_username.'</UserName>
      <Password>'.$api_password.'</Password>
    </WSUser>
  </soap:Header>
  <soap:Body>
    <ReportSubscribedContacts xmlns="http://webservices.listrak.com/v31/">
      <ListID>'.$api_list_id.'</ListID>
      <Page>'.$page.'</Page>
      <WSException>
        <SoapMethod>ReportSubscribedContacts</SoapMethod>
        <DateTime>'.$to_day.'</DateTime>
        <Description>ReportSubscribedContacts</Description>
      </WSException>
    </ReportSubscribedContacts>
  </soap:Body>
</soap:Envelope>'; 				 


  

           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        "SOAPAction: ".$soap_request, 
                        "Content-length: ".strlen($xml_string),
                    ); //SOAPAction: your op URL

            // PHP cURL  for https connection with auth
            $ch = curl_init();
			

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $api_username.":".$api_password); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting

            $response = curl_exec($ch); 
            curl_close($ch);
         
            // converting

            $response1 = str_replace("<soap:Body>","",$response);
            $response2 = str_replace("</soap:Body>","",$response1);
         
		  
            // convertingc to XML//
            $parser = simplexml_load_string($response2);			
         
           //$parse_arr= xml2array($parser); 
		   $json = json_encode($parser);
           $array_p = json_decode($json,TRUE);
		    
		   $result = $array_p['ReportSubscribedContactsResponse']['ReportSubscribedContactsResult']['WSContactSubscriptionInfo'];
		  
		   if(sizeof($result)==2500){
		   
		    $result=$result?sizeof($result):0;
			$mail_count = $mail_count + $result;
		   return  $this->request_soap_mail($client,$from_day,$to_day,$page+1,$mail_count);
		   }
		   
		   else{
		    $result =$result?sizeof($result):0;
		    $mail_count = $mail_count + $result;
		   }
		   //echo $mail_count;
		   return $mail_count;	
}

public function request_soap_delivery_message($client,$start_date,$end_date){
	
	if(!$client) return false;
	if(empty($client['api_username']) || empty($client['api_password']) || empty($client['api_list_id']) ){
		//return 'api credentials are missing!!';
		return false;
	}
	
	$url 			= 'https://webservices.listrak.com/v31/IntegrationService.asmx?op=ReportListMessageDelivery';	
	$soap_request 	= 'http://webservices.listrak.com/v31/ReportListMessageDelivery';
	$api_username   = $client['api_username'];
	$api_password   = $client['api_password'];
	$api_list_id    = $client['api_list_id'];
	
	
	$xml_string		= '<?xml version="1.0" encoding="utf-8"?>
							<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" 		
									xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">

  								<soap:Header>
    								<WSUser xmlns="http://webservices.listrak.com/v31/">
      									<UserName>'.$api_username.'</UserName>
      									<Password>'.$api_password.'</Password>
    								</WSUser>
  								</soap:Header>
  							<soap:Body>
    						<ReportListMessageDelivery xmlns="http://webservices.listrak.com/v31/">
      							<ListID>'.$api_list_id.'</ListID>
      							<StartDate>'.$start_date.'</StartDate>
      							<EndDate>'.$end_date.'</EndDate>
      							<IncludeTestMessages>1</IncludeTestMessages>
      							<WSException>
        							<SoapMethod>ReportListMessageDelivery</SoapMethod>
        							<DateTime>'.date('Y-m-d').'</DateTime>
        							<Description>ReportListMessageDelivery</Description>
      							</WSException>
    						</ReportListMessageDelivery>
  						</soap:Body>
					</soap:Envelope>';   // data from the form, e.g. some ID number

           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        "SOAPAction: ".$soap_request, 
                        "Content-length: ".strlen($xml_string),
                    ); //SOAPAction: your op URL


            // PHP cURL  for https connection with auth

            $ch = curl_init();			

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_USERPWD, $api_username.":".$api_password); // username and password - declared at the top of the doc

            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            curl_setopt($ch, CURLOPT_POST, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_string); // the SOAP request

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);



            // converting

            $response = curl_exec($ch); 

            curl_close($ch);

				
            // converting

            $response1 = str_replace("<soap:Body>","",$response);

            $response2 = str_replace("</soap:Body>","",$response1);

            // convertingc to XML//

            $parser = simplexml_load_string($response2);

			
           //$parse_arr= xml2array($parser); 

		   $json = json_encode($parser);

           $array_p = json_decode($json,TRUE);

           //echo "<pre>";	print_r($array_p);	echo "</pre>"; exit;
		   if(empty($array_p['ReportListMessageDeliveryResponse']))
		   
		     return false;
			 
		   else if(empty($array_p['ReportListMessageDeliveryResponse']['ReportListMessageDeliveryResult']))
		   
		     return false;
			 
		   else if(empty($array_p['ReportListMessageDeliveryResponse']['ReportListMessageDeliveryResult']['WSMessageDelivery']))	
		   
		     return false; 
			
		   else{	 
			 	  
		     $result = $array_p['ReportListMessageDeliveryResponse']['ReportListMessageDeliveryResult']['WSMessageDelivery'];
		   
		     return $result?$result:false;	
		   
		   }
  }
  
 public function request_soap_message($client,$start_date,$end_date){
	
	if(!$client) return false;
	if(empty($client['api_username']) || empty($client['api_password']) || empty($client['api_list_id']) ){
		return 'api credentials are missing!!';
	}
	
	$url 			= 'https://webservices.listrak.com/v31/IntegrationService.asmx?op=ReportListMessageActivity';	
	$soap_request 	= 'http://webservices.listrak.com/v31/ReportListMessageActivity';
	$api_username   = $client['api_username'];
	$api_password   = $client['api_password'];
	$api_list_id    = $client['api_list_id'];
	
	
	$xml_string		= '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Header>
    <WSUser xmlns="http://webservices.listrak.com/v31/">
      <UserName>'.$api_username.'</UserName>
      <Password>'.$api_password.'</Password>
    </WSUser>
  </soap:Header>
  <soap:Body>
    <ReportListMessageActivity xmlns="http://webservices.listrak.com/v31/">
      <ListID>'.$api_list_id.'</ListID>
      <StartDate>'.$start_date.'</StartDate>
      <EndDate>'.$end_date.'</EndDate>
      <IncludeTestMessages>0</IncludeTestMessages>
      <WSException>
        <SoapMethod>ReportListMessageActivity</SoapMethod>
        <DateTime>'.date('Y-m-d').'</DateTime>
        <Description>ReportListMessageActivity</Description>
      </WSException>
    </ReportListMessageActivity>
  </soap:Body>
</soap:Envelope>';   // data from the form, e.g. some ID number

           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        "SOAPAction: ".$soap_request, 
                        "Content-length: ".strlen($xml_string),
                    ); //SOAPAction: your op URL


            // PHP cURL  for https connection with auth

            $ch = curl_init();			

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_USERPWD, $api_username.":".$api_password); // username and password - declared at the top of the doc

            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            curl_setopt($ch, CURLOPT_POST, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_string); // the SOAP request

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);



            // converting

            $response = curl_exec($ch); 

            curl_close($ch);

				
            // converting

            $response1 = str_replace("<soap:Body>","",$response);

            $response2 = str_replace("</soap:Body>","",$response1);

            // convertingc to XML//

            $parser = simplexml_load_string($response2);

			
           //$parse_arr= xml2array($parser); 

		   $json = json_encode($parser);

           $array_p = json_decode($json,TRUE);

          //echo "<pre>";	print_r($array_p);	echo "</pre>"; exit;
		   if(empty($array_p['ReportListMessageActivityResponse']))
		   
		     return false;
			 
		   else if(empty($array_p['ReportListMessageActivityResponse']['ReportListMessageActivityResult']))
		   
		     return false;
			 
		   else if(empty($array_p['ReportListMessageActivityResponse']['ReportListMessageActivityResult']['WSMessageActivity']))	
		   
		     return false; 
			
		   else{	 
			 	  
		     $result = $array_p['ReportListMessageActivityResponse']['ReportListMessageActivityResult']['WSMessageActivity'];
		   
		     return $result;
		   }
  } 
  
   public function request_soap_ReportMessageLinkClickDetails($client,$messageID){
	
	if(!$client) return false;
	if(empty($client['api_username']) || empty($client['api_password']) || empty($client['api_list_id']) ){
		return 'api credentials are missing!!';
	}
	$url 			= 'https://webservices.listrak.com/v31/IntegrationService.asmx?op=ReportMessageLinkClick';	
	$soap_request 	= 'http://webservices.listrak.com/v31/ReportMessageLinkClick';
	$api_username   = $client['api_username'];
	$api_password   = $client['api_password'];
	$api_list_id    = $client['api_list_id'];
	
 
	 $xml_string		= '<?xml version="1.0" encoding="utf-8"?>
	<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	  <soap:Header>
		<WSUser xmlns="http://webservices.listrak.com/v31/">
		  <UserName>'.$api_username.'</UserName>
		  <Password>'.$api_password .'</Password>
		</WSUser>
	  </soap:Header>
	  <soap:Body>
		<ReportMessageLinkClick xmlns="http://webservices.listrak.com/v31/">
		  <MsgID>'.$messageID.'</MsgID>
		  <Page>1</Page>
		  <WSException>
			<SoapMethod>ReportMessageLinkClick</SoapMethod>
			<DateTime>'.date('Y-m-d').'</DateTime>
			<Description>ReportMessageLinkClick</Description>
		  </WSException>
		</ReportMessageLinkClick>
	  </soap:Body>
	</soap:Envelope>';   
  

           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        "SOAPAction: ".$soap_request, 
                        "Content-length: ".strlen($xml_string),
                    ); //SOAPAction: your op URL

            // PHP cURL  for https connection with auth
            $ch = curl_init();
			

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $api_username.":".$api_password); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting

            $response = curl_exec($ch); 
            curl_close($ch);
         
            // converting

            $response1 = str_replace("<soap:Body>","",$response);
            $response2 = str_replace("</soap:Body>","",$response1);
         
		  
            // convertingc to XML//
            $parser = simplexml_load_string($response2);			
         
           //$parse_arr= xml2array($parser); 
		   $json = json_encode($parser);
           $array_p = json_decode($json,TRUE);
		   
		  if(empty($array_p['ReportMessageLinkClickResponse']))
		   
		     return false;
			 
		  else if(empty($array_p['ReportMessageLinkClickResponse']['ReportMessageLinkClickResult']))
		   
		     return false;
			 
		  else if(empty($array_p['ReportMessageLinkClickResponse']['ReportMessageLinkClickResult']['WSMessageLink']))	
		   
		     return false; 
			
		  else{	 
			 	  
		     $result = $array_p['ReportMessageLinkClickResponse']['ReportMessageLinkClickResult']['WSMessageLink'];
		     return $result;
		   }
		     
		  
 }
 
  public function request_soap_ReportRangeMessageContactOpenDetails($client,$messageID,$sendDate){
	
	if(!$client) return false;
	if(empty($client['api_username']) || empty($client['api_password']) || empty($client['api_list_id']) ){
		return 'api credentials are missing!!';
	}
	$url 			= 'https://webservices.listrak.com/v31/IntegrationService.asmx?op=ReportRangeMessageContactOpen';	
	$soap_request 	= 'http://webservices.listrak.com/v31/ReportRangeMessageContactOpen';
	$api_username   = $client['api_username'];
	$api_password   = $client['api_password'];
	$api_list_id    = $client['api_list_id'];

	$xml_string		= '<?xml version="1.0" encoding="utf-8"?>
	<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	  <soap:Header>
		<WSUser xmlns="http://webservices.listrak.com/v31/">
		  <UserName>'.$api_username.'</UserName>
		  <Password>'.$api_password .'</Password>
		</WSUser>
	  </soap:Header>
	  <soap:Body>
		<ReportRangeMessageContactOpen  xmlns="http://webservices.listrak.com/v31/">
		  <MsgID>'.$messageID.'</MsgID>
		  <StartDate>'.$sendDate.'</StartDate>
		  <EndDate>'.date('Y-m-d',date(strtotime("+1 day", strtotime($sendDate)))).'</EndDate>
		  <Page>1</Page>
		</ReportRangeMessageContactOpen >
	  </soap:Body>
	</soap:Envelope>';  
  

           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        "SOAPAction: ".$soap_request, 
                        "Content-length: ".strlen($xml_string),
                    ); //SOAPAction: your op URL

            // PHP cURL  for https connection with auth
            $ch = curl_init();
			

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $api_username.":".$api_password); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting

            $response = curl_exec($ch); 
            curl_close($ch);
         
            // converting

            $response1 = str_replace("<soap:Body>","",$response);
            $response2 = str_replace("</soap:Body>","",$response1);
         
		  
            // convertingc to XML//
            $parser = simplexml_load_string($response2);			
         
           //$parse_arr= xml2array($parser); 
		   $json = json_encode($parser);
           $array_p = json_decode($json,TRUE);
		 
		  if(empty($array_p['ReportRangeMessageContactOpenResponse']))
		   
		     return 0;
			 
		  else if(empty($array_p['ReportRangeMessageContactOpenResponse']['ReportRangeMessageContactOpenResult']))
		   
		     return 0;
			 
		  else if(empty($array_p['ReportRangeMessageContactOpenResponse']['ReportRangeMessageContactOpenResult']['WSContactOpen']))	
		   
		     return 0; 
			
		  else{	 
			 	  
		     $result = $array_p['ReportRangeMessageContactOpenResponse']['ReportRangeMessageContactOpenResult']['WSContactOpen'];
		     return count($result);
		   }
		     
		  
 }
 
 public function request_tablet_feedback_data($client){
  
    if(!$client) return false;
	if(empty($client['api_list_id']) ){
		return 'api credentials are missing!!';
	}
	
	$url 			= 'http://stayndineuae.com/cluster/feedback/dashboard/api/feedback/';
	$username       = 'passuser';
	$password       = 'FHbxuLyHB7n2evyb66sft4QkBMnYrh';	
	$api_list_id    = $client['api_list_id'];  
    $ch = curl_init($url);
    $data_string = '{
	  "user": {
		"UserName": "'.$username.'",
		"Password": "'.$password.'"
	  },
	  "listrack": {
		"ListrakID": "'.$client['api_list_id'].'",
		"RestAttribID": null
	  }
     }';                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		'Content-Type: application/json',                                                                                
		'Content-Length: ' . strlen($data_string))                                                                       
	);                                                                                                                                                                                                                               
	$result = curl_exec($ch);
	if($result){
		$data = json_decode($result);
		// double decode is due to the api result;
		$final_data=json_decode($data);
	}
	
	return $final_data;
 
 }
 
} 
?>