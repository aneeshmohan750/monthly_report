     

        <div class="row wrapper border-bottom white-bg page-heading">

                <div class="col-lg-10">

                    <h2>Dashboard</h2>

                </div>

                <div class="col-lg-2">



                </div>

        </div>

        <div class="wrapper wrapper-content animated fadeInRight">
          
		  <div class="row">
		        
				 <div class="col-lg-12">
				 
		           <div class="ibox float-e-margins">
                   
                    <div class="ibox-title">

                        <h5>Database Growth</h5>
                        <p class="db_count">Database Count as on <?php echo $client_last_update; ?> is  <strong><?php echo $client_mail_count; ?></strong> </p>
                       <!-- <div class="ibox-tools">

                            <a class="collapse-link">

                                <i class="fa fa-chevron-up"></i>

                            </a>

                            
                        </div>-->

                    </div>

                    <div class="ibox-content" >

                     <?php  $this->load->view('mail_details_overview', $emails);?>
                    </div>
					
              </div>
             </div>
			   
			   <div class="col-lg-12">
				 
		           <div class="ibox float-e-margins">
                   
                     <div class="ibox-title">
                         <h5>Email Marketing Performance</h5>
                     </div>
                   </div>
               </div>
               <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right">Average</span>
                                <h5>Frequency Rate <a href="javascript:void(0);" data-toggle="tooltip" title="Number of mail's dispatched per month"><img src="<?php base_url(); ?>assets/img/tooltip.png" /></a> </h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $average_frequency_rate; ?></h1>
                               <!-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>-->
                                <small>Mails/month</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right">Average</span>
                                <h5>Read Rate <a href="javascript:void(0);" data-toggle="tooltip" title="Number of recipients who received and read the email"><img src="<?php base_url(); ?>assets/img/tooltip.png" /></a></h5>
								
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $average_read_rate; ?></h1>
								
                                <!--<div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>-->
                                <small>Percent</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right">Average</span>
                                <h5>Open Rate <a href="javascript:void(0);" data-toggle="tooltip" title="A measure of how many people on an email list open (or view) a particular email campaign."><img src="<?php base_url(); ?>assets/img/tooltip.png" /></a></h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $average_open_rate; ?></h1>
                               <!-- <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>-->
                                <small>Percent</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <span class="label label-info pull-right">Average </span>
                                <h5>CTOR <a href="javascript:void(0);" data-toggle="tooltip" title="Number of recipients who opened the email and how many clicked."><img src="<?php base_url(); ?>assets/img/tooltip.png" /></a></h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $average_ctor_rate; ?></h1>
                               <!-- <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div>-->
                                <small>Percent</small>
                            </div>
                        </div>
            </div>
        </div>
	<?php if($type=='hotel'){ ?>	
		<div class="row">
		   <div class="col-lg-12">
				 
		           <div class="ibox float-e-margins">
                   
                     <div class="ibox-title">
                         <h5>Database Segmentation</h5>
                     </div>
                   </div>
               </div>
            <div class="col-md-2">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>F&B</h5>
                    </div>
                    <div class="ibox-content">
					<?php //echo date("Y-m",strtotime("-1 month"); exit; ?>
                        <h1 class="no-margins"><?php $CI =& get_instance(); echo number_format($CI->getSegmentation(95,$client_id,$last_month_date)); ?></h1>
                        <small>Total Count</small>
                    </div>
                </div>
            </div>
			<div class="col-md-2">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Spa</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?php $CI =& get_instance(); echo number_format($CI->getSegmentation(132,$client_id,$last_month_date)); ?></h1>
                        <small>Total Count</small>
                    </div>
                </div>
            </div>
			<div class="col-md-2">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>RoomStay</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?php $CI =& get_instance(); echo number_format($CI->getSegmentation(299,$client_id,$last_month_date)); ?></h1>
                        <small>Total Count</small>
                    </div>
                </div>
            </div>
           
        </div>
	<?php }?>	   
		  <?php if($client_ga_details==1){ ?>
            <div class="row">

                <div class="col-lg-12">

			 
			 <div class="ibox float-e-margins">
                   
                    <div class="ibox-title">

                        <h5>Website Performance - <?php echo $client_website ?></h5>

                        <div class="ibox-tools">

                            <a class="collapse-link">

                                <i class="fa fa-chevron-up"></i>

                            </a>

                            
                        </div>

                    </div>

                    <div class="ibox-content">
                     <?php  $this->load->view('visitors_details_overview', $visitors);?>
                    </div>
					
					<!--<div class="ibox-content">
                     <?php  //$this->load->view('monthly_visitors_details');?>
                    </div>-->

             </div>
			 
			 
            </div>
		 </div>	
		 <?php } ?>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

</script>