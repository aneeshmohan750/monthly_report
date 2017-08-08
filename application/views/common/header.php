<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.0/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:49:42 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $page_title; ?> | Dashboard</title>
    
    <link rel="icon" href="<?php echo $this->config->item('assets_url')?>favicon.png" type="image/png" />
    
    <link href="<?php echo $this->config->item('assets_url')?>css/bootstrap.min.css" rel="stylesheet">
   
    <link href="<?php echo $this->config->item('assets_url')?>font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="<?php echo $this->config->item('assets_url')?>css/plugins/toastr/toastr.min.css" rel="stylesheet">


   
    <link href="<?php echo $this->config->item('assets_url')?>css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('assets_url')?>css/animate.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('assets_url')?>css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_url')?>css/fakeLoader.css">
	<link href="<?php echo $this->config->item('assets_url')?>css/plugins/dropzone/basic.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('assets_url')?>css/plugins/dropzone/dropzone.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('assets_url')?>css/sweet-alert.css">
    
    <!-- Mainly scripts -->
    <script src="<?php echo $this->config->item('assets_url')?>js/jquery-2.1.1.js"></script>
    <script src="<?php echo $this->config->item('assets_url')?>js/bootstrap.min.js"></script>
    <script src="<?php echo $this->config->item('assets_url')?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo $this->config->item('assets_url')?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo $this->config->item('assets_url')?>js/plugins/datapicker/bootstrap-datepicker.js"></script>
   <!-- Data Tables -->
    <script src="<?php echo $this->config->item('assets_url')?>js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo $this->config->item('assets_url')?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?php echo $this->config->item('assets_url')?>js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="<?php echo $this->config->item('assets_url')?>js/plugins/dataTables/dataTables.tableTools.min.js"></script>
    <script src="<?php echo $this->config->item('assets_url')?>js/fusioncharts.js"></script>
    <script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/fakeLoader.js"></script>
    <script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/fusioncharts.charts.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/fusioncharts.powercharts.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/fusioncharts.widgets.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/fusioncharts.gantt.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/fusioncharts.zoomscatter.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/fusioncharts.treemap.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/fusioncharts.theme.fint.js"></script>
    <script type="text/javascript" src="<?php echo $this->config->item('assets_url')?>js/sweet-alert.min.js"></script>


<script>

