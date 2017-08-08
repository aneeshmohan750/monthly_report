<?php


defined('BASEPATH') OR exit('No direct script access allowed');
 
 
class Index  extends CI_Controller {

	/** 
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name> 
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	var $gen_contents = array();
        
    public function __construct() {
		
            parent::__construct();
			
    } 
	 
	public function dashboard(){

	   if($this->session->userdata('is_login')){

		  $this->gen_contents['page_title'] = 'Techmart Solutions - Monthly Report';
          $this->gen_contents['current_controller']='dashboard';
		  $session_data=$this->session->userdata('logged_in');
		  if(!isset($session_data['CLIENT_ID']))
		     redirect('index/segment_consolidation', 'refresh');
		  $this->gen_contents['emails'] 	= $this->get_mail_count_details($session_data['CLIENT_ID']);
		  $this->gen_contents['messages'] 	=  $this->get_message_details($session_data['CLIENT_ID']);
		  $this->gen_contents['segmentation_emails'] = $this->get_segmentation_count_details($session_data['CLIENT_ID']); 		  
        //  $this->gen_contents['monthly_emails'] = $this->get_monthly_mail_count_details($session_data['CLIENT_ID']);
		  $this->gen_contents['username'] = $session_data['USERNAME'];
		  $this->gen_contents['client_id'] = $session_data['CLIENT_ID'];
		  $this->gen_contents['client_website'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'website');
		  $this->gen_contents['client_mail_listing'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_mail_listing');
		  $this->gen_contents['client_ga_details'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_ga_details');
		  $this->gen_contents['client_tablet_feedback'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_tablet_feedback');
		  $this->gen_contents['type'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'type');
		  $this->gen_contents['admin'] = $session_data['IS_ADMIN'];
		  $this->gen_contents['name'] = $session_data['NAME'];
		  $this->gen_contents['group_admin'] = $session_data['IS_GROUP_ADMIN'];
		  $this->gen_contents['clients']  = $this->common_model->get_data('clients','*',array('status'=>1),'name ASC');
		  $this->gen_contents['allowed_clients']  = $this->common_model->get_allowed_clients($session_data['USER_ID']);	
		
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('index',$this->gen_contents);
		  $this->load->view('common/footer');
	   }
	   else{

	          redirect('index/login', 'refresh');

	   }	  
   }
   
   public function index(){
      
	   if($this->session->userdata('is_login')){

		  $this->gen_contents['page_title'] = 'Techmart Solutions - Monthly Report -Overview';
          $this->gen_contents['current_controller']='index';
		  $session_data=$this->session->userdata('logged_in');
		  if(!isset($session_data['CLIENT_ID']))
		     redirect('index/segment_consolidation', 'refresh');
		  $this->gen_contents['client_mail_listing'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_mail_listing');
		  $this->gen_contents['client_ga_details'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_ga_details');	 
		  if($this->gen_contents['client_mail_listing']!=1 and $this->gen_contents['client_ga_details']==1)
		      redirect('index/ga_details', 'refresh');	 
		  $this->gen_contents['username'] = $session_data['USERNAME'];
		  $this->gen_contents['emails'] 	= $this->get_mail_count_details($session_data['CLIENT_ID']);	
		  //$this->common_model->generate_contact_segment_array($session_data['CLIENT_ID']);  
       //   $this->gen_contents['monthly_emails'] = $this->get_monthly_mail_count_details($session_data['CLIENT_ID']);
		  $this->gen_contents['visitors'] 	= $this->get_visitors_details($session_data['CLIENT_ID']);
		  //$this->gen_contents['monthly_visitors'] = $this->get_monthly_visitors_count_details($session_data['CLIENT_ID']);
		  $this->gen_contents['average_frequency_rate']  = $this->average_frequency_rate($session_data['CLIENT_ID']);
		  $this->gen_contents['average_open_rate']  = $this->average_mail_measure_rate($session_data['CLIENT_ID'],'open');
		  $this->gen_contents['average_read_rate']  = $this->average_mail_measure_rate($session_data['CLIENT_ID'],'read');
		  $this->gen_contents['average_ctor_rate']  = $this->average_mail_measure_rate($session_data['CLIENT_ID'],'ctor');
		  $this->gen_contents['client_id'] = $session_data['CLIENT_ID'];
		  $this->gen_contents['client'] = $this->common_model->get_entity_name('clients',$session_data['CLIENT_ID']);
		  $this->gen_contents['client_website'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'website');
		  $this->gen_contents['client_tablet_feedback'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_tablet_feedback');
		  $this->gen_contents['client_last_update'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'last_update');
		  $this->gen_contents['client_mail_count'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'mail_count');
		  $this->gen_contents['type'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'type');
		  $this->gen_contents['admin'] = $session_data['IS_ADMIN'];
		  $this->gen_contents['name'] = $session_data['NAME'];
		  $this->gen_contents['group_admin'] = $session_data['IS_GROUP_ADMIN'];
		  $this->gen_contents['clients']  = $this->common_model->get_data('clients','*',array('status'=>1),'name ASC');
		  $this->gen_contents['allowed_clients']  = $this->common_model->get_allowed_clients($session_data['USER_ID']);
		    $this->gen_contents['last_month_date'] = date('Y-m-d', strtotime('last day of previous month'));
			
		 // print_r( $this->gen_contents['allowed_clients'] );
		  //exit;		
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('overview',$this->gen_contents);
		  $this->load->view('common/footer');
	   }
	   else if(isset($_COOKIE['remember_me_token']) and $_COOKIE['remember_me_token']!='' and $this->common_model->check_login_data($_COOKIE['remember_me_token'])){
		
		$login_data=$this->common_model->check_login_data($_COOKIE['remember_me_token']);
		if ($this->authentication->process_login_encrypted_password($login_data) == 'success') {
		   redirect('index', 'refresh');	
		}
		else{
	       redirect('index/login', 'refresh');

	   }
		  
	  }
	   else{

	          redirect('index/login', 'refresh');

	   }	  
   }
   
   public function file_upload()
	{
	    
	   if($this->session->userdata('is_login')){
		  $this->gen_contents['page_title'] = 'Techmart Solutions - File Upload';
		  $this->gen_contents['current_controller']='file_upload';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['username'] = $session_data['USERNAME'];
		  $this->gen_contents['client_id']=$session_data['CLIENT_ID'];
		  $this->gen_contents['clients']  = $this->common_model->get_data('clients','*',array('status'=>1),'name ASC');
		  $this->gen_contents['allowed_clients']  = $this->common_model->get_allowed_clients($session_data['USER_ID']);	
		  $this->gen_contents['client_mail_listing'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_mail_listing');
		  $this->gen_contents['client_ga_details'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_ga_details');
		  $this->gen_contents['client_tablet_feedback'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_tablet_feedback');
		  $this->gen_contents['admin'] = $session_data['IS_ADMIN'];
		  $this->gen_contents['name'] = $session_data['NAME'];
		  $this->gen_contents['group_admin'] = $session_data['IS_GROUP_ADMIN'];
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('file_upload',$this->gen_contents);
		  $this->load->view('common/footer');
	   
	   }
	   
	   else{
	          redirect('index/login', 'refresh');
	   }	  
	}
   
   public function ga_details(){
    
	  if($this->session->userdata('is_login')){
		  $this->gen_contents['page_title'] = 'Techmart Solutions - GA Details';
		  $this->gen_contents['current_controller']='ga_details';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['username'] = $session_data['USERNAME'];
		  $this->gen_contents['clients']  = $this->common_model->get_data('clients','*',array('status'=>1),'name ASC');
		  $this->gen_contents['allowed_clients']  = $this->common_model->get_allowed_clients($session_data['USER_ID']);	
		  $this->gen_contents['client_id']=$session_data['CLIENT_ID'];	
		  $this->gen_contents['visitors'] 	= $this->get_visitors_details($session_data['CLIENT_ID']);
		  $this->gen_contents['referals'] 	= $this->get_visitors_referal_details($session_data['CLIENT_ID']);
		  $this->gen_contents['browser_visitors'] 	= $this->get_visitors_browser_details($session_data['CLIENT_ID']);
		  $this->gen_contents['country_visitors'] 	= $this->get_country_visitors_details($session_data['CLIENT_ID']);
		  $this->gen_contents['page_visitors'] 	= $this->get_toppage_visitors_details($session_data['CLIENT_ID']);
		  $this->gen_contents['client_mail_listing'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_mail_listing'); 
		  $this->gen_contents['client_ga_details'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_ga_details');
		  $this->gen_contents['client_tablet_feedback'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_tablet_feedback');
		  $this->gen_contents['client_last_update'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'last_update'); 
		  $this->gen_contents['client_visitor_count'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'visitors_count');
		  $this->gen_contents['admin'] = $session_data['IS_ADMIN'];
		  $this->gen_contents['group_admin'] = $session_data['IS_GROUP_ADMIN'];
		  $this->gen_contents['name'] = $session_data['NAME']; 
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('ga_details',$this->gen_contents);
		  $this->load->view('common/footer');
	   
	   }
	   
	   else{
	          redirect('index/login', 'refresh');
	   }	    
	   	
   
   }
   
   public function segment_consolidation(){
    
	  if($this->session->userdata('is_login')){
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Segment Consolidation';
		  $this->gen_contents['current_controller']='segment_consolidation';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['username'] = $session_data['USERNAME'];
		  $this->gen_contents['clients']  = $this->common_model->get_data('clients','*',array('status'=>1),'name ASC');
		  $this->gen_contents['allowed_clients']  = $this->common_model->get_allowed_clients($session_data['USER_ID']);	
		 // $this->gen_contents['allowed_clients']  = $this->common_model->get_data('clients','*',array('status'=>1));
		  $this->gen_contents['allowed_ga_clients']  =  $this->common_model->get_allowed_clients($session_data['USER_ID'],$allow_ga=1);	
		  $this->gen_contents['last_month']= date('Y-m-d', strtotime('first day of previous month'));
		  $this->gen_contents['last_month_date']=  date('Y-m-d', strtotime('last day of previous month'));
		  $this->gen_contents['client_id']=false;
		  $this->gen_contents['client_mail_listing'] = false; 
		  $this->gen_contents['client_ga_details'] = false;	
		  $this->gen_contents['client_tablet_feedback'] = false;
		  $this->gen_contents['primary_segments'] = $this->common_model->get_data('segments','*',array("client_id"=>0,"primary_segment"=>1,"listing"=>1,"status"=>1));
		  $this->gen_contents['admin'] = $session_data['IS_ADMIN'];
		  $this->gen_contents['group_admin'] = $session_data['IS_GROUP_ADMIN'];
		  $this->gen_contents['multi_access'] = $session_data['MULTI_ACCESS'];
		  $this->gen_contents['name'] = $session_data['NAME']; 
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('segment_consolidation',$this->gen_contents);
		  $this->load->view('common/footer');
	   
	   }
	   
	   else{
	          redirect('index/login', 'refresh');
	   }	    
	   	
   
   }
   
   public function change_password(){

	   if($this->session->userdata('is_login')){

		  $this->gen_contents['page_title'] = 'Techmart Solutions - Monthly Report';
          $this->gen_contents['current_controller']='change_password';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['username'] = $session_data['USERNAME'];
		  $this->gen_contents['user_id'] = $session_data['USER_ID'];
		  $this->gen_contents['client_id'] = false;
		  //$this->gen_contents['client_website'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'website');
		 // $this->gen_contents['client_ga_details'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_ga_details');
		  $this->gen_contents['name'] = $session_data['NAME'];
		  $this->gen_contents['admin'] = $session_data['IS_ADMIN'];
		  $this->gen_contents['group_admin'] = $session_data['IS_GROUP_ADMIN'];
		  $this->gen_contents['clients']  = $this->common_model->get_data('clients','*',array('status'=>1),'name ASC');
		  $this->gen_contents['allowed_clients']  = $this->common_model->get_allowed_clients($session_data['USER_ID']);		
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('change_password',$this->gen_contents);
		  $this->load->view('common/footer');
	   }
	   else{

	          redirect('index/login', 'refresh');

	   }	  
   }
   
   public function segments(){
   
     if($this->session->userdata('is_login')){
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Segments';
		  $this->gen_contents['current_controller']='segments';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['username'] = $session_data['USERNAME'];
		  $this->gen_contents['clients']  = $this->common_model->get_data('clients','*',array('status'=>1),'name ASC');
		  $this->gen_contents['allowed_clients']  = $this->common_model->get_allowed_clients($session_data['USER_ID']);	
		  $this->gen_contents['client_id']=$session_data['CLIENT_ID'];		
		  $this->gen_contents['segments'] = $this->common_model->get_data('segments','*',array("client_id"=>$session_data['CLIENT_ID']));
		  $this->gen_contents['client_mail_listing'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_mail_listing'); 
		  $this->gen_contents['client_ga_details'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_ga_details');
		  $this->gen_contents['client_tablet_feedback'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_tablet_feedback');
		  $this->gen_contents['admin'] = $session_data['IS_ADMIN'];
		  $this->gen_contents['group_admin'] = $session_data['IS_GROUP_ADMIN'];
		  $this->gen_contents['name'] = $session_data['NAME']; 
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('segments',$this->gen_contents);
		  $this->load->view('common/footer'); 

	 }
    
	 else{
		  redirect('index/login', 'refresh');   
	 }
   
   }
   
   public function create_segment(){
   
     if($this->session->userdata('is_login')){
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Create Segments';
		  $this->gen_contents['current_controller']='create_segment';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['username'] = $session_data['USERNAME'];
		  $this->gen_contents['clients']  = $this->common_model->get_data('clients','*',array('status'=>1),'name ASC');
		  $this->gen_contents['allowed_clients']  = $this->common_model->get_allowed_clients($session_data['USER_ID']);
		  $this->gen_contents['client_mail_listing'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_mail_listing'); 	
		  $this->gen_contents['client_ga_details'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_ga_details');
		  $this->gen_contents['client_tablet_feedback'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_tablet_feedback');	
		  $this->gen_contents['client_id'] = $session_data['CLIENT_ID'];
		  $this->gen_contents['admin'] = $session_data['IS_ADMIN'];
		  $this->gen_contents['group_admin'] = $session_data['IS_GROUP_ADMIN'];
		  $this->gen_contents['name'] = $session_data['NAME']; 
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('create_segment',$this->gen_contents);
		  $this->load->view('common/footer'); 

	 }
    
	 else{
		  redirect('index/login', 'refresh');   
	 }
   
   }
   
   public function edit_segments(){
   
    if($this->session->userdata('is_login')){
		  $segment_id = $this->input->get('segment_id');
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Edit Segments';
		  $this->gen_contents['current_controller']='update_segments';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['username'] = $session_data['USERNAME'];
		  $this->gen_contents['clients']  = $this->common_model->get_data('clients','*',array('status'=>1),'name ASC');
		  $this->gen_contents['allowed_clients']  = $this->common_model->get_allowed_clients($session_data['USER_ID']);		
		  $this->gen_contents['client_id'] = $session_data['CLIENT_ID'];
		  $this->gen_contents['segment_data'] = $this->common_model->get_data('segments','*',array("id"=>$segment_id));
		  $this->gen_contents['client_mail_listing'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_mail_listing'); 
		  $this->gen_contents['client_ga_details'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_ga_details');
		  $this->gen_contents['client_tablet_feedback'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_tablet_feedback');
		  $this->gen_contents['admin'] = $session_data['IS_ADMIN'];
		  $this->gen_contents['group_admin'] = $session_data['IS_GROUP_ADMIN'];
		  $this->gen_contents['name'] = $session_data['NAME']; 
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('edit_segments',$this->gen_contents);
		  $this->load->view('common/footer'); 

	 }
    
	 else{
		  redirect('index/login', 'refresh');   
	 }
   
   }
   
   public function users(){
   
     if($this->session->userdata('is_login')){
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Users';
		  $this->gen_contents['current_controller']='users';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['username'] = $session_data['USERNAME'];
		  $this->gen_contents['clients']  = $this->common_model->get_data('clients','*',array('status'=>1),'name ASC');
		  $this->gen_contents['allowed_clients']  = $this->common_model->get_allowed_clients($session_data['USER_ID']);	
		  $this->gen_contents['client_id']=$session_data['CLIENT_ID'];		
		  $this->gen_contents['users'] = $this->common_model->get_data('users','*',array("client_id"=>$session_data['CLIENT_ID']));
		  $this->gen_contents['client_mail_listing'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_mail_listing'); 
		  $this->gen_contents['client_ga_details'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_ga_details');
		  $this->gen_contents['client_tablet_feedback'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_tablet_feedback');
		  $this->gen_contents['admin'] = $session_data['IS_ADMIN'];
		  $this->gen_contents['group_admin'] = $session_data['IS_GROUP_ADMIN'];
		  $this->gen_contents['name'] = $session_data['NAME']; 
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('users',$this->gen_contents);
		  $this->load->view('common/footer'); 

	 }
    
	 else{
		  redirect('index/login', 'refresh');   
	 }
   
   }
   
   public function create_user(){
   
     if($this->session->userdata('is_login')){
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Create User';
		  $this->gen_contents['current_controller']='create_user';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['username'] = $session_data['USERNAME']; 
		  $this->gen_contents['clients']  = $this->common_model->get_data('clients','*',array('status'=>1),'name ASC');
		  $this->gen_contents['allowed_clients']  = $this->common_model->get_allowed_clients($session_data['USER_ID']);
		  $this->gen_contents['client_mail_listing'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_mail_listing'); 	
		  $this->gen_contents['client_ga_details'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_ga_details');
		  $this->gen_contents['client_tablet_feedback'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_tablet_feedback');
		  $this->gen_contents['client_id']=$session_data['CLIENT_ID'];		
		  $this->gen_contents['admin'] = $session_data['IS_ADMIN'];
		  $this->gen_contents['name'] = $session_data['NAME']; 
		  $this->gen_contents['group_admin'] = $session_data['IS_GROUP_ADMIN'];
		  $this->gen_contents['client_id'] = $session_data['CLIENT_ID'];
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('create_user',$this->gen_contents);
		  $this->load->view('common/footer'); 

	 }
    
	 else{
		  redirect('index/login', 'refresh');   
	 }
   
   }
   
   public function edit_users(){
   
    if($this->session->userdata('is_login')){
		  $user_id = $this->input->get('user_id');
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Edit Users';
		  $this->gen_contents['current_controller']='edit_users';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['username'] = $session_data['USERNAME']; 
		  $this->gen_contents['clients']  = $this->common_model->get_data('clients','*',array('status'=>1),'name ASC');
		  $this->gen_contents['allowed_clients']  = $this->common_model->get_allowed_clients($session_data['USER_ID']);	
		  $this->gen_contents['client_id']=$session_data['CLIENT_ID'];		
		  $this->gen_contents['admin'] = $session_data['IS_ADMIN'];	
		  $this->gen_contents['group_admin'] = $session_data['IS_GROUP_ADMIN'];
		  $this->gen_contents['client_id'] = $session_data['CLIENT_ID'];
		  $this->gen_contents['name'] = $session_data['NAME']; 
		  $this->gen_contents['user_data'] = $this->common_model->get_data('users','*',array("id"=>$user_id));
		  $this->gen_contents['client_mail_listing'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_mail_listing'); 
		  $this->gen_contents['client_ga_details'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_ga_details');
		  $this->gen_contents['client_tablet_feedback'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_tablet_feedback');
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('edit_users',$this->gen_contents);
		  $this->load->view('common/footer'); 

	 }
    
	 else{
		  redirect('index/login', 'refresh');   
	 }
   
   }
   
    public function site_page_name(){
   
     if($this->session->userdata('is_login')){
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Site Page Name';
		  $this->gen_contents['current_controller']='site_page_name';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['username'] = $session_data['USERNAME'];
		  $this->gen_contents['clients']  = $this->common_model->get_data('clients','*',array('status'=>1),'name ASC');
		  $this->gen_contents['allowed_clients']  = $this->common_model->get_allowed_clients($session_data['USER_ID']);
		  $this->gen_contents['client_id']=$session_data['CLIENT_ID'];			
		  $this->gen_contents['site_page'] = $this->common_model->get_site_pages($session_data['CLIENT_ID']);
		  foreach($this->gen_contents['site_page'] as $page_name){
		     $page = $this->common_model->get_data('site_page_name_map','*',array("client_id"=>$session_data['CLIENT_ID'],"page_url"=>$page_name->ga_event_entity_name));
			 if(!$page){
			   $this->common_model->save('site_page_name_map',array("client_id"=>$session_data['CLIENT_ID'],"page_url"=>$page_name->ga_event_entity_name));
			 }
		  }
          $this->gen_contents['page_map'] = $this->common_model->get_data('site_page_name_map','*',array("client_id"=>$session_data['CLIENT_ID']),'id ASC');
		  $this->gen_contents['client_mail_listing'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_mail_listing'); 
		  $this->gen_contents['client_ga_details'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_ga_details');
		  $this->gen_contents['client_tablet_feedback'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_tablet_feedback');
		  $this->gen_contents['admin'] = $session_data['IS_ADMIN'];
		  $this->gen_contents['name'] = $session_data['NAME']; 
		  $this->gen_contents['group_admin'] = $session_data['IS_GROUP_ADMIN'];
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('site_pages',$this->gen_contents);
		  $this->load->view('common/footer'); 

	 }
    
	 else{
		  redirect('index/login', 'refresh');   
	 }
   
   }
   
  
   
   public function edit_site_page(){
   
    if($this->session->userdata('is_login')){
		  $page_id = $this->input->get('page_id');
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Edit Site Page';
		  $this->gen_contents['current_controller']='edit_site_page_name';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['username'] = $session_data['USERNAME']; 
		  $this->gen_contents['clients']  = $this->common_model->get_data('clients','*',array('status'=>1),'name ASC');
		  $this->gen_contents['allowed_clients']  = $this->common_model->get_allowed_clients($session_data['USER_ID']);
		  $this->gen_contents['client_id']=$session_data['CLIENT_ID'];		
		  $this->gen_contents['admin'] = $session_data['IS_ADMIN'];
		  $this->gen_contents['group_admin'] = $session_data['IS_GROUP_ADMIN'];
		  $this->gen_contents['client_id'] = $session_data['CLIENT_ID'];
		  $this->gen_contents['name'] = $session_data['NAME']; 
		  $this->gen_contents['site_page'] = $this->common_model->get_data('site_page_name_map','*',array("id"=>$page_id));
		  $this->gen_contents['client_mail_listing'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_mail_listing'); 
		  $this->gen_contents['client_ga_details'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_ga_details');
		  $this->gen_contents['client_tablet_feedback'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_tablet_feedback');
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('edit_site_page',$this->gen_contents);
		  $this->load->view('common/footer'); 

	 }
    
	 else{
		  redirect('index/login', 'refresh');   
	 }
   
   }
   
   public function tablet_feedback_details(){
   
     if($this->session->userdata('is_login')){
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Tablet Feedback Details';
		  $this->gen_contents['current_controller']='tablet_feedback_details';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['username'] = $session_data['USERNAME'];
		  $this->gen_contents['clients']  = $this->common_model->get_data('clients','*',array('status'=>1),'name ASC');
		  $this->gen_contents['allowed_clients']  = $this->common_model->get_allowed_clients($session_data['USER_ID']);	
		  $this->gen_contents['client_id']=$session_data['CLIENT_ID'];
		  $this->gen_contents['tablet_feedback_active_fields'] = $this->common_model->feedback_active_fields($session_data['CLIENT_ID']);		
		  $this->gen_contents['tablet_feedback_details'] = $this->common_model->get_data('tablet_feedback_details','*',array("client_id"=>$session_data['CLIENT_ID'],"received_date>="=>'2017-01-01'),'received_date DESC');
		  $this->gen_contents['client_mail_listing'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_mail_listing');
		  $this->gen_contents['client_ga_details'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_ga_details');
		  $this->gen_contents['client_tablet_feedback'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_tablet_feedback');
		  $this->gen_contents['admin'] = $session_data['IS_ADMIN'];
		  $this->gen_contents['group_admin'] = $session_data['IS_GROUP_ADMIN'];
		  $this->gen_contents['name'] = $session_data['NAME']; 
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('tablet_feedback',$this->gen_contents);
		  $this->load->view('common/footer'); 

	 }
    
	 else{
		  redirect('index/login', 'refresh');   
	 }
   
   }
   
   public function tablet_feedback_fields(){
   
     if($this->session->userdata('is_login')){
		  $this->gen_contents['page_title'] = 'Techmart Solutions - Users';
		  $this->gen_contents['current_controller']='users';
		  $session_data=$this->session->userdata('logged_in');
		  $this->gen_contents['username'] = $session_data['USERNAME'];
		  $this->gen_contents['clients']  = $this->common_model->get_data('clients','*',array('status'=>1),'name ASC');
		  $this->gen_contents['allowed_clients']  = $this->common_model->get_allowed_clients($session_data['USER_ID']);	
		  $this->gen_contents['client_id']=$session_data['CLIENT_ID'];		
		  $this->gen_contents['feedback_fields'] = $this->common_model->get_feedback_fields($session_data['CLIENT_ID']);
		  $this->gen_contents['client_mail_listing'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_mail_listing'); 
		  $this->gen_contents['client_ga_details'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_ga_details');
		  $this->gen_contents['client_tablet_feedback'] = $this->common_model->get_client_property($session_data['CLIENT_ID'],'enable_tablet_feedback');
		  $this->gen_contents['admin'] = $session_data['IS_ADMIN'];
		  $this->gen_contents['group_admin'] = $session_data['IS_GROUP_ADMIN'];
		  $this->gen_contents['name'] = $session_data['NAME']; 
		  $this->load->view('common/header',$this->gen_contents);
		  $this->load->view('feedback_fields',$this->gen_contents);
		  $this->load->view('common/footer'); 

	 }
    
	 else{
		  redirect('index/login', 'refresh');   
	 }
   
   }
   
   public function tablet_feedbacks_fields(){
	
	for($i=1;$i<43;$i++){
	
	    $data = array("field_id"=>$i,"client_id"=>20,"status"=>1);
		$this->common_model->save("feedback_form_field_client_rel",$data);
	   	
		
		
	}
	   
	echo "done";   
	   
   }
   
   public function get_mail_count_details($client_id)	{

	  $clients		=	$this->common_model->get_data('clients','*',array('id'=>$client_id,'status'=>'1'));
	  $month 		= date('M-Y');  
	  for($i=0;$i<count($clients);$i++){	
		  	//$clients[$i]['months']  = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan','Feb','Mar','Apr','May','Jun');
		  	//$clients[$i]['months']  = $this->get_months_list(); 
			$clients[$i]['months'] = $this->get_mail_list_orig_months();
			$clients[$i]['mails'] 	= $this->getLatmonthsMails($clients[$i]['id']);
			$clients[$i]['mails_graph'] 	= $this->getLatmonthsMailsGraph($clients[$i]['id']);
			$clients[$i]['current_year_months'] =  date('m')-1;
			$clients[$i]['last_year_months']=19-$clients[$i]['current_year_months'];	 
			//$this_month 			= $this->common_model->request_soap_mail($clients[$i]);
			//$clients[$i]['mails'][]	= array('label'=>$month,'value'=>$this_month);
	  }
	  
	  //echo "<pre>"; print_r($clients); echo "</pre>"; exit;
	  $data['clients'] = $clients;
	 
	  //$html	= $this->load->view('mail_details', $data, true);
	  return  $data;
    }

    private function getLatmonthsMails($client_id){

	  $month_list = $this->get_mail_list_orig_months();
	  $months = array();
	  foreach($month_list as $month=>$month_name){
		
	    $month = date('Y-m-t',strtotime($month));
	
	   $months_arr	=	$this->common_model->get_data('email_count_log','DATE_FORMAT(month,"%b-%Y") as label, emails as value ',array("client_id"=>$client_id,"month"=>$month),'month ASC');
	  if($months_arr)
	    $months[] = $months_arr[0];
      else
	    $months[] = array("label"=>date("M-Y",strtotime($month)),"value"=>0);   		
	  	
	  }
	  
	  return $months;
   }
   
   private function getLatmonthsMailsGraph($client_id){
	
	   $months       =   $this->common_model->get_mail_count_data($client_id); 
	 //echo "<pre>"; print_r($months); echo "</pre>"; exit;
	  return $months;
   }

   public function get_message_details($client_id){
	  
	  $clients		=	$this->common_model->get_data('clients','*',array('id'=>$client_id,'status'=>'1'));	  
	  $start_date = date('Y-m-01', strtotime("-30 days"));	  
	  $end_date = date('Y-m-t', strtotime("-30 days"));	  
	  $message_output=array();
	  
	  for($i=0;$i<count($clients);$i++){
	    
		 $message = $this->common_model->request_soap_message($clients[$i],$start_date,$end_date);
		 $delivery_message = $this->common_model->request_soap_delivery_message($clients[$i],$start_date,$end_date);
		 
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
		 else{
		   
		   //$message_output = $this->common_model->get_data('message_activity','*',array('client_id'=>$clients[$i]['id']));
		     $message_output = $this->common_model->get_message_activity($clients[$i]['id'],$start_date,$end_date);
			
			 
		   
		 }
		 
		$clients[$i]['message']	 = $message_output; 
	 
	  }
	  
	 
	  
	   
	  $data['clients'] = $clients;
	  //$html	= $this->load->view('message_details', $data, true);
	  return  $data;
	
  }
  
  public function average_frequency_rate($client_id){
   
      $clients		=	$this->common_model->get_data('clients','*',array('id'=>$client_id,'status'=>'1'));	  
	  $measure_frequency=0;	  	  
	  $month = date('m')-1;	
	  $month = ($month==0) ? 12 : $month;
	  $year = ($month==12) ? date('Y')-1:date('Y');  
	  $start_date = date('Y-m-01', strtotime("01-01-".$year));  
	  $end_date = date('Y-m-t', strtotime("01-".$month."-".$year));	  
	  $mail_frequency = 0;
	  
	  for($i=0;$i<count($clients);$i++){
	    
		if($clients[$i]['api_list_id']!=0){
        
			$mail_details= $this->common_model->get_message_details($clients[$i],$start_date,$end_date);			
			$mail_frequency = round(count($mail_details)/$month,2);
		
		}
		
		else{
		 
		  $mail_frequency_data =  $this->common_model->get_data('mail_frequency_rate','*',array("client_id"=>$client_id));
		  
		  if($mail_frequency_data)
		   
		   $mail_frequency =  $mail_frequency_data[0]['mail_frequency'];
		  
		
		}
		
	   
      }
	  
	  return $mail_frequency;
  
  }
  
  public function report_correction(){
		
	   $this->common_model->report_correction(135,'2017-04-30');	
		
	}
	 
 
 public function average_mail_measure_rate($client_id,$measure){
   
      $clients		=	$this->common_model->get_data('clients','*',array('id'=>$client_id,'status'=>'1'));
	  
	  $year = date('Y');
	  
	  $month = date('m')-1;
	  
	  $month = ($month==0) ? 12 : $month;
	  $year = ($month==12) ? date('Y')-1:date('Y');
	  
	  $start_date = date('Y-m-01', strtotime("01-01-".$year));
	  
	  $end_date = date('Y-m-t', strtotime("01-".$month."-".$year));
	  
	  for($i=0;$i<count($clients);$i++){
	   
	   $measure_frequency = 0;
	   
	   if($clients[$i]['api_list_id']){
        
		$message_details = $this->common_model->get_message_details($clients[$i],$start_date,$end_date);		
		
		
		$message_count = count($message_details);
		
		if($message_details){
		
		foreach($message_details as $message){
		  
		  if($measure=='open') 
		  		    
			$measure_frequency = $measure_frequency+$message['OpenPercent']; 

		  else if($measure=='read')		 
		    
		    $measure_frequency = $measure_frequency+$message['ReadPercent'];
		  
		  else if($measure=='ctor')	
		   
		   $measure_frequency = $measure_frequency+$message['Ctor'];
		   	
		} 
		
		 $measure_frequency =  round($measure_frequency/$message_count,2);
		 
	   }	 
		 
	  }
	  
	  else {
	  
	     $mail_frequency_data =  $this->common_model->get_data('mail_frequency_rate','*',array("client_id"=>$client_id));
		 
		 if($mail_frequency_data and $measure=='open')
		  
		  $measure_frequency = $mail_frequency_data[0]['open_rate'];
		  
		else if($mail_frequency_data and $measure=='read')		 
		  
		  $measure_frequency = $mail_frequency_data[0]['read_rate'];
		  
		else if($mail_frequency_data and $measure=='ctor')		 
		  
		  $measure_frequency = $mail_frequency_data[0]['ctor'];    
	  
	  }	 
	   
     }
  
	return $measure_frequency;
 
 
 
 } 
   
  
  public function get_segmentation_count_details($client_id)	{

	  $clients		=	$this->common_model->get_data('clients','*',array('id'=>$client_id,'status'=>'1'));
	  $month 		= date('M-Y'); 
	  
	  for($i=0;$i<count($clients);$i++){
		 
		  // $clients[$i]['months'] = $this->get_months_array_list();
		   $clients[$i]['months'] =$this->get_mail_list_months();
		   $clients[$i]['common_segments'] = $this->common_model->get_data('segments','id,name',array('segment_type'=>'normal','client_id'=>0,'listing'=>1));
		   $clients[$i]['common_source_segments'] = $this->common_model->get_data('segments','id,name',array('segment_type'=>'source','client_id'=>0,'listing'=>1));
		   $clients[$i]['non_hotel_common_source_segments'] = $this->common_model->get_data('segments','id,name',array('segment_type'=>'source','client_id'=>0,'non_hotel_segment'=>1));
		   $clients[$i]['segments'] = $this->common_model->get_data('segments','id,name',array('segment_type'=>'normal','client_id'=>$clients[$i]['id'],'listing'=>1));
		   $clients[$i]['res_segments'] = $this->common_model->get_data('segments','id,name',array('segment_type'=>'restaurant','client_id'=>$clients[$i]['id'],'listing'=>1));
		   $clients[$i]['source_segments'] = $this->common_model->get_data('segments','id,name',array('segment_type'=>'Source','client_id'=>$clients[$i]['id'],'listing'=>1));
		   
		   $clients[$i]['current_year_months'] =  date('m')-1;
		   $clients[$i]['last_year_months']=20-$clients[$i]['current_year_months'];	 
	  }
	   
	  $data['clients'] = $clients;
	  //$html	= $this->load->view('mail_details', $data, true);
	  return  $data;
    }
	
  public function get_visitors_details($client_id)	{

	  $clients		=	$this->common_model->get_data('clients','*',array('id'=>$client_id,'status'=>'1'));
	  $month 		= date('M-Y');  
	  for($i=0;$i<count($clients);$i++){	
		  	// $clients[$i]['months']  =  $this->get_visitors_months_list(15); 
			$clients[$i]['months']  =  $this->get_visitors_list_months();
			$clients[$i]['visitors'] 	= $this->getLastmonthsVisitDetail($clients[$i]['id'],'visits');
			$clients[$i]['visitors_per_day'] 	= $this->getLastmonthsVisitperDay($clients[$i]['id'],'visits');
			$clients[$i]['page_views'] 	= $this->getLastmonthsVisitDetail($clients[$i]['id'],'pageviews');
			$clients[$i]['newVisit'] 	= $this->getLastmonthsVisitDetail($clients[$i]['id'],'percentNewVisits');
			$clients[$i]['visitors_graph'] 	= $this->getLastmonthsVisitDetailGraph($clients[$i]['id'],'visits');
			$clients[$i]['current_year_months'] =  date('m')-1;
		    $clients[$i]['last_year_months']=16-$clients[$i]['current_year_months'];
	  }
	 
	  //echo "<pre>"; print_r($clients); echo "</pre>"; exit;
	  $data['clients'] = $clients;
	  //$html	= $this->load->view('mail_details', $data, true);
	  return  $data;
    }
	
	
	/// import
	
	 public function import_excel_file(){
     
	  $uploaded_file_name ='upload.xlsx';
	  $file_name= $this->input->post('file_name');
	  $data_segment= array();
	  $contact_segmentation='';
	  $client_id = 4;
	  ini_set('memory_limit', '-1');
	  $this->load->library('excel');
	  //$uploaded_file = FCPATH.'uploads\\excel\\'.$uploaded_file;
	  $uploaded_file = FCPATH.'uploads/sample_excel/'.$uploaded_file_name;
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
	   //$current_date="2015-12-01";
	   for($i=2;$i<34;$i++){
	    $arr_dat=explode('.',$content[$i]['C']);
		$dat=$arr_dat[2].'-'.$arr_dat[0].'-'.$arr_dat[1];
		
		$content[$i]['G'] = round($content[$i]['G']*100,2);
		$content[$i]['I'] = round($content[$i]['I']*100,2);
		$content[$i]['K'] = round($content[$i]['K']*100,2);
		$content[$i]['M'] = round($content[$i]['M']*100,2);
		$content[$i]['P'] = round($content[$i]['P']*100,2);
		$content[$i]['Q'] = round($content[$i]['Q']*100,2);
		
		  $arr = array("client_id"=>$content[$i]['A'],"Subject"=>$content[$i]['B'],"SendDate"=>$dat,"DeliverCount"=>$content[$i]['D'],"Sent"=>$content[$i]['E'],
		          "BounceCount"=>$content[$i]['F'],"BouncePercent"=>$content[$i]['G'],"RemoveCount"=>$content[$i]['H'],"RemovePercent"=>$content[$i]['I'],
				  "OpenCount"=>$content[$i]['J'],"OpenPercent"=>$content[$i]['K'],"ReadCount"=>$content[$i]['L'],"ReadPercent"=>$content[$i]['M'],"ClickCount"=>$content[$i]['N'],"ClickerCount"=>$content[$i]['O'],"ClickerPercent"=>$content[$i]['P'],"Ctor"=>$content[$i]['Q'],"status"=>1 );
		
		 $this->common_model->save('message_activity',$arr);
		  
		}			
//echo "success";
   
    exit;
 
}
	
	
	
  
   private function getLastmonthsVisitDetail($client_id,$type){
	
	   $visitors		=	$this->common_model->get_monthly_visit_data(1,$client_id,$type);
	   
	  return $visitors;
   }
   
   private function getLastmonthsVisitperDay($client_id,$type){
	
	   $visitors_per_day		=	$this->common_model->get_monthly_visit_per_day(1,$client_id,$type);
	   
	 //echo "<pre>"; print_r($months); echo "</pre>"; exit;
	  return $visitors_per_day;
   }
   
   public function get_brand_multilist_select($user_id=''){
     $brand_lists=$this->common_model->get_data('product_brand','id,name',array("status"=>'1'));
	 $brand_arr=array();
	 $selected_brand_lists=$this->common_model->get_data('user_brands','brand_id',array("user_id"=>$user_id));
	 foreach($selected_brand_lists as $selected_brand ){
	    $brand_arr[] = $selected_brand['brand_id'];
	 }
	 $select_box="<select style='width:350px' data-placeholder='Choose Brands...' class='chosen-brand' multiple  name='brand_id[]' ><option value='-1'></option>";
     foreach($brand_lists as $brand){  
	     $selected=(in_array($brand['id'],$brand_arr)) ? "selected" : "";
	     $select_box .="<option ".$selected." value='".$brand['id']."'>".$brand['name']."</option>";
	 }
	$select_box  .="</select>";
	return $select_box;
   
   }
   
    public function get_visitors_referal_details($client_id)	{

	  $clients		=	$this->common_model->get_data('clients','*',array('id'=>$client_id,'status'=>'1'));
	  $month 		= date('M-Y');  
	  for($i=0;$i<count($clients);$i++){	
		  	//$clients[$i]['months']  = $this->get_visitors_list_months(); 
			$clients[$i]['months']  = $this->get_visitors_list_all_months(); 
			$clients[$i]['months_year']  = $this->get_visitors_months_year_list(); 
			$clients[$i]['referals'] 	= $this->getreferals($clients[$i]['id']);
			$clients[$i]['current_year_months'] =  date('m')-1;
		    $clients[$i]['last_year_months']=15-$clients[$i]['current_year_months'];
			
	  }
	 
	  //echo "<pre>"; print_r($clients); echo "</pre>"; exit;
	  $data['clients'] = $clients;
	  //$html	= $this->load->view('mail_details', $data, true);
	  return  $data;
    }	
	
	private function getreferals($client_id){
	
	   $referals		=	$this->common_model->get_referal_data($client_id);
	   $referals =array("Direct","referral","organic");
	   
	 //echo "<pre>"; print_r($months); echo "</pre>"; exit;
	  return $referals;
   }
   
   private function getLastmonthsVisitDetailGraph($client_id,$type){
	
	   $visitors		=	$this->common_model->get_monthly_visit_data_graph(1,$client_id,$type);
	   
	 //echo "<pre>"; print_r($months); echo "</pre>"; exit;
	  return $visitors;
   }	
  
  public function getReferalVisitors($referal,$client_id,$month){
    
	 $referal_visitors = $this->common_model->get_referal_visitors($referal,$client_id,$month);
	 
	 return $referal_visitors;
  
  }
  
  public function get_visitors_browser_details($client_id)	{

	  $clients		=	$this->common_model->get_data('clients','*',array('id'=>$client_id,'status'=>'1'));
	  $month 		= date('M-Y',strtotime("-1 month"));  
	  for($i=0;$i<count($clients);$i++){	
		  	//$clients[$i]['months']  = $this->get_visitors_list_months(); 
			$clients[$i]['months']  = $this->get_visitors_list_all_months(); 
			$clients[$i]['months_year']  = $this->get_visitors_months_year_list(); 
			$clients[$i]['browser_visitors'] 	= $this->getbrowserDetails($clients[$i]['id']);
			$clients[$i]['last_month_browser_visitors'] 	= $this->getbrowserlastmonthDetails($clients[$i]['id'],$month);
			$clients[$i]['current_year_months'] =  date('m')-1;
		    $clients[$i]['last_year_months']=15-$clients[$i]['current_year_months'];
			
	  }
	 
	  //echo "<pre>"; print_r($clients); echo "</pre>"; exit;
	  $data['clients'] = $clients;
	  //$html	= $this->load->view('mail_details', $data, true);
	  return  $data;
    }	
	
	private function getbrowserDetails($client_id){
	
	   $browsers		=	array("Chrome","Firefox","Internet Explorer","Safari");
	   
	 //echo "<pre>"; print_r($months); echo "</pre>"; exit;
	  return $browsers;
   }	
  
  public function getBrowserVisitors($browser,$client_id,$month){
    
	 $browser_visitors = $this->common_model->get_browser_visitors($browser,$client_id,$month);
	 
	 return $browser_visitors;
  
  }
  
   public function getbrowserlastmonthDetails($client_id,$month){
   
    $last_month = $this->common_model->getBrowserlastmonthVisit($client_id,$month);
	
	return $last_month;	  
	  
  }
  
  
  public function get_country_visitors_details($client_id)	{

	  $clients		=	$this->common_model->get_data('clients','*',array('id'=>$client_id,'status'=>'1'));
	  $month 		= date('M-Y');
	  for($i=0;$i<count($clients);$i++){	
		  	//$clients[$i]['months']  = $this->get_visitors_list_months();
			$clients[$i]['months']  = $this->get_visitors_list_all_months();  
			$clients[$i]['months_year']  = $this->get_visitors_months_year_list(13); 
			$clients[$i]['country_visitors'] 	= $this->getcountryvisitDetails($clients[$i]['id']);
			$clients[$i]['last_month_country_visitors'] 	= $this->getcountrylastmonthDetails($clients[$i]['id'],$month);
			$clients[$i]['current_year_months'] =  date('m')-1;
		    $clients[$i]['last_year_months']=14-$clients[$i]['current_year_months'];
	  }
	 
	  //echo "<pre>"; print_r($clients); echo "</pre>"; exit;
	  $data['clients'] = $clients;
	  //$html	= $this->load->view('mail_details', $data, true);
	  return  $data;
    }	
	
  private function getcountryvisitDetails($client_id){	
   
   $country_visitors = $this->common_model->get_data('ga_site_visitors','*',array('ga_event_id'=>'6','client_id'=>$client_id));
   
   return $country_visitors;
   
  }
  
  public function getCountryVisitor($client,$month,$position){
	 
	 $country = $this->common_model->getCountry($client,$month,$position) ;
	  
     return $country;
  
  }
  
  public function getcountrylastmonthDetails($client_id,$month){
   
    $last_month = $this->common_model->getCountrylastmonthVisit($client_id,$month);
	
	return $last_month;	  
	  
  }
  
  public function get_toppage_visitors_details($client_id)	{

	  $clients		=	$this->common_model->get_data('clients','*',array('id'=>$client_id,'status'=>'1'));
	  $month 		= date('M-Y',strtotime("-1 month"));
	  for($i=0;$i<count($clients);$i++){	
		  	//$clients[$i]['months']  = $this->get_visitors_list_months();
			$clients[$i]['months']  = $this->get_visitors_list_all_months();  
			$clients[$i]['months_year']  = $this->get_visitors_months_year_list(13); 
			$clients[$i]['page_visitors'] 	= $this->gettoppagevisitDetails($clients[$i]['id']);
			$clients[$i]['last_month_toppage_visitors'] 	= $this->gettoppagelastmonthDetails($clients[$i]['id'],$month);
			$clients[$i]['current_year_months'] =  date('m')-1;
		    $clients[$i]['last_year_months']=14-$clients[$i]['current_year_months'];
	  }
	 
	  //echo "<pre>"; print_r($clients); echo "</pre>"; exit;
	  $data['clients'] = $clients;
	  //$html	= $this->load->view('mail_details', $data, true);
	  return  $data;
    }	
	
  private function gettoppagevisitDetails($client_id){	
   
   $toppage_visitors = $this->common_model->get_data('ga_site_visitors','*',array('ga_event_id'=>'5','client_id'=>$client_id));
   
   return $toppage_visitors;
   
  }
  
  public function getToppageVisitor($client,$month,$position){
	 
	 
	 $page = $this->common_model->getToppage($client,$month,$position) ;
	  
     return $page;
  
  }
  
  public function gettoppagelastmonthDetails($client_id,$month){
   
    $last_month = $this->common_model->getToppagelastmonthVisit($client_id,$month);
	
	return $last_month;	  
	  
  }
   
 
  public function getSegmentation($segment_id,$client_id,$month){
	  
	  
	  //accessing backup data as open balance till july 31 
	    
	   if($month<='2016-07-31')
	     $email_count		=	$this->common_model->get_backup_segmentation_data($segment_id,$client_id,$month);
	 //echo "<pre>"; print_r($months); echo "</pre>"; exit;
	 
	 else{
	    $email_count = $this->common_model->get_segmentation_data($segment_id,$client_id,$month);
		
		if($email_count==0)
          $email_count		=	$this->common_model->get_backup_segmentation_data($segment_id,$client_id,$month);		 
		
		}
	
		
	  return $email_count;
   }
   
  public function get_site_page_name($page_name,$client_id) {
  
    $page_url = $this->common_model->get_site_page_name($page_name,$client_id);
	return $page_url;
  
  }
  
  
  public function export_report($client_id)
   {
     
		$this->load->library('excel');
		
		// Instantiate a new PHPExcel object
		$objPHPExcel = new PHPExcel(); 
		// Set the active Excel worksheet to sheet 0
		$objPHPExcel->setActiveSheetIndex(0); 
		// Initialise the Excel row number
		$row = 1; 
		// Iterate through each result from the SQL query in turn
		// We fetch each database result row into $row in turn
		$client_name=$this->get_entity_name('clients',$client_id);
		$ews = $objPHPExcel->getSheet(0);
		//$ews->setCellValue('g1', 'Sell in / Sell out Details of '.$retailer_name.' from '.$start_date.' to '.$end_date.'');
		$ews->setCellValueByColumnAndRow(0, $row, ''.$client_name.' Database Performance');
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'background'=>array('color'=>'#000'),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->mergeCells('a'.$row.':m'.$row);
		$ews->getStyle('a'.$row.':m'.$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true);
		
		
		$client_data = $this->common_model->get_data('clients','type,mail_count',array("id"=>$client_id));
		$months = $this->get_mail_list_months();
		$mails 	= $this->getLatmonthsMails($client_id);
		$row=$row+3;
		
		$ews->setCellValueByColumnAndRow(0, $row, 'Database Count as on '.date('Y-m-d').' is '.$client_data[0]['mail_count']);
		$style = array(
		'font' => array('bold' => false, 'size' => 10,),
		'background'=>array('color'=>'#000'),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->mergeCells('a'.$row.':m'.$row);
		$ews->getStyle('a'.$row.':m'.$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true);
        $row=$row+3;
		
		$ews->setCellValueByColumnAndRow(0, $row, 'Mail Listing Count');
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'background'=>array('color'=>'#000'),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->mergeCells('a'.$row.':m'.$row);
		$ews->getStyle('a'.$row.':m'.$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true);
		$row=$row+1;
		
	    if($mails){
			
			$ews->setCellValueByColumnAndRow(0, $row, date('Y')-1);
				
			$prev_month = 12-(date('m')-1);	
			
		   if($prev_month!=0){
			$ews->mergeCells('a'.$row.':'.$this->toAlpha($prev_month).$row);
			$ews->getStyle('a'.$row.':'.$this->toAlpha($prev_month).$row)->applyFromArray($style);
		    $ews->getColumnDimension('a')->setAutoSize(true); 
		   }
			
		   $current_month  = date('m')-1;
		  
		   if($current_month!=0){
			 /* $ews->setCellValueByColumnAndRow(0, $row, date('Y'));
			  $first_column = $this->toAlpha($prev_month+1);
			  $last_column = $this->toAlpha($current_month);
			  $ews->mergeCells(($first_column).$row.':'.$last_column.$row);	*/
			  $ews->setCellValue($this->toAlpha($prev_month+1).$row, date('Y'));
			  $ews->getStyle($this->toAlpha($prev_month+1).$row)->applyFromArray($style);		
			
			}
			
			
			$i=1;
            $row = $row+3;
			foreach($months as $month){	 
			  $style = array(
				'font' => array('bold' => true, 'size' => 12,),
				'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
              );
			  $ews->setCellValue($this->toAlpha($i).$row, $month);
			  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);			  
			  $i++;	
			}
			$row = $row+1;
			$i=1;
			$style = array(
				'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,),
              );
			foreach($mails as $mail){				 
			  $ews->setCellValue($this->toAlpha($i).$row, number_format($mail['value']));
			  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);	
			  $i++;	
			}
		
		}
		
		$row = $row+4;
		$ews->setCellValueByColumnAndRow(0, $row, 'Database Segmentation');
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->mergeCells('a'.$row.':m'.$row);
		$ews->getStyle('a'.$row.':m'.$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true);
		
		$common_segments = $this->common_model->get_data('segments','id,name',array('segment_type'=>'normal','client_id'=>0,'listing'=>1));
		$common_source_segments = $this->common_model->get_data('segments','id,name',array('segment_type'=>'source','client_id'=>0,'listing'=>1));
		$non_hotel_common_source_segments = $this->common_model->get_data('segments','id,name',array('segment_type'=>'source','client_id'=>0,'non_hotel_segment'=>1));
		
	    $segments = $this->common_model->get_data('segments','id,name',array('segment_type'=>'normal','client_id'=>$client_id,'listing'=>1));
	    $res_segments = $this->common_model->get_data('segments','id,name',array('segment_type'=>'restaurant','client_id'=>$client_id,'listing'=>1));
	    $source_segments = $this->common_model->get_data('segments','id,name',array('segment_type'=>'Source','client_id'=>$client_id,'listing'=>1));
	  
	   if($common_segments){
		    $row =$row+1;
		    $ews->setCellValueByColumnAndRow(0, $row, date('Y')-1);
			$style = array(
			'font' => array('bold' => true, 'size' => 13,),
			'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
			);
			
			$prev_month = 12-(date('m')-1);	
			
		   if($prev_month!=0){
			$ews->mergeCells('a'.$row.':'.$this->toAlpha($prev_month+1).$row);
			$ews->getStyle('a'.$row.':'.$this->toAlpha($prev_month).$row)->applyFromArray($style);
		    $ews->getColumnDimension('a')->setAutoSize(true); 
		   }
			
			$current_month  = date('m')-1;	
			if($current_month!=0){
			 /* $ews->setCellValueByColumnAndRow($prev_month+2, $row, date('Y'));
			  $ews->mergeCells(($this->toAlpha($prev_month)+2).$row.':'.$this->toAlpha($current_month).$row);	*/
			  
			  $ews->setCellValue($this->toAlpha($prev_month+2).$row, date('Y'));
			  $ews->getStyle($this->toAlpha($prev_month+2).$row)->applyFromArray($style);		
			
			}
			
			$i=2;
			$row = $row+3;
			$style = array(
		     'font' => array('bold' => true, 'size' => 12,),
		     'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	        );
			$ews->setCellValue('a'.$row, 'Segment');
			$ews->getStyle('a'.$row)->applyFromArray($style);					    
			foreach($months as $month){	 
			  $ews->setCellValue($this->toAlpha($i).$row, $month);
			  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
			  $i++;	
			}
			$style = array(
		     'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,),
	        );
			$row=$row+1;
			foreach($common_segments as $segment){
			  $i=1;
			  $ews->setCellValue($this->toAlpha($i).$row, $segment['name']);		
			  $i++;
			  foreach($months as $dat=>$month){	 				  
				  $segment_value=$this->getSegmentation($segment['id'],$client_id,$dat);
				  $ews->setCellValue($this->toAlpha($i).$row, number_format($segment_value));
				  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
				  $i++;	
			  }
			  
			  $row++;
			  
			}
			
			
			  
		   
		   
	   }
	   
	   $row = $row +2;
	   
	   
	   if($segments){
		    
			$ews->setCellValueByColumnAndRow(0, $row, 'Property Segments');
		    $style = array(
			'font' => array('bold' => true, 'size' => 13,),
			'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
			);
			$ews->mergeCells('a'.$row.':m'.$row);
			$ews->getStyle('a'.$row.':m'.$row)->applyFromArray($style);
			$ews->getColumnDimension('a')->setAutoSize(true);
			$row ++; 
		    $ews->setCellValueByColumnAndRow(0, $row, date('Y')-1);
			$style = array(
			'font' => array('bold' => true, 'size' => 13,),
			'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
			);
			
			$prev_month = 12-(date('m')-1);	
			
		   if($prev_month!=0){
			$ews->mergeCells('a'.$row.':'.$this->toAlpha($prev_month+1).$row);
			$ews->getStyle('a'.$row.':'.$this->toAlpha($prev_month).$row)->applyFromArray($style);
		    $ews->getColumnDimension('a')->setAutoSize(true); 
		   }
			
			$current_month  = date('m')-1;	
			if($current_month!=0){
			 /* $ews->setCellValueByColumnAndRow($prev_month+2, $row, date('Y'));
			  $ews->mergeCells(($this->toAlpha($prev_month)+2).$row.':'.$this->toAlpha($current_month).$row);*/	
			  $ews->setCellValue($this->toAlpha($prev_month+2).$row, date('Y'));
			  $ews->getStyle($this->toAlpha($prev_month+2).$row)->applyFromArray($style);	 
			}
			$i=2;
			$row = $row+3;
			$style = array(
		     'font' => array('bold' => true, 'size' => 12,),
		     'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	        );
			
			$ews->setCellValue('a'.$row, 'Segment');
			$ews->getStyle('a'.$row)->applyFromArray($style);		    
			foreach($months as $month){	 			 
			   $ews->setCellValue($this->toAlpha($i).$row, $month);
			   $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
			  $i++;	
			}
			$style = array(
		     'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,),
	        );
			$row = $row+1;
			foreach($segments as $source_segment){
			  $i=1;		
			  $ews->setCellValue($this->toAlpha($i).$row, $source_segment['name']);
			  $i++;
			  foreach($months as $dat=>$month){	 			 
				  $segment_value=$this->getSegmentation($source_segment['id'],$client_id,$dat);
				  $ews->setCellValue($this->toAlpha($i).$row, number_format($segment_value));
				  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
				  $i++;	
			  }
			  
			  $row++;
			  
			}
	   
	   }
	   
	    $row = $row +2;
	   
	   
	   if($res_segments){
		    
			$ews->setCellValueByColumnAndRow(0, $row, 'Distribution by restaurants');
		    $style = array(
			'font' => array('bold' => true, 'size' => 13,),
			'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
			);
			$ews->mergeCells('a'.$row.':m'.$row);
			$ews->getStyle('a'.$row.':m'.$row)->applyFromArray($style);
			$ews->getColumnDimension('a')->setAutoSize(true);
			$row ++; 
		    $ews->setCellValueByColumnAndRow(0, $row, date('Y')-1);
			$style = array(
			'font' => array('bold' => true, 'size' => 13,),
			'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
			);
			
			$prev_month = 12-(date('m')-1);	
			
		   if($prev_month!=0){
			$ews->mergeCells('a'.$row.':'.$this->toAlpha($prev_month+1).$row);
			$ews->getStyle('a'.$row.':'.$this->toAlpha($prev_month).$row)->applyFromArray($style);
		    $ews->getColumnDimension('a')->setAutoSize(true); 
		   }
			
			$current_month  = date('m')-1;	
			if($current_month!=0){
			 /* $ews->setCellValueByColumnAndRow($prev_month+2, $row, date('Y'));
			  $ews->mergeCells(($this->toAlpha($prev_month)+2).$row.':'.$this->toAlpha($current_month).$row);	*/
			  $ews->setCellValue($this->toAlpha($prev_month+2).$row, date('Y'));
			  $ews->getStyle($this->toAlpha($prev_month+2).$row)->applyFromArray($style);	
			}
			$i=2;
			$row = $row+3;
			$style = array(
		     'font' => array('bold' => true, 'size' => 12,),
		     'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	        );
			$ews->setCellValue('a'.$row, 'Segment');	
			$ews->getStyle('a'.$row)->applyFromArray($style);				    
			foreach($months as $month){	 
			  $ews->setCellValue($this->toAlpha($i).$row, $month);
			  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);			 
			  $i++;	
			}
			$style = array(
		     'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,),
	        );
			$row = $row+1;
			foreach($res_segments as $source_segment){
			  $i=1;		
			  $ews->setCellValue($this->toAlpha($i).$row, $source_segment['name']);
			  $i++;
			 foreach($months as $dat=>$month){	 				 
				  $segment_value=$this->getSegmentation($source_segment['id'],$client_id,$dat);
				  $ews->setCellValue($this->toAlpha($i).$row, number_format($segment_value));
				  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
				  $i++;	
			  }
			  
			  $row++;
			  
			}
	   
	   }
	   
	   $row = $row +2;
	   
	 if($client_data[0]['type']=='hotel'){  
	   if($common_source_segments){
		    
			$ews->setCellValueByColumnAndRow(0, $row, 'Automated Sources');
		    $style = array(
			'font' => array('bold' => true, 'size' => 13,),
			'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
			);
			$ews->mergeCells('a'.$row.':m'.$row);
			$ews->getStyle('a'.$row.':m'.$row)->applyFromArray($style);
			$ews->getColumnDimension('a')->setAutoSize(true);
			$row ++; 
		    $ews->setCellValueByColumnAndRow(0, $row, date('Y')-1);
			$style = array(
			'font' => array('bold' => true, 'size' => 13,),
			'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
			);
			
			$prev_month = 12-(date('m')-1);	
			
		   if($prev_month!=0){
			$ews->mergeCells('a'.$row.':'.$this->toAlpha($prev_month+1).$row);
			$ews->getStyle('a'.$row.':'.$this->toAlpha($prev_month).$row)->applyFromArray($style);
		    $ews->getColumnDimension('a')->setAutoSize(true); 
		   }
			
			$current_month  = date('m')-1;	
			if($current_month!=0){
			/*  $ews->setCellValueByColumnAndRow($prev_month+2, $row, date('Y'));
			  $ews->mergeCells(($this->toAlpha($prev_month)+2).$row.':'.$this->toAlpha($current_month).$row);*/	
			  $ews->setCellValue($this->toAlpha($prev_month+2).$row, date('Y'));
			  $ews->getStyle($this->toAlpha($prev_month+2).$row)->applyFromArray($style);	
			}
			$i=2;
			$row = $row+3;
			$style = array(
		     'font' => array('bold' => true, 'size' => 12,),
		     'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	        );
			$ews->setCellValue('a'.$row, 'Segment');		
			$ews->getStyle('a'.$row)->applyFromArray($style);			    
			foreach($months as $month){	 
			  $ews->setCellValue($this->toAlpha($i).$row, $month);
			  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);			 
			  $i++;	
			}
			$style = array(
		     'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,),
	        );
			$row = $row+1;
			foreach($common_source_segments as $source_segment){
			  $i=1;		
			  $ews->setCellValue($this->toAlpha($i).$row, $source_segment['name']);
			  $i++;
			  foreach($months as $dat=>$month){	
				  $segment_value=$this->getSegmentation($source_segment['id'],$client_id,$dat);
				  $ews->setCellValue($this->toAlpha($i).$row, number_format($segment_value));
				  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
				  $i++;	
			  }
			  
			  $row++;
			  
			}
	   
	   }
	   
	    $row = $row +2;
	 }
	 
	 if($client_data[0]['type']=='non-hotel'){
	   
	   if($non_hotel_common_source_segments){
		    
			$ews->setCellValueByColumnAndRow(0, $row, 'Automated Sources');
		    $style = array(
			'font' => array('bold' => true, 'size' => 13,),
			'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
			);
			$ews->mergeCells('a'.$row.':m'.$row);
			$ews->getStyle('a'.$row.':m'.$row)->applyFromArray($style);
			$ews->getColumnDimension('a')->setAutoSize(true);
			$row ++; 
		    $ews->setCellValueByColumnAndRow(0, $row, date('Y')-1);
			$style = array(
			'font' => array('bold' => true, 'size' => 13,),
			'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
			);
			
			$prev_month = 12-(date('m')-1);	
			
		   if($prev_month!=0){
			$ews->mergeCells('a'.$row.':'.$this->toAlpha($prev_month+1).$row);
			$ews->getStyle('a'.$row.':'.$this->toAlpha($prev_month).$row)->applyFromArray($style);
		    $ews->getColumnDimension('a')->setAutoSize(true); 
		   }
			
			$current_month  = date('m')-1;	
			if($current_month!=0){
			/*  $ews->setCellValueByColumnAndRow($prev_month+2, $row, date('Y'));
			  $ews->mergeCells(($this->toAlpha($prev_month)+2).$row.':'.$this->toAlpha($current_month).$row);	*/
			  $ews->setCellValue($this->toAlpha($prev_month+2).$row, date('Y'));
			  $ews->getStyle($this->toAlpha($prev_month+2).$row)->applyFromArray($style);	
			}
			$i=2;
			$row = $row+3;
			$style = array(
		     'font' => array('bold' => true, 'size' => 12,),
		     'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	        );
			$ews->setCellValue('a'.$row, 'Segment');		
			$ews->getStyle('a'.$row)->applyFromArray($style);			    
			foreach($months as $month){	 
			  $ews->setCellValue($this->toAlpha($i).$row, $month);
			  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);			
			  $i++;	
			}
			$style = array(
		     'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,),
	        );
			$row = $row+1;
			foreach($non_hotel_common_source_segments as $source_segment){
			  $i=1;		
			  $ews->setCellValue($this->toAlpha($i).$row, $source_segment['name']);
			  $i++;
			 foreach($months as $dat=>$month){		 
				
				  $segment_value=$this->getSegmentation($source_segment['id'],$client_id,$dat);
				  $ews->setCellValue($this->toAlpha($i).$row, number_format($segment_value));
				  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
				  $i++;	
			  }
			  
			  $row++;
			  
			}
	   
	   }
	   
	      $row = $row +2;
	   
	 }
	   
	   if($source_segments){
		    
			$ews->setCellValueByColumnAndRow(0, $row, 'Property Sources');
		    $style = array(
			'font' => array('bold' => true, 'size' => 13,),
			'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
			);
			$ews->mergeCells('a'.$row.':m'.$row);
			$ews->getStyle('a'.$row.':m'.$row)->applyFromArray($style);
			$ews->getColumnDimension('a')->setAutoSize(true);
			$row ++; 
		    $ews->setCellValueByColumnAndRow(0, $row, date('Y')-1);
			$style = array(
			'font' => array('bold' => true, 'size' => 13,),
			'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
			);
			
			$prev_month = 12-(date('m')-1);	
			
		   if($prev_month!=0){
			$ews->mergeCells('a'.$row.':'.$this->toAlpha($prev_month+1).$row);
			$ews->getStyle('a'.$row.':'.$this->toAlpha($prev_month).$row)->applyFromArray($style);
		    $ews->getColumnDimension('a')->setAutoSize(true); 
		   }
			
			$current_month  = date('m')-1;	
			if($current_month!=0){
			 /* $ews->setCellValueByColumnAndRow($prev_month+2, $row, date('Y'));
			  $ews->mergeCells(($this->toAlpha($prev_month)+2).$row.':'.$this->toAlpha($current_month).$row);	*/
			  $ews->setCellValue($this->toAlpha($prev_month+2).$row, date('Y'));
			  $ews->getStyle($this->toAlpha($prev_month+2).$row)->applyFromArray($style);	
			}
			$i=2;
			$row = $row+3;
			$style = array(
		     'font' => array('bold' => true, 'size' => 12,),
		     'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	        );
			$ews->setCellValue('a'.$row, 'Segment');		    
			$ews->getStyle('a'.$row)->applyFromArray($style);			
			foreach($months as $month){	
			  $ews->setCellValue($this->toAlpha($i).$row, $month); 
			  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);			 
			  $i++;	
			}
			$style = array(
		     'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,),
	        );
			$row = $row+1;
			foreach($source_segments as $source_segment){
			  $i=1;		
			  $ews->setCellValue($this->toAlpha($i).$row, $source_segment['name']);
			  $i++;
			  foreach($months as $dat=>$month){	 
				 
				  $segment_value=$this->getSegmentation($source_segment['id'],$client_id,$dat);
				  $ews->setCellValue($this->toAlpha($i).$row, number_format($segment_value));
				  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
				  $i++;	
			  }
			  
			  $row++;
			  
			}
	   
	   }
	   
	   	
		
       $file_name=$client_name.'Report.xlsx';
     
		// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
	   $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		// Write the Excel file to filename some_excel_file.xlsx in the current directory
		//$objWriter->save('some_excel_file.xlsx');
		// We'll be outputting an excel file
	   header('Content-type: application/vnd.ms-excel');
		
		// It will be called file.xls
	   header('Content-Disposition: attachment; filename="'.$file_name.'"');
		
		// Write file to the browser
	   $objWriter->save('php://output'); 

   
   }
   
   public function export_message_activity_report($client_id,$start_date,$end_date)
   {
     
		$this->load->library('excel');
		
		// Instantiate a new PHPExcel object
		$objPHPExcel = new PHPExcel(); 
		// Set the active Excel worksheet to sheet 0
		$objPHPExcel->setActiveSheetIndex(0); 
		// Initialise the Excel row number
		$row = 1; 
		// Iterate through each result from the SQL query in turn
		// We fetch each database result row into $row in turn
		$client_name=$this->get_entity_name('clients',$client_id);
		$ews = $objPHPExcel->getSheet(0);
		//$ews->setCellValue('g1', 'Sell in / Sell out Details of '.$retailer_name.' from '.$start_date.' to '.$end_date.'');
		$ews->setCellValueByColumnAndRow(0, 1, ''.$client_name.' Message Activity From '.$start_date.' to '.$end_date);
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->mergeCells('a'.$row.':p'.$row);
		$ews->getStyle('a'.$row.':p'.$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true);
		
		$row = $row+2;
		
		$ews->setCellValue('a'.$row, 'Subject');
		$ews->setCellValue('b'.$row, 'SendDate');
		$ews->setCellValue('c'.$row, 'Sent');
		$ews->setCellValue('d'.$row, 'Delivered');
		$ews->setCellValue('e'.$row, 'Bounces');
		$ews->setCellValue('f'.$row, 'Bounces(%)');
		$ews->setCellValue('g'.$row, 'Removals');
		$ews->setCellValue('h'.$row, 'Removals(%)');
		$ews->setCellValue('i'.$row, 'Opens');
		$ews->setCellValue('j'.$row, 'Opens(%)');
		$ews->setCellValue('k'.$row, 'Reads');
		$ews->setCellValue('l'.$row, 'Reads(%)');
		$ews->setCellValue('m'.$row, 'Clicks');
		$ews->setCellValue('n'.$row, 'Unique Clickers');
		$ews->setCellValue('o'.$row, 'Unique Clickers(%)');
		$ews->setCellValue('p'.$row, 'CTOR');		
		$style = array(
		'font' => array('bold' => true, 'size' => 11,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	);
		$ews->getStyle('a'.$row)->applyFromArray($style);
		$ews->getStyle('b'.$row)->applyFromArray($style);
		$ews->getStyle('c'.$row)->applyFromArray($style);
		$ews->getStyle('d'.$row)->applyFromArray($style);
		$ews->getStyle('e'.$row)->applyFromArray($style);
		$ews->getStyle('f'.$row)->applyFromArray($style);
		$ews->getStyle('g'.$row)->applyFromArray($style);
		$ews->getStyle('h'.$row)->applyFromArray($style);
		$ews->getStyle('i'.$row)->applyFromArray($style);
		$ews->getStyle('j'.$row)->applyFromArray($style);
		$ews->getStyle('k'.$row)->applyFromArray($style);
		$ews->getStyle('l'.$row)->applyFromArray($style);
		$ews->getStyle('m'.$row)->applyFromArray($style);
		$ews->getStyle('n'.$row)->applyFromArray($style);
		$ews->getStyle('o'.$row)->applyFromArray($style);
		$ews->getStyle('p'.$row)->applyFromArray($style);
		
		$client = $this->common_model->get_data('clients','*',array('id'=>$client_id));
		$message_details = $this->common_model->get_message_details($client[0],$start_date,$end_date);
		$row++; 
	    foreach($message_details as $msg_det){
		  
		    $ews->setCellValue('a'.$row,$msg_det['Subject']);
		    $ews->setCellValue('b'.$row, date('Y-m-d',strtotime($msg_det['SendDate'])));	
			$ews->setCellValue('c'.$row, $msg_det['Sent']);
			$ews->setCellValue('d'.$row, $msg_det['DeliverCount']);
			$ews->setCellValue('e'.$row, $msg_det['BounceCount']);
			$ews->setCellValue('f'.$row, (round($msg_det['BouncePercent'],2)).'%');
			$ews->setCellValue('g'.$row, $msg_det['RemoveCount']);
			$ews->setCellValue('h'.$row, (round($msg_det['RemovePercent'],2)).'%');
			$ews->setCellValue('i'.$row, $msg_det['OpenCount']);
			$ews->setCellValue('j'.$row, (round($msg_det['OpenPercent'],2)).'%');
			$ews->setCellValue('k'.$row, $msg_det['ReadCount']);
			$ews->setCellValue('l'.$row, (round($msg_det['ReadPercent'],2)).'%');
			$ews->setCellValue('m'.$row, $msg_det['ClickCount']);
			$ews->setCellValue('n'.$row, $msg_det['ClickerCount']);
			$ews->setCellValue('o'.$row, (round($msg_det['ClickerPercent'],2)).'%');
			$ews->setCellValue('p'.$row, $msg_det['Ctor'].'%');
            $row++;  
	   }
		
		$file_name=$client_name.'Message Activity.xlsx';
		
		// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		// Write the Excel file to filename some_excel_file.xlsx in the current directory
		//$objWriter->save('some_excel_file.xlsx');
		// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');
		
		// It will be called file.xls
		header('Content-Disposition: attachment; filename="'.$file_name.'"');
		
		// Write file to the browser
		$objWriter->save('php://output'); 

   
   }
   
  public function export_ga_report($client_id)
   {
     
		$this->load->library('excel');
		
		// Instantiate a new PHPExcel object
		$objPHPExcel = new PHPExcel(); 
		// Set the active Excel worksheet to sheet 0
		$objPHPExcel->setActiveSheetIndex(0); 
		// Initialise the Excel row number
		$row = 1; 
		// Iterate through each result from the SQL query in turn
		// We fetch each database result row into $row in turn
		$client_name=$this->get_entity_name('clients',$client_id);
		$ews = $objPHPExcel->getSheet(0);
		//$ews->setCellValue('g1', 'Sell in / Sell out Details of '.$retailer_name.' from '.$start_date.' to '.$end_date.'');
		$ews->setCellValueByColumnAndRow(0, $row, ''.$client_name.' Website Performance');
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->mergeCells('a'.$row.':m'.$row);
		$ews->getStyle('a'.$row.':m'.$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true);
		
		
		$client_data = $this->common_model->get_data('clients','type',array("id"=>$client_id));
		$months = $this->get_mail_list_months();
		$mails 	= $this->getLatmonthsMails($client_id);
        $row=$row+3;
		
		$ews->setCellValueByColumnAndRow(0, $row, 'Visitors Summary');
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->mergeCells('a'.$row.':m'.$row);
		$ews->getStyle('a'.$row.':m'.$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true);
		$row=$row+1;
	    
		$visitors 	= $this->getLastmonthsVisitDetail($client_id,'visits');
		$visitors_per_day 	= $this->getLastmonthsVisitperDay($client_id,'visits');
		$page_views 	= $this->getLastmonthsVisitDetail($client_id,'pageviews');
		$newVisit 	= $this->getLastmonthsVisitDetail($client_id,'percentNewVisits');
		
		$row =$row+1;
		$ews->setCellValueByColumnAndRow(0, $row, date('Y')-1);
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		
		$prev_month = 12-(date('m')-1);	
		
	   if($prev_month!=0){
		$ews->mergeCells('a'.$row.':'.$this->toAlpha($prev_month+1).$row);
		$ews->getStyle('a'.$row.':'.$this->toAlpha($prev_month).$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true); 
	   }
		
		$current_month  = date('m')-1;	
		if($current_month!=0){
		 /* $ews->setCellValueByColumnAndRow($prev_month+2, $row, date('Y'));
		  $ews->mergeCells(($this->toAlpha($prev_month)+2).$row.':'.$this->toAlpha($current_month).$row);	*/
		  $ews->setCellValue($this->toAlpha($prev_month+2).$row, date('Y'));
		  $ews->getStyle($this->toAlpha($prev_month+2).$row)->applyFromArray($style);	
		
		}
		$i=2;
		$row = $row+3;
		$style = array(
		 'font' => array('bold' => true, 'size' => 12,),
		 'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->setCellValue('a'.$row, 'WEBSITE BASIC STATS');
		$ews->getStyle('a'.$row)->applyFromArray($style);					    
		foreach($months as $month){	 
		  $ews->setCellValue($this->toAlpha($i).$row, $month);
		  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
		  $i++;	
		}
		$ews->setCellValue($this->toAlpha($i).$row, 'This month till today');
		$ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
		$i++;	
		$style = array(
		 'font' => array('bold' => false, 'size' => 10,),
		);
		
		if($visitors){
			$row=$row+1;
			$i=1;
			$ews->setCellValue($this->toAlpha($i).$row,'Visitors');	
			$ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
			$i++;
			$style = array(
		 'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,),
		);
			foreach($visitors as $vist){
				  $ews->setCellValue($this->toAlpha($i).$row, number_format($vist->value));
				  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
				  $i++;	
			}
		}
		if($visitors_per_day){
			$row=$row+1;
			$i=1;
			$ews->setCellValue($this->toAlpha($i).$row,'Visitors per day');	
			$i++;
			foreach($visitors_per_day as $vist){
				  $ews->setCellValue($this->toAlpha($i).$row, number_format($vist->value));
				  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
				  $i++;	
			}
		}
		if($page_views){
			$row=$row+1;
			$i=1;
			$ews->setCellValue($this->toAlpha($i).$row,'Page Views');	
			$i++;
			foreach($page_views as $vist){
				  $ews->setCellValue($this->toAlpha($i).$row, number_format($vist->value));
				  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
				  $i++;	
			}
		}
		if($newVisit){
			$row=$row+1;
			$i=1;
			$ews->setCellValue($this->toAlpha($i).$row,'New Visitors(%)');	
			$i++;
			foreach($newVisit as $vist){
				  $ews->setCellValue($this->toAlpha($i).$row, intval($vist->value));
				  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
				  $i++;	
			}
		}
			
		
		$row=$row+3;
		
		$ews->setCellValueByColumnAndRow(0, $row, 'Acquisition Share');
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->mergeCells('a'.$row.':m'.$row);
		$ews->getStyle('a'.$row.':m'.$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true);
		$row=$row+2;
	  
		
		$ews->setCellValueByColumnAndRow(0, $row, date('Y')-1);
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		
		$prev_month = 12-(date('m')-1);	
		
	   if($prev_month!=0){
		$ews->mergeCells('a'.$row.':'.$this->toAlpha($prev_month+1).$row);
		$ews->getStyle('a'.$row.':'.$this->toAlpha($prev_month).$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true); 
	   }
		
		$current_month  = date('m')-1;	
		if($current_month!=0){
		/*  $ews->setCellValueByColumnAndRow($prev_month+2, $row, date('Y'));
		  $ews->mergeCells(($this->toAlpha($prev_month)+2).$row.':'.$this->toAlpha($current_month).$row);	*/
		  $ews->setCellValue($this->toAlpha($prev_month+2).$row, date('Y'));
		  $ews->getStyle($this->toAlpha($prev_month+2).$row)->applyFromArray($style);	
		
		}
		$i=2;
		$row = $row+3;
		$style = array(
		 'font' => array('bold' => true, 'size' => 12,),
		 'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->setCellValue('a'.$row, 'Acquisition');
		$ews->getStyle('a'.$row)->applyFromArray($style);					    
		foreach($months as $month){	 
		  $ews->setCellValue($this->toAlpha($i).$row, $month);
		  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
		  $i++;	
		}
		$style = array(
		 'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,),
		);
			
		$referals 	= $this->getreferals($client_id);	  
		
		$row = $row+1;
		foreach($referals as $refer){
		  $i=1;		
		  $ews->setCellValue($this->toAlpha($i).$row, ucfirst($refer));
		  $i++;
		  foreach($months as $dat=>$month){	 
			 
			  $referal_visitors =  $this->getReferalVisitors($refer,$client_id,$dat);
			  if($referal_visitors){
				  foreach($referal_visitors as $refers ){
					  $ews->setCellValue($this->toAlpha($i).$row, number_format($refers->percent,2).'%');
					  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
					  
				  }
				  
			  }
			  else{
			         $ews->setCellValue($this->toAlpha($i).$row, 0);
					  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);	  
			  }
			  
			  $i++;
		  }
		  
		  $row++;
		  
		} 
		
		$row=$row+3;
		
		$ews->setCellValueByColumnAndRow(0, $row, 'Browsers');
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->mergeCells('a'.$row.':m'.$row);
		$ews->getStyle('a'.$row.':m'.$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true);
		$row=$row+2;
	  
		
		$ews->setCellValueByColumnAndRow(0, $row, date('Y')-1);
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		
		$prev_month = 12-(date('m')-1);	
		
	   if($prev_month!=0){
		$ews->mergeCells('a'.$row.':'.$this->toAlpha($prev_month+1).$row);
		$ews->getStyle('a'.$row.':'.$this->toAlpha($prev_month).$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true); 
	   }
		
		$current_month  = date('m')-1;	
		if($current_month!=0){
		 /* $ews->setCellValueByColumnAndRow($prev_month+2, $row, date('Y'));
		  $ews->mergeCells(($this->toAlpha($prev_month)+2).$row.':'.$this->toAlpha($current_month).$row);	*/
		  $ews->setCellValue($this->toAlpha($prev_month+2).$row, date('Y'));
		  $ews->getStyle($this->toAlpha($prev_month+2).$row)->applyFromArray($style);	
		
		}
		$i=2;
		$row = $row+3;
		$style = array(
		 'font' => array('bold' => true, 'size' => 12,),
		 'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->setCellValue('a'.$row, 'Browser');
		$ews->getStyle('a'.$row)->applyFromArray($style);					    
		foreach($months as $month){	 
		  $ews->setCellValue($this->toAlpha($i).$row, $month);
		  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
		  $i++;	
		}
		$style = array(
		 'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,),
		);
			
		$browser_visitors 	= $this->getbrowserDetails($client_id);
		$row = $row+1;
		foreach($browser_visitors as $browser){
		  $i=1;		
		  $ews->setCellValue($this->toAlpha($i).$row, ucfirst($browser));
		  $i++;
		  foreach($months as $dat=>$month){	 
			 
			  $browser_visits =  $this->getBrowserVisitors($browser,$client_id,$dat);
			  if($browser_visits){
				  foreach($browser_visits as $browse ){
					  $ews->setCellValue($this->toAlpha($i).$row, number_format($browse->percent,2).'%');
					  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
					  
				  }
				  
			  }
			  else{
			         $ews->setCellValue($this->toAlpha($i).$row, 0);
					  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);	  
			  }
			  
			  $i++;
		  }
		  
		  $row++;
		  
		}     
	    
		
		$row=$row+3;
		
		$ews->setCellValueByColumnAndRow(0, $row, 'Top Countries');
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->mergeCells('a'.$row.':m'.$row);
		$ews->getStyle('a'.$row.':m'.$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true);
		$row=$row+2;
	  
		
		$ews->setCellValueByColumnAndRow(0, $row, date('Y')-1);
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		
		$prev_month = 12-(date('m')-1);	
		
	   if($prev_month!=0){
		$ews->mergeCells('a'.$row.':'.$this->toAlpha($prev_month+1).$row);
		$ews->getStyle('a'.$row.':'.$this->toAlpha($prev_month).$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true); 
	   }
		
		$current_month  = date('m')-1;	
		if($current_month!=0){
		  /*$ews->setCellValueByColumnAndRow($prev_month+2, $row, date('Y'));
		  $ews->mergeCells(($this->toAlpha($prev_month)+2).$row.':'.$this->toAlpha($current_month).$row);	*/
		  $ews->setCellValue($this->toAlpha($prev_month+2).$row, date('Y'));
		  $ews->getStyle($this->toAlpha($prev_month+2).$row)->applyFromArray($style);	
		
		}
		$i=2;
		$row = $row+3;
		$style = array(
		 'font' => array('bold' => true, 'size' => 12,),
		 'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->setCellValue('a'.$row, 'Position');
		$ews->getStyle('a'.$row)->applyFromArray($style);					    
		foreach($months as $month){	 
		  $ews->setCellValue($this->toAlpha($i).$row, $month);
		  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
		  $i++;	
		}
		$style = array(
		 'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),
		);
			
		$row = $row+1;
		for($pos=0;$pos<6;$pos++){ 
		  $i=1;		
		  $ews->setCellValue($this->toAlpha($i).$row, $pos+1);
		  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
		  $i++;
		  foreach($months as $dat=>$month){	 
			 
			  $country=$this->getCountryVisitor($client_id,$dat,$pos);
			  $ews->setCellValue($this->toAlpha($i).$row, $country);
			  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
			  $i++;
		  }
		  
		  $row++;
		  
		} 
		
		
		$row=$row+3;
		
		$ews->setCellValueByColumnAndRow(0, $row, 'Top Pages');
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->mergeCells('a'.$row.':m'.$row);
		$ews->getStyle('a'.$row.':m'.$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true);
		$row=$row+2;
	  
		
		$ews->setCellValueByColumnAndRow(0, $row, date('Y')-1);
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		
		$prev_month = 12-(date('m')-1);	
		
	   if($prev_month!=0){
		$ews->mergeCells('a'.$row.':'.$this->toAlpha($prev_month+1).$row);
		$ews->getStyle('a'.$row.':'.$this->toAlpha($prev_month).$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true); 
	   }
		
		$current_month  = date('m')-1;	
		if($current_month!=0){
		/*  $ews->setCellValueByColumnAndRow($prev_month+2, $row, date('Y'));
		  $ews->mergeCells(($this->toAlpha($prev_month)+2).$row.':'.$this->toAlpha($current_month).$row);	*/
		  $ews->setCellValue($this->toAlpha($prev_month+2).$row, date('Y'));
		  $ews->getStyle($this->toAlpha($prev_month+2).$row)->applyFromArray($style);	
		
		}
		$i=2;
		$row = $row+3;
		$style = array(
		 'font' => array('bold' => true, 'size' => 12,),
		 'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->setCellValue('a'.$row, 'Page Ranking');
		$ews->getStyle('a'.$row)->applyFromArray($style);					    
		foreach($months as $month){	 
		  $ews->setCellValue($this->toAlpha($i).$row, $month);
		  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
		  $i++;	
		}
		$style = array(
		 'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),
		);
			
		$row = $row+1;
		for($pos=0;$pos<6;$pos++){ 
		  $i=1;		
		  $ews->setCellValue($this->toAlpha($i).$row, $pos+1);
		  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
		  $i++;
		  foreach($months as $dat=>$month){	 
			 
			  $toppage=$this->getToppageVisitor($client_id,$dat,$pos);
			  $toppage_name= $this->get_site_page_name($toppage,$client_id);
			  $ews->setCellValue($this->toAlpha($i).$row, $toppage_name);
			  $ews->getStyle($this->toAlpha($i).$row)->applyFromArray($style);
			  $i++;
		  }
		  
		  $row++;
		  
		}         
	
        $file_name=$client_name.'GA-Report.xlsx';
     
		// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
	    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		// Write the Excel file to filename some_excel_file.xlsx in the current directory
		//$objWriter->save('some_excel_file.xlsx');
		// We'll be outputting an excel file
	    header('Content-type: application/vnd.ms-excel');
		
		// It will be called file.xls
	    header('Content-Disposition: attachment; filename="'.$file_name.'"');
		
		// Write file to the browser
	    $objWriter->save('php://output'); 

   
   } 
  
  public function export_message_click($message_id,$client_id)
   {
     
		$this->load->library('excel');
		
		// Instantiate a new PHPExcel object
		$objPHPExcel = new PHPExcel(); 
		// Set the active Excel worksheet to sheet 0
		$objPHPExcel->setActiveSheetIndex(0); 
		// Initialise the Excel row number
		$row = 1; 
		// Iterate through each result from the SQL query in turn
		// We fetch each database result row into $row in turn
		$client_name=$this->get_entity_name('clients',$client_id);
		$ews = $objPHPExcel->getSheet(0);
		//$ews->setCellValue('g1', 'Sell in / Sell out Details of '.$retailer_name.' from '.$start_date.' to '.$end_date.'');
		$ews->setCellValueByColumnAndRow(0, 1, 'Link click details');
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->mergeCells('a'.$row.':p'.$row);
		$ews->getStyle('a'.$row.':p'.$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true);
		
		$row = $row+2;
		
		$ews->setCellValue('a'.$row, 'Link Url');
		$ews->setCellValue('b'.$row, 'LinkType');
		$ews->setCellValue('c'.$row, 'ClickCount');
		$ews->setCellValue('d'.$row, 'ClickerCount');
		$ews->setCellValue('e'.$row, 'ClickPercent');
		
		$style = array(
		'font' => array('bold' => true, 'size' => 11,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	);
		$ews->getStyle('a'.$row)->applyFromArray($style);
		$ews->getStyle('b'.$row)->applyFromArray($style);
		$ews->getStyle('c'.$row)->applyFromArray($style);
		$ews->getStyle('d'.$row)->applyFromArray($style);
		$ews->getStyle('e'.$row)->applyFromArray($style);
		
		$client = $this->common_model->get_data('clients','*',array('id'=>$client_id));
        $messageClickdetails = $this->common_model->ReportMessageLinkClickDetails($client[0],$message_id);
		$row++; 
	    foreach($messageClickdetails as $msg_det){
		  
		    $ews->setCellValue('a'.$row,$msg_det['LinkURL']);
		    $ews->setCellValue('b'.$row, $msg_det['LinkType']);	
			$ews->setCellValue('c'.$row, $msg_det['ClickCount']);
			$ews->setCellValue('d'.$row, $msg_det['ClickerCount']);
			$ews->setCellValue('e'.$row, (round($msg_det['ClickPercent']*100,2)).'%');
            $row++;  
	   }
		
		$file_name='Message Click Details.xlsx';
		
		// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		// Write the Excel file to filename some_excel_file.xlsx in the current directory
		//$objWriter->save('some_excel_file.xlsx');
		// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');
		
		// It will be called file.xls
		header('Content-Disposition: attachment; filename="'.$file_name.'"');
		
		// Write file to the browser
		$objWriter->save('php://output'); 

   
   } 
  
  public function export_tablet_feedback_report($client_id,$start_date='',$end_date='')
   {
     
		$this->load->library('excel');
		
		// Instantiate a new PHPExcel object
		$objPHPExcel = new PHPExcel(); 
		// Set the active Excel worksheet to sheet 0
		$objPHPExcel->setActiveSheetIndex(0); 
		// Initialise the Excel row number
		$row = 1; 
		// Iterate through each result from the SQL query in turn
		// We fetch each database result row into $row in turn
		$client_name=$this->get_entity_name('clients',$client_id);
		$ews = $objPHPExcel->getSheet(0);
		//$ews->setCellValue('g1', 'Sell in / Sell out Details of '.$retailer_name.' from '.$start_date.' to '.$end_date.'');
		$ews->setCellValueByColumnAndRow(0, 1, ''.$client_name.' Tablet Feedback Details ');
		$style = array(
		'font' => array('bold' => true, 'size' => 13,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
		);
		$ews->mergeCells('a'.$row.':p'.$row);
		$ews->getStyle('a'.$row.':p'.$row)->applyFromArray($style);
		$ews->getColumnDimension('a')->setAutoSize(true);
		
		$row = $row+2;
		
		$tablet_feedback_active_fields = $this->common_model->feedback_active_fields($client_id);
		

		$i=0;
		if($tablet_feedback_active_fields){
		 
		 foreach($tablet_feedback_active_fields as $field){
			
		  $ews->setCellValue($this->getNameFromNumber($i).$row, html_entity_decode($field->title));
		  $style = array(
		'font' => array('bold' => true, 'size' => 11,),
		'alignment' => array('horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
	);
		 $ews->getStyle($this->getNameFromNumber($i).$row)->applyFromArray($style);
		
	    $i++;
		}
	}
		
		$row++; 
		if($start_date=='')
		  $tablet_feedback_data = $this->common_model->get_data('tablet_feedback_details','*',array("client_id"=>$client_id,"received_date>="=>'2017-01-01'),'received_date DESC');
		else
		  $tablet_feedback_data = $this->common_model->get_data('tablet_feedback_details','*',array("client_id"=>$client_id,"received_date>="=>$start_date,"received_date<="=>$end_date),'received_date ASC');
		 $i=0;   
	    foreach($tablet_feedback_data as $feedback_data){
		   
		   foreach($tablet_feedback_active_fields as $field){
		  
		    $ews->setCellValue($this->getNameFromNumber($i).$row,$feedback_data[$field->field_name]);
		    $i++;
		   }
		    
			$i=0;
            $row++;  
	   }
		
		$file_name=$client_name.'Feedback Data.xlsx';
		
		// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		// Write the Excel file to filename some_excel_file.xlsx in the current directory
		//$objWriter->save('some_excel_file.xlsx');
		// We'll be outputting an excel file
		header('Content-type: application/vnd.ms-excel');
		
		// It will be called file.xls
		header('Content-Disposition: attachment; filename="'.$file_name.'"');
		
		// Write file to the browser
		$objWriter->save('php://output'); 

   
   } 
  
  public function getSiteVisitorData($client_id,$entity_id,$entity_name,$month) {
	 
	 $visitors_data = $this->common_model->get_data('ga_site_visitors','visitors_count',
	                    array("client_id"=>$client_id,"ga_event_id"=>$entity_id,"ga_event_entity_name"=>$entity_name,"date"=>$month)) ; 
	 
	 if($visitors_data)	 					
	  
	  return $visitors_data[0]['visitors_count'];
	
	else
	
	  return 0;   					
  
  
  }
  
  
  
  
  public function getEmailCount($client_id,$start_date,$end_date) {
	 
	 $email_count = $this->common_model->get_mail_count_month_data($client_id,$start_date,$end_date);		
  
     return $email_count;
  }

  public function get_months_list() {
	  
	 $current_total_months = date('m')-1;	  
     $total_months_last_year=19-$current_total_months;	 
	 $year=date('Y')-1;
	 $month_arr=array();
	 $start_month=(12-$total_months_last_year)+1;
	 $total_months=12;
	 for($month_count=$start_month;$month_count<=$total_months;$month_count++){		  
		 
		$month_name=date('M',strtotime("01-".$month_count."-".$year));		 
		$month_arr[]=$month_name;		  
		 
		if($month_count==12){
		 
		   $month_count =0;
		   $total_months = date('m')-1;
		   $year = $year+1;
		   
		}
	 }			  
   
    return $month_arr;
  
  }
  
  public function get_months_array_list() {
	  
	 $current_total_months = date('m')-1;	  
     $total_months_last_year=19-$current_total_months;	 
	 $year=date('Y')-1;
	 $month_arr=array();
	 $start_month=(12-$total_months_last_year)+1;
	 $total_months=12;
	 for($month_count=$start_month;$month_count<=$total_months;$month_count++){		  
		 
		$month_name=date('M',strtotime("01-".$month_count."-".$year));
		
		$start_date = date('Y-m-d',strtotime("01-".$month_count."-".$year));
				 
		$month_arr[$start_date]=$month_name;		  
		 
		if($month_count==12){
		 
		   $month_count =0;
		   $total_months = date('m')-1;
		   $year = $year+1;
		   
		}
	 }			  
   
    return $month_arr;
  
  }
  
  
  public function get_visitors_months_list($count=14) {
	  	  
     $current_total_months = date('m')-1;	  
     $total_months_last_year=$count-$current_total_months;	 
	 $year=date('Y')-1;
	 $month_arr=array();
	 $start_month=(12-$total_months_last_year)+1;
	 $total_months=12;
	 	 
	 for($month_count=$start_month;$month_count<=$total_months;$month_count++){		  
		 
		$month_name=date('M',strtotime("01-".$month_count."-".$year));		 
		$month_arr[]=$month_name;		  
		 
		if($month_count==12){
		 
		   $month_count =0;
		   $total_months = date('m')-1;
		   $year = $year+1;
		   
		}
	 }			  
   
    return $month_arr;
  
  }
  
  
 /* public function get_mail_list_months() {
	  	  
     $current_total_months = date('m')-1;
	 $prev_year = date('Y')-1;
	 $start_date= $prev_year."-01-01"; 
	 $month_arr[$start_date]=date('M',strtotime("01-01-".$prev_year));
	 $year = date('Y');	 
	 for($month_count=1;$month_count<=$current_total_months;$month_count++){		  
		 
		$month_name=date('M',strtotime("01-".$month_count."-".$year));		 
		$start_date = date('Y-m-d',strtotime("01-".$month_count."-".$year));				 
		$month_arr[$start_date]=$month_name;			  
	 }			  
    return $month_arr;
  
  }*/
  
   /*public function get_mail_list_months() {
	  	  
     $current_total_months = date('m')-1;
	 $current_total_months = ($current_total_months==0) ? 12 :$current_total_months;
	 $month_diff = 12-$current_total_months;
	 $year = date('Y')-1;
	 for($month_count=$month_diff+1;$month_count<=$current_total_months;$month_count++){		  
		 
		$month_name=date('M',strtotime("01-".$month_count."-".$year));		 
		$start_date = date('Y-m-d',strtotime("01-".$month_count."-".$year));				 
		$month_arr[$start_date]=$month_name;			  
	 }
	  $year = date('Y');
	 for($month_count=1;$month_count<=$month_diff;$month_count++){		  
		 
		$month_name=date('M',strtotime("01-".$month_count."-".$year));		 
		$start_date = date('Y-m-d',strtotime("01-".$month_count."-".$year));				 
		$month_arr[$start_date]=$month_name;			  
	 }
		  
    return $month_arr;
  
  }*/
  
  public function get_mail_list_orig_months() {
	  	  
	 $current_total_months =date('m'); 
	 $year = date('Y')-1;
	 for($month_count=$current_total_months;$month_count<=12;$month_count++){		  
		 
		$month_name=date('M',strtotime("01-".$month_count."-".$year));		 
		$start_date = date('Y-m-d',strtotime("01-".$month_count."-".$year));				 
		$month_arr[$start_date]=$month_name;			  
	 }
	
	 $last_month = date('m')-1;  
	 $year = date('Y');
	 for($month_count=1;$month_count<=$last_month;$month_count++){		  
		 
		$month_name=date('M',strtotime("01-".$month_count."-".$year));		 
		$start_date = date('Y-m-d',strtotime("01-".$month_count."-".$year));				 
		$month_arr[$start_date]=$month_name;			  
	 }
	
    return $month_arr;
  
  }
  
  public function get_mail_list_months() {
	  	  
     $session_data=$this->session->userdata('logged_in');
	 if($session_data['CLIENT_ID']==20 or $session_data['CLIENT_ID']==2 )
	   $current_total_months =date('m')+1;
	 else
	   $current_total_months =date('m'); 
	 $year = date('Y')-1;
	 for($month_count=$current_total_months;$month_count<=12;$month_count++){		  
		 
		$month_name=date('M',strtotime("01-".$month_count."-".$year));		 
		$start_date = date('Y-m-d',strtotime("01-".$month_count."-".$year));				 
		$month_arr[$start_date]=$month_name;			  
	 }
	 if($session_data['CLIENT_ID']==20 or $session_data['CLIENT_ID']==2)
	   $last_month = date('m');
	 else
	    $last_month = date('m')-1;  
	 $year = date('Y');
	 for($month_count=1;$month_count<=$last_month;$month_count++){		  
		 
		$month_name=date('M',strtotime("01-".$month_count."-".$year));		 
		$start_date = date('Y-m-d',strtotime("01-".$month_count."-".$year));				 
		$month_arr[$start_date]=$month_name;			  
	 }
	
    return $month_arr;
  
  }
  
  public function get_visitors_list_months() {
	  	  
   $current_total_months =date('m');
	 $year = date('Y')-1;
	 for($month_count=$current_total_months;$month_count<=12;$month_count++){		  
		 
		$month_name=date('M',strtotime("01-".$month_count."-".$year));		 
		$start_date = date('Y-m-d',strtotime("01-".$month_count."-".$year));				 
		$month_arr[$start_date]=$month_name;			  
	 }
	 $last_month = date('m')-1;
	  $year = date('Y');
	 for($month_count=1;$month_count<=$last_month;$month_count++){		  
		 
		$month_name=date('M',strtotime("01-".$month_count."-".$year));		 
		$start_date = date('Y-m-d',strtotime("01-".$month_count."-".$year));				 
		$month_arr[$start_date]=$month_name;			  
	 }
	
    return $month_arr;
  
  }
  //get all months
  public function get_visitors_list_all_months() {
	  	  
   $current_total_months =date('m');
	 $year = date('Y')-1;
	 for($month_count=$current_total_months;$month_count<=12;$month_count++){		  
		 
		$month_name=date('M',strtotime("01-".$month_count."-".$year));		 
		$start_date = date('Y-m-d',strtotime("01-".$month_count."-".$year));				 
		$month_arr[$start_date]=$month_name;			  
	 }
	 $last_month = date('m');
	  $year = date('Y');
	 for($month_count=1;$month_count<=$last_month;$month_count++){		  
		 
		$month_name=date('M',strtotime("01-".$month_count."-".$year));		 
		$start_date = date('Y-m-d',strtotime("01-".$month_count."-".$year));				 
		$month_arr[$start_date]=$month_name;			  
	 }
	
    return $month_arr;
  
  }
  
  
  public function get_visitors_months_year_list($count=14) {
	 
	  	  
     $current_total_months = date('m')-1;	  
     $total_months_last_year=$count-$current_total_months;	 
	 $year=date('Y')-1;
	 $month_arr=array();
	 $start_month=(12-$total_months_last_year)+1;
	 $total_months=12;
	 
	 for($month_count=$start_month;$month_count<=$total_months;$month_count++){		  
		 
		$month_name=date('M-Y',strtotime("01-".$month_count."-".$year));		 
		$month_arr[]=$month_name;		  
		 
		if($month_count==12){
		 
		   $month_count =0;
		   $total_months = date('m')-1;
		   $year = $year+1;
		   
		}
	 }			  
   
    return $month_arr;
  
  }
  
  public function get_monthly_mail_count_details($client_id)	{

	  $clients		=	$this->common_model->get_data('clients','*',array('id'=>$client_id,'status'=>'1'));
	  $date 		= date('Y-m-d');
	  $start_date   = date('Y-m-01',strtotime(date('Y-m')));
	  
	  for($i=0;$i<count($clients);$i++){	
			$clients[$i]['monthly_mail_count'] 	= $this->common_model->request_soap_mail($clients[$i],$start_date,$date,1,0);
	  }
	 
	  //echo "<pre>"; print_r($clients); echo "</pre>"; exit;
	  $data['clients'] = $clients;
	  //$html	= $this->load->view('mail_details', $data, true);
	  return  $data;
    }
	
  public function get_monthly_visitors_count_details($client_id)	{

	  $clients		=	$this->common_model->get_data('clients','*',array('id'=>$client_id,'status'=>'1'));
	  $date 		= date('Y-m-d');
	  $start_date   = date('Y-m-01',strtotime(date('Y-m')));
	  
	  for($i=0;$i<count($clients);$i++){	
			$clients[$i]['monthly_visitors_count'] 	= $this->common_model->request_ga_month_site_visitors($clients[$i],$start_date,$date);
			//$clients[$i]['monthly_visitors_count']=0;
	  }
	 
	  //echo "<pre>"; print_r($clients); echo "</pre>"; exit;
	  $data['clients'] = $clients;
	  //$html	= $this->load->view('mail_details', $data, true);
	  return  $data;
    }
 
 public function sync_previous_ga_data(){
	 
	 $this->common_model->sync_previous_ga_data();
	 
 }
  
  public function toAlpha($num) {
	 
    $alphabet = array( 'a', 'b', 'c', 'd', 'e',
                       'f', 'g', 'h', 'i', 'j',
                       'k', 'l', 'm', 'n', 'o',
                       'p', 'q', 'r', 's', 't',
                       'u', 'v', 'w', 'x', 'y',
                       'z'
                       );
    $index=$num-1;
	if($index<0)
	 return false;				   
    return $alphabet[$index];
 }
 
 public function getNameFromNumber($num) {
    $numeric = $num % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($num / 26);
    if ($num2 > 0) {
        return $this->getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
} 	
	
  public function convert_date($string){
    
	$arr = explode('T',$string);	
	$format_date =  date('Y-m-d',strtotime($arr[0]));
	return $format_date;
  
  
  }	
  
  public function get_entity_name($model,$id){
     $entity_name=$this->common_model->get_data($model,'id,name',array('id'=>$id));
	 
	 if($entity_name)
	   return $entity_name[0]['name'];
	 else
	   return false;   
	 
   }
   
  public function get_client_logo($client_id){ 		
  
     $client=$this->common_model->get_data('clients','logo',array('id'=>$client_id)); 
	 if($client)
	   return $client[0]['logo'];
	 else
	   return false; 
   

  }
   
  public function login() {

	   if($this->session->userdata('is_login')){
	           redirect('index', 'refresh');

	   }

	   else{

		     $this->gen_contents['page_title'] = 'Techmart Solutions - Monthly Report';
		     $this->load->view('common/login_header',$this->gen_contents); 
	         $this->load->view('login');
			 $this->load->view('common/login_footer');			 

		 }

  }
  public function logout() {

	 $this->authentication->user_logout();
	 if (isset($_COOKIE['remember_me_token']))
	   unset($_COOKIE['remember_me_token']); 
     redirect('index/login');

   

   }
   
   public function test(){
	   
	for($i=1;$i<70000;$i++){
	  
	  $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
               //$memmory = memory_get_usage() . "\n"; 
               fwrite($myfile, $i);

                fclose($myfile);
	 	
	}
	echo "success";   
   }
   
   public function empty_ga_data(){
	
	for($i=1;$i<=12;$i++){
	  
	  $date = '2016-'.$i.'-01';
	  
	  $month_end = date('Y-m-t',strtotime($date));
	  
	  $data = array("client_id"=>24,"ga_event_id"=>1,"ga_event_entity_name"=>"visitors","date"=>$month_end,"visitors_count"=>0); 
	  
	  $this->common_model->save('ga_site_visitors',$data);
	  
	  $data = array("client_id"=>24,"ga_event_id"=>1,"ga_event_entity_name"=>"newVisits","date"=>$month_end,"visitors_count"=>0); 
	  
	  $this->common_model->save('ga_site_visitors',$data);
	  
	  $data = array("client_id"=>24,"ga_event_id"=>1,"ga_event_entity_name"=>"percentNewVisits","date"=>$month_end,"visitors_count"=>0); 
	  
	  $this->common_model->save('ga_site_visitors',$data);
	  
	   $data = array("client_id"=>24,"ga_event_id"=>1,"ga_event_entity_name"=>"pageviews","date"=>$month_end,"visitors_count"=>0); 
	  
	  $this->common_model->save('ga_site_visitors',$data);
	  $data = array("client_id"=>24,"ga_event_id"=>1,"ga_event_entity_name"=>"visits","date"=>$month_end,"visitors_count"=>0); 
	  
	  $this->common_model->save('ga_site_visitors',$data);	
		
	}
	   
	exit;
	   
	   
   }
   
   public function get_ga_data(){
	
	for($i=4;$i<=12;$i++){
	  
	  $date = '2016-'.$i.'-01';
	  
	  $month_end = date('Y-m-t',strtotime($date));
	  $month_start = date('Y-m-01',strtotime($date));
	  $clients		=	$this->common_model->get_data('clients','*',array('id'=>29,'status'=>'1'));
	  for($j=1;$j<7;$j++)
	  $this->common_model->request_ga_site_visitors($clients[0],$j,$month_start,$month_end);
		
	}
	   
	exit;
	   
	   
   }
   
   
}
	

