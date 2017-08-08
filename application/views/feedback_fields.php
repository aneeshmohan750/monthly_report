     

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

                        <h5>Feedback Form Fields</h5>
                       
                        <div class="ibox-content">
                    <div class="row"></div>
                    <div id="ip_messages">

          
            <table class="table table-striped table-bordered table-hover dataTables" id="datatable" >
            <thead>
				<tr> 
                    <th>Title</th>
                    <th>Status</th> 
                    <th>Action</th>                
				</tr>
		  </thead>
          <tbody>
          <?php if($feedback_fields){ ?>
			  <?php foreach($feedback_fields as $feedback_field) :?>
              <tr>
              <td><?php echo $feedback_field->title; ?></td>
              <td><?php if($feedback_field->status==1) echo "Active"; else echo "Inactive"; ?></td>
			  <td><a href="javascript:void(0)" onClick="change_status(<?php echo $feedback_field->id ?>,<?php echo $feedback_field->status ?>)" class="btn btn-info btn-small"><i class="btn-icon-only icon-remove"><?php if($feedback_field->status==1) echo "Deactivate"; else echo "Activate"; ?></i></a></td>
              </tr>
              <?php endforeach; ?> 
          <?php } ?>   
          </tbody>  
           </table>
            
                        
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
						iDisplayLength: -1
			});       
		 
   
   
   });
   
function change_status(list_id,status){
  
  swal({   title: "Are you sure?",   text: "Do you want to change status!",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, Change it!",   closeOnConfirm: false }, function(){ status_change(list_id,status);   });

}

  function status_change(list_id,status){ 
        $.ajax({   
				 type:'POST',
				 dataType:'json',
				 data:'list_id='+list_id+'&status='+status,
				 url:'<?php echo base_url();?>'+'index.php/custom_ajax/feedback_field_status_change',
				 success: function(data){
					if(data.status=="success"){
					     window.location.href = "<?php echo base_url();?>index.php/index/tablet_feedback_fields";	
						  							  
					}											
				}
		});
} 
   
   </script>