       <div class="row wrapper border-bottom white-bg page-heading">

                <div class="col-lg-10">

                    <h2>Consolidated View</h2>
                </div>

                <div class="col-lg-2">



                </div>

        </div>

        <div class="wrapper wrapper-content animated fadeInRight">
	
        <?php if($multi_access==0){ ?>
            <div class="row">

                <div class="col-lg-12">

                <div class="ibox float-e-margins">

                 
                   <div class="ibox-content">
                    <?php if($allowed_clients) :?>
            <div class="special-head"><h3>Database Consolidation</h3></div>
           <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label for="start_date" class="control-label">Date</label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" 
                                                        value="<?php echo $this->input->post('date')?$this->input->post('date'):date('m-Y', strtotime("-30 days"));?>" class="form-control" id="date" name="date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="pdt_25" style="margin-top:25px">
                                                <input type="button" class="btn btn-primary btnsearch" name="search_date" id="search_date" value="Search">
                                                
                                            </div>
                                        </div>
                                    </div>
            <?php if(is_array($allowed_clients)) :?>
            <table class="table table-striped table-bordered table-hover" >
            	<thead>
					<tr>
                     <th align="center">Hotel</th>
                     <th align="center">Mail Count</th>
					 <?php foreach($primary_segments as $segment): ?><th align="center"><?php echo $segment['name']; ?></th>
					 <?php endforeach;?>
                    </tr>
					
			 </thead>
           
            <tbody id="search_data">
				
                <?php foreach($allowed_clients as $client): ?>
                        <tr>
                          <td><?php echo $client->name; ?></td>
                          <td align="right"><?php $CI =& get_instance(); echo number_format($CI->getEmailCount($client->id,$last_month,$last_month_date)); ?></td>
                          <?php foreach($primary_segments as $segment): ?>
                          <td align="right"><?php $CI =& get_instance(); echo number_format($CI->getSegmentation($segment['id'],$client->id,$last_month)); ?></td>
                          <?php endforeach;?>
                        </tr>
                    <?php endforeach;?>
            </tbody>
           </table>
            	
	       <?php else: ?>
           <table class="table table-striped table-bordered table-hover" >
	     		<tr class="gradeX"><td colspan="7"><?php echo 'No Data Found' ;?></td></tr>
           </table>
           <?php endif;?>
           
     <?php endif;?> 
                    </div>

                 


             </div>

            </div>
           
           </div>
         <?php } ?>  
           <div class="row">

                <div class="col-lg-12">

                <div class="ibox float-e-margins">

                 
                   <div class="ibox-content">
                    <?php if($allowed_clients) :?>
            <div class="special-head"><h3>Website Performance</h3></div>
           <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label for="start_date" class="control-label">Date</label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" 
                                                        value="<?php echo $this->input->post('date')?$this->input->post('date'):date('m-Y', strtotime("-30 days"));?>" class="form-control" id="ga_date" name="ga_date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="pdt_25" style="margin-top:25px">
                                                <input type="button" class="btn btn-primary btnsearch" name="search_ga_date" id="search_ga_date" value="Search">
                                                
                                            </div>
                                        </div>
                                    </div>
            <?php if(is_array($allowed_ga_clients)) :?>
            <table class="table table-striped table-bordered table-hover" >
            	<thead>
					<tr>
                     <th align="center">Hotel</th>
                     <th align="center">Visitors</th>
                     <th align="center">Page Views</th>
                     <th align="center">New Visitors(%)</th>
                    </tr>
					
			 </thead>
           
            <tbody id="search_data_ga">
				
                <?php foreach($allowed_ga_clients as $client): ?>
                        <tr>
                          <td><?php echo $client->name; ?></td>
                          <td align="right"><?php $CI =& get_instance(); echo number_format($CI->getSiteVisitorData($client->id,1,'visits',$last_month_date)); ?></td>
                          <td align="right"><?php $CI =& get_instance(); echo number_format($CI->getSiteVisitorData($client->id,1,'pageviews',$last_month_date)); ?></td>
                          <td align="right"><?php $CI =& get_instance(); echo number_format($CI->getSiteVisitorData($client->id,1,'percentNewVisits',$last_month_date)); ?></td>
                        </tr>
                    <?php endforeach;?>
            </tbody>
           </table>
            	
	       <?php else: ?>
           <table class="table table-striped table-bordered table-hover" >
	     		<tr class="gradeX"><td colspan="7"><?php echo 'No Data Found' ;?></td></tr>
           </table>
           <?php endif;?>
           
     <?php endif;?> 
                    </div>

                 


             </div>

            </div>
           
           </div>

            </div> 
<script>			
			
$(document).ready(function(){

 $('.date').datepicker({format: "mm-yyyy",
    viewMode: "months", 
    minViewMode: "months",
	startDate:"01-2016"}); 
  
  $('#search_date').click(function(){		    
			 var search_date   = $('#date').val();	
			 $('.loadings').show();
			 $.ajax({   

						type:'POST',
						data:'search_date='+search_date,
						dataType:'json',
						url:'<?php echo base_url();?>'+'index.php/custom_ajax/search_consolidation',
						success: function(data){
							if(data.status=="success"){
								$('.loadings').hide();
								$('#search_data').html(data.data_html);
								 								   
                             }

						   }					

					  });
		  });   
  
   $('#search_ga_date').click(function(){		    
			 var search_date   = $('#ga_date').val();	
			 $('.loadings').show();
			 $.ajax({   

						type:'POST',
						data:'search_date='+search_date,
						dataType:'json',
						url:'<?php echo base_url();?>'+'index.php/custom_ajax/search_ga_consolidation',
						success: function(data){
							if(data.status=="success"){
								$('.loadings').hide();
								$('#search_data_ga').html(data.data_html);
								 								   
                             }

						   }					

					  });
		  });     		    	
 

});


</script>			
      