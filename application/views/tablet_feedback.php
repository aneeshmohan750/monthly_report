     

        <div class="row wrapper border-bottom white-bg page-heading">

                <div class="col-lg-10">

                    <h2>Monthly Database</h2>

                </div>

                <div class="col-lg-2">



                </div>

        </div>

        <div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">

                <div class="col-lg-12">

                <div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5>Tablet Feedback Entries From JAN-2017</h5>
                         <span  class="export-btn" style="margin-top:-7px"><a id="feedback_export_url" class="btn btn-primary" href="<?php echo base_url();?>index.php/index/export_tablet_feedback_report/<?php echo $client_id; ?>">Export Data</a></span>
                       
                        <div class="ibox-content">
                    <div class="row"><div class="col-sm-5">
                                            <div class="form-group">
                                                <label for="start_date" class="control-label">Date</label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                    <input type="text" class="form-control date" id="search_date" name="search_date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="pdt_25" style="margin-top:25px">
                                                <input type="button" class="btn btn-primary btnsearch" name="search_date" id="searchdate_<?php echo $client_id;?>" value="Search">
                                                
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="pdt_25" style="margin-top:30px">
                                                
                                                <a href="javascript:void(0)" id="clearsearch_<?php echo $client_id;?>" class="clear_serach">Clear Search</a>
                                                
                                            </div>
                                        </div>
                                       </div>
                    <div id="ip_messages">

          <div class="table-responsive">
          <?php if($tablet_feedback_active_fields){ ?>
            <table class="table table-striped table-bordered table-hover dataTables" id="datatable" >
            <thead>
				<tr>
                  <?php foreach($tablet_feedback_active_fields as $field): ?>
                   <td><?php echo $field->title; ?></td>
                  <?php endforeach; ?>  
				</tr>
		  </thead>
          <tbody id="search_data">
          <?php if($tablet_feedback_details){ ?>
          
          <?php foreach($tablet_feedback_details as $feedback_data) :?>
           <tr>
           <?php foreach($tablet_feedback_active_fields as $field): ?>            
              <td><?php echo $feedback_data[$field->field_name]; ?></td>              
           <?php endforeach; ?> 
           </tr>
          <?php endforeach; ?>     
          <?php } ?>   
          </tbody>  
           </table>
         <?php } ?>   
              </div>          
                    </div>
                    
 

                   </div>
           

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
						iDisplayLength: 6,
						order : []
						
			});       
			
	 $('.date').datepicker({format: "mm-yyyy",
		viewMode: "months", 
		minViewMode: "months",
		startDate:"01-2017"}); 
		
    $('.btnsearch').click(function(){		    
             var client_id = $(this).attr('id').split('_').pop();
			 var search_date   = $('#search_date').val();
			 if(search_date=='')
			   return false;	
			 $('.loadings').show();
			 $.ajax({   

						type:'POST',
						data:'search_date='+search_date+'&client_id='+client_id,
						dataType:'json',
						url:'<?php echo base_url();?>'+'index.php/custom_ajax/search_tablet_feedback',
						success: function(data){
							if(data.status=="success"){
								$('.loadings').hide();
								 $('#feedback_export_url').attr('href','<?php echo base_url(); ?>'+'index.php/index/export_tablet_feedback_report/'+client_id+'/'+data.start_date+'/'+data.end_date);  
								$table.fnDestroy(); 
								$('#search_data').html(data.data_html);								 								   
                               	$(".dataTables").dataTable({
						aLengthMenu: [
							[25, 50, 100, -1],
							[25, 50, 100, "All"]
						],
						iDisplayLength: 6,
						order : []
						
			});       
                              
                             }

						   }					

					  });
		  });
	$('.clear_serach').click(function(){		    
             var client_id = $(this).attr('id').split('_').pop();
			 $('#search_date').val('');
			 $('.loadings').show();
			 $.ajax({   

						type:'POST',
						data:'client_id='+client_id,
						dataType:'json',
						url:'<?php echo base_url();?>'+'index.php/custom_ajax/list_tablet_feedback',
						success: function(data){
							if(data.status=="success"){
								$('.loadings').hide();
								$('#feedback_export_url').attr('href','<?php echo base_url(); ?>'+'index.php/index/export_tablet_feedback_report/'+client_id+'');  
								$table.fnDestroy(); 
								$('#search_data').html(data.data_html);								 								   
                               	$(".dataTables").dataTable({
						aLengthMenu: [
							[25, 50, 100, -1],
							[25, 50, 100, "All"]
						],
						iDisplayLength: 6,
						order : []
						
			});       
                              
                             }

						   }					

					  });
		  });	  		
			   
 });
 
  
   </script>