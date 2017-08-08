    
     <!-- Pop up box starts -->
    <div class="overlay"></div>
    <div id="popup_box">
      <div class="popInner">
        <h2 id="title_text">Clicks</h2>
        <div id="export_link"></div>        
          <div class="tableContent"></div>
          <a id="popupBoxClose"></a>  
    </div>
    </div>
     <!-- Pop up box ends -->  
     
    <div class="row wrapper border-bottom white-bg page-heading">

                <div class="col-lg-10">

                    <h2>Database Performance </h2>
                    <span  class="export-btn">
                      <a class="btn btn-primary" href="<?php echo base_url();?>index.php/index/export_report/<?php echo $client_id; ?>">Export Data</a></span>
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

                        <div class="ibox-tools">

                            <a class="collapse-link">

                                <i class="fa fa-chevron-up"></i>

                            </a>


                        </div>

                    </div>

                    <div class="ibox-content">
                     <?php //echo $mail_count_details; 
					 $this->load->view('mail_details', $emails);?>
                    </div>
					
					<!--<div class="ibox-content">
                     <?php //echo $mail_count_details; 
					 //$this->load->view('monthly_mail_details');?>
                    </div>-->
                  
				  <div class="ibox-title">

                        <h5>Message Activity</h5>
                          <span  class="export-btn" style="margin-top:-7px"><a id="message_export_url" class="btn btn-primary" href="<?php echo base_url();?>index.php/index/export_message_activity_report/<?php echo $client_id; ?>/<?php echo date('Y-m-01', strtotime("-30 days"));?>/<?php echo date('Y-m-t', strtotime("-30 days"));?>">Export Data</a></span>
                        <!-- <div class="ibox-tools">

                            <a class="collapse-link">

                                <i class="fa fa-chevron-up"></i>

                            </a>

                           <a class="dropdown-toggle" data-toggle="dropdown" href="#">

                                <i class="fa fa-wrench"></i>

                            </a>

                           

                            <a class="close-link">

                                <i class="fa fa-times"></i>

                            </a>

                        </div>-->

                    </div>
                     
                   <?php //echo $message_details; 
						$this->load->view('message_details', $messages);
						?>
                    
                   
                   <div class="ibox-content">
                     <?php 
					 $this->load->view('segmentation_details', $segmentation_emails);?>
                    </div>

                 


             </div>

            </div>

<script type="application/javascript">
   $(document).ready(function() {
	  		var $table= $(".dataTables").dataTable({
						aLengthMenu: [
							[25, 50, 100, -1],
							[25, 50, 100, "All"]
						],
						iDisplayLength: 10
			});       
		  $('.date').datepicker({format: 'yyyy-mm-dd',}); 
		  $('.btnsearch').click(function(){		    
             var client_id = $(this).attr('id').split('_').pop();
			 var start_date = $('#start_date').val();
			 var end_date   = $('#end_date').val();	
			 $('.loadings').show();
			 $.ajax({   

						type:'POST',
						data:'start_date='+start_date+'&end_date='+end_date+'&client_id='+client_id,
						dataType:'json',
						url:'<?php echo base_url();?>'+'index.php/custom_ajax/search_message_activity',
						success: function(data){
							if(data.status=="success"){
								$('.loadings').hide();
								$table.fnDestroy(); 
								$('#search_data_'+client_id).html(data.data_html);								 								   
                               	$(".dataTables").dataTable({
									aLengthMenu: [
										[25, 50, 100, -1],
										[25, 50, 100, "All"]
									],
									iDisplayLength: 10
			                    }); 
                               $('#message_export_url').attr('href','<?php echo base_url(); ?>'+'index.php/index/export_message_activity_report/'+client_id+'/'+start_date+'/'+end_date);  
                             }

						   }					

					  });
		  });     
   
 $('body').on('click','.clickCount',function(){ 
  
	 var messageID = $(this).attr('rel');
	 var client_id = $(this).attr('data-client');
	 $('.loadings').show();
	 $.ajax({
		type:'POST',
		data:'messageID='+messageID+'&client_id='+client_id,
		dataType:'json',
		url:'<?php echo base_url();?>'+'index.php/custom_ajax/ReportMessageLinkClick',
		success: function(data){
		  
		  if(data.status=='success'){
			 
			 $('.tableContent').html('<div class="table_content">'+data.data_html+'</div>');
			 $('#title_text').text('Clicks');
			 $('#export_link').html('<a class="btn btn-primary" href="<?php base_url(); ?>export_message_click/'+messageID+'/'+client_id+'">Export</a>');
			 $('.loadings').hide();			
			 $('#popup_box').show();
             $('.overlay').addClass('show');
			   
		  }
		  
		}
	   });
 
 });
 
 $('body').on('click','.clickOpenCount',function(){ 
  
	 var messageID = $(this).attr('rel');
	 var client_id = $(this).attr('data-client');
	 var sendDate = $(this).attr('data-sendDate');
	 var message = $(this).attr('data-message');
	 $('.loadings').show();
	 $.ajax({
		type:'POST',
		data:'messageID='+messageID+'&clientID='+client_id+'&sendDate='+sendDate+'&message='+message,
		dataType:'json',
		url:'<?php echo base_url();?>'+'index.php/custom_ajax/ReportMessageContactOpen',
		success: function(data){
		  
		  if(data.status=='success'){
			 
			 $('.tableContent').html('<div class="tableOpen_content">'+data.data_html+'</div>');
			 $('#title_text').text('Opens')
			 $('#export_link').html('');
			 $('.loadings').hide();   
			 $('#popup_box').show();
             $('.overlay').addClass('show');
			   
		  }
		  
		}
	   });
 
 });
 
  $('#popupBoxClose,.overlay').click(function(){
	  $('#popup_box').hide();
      $('.overlay').removeClass('show');	  
 });
   
 });
   </script>