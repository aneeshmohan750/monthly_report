     

        <div class="row wrapper border-bottom white-bg page-heading">

                <div class="col-lg-10">

                    <h2>Website Performance</h2>
                    <span  class="export-btn"><a class="btn btn-primary" href="<?php echo base_url();?>index.php/index/export_ga_report/<?php echo $client_id; ?>">Export Data</a></span>
                </div>

                <div class="col-lg-2">



                </div>

        </div>

        <div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">

                <div class="col-lg-12">

                <div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5>Visitors Summary</h5>
                          <p class="db_count">Visitor count for the month of <?php echo date('F',strtotime($client_last_update)); ?> as  <?php echo $client_last_update; ?> is  <strong><?php echo $client_visitor_count; ?></strong> </p>
                       <!-- <div class="ibox-tools">

                            <a class="collapse-link">

                                <i class="fa fa-chevron-up"></i>

                            </a>

                        </div> -->

                    </div>

                    <div class="ibox-content">
                     <?php //echo $mail_count_details; 
					 $this->load->view('visitors_details', $visitors);?>
                    </div>

                    
                    <div class="ibox-content">
                     <?php 
					 $this->load->view('referal_details', $referals);?>
                    </div>
                    
                    <div class="ibox-content">
                     <?php 
					 $this->load->view('browser_details', $browser_visitors);?>
                    </div>
                    
                     <div class="ibox-content">
                     <?php 
					 $this->load->view('country_details', $country_visitors);?>
                    </div>
                    
					<div class="ibox-content">
                     <?php 
					 $this->load->view('toppage_details', $page_visitors);?>
                    </div>

                     


             </div>

            </div>

<script type="application/javascript" >
   $(document).ready(function() {
	  		 $(".dataTables").dataTable({
						aLengthMenu: [
							[25, 50, 100, -1],
							[25, 50, 100, "All"]
						],
						iDisplayLength: 25
			});       
		  $('.date').datepicker({format: 'yyyy-mm-dd',}); 
		  $('#search_date').click(function(){		    

			 var start_date = $('#start_date').val();
			 var end_date   = $('#end_date').val();	
			 $("#ip_messages").LoadingOverlay("show");
			 $.ajax({   

						type:'POST',
						data:'start_date='+start_date+'&end_date='+end_date,
						dataType:'json',
						url:'<?php echo base_url();?>'+'index.php/custom_ajax/search_message',
						success: function(data){
							if(data.status=="success"){
								$("#ip_messages").LoadingOverlay("hide");
								$('#ip_messages').html(data.data_html);  								   
                               	$(".dataTables").dataTable({
									aLengthMenu: [
										[25, 50, 100, -1],
										[25, 50, 100, "All"]
									],
									iDisplayLength: 25
								  }); 

                             }

						   }					

					  });
		  });     
   });
   </script>