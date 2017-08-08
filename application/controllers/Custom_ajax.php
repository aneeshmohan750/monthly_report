<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custom_ajax extends CI_Controller {

 public function __construct()
 {
   parent::__construct();
  
 }

 public function verifylogin()
 {
        $this->mcontents = array();
        if (!empty($_POST)) {
            $this->load->library('form_validation');
            $this->_init_login_validation_rules(); //server side validation of input values
            if ($this->form_validation->run() == FALSE) {// form validation
                $arr = array('status' =>'failed','message'=>'Invalid Username or Password');
            } else {
                $this->_init_login_details();
                $login_details['username'] = $this->username;
                $login_details['password'] = $this->password;
                if ($this->authentication->process_login($login_details) == 'success') {
				    $session_data=$this->session->userdata('logged_in');
					$log_data =array('ip_address' =>$_SERVER['REMOTE_ADDR'],
	                    'attempt' =>'success',
						'username' => $this->username,
						'log_date' =>  date("Y-m-d H:i:s"));
	                $this->common_model->save('user_logs',$log_data);
					if(isset($_POST['remember_me'])){
					  $token = $this->rand_string(8);	
					  $cookie = array(
						'name'   => 'remember_me_token',
						'value'  =>  $token,
						'expire' => '1209600000',  // Two weeks
						'domain' => 'dashboard.datasight.biz',
						'path'   => '/'
					);
                    set_cookie($cookie);
					$this->common_model->set_remember_data($token,$session_data['USER_ID']);	
					}
                    $arr = array('status' =>'success','group_admin'=>$session_data['IS_GROUP_ADMIN']);
                } else {
					$log_data =array('ip_address' =>$_SERVER['REMOTE_ADDR'],
	                    'attempt' =>'failure',
						'username' => $this->username,
						'log_date' =>  date("Y-m-d H:i:s"));
	                $this->common_model->save('user_logs',$log_data);
                    sf('error_message', 'Invalid Username or Password');
                    $arr = array('status' =>'failed','message'=>'Invalid Username or Password');
                }
            }
		 echo json_encode($arr); 
	     exit;	
        }
   
 }
 
 public function search_message_activity(){
   
    $start_date =date('Y-m-d',strtotime($this->input->post('start_date')));
    $end_date  = date('Y-m-d',strtotime($this->input->post('end_date')));
	$end_date  = date('Y-m-d', strtotime($end_date . ' +1 day'));
	$client_id = $this->input->post('client_id');
	$client = $this->common_model->get_data('clients','*',array('id'=>$client_id));
	$message_details_html='';
	$message_details = $this->common_model->get_message_details($client[0],$start_date,$end_date);
	
	  foreach($message_details as $mes_id=>$msg_det){
		
       $message_details_html .= '
                    <tr class="gradeX">
                        <td>'.$msg_det['Subject'].'</td>
                        <td>'.$msg_det['SendDate'].'</td>
						<td>'.$msg_det['Sent'].'</td>
						<td>'.$msg_det['DeliverCount'].'</td>
						<td>'.$msg_det['BounceCount'].'</td>
						<td>'.(round($msg_det['BouncePercent'],2)).'%</td>
						<td>'.$msg_det['RemoveCount'].'</td>
						<td>'.(round($msg_det['RemovePercent'],2)).'%</td>
						<td><a class="clickOpenCount" href="javascript:void(0);" data-sendDate="'.$msg_det['SendDate'].'" data-client="'.$client_id.'" data-message="'.$msg_det['Subject'].'" rel="'.$mes_id.'">'.$msg_det['OpenCount'].'</a></td>
						<td>'.(round($msg_det['OpenPercent'],2)).'%</td>
						<td>'.$msg_det['ReadCount'].'</td>
						<td>'.(round($msg_det['ReadPercent'],2)).'%</td>
						<td><a href="javascript:void(0);" data-client="'.$client_id.'" rel="'.$mes_id.'" class="clickCount">'.$msg_det['ClickCount'].'</a></td>
						<td>'.$msg_det['ClickerCount'].'</td>
						<td>'.(round($msg_det['ClickerPercent'],2)).'</td>
						<td>'.$msg_det['Ctor'].'%</td>
                    </tr>';
	   }
	//  $message_details_html .='</tbody>';
	  $arr = array('status' =>'success','data_html'=>$message_details_html);
	  echo json_encode($arr); 
	  exit;	 
 
 }
 
 public function ReportMessageLinkClick(){
  
  $messageID = $this->input->post('messageID');
  $client_id = $this->input->post('client_id');
  $client = $this->common_model->get_data('clients','*',array('id'=>$client_id));
  $messageClickdetails = $this->common_model->ReportMessageLinkClickDetails($client[0],$messageID);
 
  $data_html = '<table class="table table-striped table-bordered table-hover dataTables">
            <thead>
				<tr>
					<th>Link Url</th>
					<th>LinkType</th>
					<th>ClickCount</th>
					<th>ClickerCount</th>
					<th>ClickPercent</th>
				</tr>
			 </thead>
			 <tbody>';
  if($messageClickdetails){
  	
	foreach($messageClickdetails as $messageClick){
		 
		  $data_html .= '
                    <tr class="gradeX">
					    <td>'.$messageClick['LinkURL'].'</td>
						<td>'.$messageClick['LinkType'].'</td>
						<td>'.$messageClick['ClickCount'].'</td>
						<td>'.$messageClick['ClickerCount'].'</td>
						<td>'.($messageClick['ClickPercent']*100).'%</td>
					</tr>';
		
	}
	
	 
  }
  
  $data_html .= '</tbody></table>';
  
  $arr = array('status' =>'success','data_html'=>$data_html);
  echo json_encode($arr); 
  exit;	 
  
 }
 
  public function ReportMessageContactOpen(){
  
  $messageID = $this->input->post('messageID');
  $client_id = $this->input->post('clientID');
  $sendDate = $this->input->post('sendDate');
  $message = $this->input->post('message');
  $client = $this->common_model->get_data('clients','*',array('id'=>$client_id));
  $messageOpenCount = $this->common_model->ReportMessageContactOpen($client[0],$messageID,$sendDate);
 
  $data_html = '<table class="table table-striped table-bordered table-hover dataTables">
            <thead>
				<tr>
					<th>Subject</th>
					<th>Dispatch Date</th>
					<th>Open Count</th>
				</tr>
			 </thead>
			 <tbody>
			<tr class="gradeX">
				<td>'.$message.'</td>
				<td>'.$sendDate.'</td>
				<td>'.$messageOpenCount.'</td>
			</tr></tbody></table>';
	
  
  
  $arr = array('status' =>'success','data_html'=>$data_html);
  echo json_encode($arr); 
  exit;	 
  
 }
 
 public function search_consolidation(){
   
    $search_date  =  $this->input->post('search_date');
	$dat_arr = explode('-',$search_date);
	$search_date = $dat_arr[1].'-'.$dat_arr[0].'-01';
    $start_date =date('Y-m-01',strtotime($search_date));
    $end_date  = date('Y-m-t',strtotime($search_date));
	
	$session_data=$this->session->userdata('logged_in');
	$consolidation_details_html='';	
	$allowed_clients  = $this->common_model->get_allowed_clients($session_data['USER_ID']);
	$primary_segments = $this->common_model->get_data('segments','*',array("client_id"=>0,"primary_segment"=>1,"listing"=>1,"status"=>1));
	
	foreach($allowed_clients as $client){
	 
	 $consolidation_details_html .=' <tr>
                                     <td>'.$client->name.'</td>
                                     <td align="right">'.number_format($this->common_model->get_mail_count_month_data($client->id,$start_date,$end_date)).'</td>';
     foreach($primary_segments as $segment){
         $consolidation_details_html .='<td align="right">'.number_format($this->common_model->getSegmentation($segment['id'],$client->id,$end_date)).'</td>';
     }
     $consolidation_details_html .='</tr>';
	
	}	
	
	$arr = array('status' =>'success','data_html'=>$consolidation_details_html);
	echo json_encode($arr); 
	exit;	 
 
 }
 
 public function search_ga_consolidation(){
   
    $search_date  =  $this->input->post('search_date');
	$dat_arr = explode('-',$search_date);
	$search_date = $dat_arr[1].'-'.$dat_arr[0].'-01';
    $end_date  = date('Y-m-t',strtotime($search_date));
	
	$session_data=$this->session->userdata('logged_in');
	$consolidation_details_html='';	
    $allowed_ga_clients  =  $this->common_model->get_allowed_clients($session_data['USER_ID'],$allow_ga=1);	
	
	foreach($allowed_ga_clients as $client){
	 
	 $consolidation_details_html .='  <tr>
                          <td>'.$client->name.'</td>
                          <td align="right">'.number_format($this->getSiteVisitorData($client->id,1,'visits',$end_date)).'</td>
                          <td align="right">'.number_format($this->getSiteVisitorData($client->id,1,'pageviews',$end_date)).'</td>
                          <td align="right">'.number_format($this->getSiteVisitorData($client->id,1,'percentNewVisits',$end_date)).'</td>
                        </tr>';
	
	}	
	
	$arr = array('status' =>'success','data_html'=>$consolidation_details_html);
	echo json_encode($arr); 
	exit;	 
 
 }
 
 public function upload_excel() {
    
	if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
	    $extension = explode('.', $_FILES['file']['name']);
		$file_name=$this->rand_string(10).'.'.$extension[1];
        move_uploaded_file($_FILES['file']['tmp_name'], $this->config->item("upload_file_path").'excel/'.$file_name);
		
	    echo $file_name;
		exit;	
    }
   
  }
  
  public function data_sync() {
   
     $sync_bol = $this->common_model->sync_data();
	 if($sync_bol)
	    $arr= array("status"=>"success");
     else
	    $arr= array("status"=>"failed");
		 		
	 echo json_encode($arr);
	 exit; 
  }
  
  public function change_client() {
   
     $client_id = $this->input->post('client_id'); 
	 $session_data = $this->session->userdata('logged_in');
	 $session_data['CLIENT_ID'] 	= $client_id;
	 $this->session->set_userdata ('logged_in',$session_data); 
	 $arr= array("status"=>"success");	 		
	 echo json_encode($arr);
	 exit; 
  }
  
  public function create_segment()
  {
	 
	 if($this->input->post('listing'))
	  $listing = $this->input->post('listing');
	 else
	  $listing  = 0;  
	 
	 $data = array("name" => $this->input->post('segment_name'),
	               "client_id" => $this->input->post('client_id'),
				   "segment_type" => $this->input->post('segment_type'),
				   "listing" => $listing,
				   "status" => 1 );
	
	$segment = $this->common_model->save("segments",$data);		
	
	if($segment)
	  $arr = array("status"=>"success");
	else
	  $arr = array("status"=>"failed"); 	  
	echo json_encode($arr);
	 exit;    	  
	  
  }
  

  
  public function update_segment()
  {
	 
	 $data = array("name" => $this->input->post('segment_name'),
	               "client_id" => $this->input->post('client_id'),
				   "segment_type" => $this->input->post('segment_type'),
				   "listing" => $this->input->post('listing'));
	
	$segment = $this->common_model->update("segments",$data,array("id"=>$this->input->post('segment_id')));		
	
	if($segment)
	  $arr = array("status"=>"success");
	else
	  $arr = array("status"=>"failed"); 	  
	echo json_encode($arr);
	 exit;    	  
	  
  }
  
  public function create_user()
  {
	 
	if (!empty($_POST)) {
		
		    $password=$this->input->post('confirm_password');		
			$query = $this->db->query("INSERT INTO users
			                             SET first_name='".$this->input->post('first_name')."',
										 last_name='".$this->input->post('last_name')."',
										 username='".$this->input->post('username')."',
										 email='".$this->input->post('email')."',
										 client_id='".$this->input->post('client_id')."',
										 password = LEFT(MD5(CONCAT(MD5('$password'), 'cloud')), 50),
										 is_admin ='".$this->input->post('admin_access')."',
										 is_group_admin ='".$this->input->post('group_admin_access')."',
										 status=1,
										 created_date='".date("Y-m-d H:m:s")."'");
			
			$users_details =$this->db->insert_id();
			
			if($this->input->post('group_admin_access')==1){
			  
			  $client_ids = $this->input->post('allowed_client_id');
			  
			  if($client_ids){
				
				foreach($client_ids as $client_id){
				
				  $data = array("user_id"=>$users_details,"client_id"=>$client_id,"status"=>1);				  
				  $this->common_model->save("allowed_clients",$data);			  	
				
				}
				  
			  }
			}
			
				
	}
	
	if($users_details)
	  $arr = array("status"=>"success");
	else
	  $arr = array("status"=>"failed"); 	  
	echo json_encode($arr);
	 exit;    	  
	  
  }
  

  
  public function update_user()
  {
	 
	 $data = array("first_name" => $this->input->post('first_name'),
	               "last_name" => $this->input->post('last_name'),
				   "email" => $this->input->post('email'),
				   "is_admin" => $this->input->post('admin_access'),
				   "is_group_admin" => $this->input->post('group_admin_access'));
	
	$user = $this->common_model->update("users",$data,array("id"=>$this->input->post('user_id')));		
	
	if($user)
	  $arr = array("status"=>"success");
	else
	  $arr = array("status"=>"failed"); 	  
	echo json_encode($arr);
	exit;    	  
	  
  }
  
  public function update_site_page()
  {
	 
	 $data = array("page_name" => $this->input->post('page_name'));
	 $page = $this->common_model->update("site_page_name_map",$data,array("id"=>$this->input->post('page_id')));		
	
	if($page)
	  $arr = array("status"=>"success");
	else
	  $arr = array("status"=>"failed"); 
	echo json_encode($arr);
	 exit;    	  
	  
  }
  
  public function feedback_field_status_change(){
	
	$field_id = $this->input->post('list_id');
	$status = $this->input->post('status');
	$new_status = ($status==1) ? 0 :1;	
	$update = $this->common_model->update("feedback_form_field_client_rel",array("status"=>$new_status),array("id"=>$field_id));  
	if($update)
	 $arr = array("status"=>"success");
	else
	  $arr = array("status"=>"failed"); 
	echo json_encode($arr);
	exit;    
	   	  
  }
  
  public function delete_entity()
 {
     if($this->common_model->delete($this->input->post('enity_name'),array("id"=>$this->input->post('entity_id')))){
	    $arr=array("status"=>"success");
	 }
	 else{
	     $arr=array("status"=>"failed");
	 }
	 echo json_encode($arr);			  
	 exit;
 
 }
  
  public function validate_excel_file(){
     
	 
	  $uploaded_file_name =$this->input->post('uploaded_file');
	
	  ini_set('memory_limit', '-1');
	  $this->load->library('excel');
	 /* $uploaded_file = FCPATH.'uploads\\excel\\'.$uploaded_file;
	  $sample_file =   FCPATH.'uploads\\sample_excel\\'.$retailer_export_details[0]['sample_excel_file'];*/
	  $uploaded_file = FCPATH.'uploads/excel/'.$uploaded_file_name;
	  $client_export_details=$this->common_model->get_data('clients','*',array("id"=>$this->input->post('client_id'))); 
	  $client_id = $this->input->post('client_id'); 
	  if($client_export_details){
	
//		$end_column =  $client_export_details[0]['end_column'];
		$sample_file = $client_export_details[0]['template_name'];
	  
	  }
	  
	  $sample_file =   FCPATH.'uploads/sample_excel/'.$client_export_details[0]['template_name'];
	  //read file from path
	  $objPHPExcel_sample = PHPExcel_IOFactory::load($sample_file);
      $objPHPExcel = PHPExcel_IOFactory::load($uploaded_file);
	  
	  $sheetCount = $objPHPExcel->getSheetCount();
	  $sheetCount_sample = $objPHPExcel_sample->getSheetCount();
	
	  
	  $objPHPExcel->setActiveSheetIndex(0);
	  $objPHPExcel_sample->setActiveSheetIndex(0);
	 //get only the Cell Collection
	  $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
	  $cell_collection_sample = $objPHPExcel_sample->getActiveSheet()->getCellCollection();
	  if(!$cell_collection){
		$arr= array("status"=>"not_readable");
		echo json_encode($arr);
		exit; 
	  }
         //extract to a PHP readable array format
	  
	  //extract to a PHP readable array format
         foreach ($cell_collection as $cell) {
			$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
			//header will/should be in row 1 only. 
			
			if($row==1){
			  $header[$row][$column] = $data_value;
			  
			}
			
       }	
	   foreach ($cell_collection_sample as $cell) {
			$column = $objPHPExcel_sample->getActiveSheet()->getCell($cell)->getColumn();
			$row = $objPHPExcel_sample->getActiveSheet()->getCell($cell)->getRow();
			$data_value = $objPHPExcel_sample->getActiveSheet()->getCell($cell)->getValue();
			//header will/should be in row 1 only. 
			if ($row == 1) {
			   $header_sample[$row][$column] = $data_value;
			}
			if ($row > 1) {
			   $content[$row][$column] = $data_value;
			} 	  
	  } 	    
	  
	  
	  
	  $count =1; 
	  foreach ($header[1] as $index=>$value){
	     // if($count <= $end_column){	
		     $header_word = trim($header[1][$index]);
			 $header_word = preg_replace('/\s+/', ' ', $header_word);		 
			 if($header_sample[1][$index] and trim($header_sample[1][$index])!=$header_word){			 		    
				 $arr= array("status"=>"falied","message"=>"Format is incorrect because of fields mismatch");
				 echo json_encode($arr);
				 exit; 
			 } 	     		 
	     // }
	    $count = $count +1; 	 
	  }
	  $segment_error_array=array();
	  
	  foreach ($header[1] as $index=>$value){
	     
		 if($value){
			$value = trim($value);
			$primary_segment_id=$this->common_model->get_segment_id($value,0);
			
			if(!$primary_segment_id){
			  
			 $segment_id= $this->common_model->get_segment_id($value,$client_id); 
			 
			 if(!$segment_id)
			 
			  $segment_error_array[]=$value;
			   
				
			}		 
			 
		 }
		 
	  
	  }
   	    
     if($segment_error_array){
		$arr= array("status"=>"failed","arr"=>$segment_error_array);
        echo json_encode($arr);
        exit; 	  
	 }
     $arr= array("status"=>"success");
     echo json_encode($arr);
     exit; 	 
   
 } 
 
 

  public function import_excel_file(){
     
	  $uploaded_file_name =$this->input->post('uploaded_file');
	  $file_name= $this->input->post('file_name');
	  $end_date=date('Y-m-t', strtotime("01-".$this->input->post('report_date')));
	  $data_segment= array();
	  $header_segment=array();
	  $contact_segmentation='';
	  $client_id = $this->input->post('client_id');
	  $segments = $this->common_model->get_data('segments','*',array("client_id"=>0,"status"=>1));
	  $segments_count = sizeof($segments);
	  ini_set('memory_limit', '-1');
	  $this->load->library('excel');
	  //$uploaded_file = FCPATH.'uploads\\excel\\'.$uploaded_file;
	  $uploaded_file = FCPATH.'uploads/excel/'.$uploaded_file_name;
	  //read file from path
      $objPHPExcel = PHPExcel_IOFactory::load($uploaded_file);	  
	  $sheetCount = $objPHPExcel->getSheetCount();	  
	  $objPHPExcel->setActiveSheetIndex(0);
	 //get only the Cell Collection
	  $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
	//extract to a PHP readable array format
	  foreach ($cell_collection as $cell) {
		  
		$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
		$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
		$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		
	    if($row==1){
			
	       $header[$row][$column] = $data_value;
		   $header_segment[] = $data_value;	
		   	   
	    }	 
	    if ($row >1) {
			
	       $content[$row][$column] = $data_value;
		   
	    }		
      }	
	  $segment_arr = $this->common_model->generate_segment_array($header_segment,$client_id);
	  $i=1;
	  foreach ($content as $page_content){	
	   
	     $h = 0; 
		 $segmentids= array();
		 $contact_data=NULL;
		 $query = '';
		 $coma = ',';
		 
		 foreach($page_content as $index => $value){  
		 
		   $h++;
		   
		 if($this->toNum($index)==1 and $value){
			 		    
			$contact_data = $this->common_model->get_data("contacts",'*',array("email"=>$value,"client_id"=>$client_id));
			$contact_segment_arr = $this->common_model->generate_contact_segment_array($client_id,$value);
			
			if(!$contact_data){	
					
			  $data = array("client_id"=>$client_id,"email"=>$value,"create_date"=>$end_date,"status"=>1);			 
			  $contact_id= $this->common_model->save("contacts",$data);
			 // $segment_id= $this->common_model->get_segment_id($header[1][$index],0);
			  $segment_id=$segment_arr[trim($header[1][$index])];
			  $segment_data_arr = array("contact_id"=>$contact_id,"segment_id"=>$segment_id,"value"=>$value,"create_date"=>$end_date,"update_date"=>$end_date);
			  $this->common_model->save("contact_segment_map",$segment_data_arr); 
			  
			}
			else{
				
			    $segment_id=$segment_arr[trim($header[1][$index])];
			    $segment_data_arr = array("update_date"=>$end_date);
		        $this->common_model->update("contact_segment_map",$segment_data_arr,array("contact_id"=>$contact_data[0]['id'],"segment_id"=>$segment_id));
				
			}
			
		   }
		 else if($this->toNum($index)!=1){  
		       
		   $segment_id=$segment_arr[trim($header[1][$index])];  
			  
		   if(!$segment_id){
		      
			  $arr= array("status"=>"failed","message"=>"Segment Not Found");
              echo json_encode($arr);
              exit;
		    
		   }	  
		    
			   
		   if(!$contact_data){
			   				 
			   $segment_data_arr = array("contact_id"=>$contact_id,"segment_id"=>$segment_id,"value"=>$value,"create_date"=>$end_date,"update_date"=>$end_date);
			   
			   if($query!='')
			   
				    $query .= $coma;
				
			   $query .= '("'.$contact_id.'","'.$segment_id.'","'.htmlentities($value).'","'.$end_date.'","'.$end_date.'")';
				
				
			   //$this->common_model->save("contact_segment_map",$segment_data_arr); 
		   }		   
		   else{
			   
			   $contact_id = $contact_data[0]['id'];
			   
			 if(in_array($segment_id,$contact_segment_arr)) { 
			 
				 $segmentids[]  = $segment_id;
				 
			 }
			 else{
				 
				 if($query!='')
				 
				    $query .= $coma;
				
				$query .= '("'.$contact_id.'","'.$segment_id.'","'.htmlentities($value).'","'.$end_date.'","'.$end_date.'")';
								 
			 }
		     //$this->common_model->update("contact_segment_map",$segment_data_arr,array("contact_id"=>$contact_data[0]['id'],"segment_id"=>$segment_id));			 
			 		
		   }
		   	   	  
		   }
		  
		 }
			
		 if($segmentids)
		 
			 $this->common_model->update_contact_segment($contact_id,$segmentids,array("update_date"=>$end_date));
			 
		  if($query!=''){
			  	
			  $this->common_model->create_contact_segment_map($query); 
			  
		  }
			
			$i++;
		}			
       unlink($uploaded_file); 
       $arr= array("status"=>"success","message"=>"Validation Success");
       echo json_encode($arr);
       exit;
}

/*public function import_excel_file(){
      

	  $uploaded_file_name =$this->input->post('uploaded_file');
	  $file_name= $this->input->post('file_name');
	  $end_date=date('Y-m-t', strtotime("01-".$this->input->post('report_date')));
	  $data_segment= array();
	  $contact_segmentation='';
	  $client_id = $this->input->post('client_id');
	  $segments = $this->common_model->get_data('segments','*',array("client_id"=>0,"status"=>1));
	  $segments_count = sizeof($segments);
	  ini_set('memory_limit','-1');
	  $this->load->library('excel');
	  //$uploaded_file = FCPATH.'uploads\\excel\\'.$uploaded_file;
	  $uploaded_file = FCPATH.'uploads/excel/'.$uploaded_file_name;
	  //read file from path
      $objPHPExcel = PHPExcel_IOFactory::load($uploaded_file);	  
	  $sheetCount = $objPHPExcel->getSheetCount();	  
	  $objPHPExcel->setActiveSheetIndex(0);
	 //get only the Cell Collection
	  $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
	//extract to a PHP readable array format
	  foreach ($cell_collection as $cell) {
		$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
		$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
		$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
		//header will/should be in row 1 only. of course this can be modified to suit your need.
	    if($row==1){
	       $header[$row][$column] = $data_value;
	    }	 
	    if ($row >1) {

	       $content[$row][$column] = $data_value;
	    }		
      }
	  
	 
	   $row_count = $row;	
	   
	   $ratio = ($row_count>5000) ? 5000 : $row_count;
	   $divider = ($row_count%$ratio);
	   $divident = floor($row_count/$ratio);
	   ini_set('max_execution_time', 0);
	   for($k=1;$k<=$divident;$k++){
		  		   
		  $start = ($k-1)*$ratio; 
	      $limit = $start + $ratio;	   
		  $query = '';		
		  $start = ($start==0)  ? 2 :  $start;
		   
		   for ($i = $start; $i <  $limit; $i++){	
		     
			  $page_content = $content[$i];
			  $page_content_count =count($page_content);
			  $last_entry_count = count($content[$limit-1]);
			  $z=0;
			  foreach($page_content as $index => $value){
			      $value = str_replace("'", "", $value);
				  $segment_id= $this->common_model->get_segment_id($header[1][$index],0);
				  if(!$segment_id)
					 $segment_id= $this->common_model->get_segment_id($header[1][$index],$client_id);		  
				  $query .= "('$client_id','$segment_id','$value')";
                       if($i<$limit and $z<$last_entry_count-1){				 
						$query .= ",";
					   }
					  
					  

				  unset($page_content[$index]);
			if($i==$limit-1)
			  $z++;	   
			   
			}
			unset($content[$i]);
			
			}
			
			$this->common_model->create_contact_temp($query);
		unset($content[$i]);	
	   }
	   
	   if($divider > 0 ){
		 
		  $start = $divident*$ratio; 
	      $limit = $start+$divider;
		  
		  for ($i = $start; $i <= $limit; $i++){	
		     
			  $page_content = $content[$i];
			  $page_content_count =count($page_content);
			  $last_entry_count = count($content[$limit-1]);
			  $z=0;
			  foreach($page_content as $index => $value){
			      $value = str_replace("'", "", $value);
				  $segment_id= $this->common_model->get_segment_id($header[1][$index],0);
				  if(!$segment_id)
					 $segment_id= $this->common_model->get_segment_id($header[1][$index],$client_id);		  
				  $query .= "('$client_id','$segment_id','$value')";
                       if($i<$limit and $z<$last_entry_count-1){				 
						$query .= ",";
					   }				  

				  unset($page_content[$index]);
				  if($i==$limit-1)
			        $z++;	  
			
			   
			}
			unset($content[$i]);
			
			}
			
			$this->common_model->create_contact_temp($query);	      
		   
		   
	   }
    //unlink($uploaded_file); 
    $arr= array("status"=>"success","message"=>"Validation Success");
    echo json_encode($arr);
    exit;
 
}*/

 
 public function getSiteVisitorData($client_id,$entity_id,$entity_name,$month) {
	 
	 $visitors_data = $this->common_model->get_data('ga_site_visitors','visitors_count',
	                    array("client_id"=>$client_id,"ga_event_id"=>$entity_id,"ga_event_entity_name"=>$entity_name,"date"=>$month)) ; 
	 
	 if($visitors_data)	 					
	  
	  return $visitors_data[0]['visitors_count'];
	
	else
	
	  return 0;   					
  
  
  }

 public function get_current_data()
 
 {
    $client_id = $this->input->post('client_id');
    $clients		=	$this->common_model->get_data('clients','*',array('id'=>$client_id,'status'=>'1'));
	$date 		= date('Y-m-d');
	$start_date   = date('Y-m-01',strtotime(date('Y-m')));
	$end_date   = date('Y-m-t',strtotime(date('Y-m')));
	$mail_count=0;
	$site_visitors=0;  
	$data =array();
	for($i=0;$i<count($clients);$i++){
	         if($clients[$i]['api_list_id']!=0){	
			   $mail_count 	= $this->common_model->request_soap_mail($clients[$i],$start_date,$date,1,0);
			   if($mail_count!=0)
			     $data['mail_count']=$mail_count;
			 } 
			 if($clients[$i]['ga_account_id']!='0') { 
			
			   $site_visitors 	= $this->common_model->request_ga_month_site_visitors($clients[$i],$start_date,$date,'count');
			   if($site_visitors!=0)
			    $data['visitors_count']=$site_visitors;
				
				$this->update_gadetails($clients[$i],$start_date,$date,$end_date);
				
			 }  
			 if($data and is_array($data)) { 
			 $data['last_update']=date('Y-m-d');
			 $this->common_model->update('clients',$data,array("id"=>$clients[$i]['id']));
			 
			 }
	} 
    $arr= array("status"=>"success");
    echo json_encode($arr);
    exit;
 
 
 }
 
 public function get_tablet_feedback_data()
 
 {
    $client_id = $this->input->post('client_id');
    $clients		=	$this->common_model->get_data('clients','*',array('id'=>$client_id,'enable_tablet_feedback'=>1,'status'=>'1'));
	$data =array();
	for($i=0;$i<count($clients);$i++){
	         if($clients[$i]['api_list_id']!=0){	
			   $feedback_data 	= $this->common_model->request_tablet_feedback_data($clients[$i]);
			   $feedback_data_api_records_count =  sizeof($feedback_data);
			   $feedback_records =  $this->common_model->get_data('tablet_feedback_details','id,client_id',array('client_id'=>$client_id,'status'=>'1'));
			   $feeback_records_count = sizeof($feedback_records);
			   if($feedback_data_api_records_count!=0 and $feedback_data_api_records_count > $feeback_records_count){
				
				  $new_records = $feedback_data_api_records_count -  $feeback_records_count;
				 
				  for($j=0;$j<$new_records;$j++){
					  
					 $data['client_id'] = $client_id;
					 $data['email'] = $feedback_data[$j]->Email;	   
					 $data['received_date']	=  date('Y-m-d',strtotime($feedback_data[$j]->RecievedDate));
					 $data['from_ip'] = $feedback_data[$j]->FromIP;
					 $data['restaurant'] = $feedback_data[$j]->ClientName;
					 $data['status'] =1;
					 
					 $profile_details = json_decode($feedback_data[$j]->ProfileData);
					 
					 if($profile_details){
					  
					 foreach($profile_details as $profile_data){
						
					    if($profile_data->AttributeID){
							$field_name = $this->common_model->get_field_name($profile_data->AttributeID,$client_id);
							if($field_name and $profile_data->Value)					   
							  $data[$field_name]= $profile_data->Value;
						}
								
					
					 }
					}
					
					$this->common_model->save("tablet_feedback_details",$data);	  
					 unset($data);  
				  }
				
				   
			   }
			 }
	} 
   exit;
    $arr= array("status"=>"success");
    echo json_encode($arr);
    exit;
 
 
 }
 
 public function update_gadetails($clients,$start_date,$date,$end_date){
	
	$ga_events  =  $this->common_model->get_data('ga_events','*',array('status'=>'1'));
	$client_id=$clients['id'];    
	for($j=0;$j<count($ga_events);$j++)  {	
		 $query = $this->db->query("SELECT * FROM ga_site_visitors WHERE date>='".$start_date."' AND date<='".$end_date."' AND client_id=".$client_id."
		                             AND ga_event_id=".$ga_events[$j]['id']."");
	     $ga_site_vistors = $query->result(); 
		 	
	     if(!$ga_site_vistors){	  
	       $this->common_model->request_ga_site_visitors($clients,$ga_events[$j]['id'],$start_date,$end_date);
		   
		 }
		 else{
		   $data_visit_details = $this->common_model->request_ga_site_visitors($clients,$ga_events[$j]['id'],$start_date,$end_date,'array');
		   if($ga_events[$j]['id']==1 and isset($data_visit_details['totalsForAllResults'])){
			 
			 foreach($data_visit_details['totalsForAllResults'] as $entity_name=>$value){
	  
	                $event_name = str_replace("ga:", "", $entity_name);
					$ga_visitors_event_details = $this->common_model->get_data('ga_site_visitors','*',array(
					                              "client_id"=>$client_id,"ga_event_id"=>1,"ga_event_entity_name"=>$event_name,"date"=>$end_date));												  
					$data_ga_details = array("visitors_count" => $value );
					$where_cond = array("id"=>$ga_visitors_event_details[0]['id']);
					$this->common_model->update('ga_site_visitors',$data_ga_details,$where_cond);  					
	
	          }
			   
			   
		   }
		  else if($ga_events[$j]['id']==2){
			 
			 foreach( $data_visit_details['rows'] as $visit){
	        
				if($visit[0]=='(none)')
				  $visit[0] ='Direct';	  
				$ga_visitors_event_details = $this->common_model->get_data('ga_site_visitors','*',array(
					                              "client_id"=>$client_id,"ga_event_id"=>2,"ga_event_entity_name"=>$visit[0],"date"=>$end_date));												                if($ga_visitors_event_details and is_array($ga_visitors_event_details)){
					$data_ga_details = array("visitors_count" => $visit[1] );
					$where_cond = array("id"=>$ga_visitors_event_details[0]['id']);
					$this->common_model->update('ga_site_visitors',$data_ga_details,$where_cond);
			    }

	       }
			  
			  
		  }
		  
		  else if($ga_events[$j]['id']==3 or $ga_events[$j]['id']==5 or $ga_events[$j]['id']==6){
			
			foreach( $data_visit_details['rows'] as $visit){
		 		
				$ga_visitors_event_details = $this->common_model->get_data('ga_site_visitors','*',array(
					                              "client_id"=>$client_id,"ga_event_id"=>$ga_events[$j]['id'],"ga_event_entity_name"=>$visit[0],"date"=>$end_date));												                
				if($ga_visitors_event_details and is_array($ga_visitors_event_details)){								  
					$data_ga_details = array("visitors_count" => $visit[1] );
					$where_cond = array("id"=>$ga_visitors_event_details[0]['id']);
					$this->common_model->update('ga_site_visitors',$data_ga_details,$where_cond);
				}
				else{
					
				  $data =array("ga_event_id"=>$ga_events[$j]['id'],
	               "client_id"=>$client_id,
				   "date" => $end_date,
				   "ga_event_entity_name" => $visit[0],
				   "visitors_count" => $visit[1] ); 	  
	              $this->common_model->save("ga_site_visitors",$data); 	
				
				}

	     }	  
			  
			  
		  }
			 
		 }
	       
	   }  
	 
	return true; 
	 
 }
 
 public function search_tablet_feedback(){
   
    $search_date  =  $this->input->post('search_date');
	$client_id = $this->input->post('client_id');
	$dat_arr = explode('-',$search_date);
	$search_date = $dat_arr[1].'-'.$dat_arr[0].'-01';
    $start_date =date('Y-m-01',strtotime($search_date));
    $end_date  = date('Y-m-t',strtotime($search_date));
	$tablet_feedback_table ='';
	$tablet_feedback_data = $this->common_model->get_data('tablet_feedback_details','*',array("client_id"=>$client_id,"received_date>="=>$start_date,"received_date<="=>$end_date),'received_date ASC');
	$tablet_feedback_active_fields = $this->common_model->feedback_active_fields($client_id);
	$field_count = sizeof($tablet_feedback_active_fields);	
	if($tablet_feedback_data){
	  
	  foreach($tablet_feedback_data as $feedback_data){
		$tablet_feedback_table .='<tr>';
		if($tablet_feedback_active_fields){
			
			foreach($tablet_feedback_active_fields as $field){
		
		$tablet_feedback_table .='<td>'.$feedback_data[$field->field_name].'</td>';
		  
		  
	  }
	
	
	}
	$tablet_feedback_table .='</tr>';
	  }
	}
   else{
	$tablet_feedback_table .='<tr><td colspan="'.$field_count.'">No data Found</td></tr>';   
	   
   }
  $arr = array('status' =>'success','data_html'=>$tablet_feedback_table,'start_date'=>$start_date,'end_date'=>$end_date);
  echo json_encode($arr); 
  exit;	 
 
 }
 
 public function list_tablet_feedback(){
   
	$client_id = $this->input->post('client_id');
	$tablet_feedback_table ='';
	$tablet_feedback_data = $this->common_model->get_data('tablet_feedback_details','*',array("client_id"=>$client_id,"received_date>="=>'2017-01-01'),'received_date DESC');
	$tablet_feedback_active_fields = $this->common_model->feedback_active_fields($client_id);
	$field_count = sizeof($tablet_feedback_active_fields);	
	if($tablet_feedback_data){
	  
	  foreach($tablet_feedback_data as $feedback_data){
		$tablet_feedback_table .='<tr>';
		if($tablet_feedback_active_fields){
			
			foreach($tablet_feedback_active_fields as $field){
		
		$tablet_feedback_table .='<td>'.$feedback_data[$field->field_name].'</td>';
		  
		  
	  }
	
	
	}
	$tablet_feedback_table .='</tr>';
	  }
	}
   else{
	$tablet_feedback_table .='<tr><td colspan="'.$field_count.'">No data Found</td></tr>';   
	   
   }
  $arr = array('status' =>'success','data_html'=>$tablet_feedback_table);
  echo json_encode($arr); 
  exit;	 
 
 }
 
  public function change_password()
  {
	 
	if (!empty($_POST)) {
		
		    $password=$this->input->post('current_password');
			$confirm_password = $this->input->post('confirm_password');
			$user_id = $this->input->post('user_id');
			$query = $this->db->query("SELECT * FROM users WHERE id=".$user_id." AND  password=LEFT(MD5(CONCAT(MD5('$password'), 'cloud')), 50)");
			if ($query->num_rows() > 0) {
			 
			 $this->db->query("UPDATE users SET password=LEFT(MD5(CONCAT(MD5('$confirm_password'), 'cloud')), 50) WHERE id=".$user_id."");
			 $arr = array("status"=>"success");
			}
			else{
			   $arr = array("status"=>"failed"); 
			}		
	}
	  
	echo json_encode($arr);
	 exit;    	  
	  
  }
   

  public function toNum($data) {
    $alphabet = array( 'A', 'B', 'C', 'D', 'E',
                       'F', 'G', 'H', 'I', 'J',
                       'K', 'L', 'M', 'N', 'O',
                       'P', 'Q', 'R', 'S', 'T',
                       'U', 'V', 'W', 'X', 'Y',
                       'Z');
    $alpha_flip = array_flip($alphabet);
    $return_value = -1;
    $length = strlen($data);
    for ($i = 0; $i < $length; $i++) {
        $return_value +=
            ($alpha_flip[$data[$i]] + 1) * pow(26, ($length - $i - 1));
    }
    return $return_value+1;;
}

 function getNameFromNumber($num) {
    $numeric = $num % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($num / 26);
    if ($num2 > 0) {
        return $this->getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
 }

 
 
  
  public function rand_string($length) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);

  }
 
 /**
     * validating the form elemnets
     */
  public function _init_login_validation_rules() {
        $this->form_validation->set_rules('username', 'username', 'required|max_length[50]');
        $this->form_validation->set_rules('password', 'password', 'required|max_length[20]');
    }

  public function _init_login_details() {
        $this->username = $this->input->post("username");
        $this->password = $this->input->post("password");
    }
 

}



?>