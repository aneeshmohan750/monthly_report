<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(! function_exists('authAdmin')){	
	 function authAdmin(){
		$ci=& get_instance();
		if( $ci->session->userdata('logged_in') !== TRUE || $ci->session->userdata('is_admin') !== TRUE ) {
				redirect('admin/login');
		} 
	    return true;
	 }
}
if(! function_exists('authUser')){	
	 function authUser(){
		$ci=& get_instance();
		if( $ci->session->userdata('is_login') !== TRUE ) {
				redirect('login');
		} 
	    return true;
	 }
}
if(! function_exists('printr')){	
	 function printr($string, $echo = true){
		 if($echo) 
		 	echo stripslashes(trim($string));
		 else 
		 	return stripslashes(trim($string));
	 }
}
if(! function_exists('printDate')){	
	 function printDate($date, $echo = true){
		 if($date != '0000-00-00'){
			 if($echo) 
				echo date("M d, Y", strtotime($date));
			 else 
				return date("M d, Y", strtotime($date));
		 }
		 else{
			 if($echo) 
				echo 'None';
			 else 
				return 'None';
		 }
	 }
}
if(! function_exists('printDateTime')){	
	 function printDateTime($date, $echo = true){
		 if($date != '0000-00-00 00:00:00'){
			 if($echo) 
				echo date("M d, Y - h:i A", strtotime($date));
			 else 
				return date("M d, Y - h:i A", strtotime($date));
		 }
		 else{
			 if($echo) 
				echo 'None';
			 else 
				return 'None';
		 }
	 }
}

if ( ! function_exists('send_email'))
{
    function send_email($email_id,$email_to, $vars,$email_cc='',$attachment='')
    {
		if(!$email_id) return false;
		if(!$email_to) return false;
		
        $ci=& get_instance();

        $ci->db->select('*');
		$ci->db->from('general_emails'); 
		$ci->db->where('email_id', $email_id); 
        $query = $ci->db->get();
        $row = $query->row();
		if($row->status == 'Y'){
			$email_subject 	 = $row->email_subject;
			$email_content 	 = $row->email_content;
			$email_variables = $row->email_variables?explode(',', $row->email_variables):array();
			
			foreach($email_variables as $variable){
				$email_content 	 = str_replace($variable, $vars[$variable], $email_content);
			}
			
			if(is_array($email_to))
				$email_to = implode(',', $email_to);
			
			if(is_array($email_cc))
				$email_cc = implode(',', $email_cc);
				
			$email_from = $ci->config->item('email_from');
			$email_from_name = $ci->config->item('email_from_name');
			//********* EMAIL*************//
			/*$config = Array(
			  'protocol' => 'smtp',
			  'smtp_host' => 'ssl://smtp.googlemail.com',
			  'smtp_port' => 465,
			  'smtp_user' => '', // change it to yours
			  'smtp_pass' => '', // change it to yours
			  'mailtype' => 'html',
			  'charset' => 'iso-8859-1',
			  'wordwrap' => TRUE
			);*/
			
			$ci->load->library('email');
			
			$config['protocol'] = 'mail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html'; // Append This Line
			$ci->email->initialize($config);

			$ci->email->from($email_from, $email_from_name);
			$ci->email->to($email_to); 
			
			if($email_cc)
				$ci->email->cc($email_cc); 
			//$ci->email->bcc('them@their-example.com'); 
			
			$ci->email->subject($email_subject);
			$ci->email->message($email_content);
			if($attachment != '' && file_exists($attachment)){	
				$ci->email->attach($attachment);
			}
			//echo "<pre>"; print_r($ci->email); exit;
			$send = $ci->email->send();
			
			
			if($send){
				return true;
			}
			else
				return false;
		}
    }
}

