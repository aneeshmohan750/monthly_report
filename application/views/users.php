     

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

                        <h5>Users</h5>
                        <a style="float:right;" href="<?php echo  base_url(); ?>index.php/index/create_user">Create</a>
                       
                        <div class="ibox-content">
                    <div class="row"></div>
                    <div id="ip_messages">

          
            <table class="table table-striped table-bordered table-hover dataTables" id="datatable" >
            <thead>
				<tr> 
                    <th>Username</th>
                    <th>First Name</th>
					<th>Last Name</th>                  
                    <th>Email</th> 
                    <th>Status</th>  
					<th>Action</th>                  
				</tr>
		  </thead>
          <tbody>
          <?php if($users){ ?>
			  <?php foreach($users as $user) :?>
              <tr>
              <td><a href="<?php  echo base_url(); ?>index.php/index/edit_users?user_id=<?php echo $user['id'] ?>"><?php echo $user['username']; ?></a></td>
              <td><?php echo $user['first_name']; ?></td>
              <td><?php echo $user['last_name']; ?></td>
              <td><?php echo $user['email']; ?></td>
              <td><?php if($user['status']==1) echo "Active"; else echo "Inactive"; ?></td>
			  <td><a href="javascript:void(0)" onClick="delete_confirm(<?php echo $user['id'] ?>)" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove">Delete</i></a></td>
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
						iDisplayLength: 10
			});       
		 
   
   
   });
   
function delete_confirm(user_id){
  
  swal({   title: "Are you sure?",   text: "Do you want to delete the user!",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, function(){ delete_user(user_id);   });

}

  function delete_user(user_id){ 
        $.ajax({   
				 type:'POST',
				 dataType:'json',
				 data:'enity_name=users&entity_id='+user_id,
				 url:'<?php echo base_url();?>'+'index.php/custom_ajax/delete_entity',
				 success: function(data){
					if(data.status=="success"){
					      $('#user_row_'+user_id).fadeOut(100); 
						  swal("Deleted!", "User has been deleted.", "success");
						  							  
					}											
				}
		});
} 
   
   </script>