$(document).ready(function(){

 $('#sync_data').click(function(){
  
  swal({   title: "Are you sure?",   text: "Do you want to syncronize last month data from listrak and google analytics!",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes",   closeOnConfirm: true }, function(){ sync_data();   });
 
 });
 
 $('#client_id').change(function(){
    
	var client_id = $(this).val();
	if(client_id!=-1){
	swal({   title: "Are you sure?",   text: "Do you want to switch the client!",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes",   closeOnConfirm: true }, function(){ change_client_session(client_id);   });
	}
 
 
 });
 
 get_current_data(<?php echo $client_id; ?>);
 get_tablet_feedback_data(<?php echo $client_id; ?>);


});

function sync_data() {
    
	$('.loadings').show();	
    $.ajax({   
                     	type:'POST',
						dataType:'json',
						url:'<?php echo base_url();?>'+'index.php/custom_ajax/data_sync',
						success: function(data){
							if(data.status=="success"){
							  $('.loadings').hide();	
							  swal("Data Sync!", "Data Sync has been successfully done.", "success");
							  window.location.href='<?php echo base_url(); ?>'; 
							}
							else {
							  $('.loadings').hide();
							  swal("Data Sync!", "Data is uptodate.", "success"); 
                            }
						   }					

					  });


}

function change_client_session(client_id){
  
    if(client_id==-1)
	  return false;
    $('.loadings').show();
	$('#client_id').attr('disabled',true);	
    $.ajax({   
                     	type:'POST',
						dataType:'json',
						url:'<?php echo base_url();?>'+'index.php/custom_ajax/change_client',
						data:'client_id='+client_id,
						success: function(data){
							if(data.status=="success"){
								
							  $('.loadings').hide();	
							  window.location.href='<?php echo base_url(); ?>'; 
							}
							else {
							  $('.loadings').hide();
                            }
						   }					

					  });
 


}

function get_current_data(client_id){

  $.ajax({   
                     	type:'POST',
						dataType:'json',
						url:'<?php echo base_url();?>'+'index.php/custom_ajax/get_current_data',
						data:'client_id='+client_id,
						success: function(data){}					

					  });
 


}

function get_tablet_feedback_data(client_id){

  $.ajax({   
                     	type:'POST',
						dataType:'json',
						url:'<?php echo base_url();?>'+'index.php/custom_ajax/get_tablet_feedback_data',
						data:'client_id='+client_id,
						success: function(data){}					

					  });
 


}

</script>
    
</head>
 <div class="loadings" style="display:none;"> <img src="<?php echo $this->config->item('assets_url')?>img/preloader.gif"><span>Processing your request...</span></div>
<body>
    <div id="wrapper">
	  
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
			   
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
						<div><?php if($client_id){ ?>
                        <img src="<?php echo base_url(); ?>uploads/logo/<?php $CI =&get_instance(); echo $CI->get_client_logo($client_id); ?>"><?php } ?><?php if(!$client_id){ ?><img src="<?php echo base_url(); ?>uploads/logo/marriott_logo.png"><?php } ?></div>
                        <div class="logo-element">
						
                       </div>
                    </li>
					
					<li class="username_section">
				<div class="dropdown profile-element"> <span></span>

                            <a data-toggle="dropdown" class="dropdown-toggle username" href="#">

                            <span class="clear"> <span class="block m-t-xs username_span"> <strong class="font-bold"><?php echo $name; ?></strong>

                             </span> <span class="text-muted text-xs block username_icon"> <b class="caret"></b></span> </span> </a>

                            <ul class="dropdown-menu animated fadeInRight m-t-xs ">

                                <li><a href="<?php echo base_url(); ?>index.php/index/logout">Logout</a></li>
								 <li><a href="<?php echo base_url(); ?>index.php/index/change_password">Change Password</a></li>

                            </ul>

                        </div>

						
				</li>
                   <?php if($client_id){ ?>
                    <?php if($client_mail_listing==1){ ?>
					<li <?php if($current_controller=='index') echo 'class="active"'; ?>>
                        <a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i> <span class="nav-label">Dashboard</span> </a>
                    </li>
                    <li <?php if($current_controller=='dashboard') echo 'class="active"'; ?>>
                        <a href="<?php echo base_url();?>index.php/index/dashboard"><i class="fa fa-th-large"></i> <span class="nav-label">Database Performance</span> </a>
                    </li>
                    <?php } ?>
					<?php if($client_ga_details==1){ ?>
                    <li <?php if($current_controller=='ga_details') echo 'class="active"'; ?>>
                        <a href="<?php echo base_url();?>index.php/index/ga_details"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Website Performance</span> </a>
                    </li>
					<?php } ?>
                    <?php if($client_tablet_feedback==1){ ?>
                    <li <?php if($current_controller=='tablet_feedback_details') echo 'class="active"'; ?>>
                        <a href="<?php echo base_url();?>index.php/index/tablet_feedback_details"><i class="fa fa-book"></i> <span class="nav-label">Tablet Feedback</span> 
                        </a>
                    </li>
					<?php } ?>
                   <?php } ?> 
                    <?php if($admin==1 or $group_admin==1){ ?>
                    <li <?php if($current_controller=='segment_consolidation') echo 'class="active"'; ?>>
                        <a href="<?php echo base_url();?>index.php/index/segment_consolidation"><i class="fa fa-server"></i> <span class="nav-label">Consolidated View </span> </a>
                    </li>
					<?php } ?>
					<?php if($admin==1 and $client_id){ ?>
					<li <?php if($current_controller=='file_upload') echo 'class="active"'; ?>>
                        <a href="<?php echo base_url();?>index.php/index/file_upload"><i class="fa fa-desktop"></i> <span class="nav-label">Upload</span> </a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-database"></i> <span class="nav-label">Settings</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url();?>index.php/index/segments">Segments</a></li>
                            <li><a href="<?php echo base_url();?>index.php/index/users">Users</a></li>
							<li><a href="<?php echo base_url();?>index.php/index/site_page_name">Site Page Name</a></li>
                           <?php if($client_tablet_feedback==1){ ?>
                            <li><a href="<?php echo base_url();?>index.php/index/tablet_feedback_fields">Tablet Feedback Fields</a></li>
                           <?php } ?> 
                        </ul>
                    </li>
					
					<?php } ?>
     
                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
		<?php if($admin==1 or $group_admin==1){ ?>
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
		
        <div class="navbar-header" style="padding-top:13px;padding-left:20px;">
         <?php if($admin==1){ ?>
		   <select name="client_id" id="client_id" class="form-control">
		     <option value="-1">---Change Client---</option>
            <?php foreach($clients as $client): ?>
			 <option value="<?php echo $client['id']; ?>" <?php if($client_id==$client['id']) echo 'selected="selected"'; ?>><?php echo $client['name']; ?></option>
			<?php endforeach; ?>
		   </select>
        <?php } ?>
         <?php if($group_admin==1 and $admin!=1 and $allowed_clients){ ?>
		   <select name="client_id" id="client_id" class="form-control">
		     <option value="-1">---Change Client---</option>
            <?php foreach($allowed_clients as $allowed_client): ?>
			 <option value="<?php echo $allowed_client->id; ?>" <?php if($client_id==$allowed_client->id) echo 'selected="selected"'; ?>><?php echo $allowed_client->name; ?></option>
			<?php endforeach; ?>
		   </select>
        <?php } ?>   	     	 
			
        </div>
        <ul class="nav navbar-top-links navbar-right">
		    <?php if($admin==1){ ?>  
                <li>
                    <a  href="javascript:void(0)" id="sync_data" class="btn btn-info btn-lg btn-syndata">
          <span class="glyphicon glyphicon-refresh"></span> Sync Data
        </a>
                </li>
            <?php } ?>
                <li>
                   <a href="<?php echo base_url(); ?>index.php/index/logout">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
				
               
            </ul>

        </nav>
	 <?php } ?>  	
        </div>