<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Update User</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <?php if($user_data){ ?>
                         <?php foreach($user_data as $user): ?>
                        <div class="ibox-content">
                           <form method="get" class="form-horizontal" name="edit_user" id="edit_user">
						      <input type="hidden" name="user_id" id="user_id" value="<?php echo $user['id']; ?>" />
                                <div class="form-group"><label class="col-sm-2 control-label">First Name</label>

                                    <div class="col-sm-5"><input type="text" name="first_name" id="first_name" value="<?php echo $user['first_name']; ?>" class="form-control">
                                     
                                     </div>
                                </div>
 
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Last Name</label>

                                    <div class="col-sm-5"><input type="text" name="last_name" id="last_name" value="<?php echo $user['last_name']; ?>" class="form-control">
                                     
                                     </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Username</label>

                                    <div class="col-sm-5"><input type="text" name="username" disabled="" id="username" value="<?php echo $user['username']; ?>" class="form-control">
                                     
                                     </div>
                                </div>
                               
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-5"><input type="text" name="email" id="email" value="<?php echo $user['email']; ?>" class="form-control">
                                     
                                     </div>
                                </div>
                                <div class="form-group"><label class="col-lg-2 control-label">Client</label>

                                    <div class="col-lg-5"><input type="text" disabled="" name="client_id" id="client_id" class="form-control" value="<?php $CI =& get_instance(); echo $CI->get_entity_name('clients',$client_id); ?>"> <input type="hidden" name="client_id" id="client_id" value="<?php echo $client_id; ?>" /></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Is Admin</label>

                                    <div class="col-sm-10"><label class="checkbox-inline i-checks"> <input type="checkbox" value="1" name="admin_access" id="admin_access" <?php if($user['is_admin']==1) echo 'checked="checked"'; ?> >Yes</label>
                                       </div>
                                </div>
                                 <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Is Group Admin</label>

                                    <div class="col-sm-10"><label class="checkbox-inline i-checks"> <input type="checkbox" value="1" name="group_admin_access" id="group_admin_access" <?php if($user['is_group_admin']==1) echo 'checked="checked"'; ?> >Yes</label>
                                       </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                 <div class="form-group" id="allow_clients" <?php if($user['is_group_admin']==1) echo 'style="display:block;"'; else echo 'style="display:none;"';  ?>  ><label class="col-sm-2 control-label">Allowed Client</label>

                                    <div class="col-sm-5">
                                    <select  style="width:350px" data-placeholder="Choose clients..." class="chosen-client" multiple  name="allowed_client_id[]" >                                     <option value='-1'></option>
                                  
									<?php foreach($clients as $client): ?>
                                     <?php foreach($allowed_clients as $allow_client): ?> 
                                     <option value="<?php echo $client['id']; ?>"  ><?php echo $client['name']; ?></option>
                                    <?php endforeach; ?> 
                                   <?php endforeach; ?>  
                                    </select>
                                     
                                     </div>
                                </div>
                                <!--</div>-->
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" type="button" href="<?php echo base_url(); ?>index.php/index/users">Cancel</a>
                                        <button class="btn btn-primary" type="submit">Save</button>
                                    </div>
                                </div>
                            </form>
                           <?php endforeach; ?>
                          <?php } ?>  
                        </div>
                    </div>
                </div>
            </div>
<script>
	$(document).ready(function(){
	  
	  $('.chosen-client').chosen({});
	  
	  if($(this). prop("checked") == true){	 
		 
		    $('#allow_clients').show();
			$('.chosen-client').chosen({});
		 }
		 else{
			  $('#allow_clients').hide(); 
		 }
	 	
	  $('#edit_user').submit(function(e){
	        e.preventDefault();
			var first_name = $('#first_name').val();
			var username = $('#username').val();
			if(first_name=='' || username =='' ){
			  setTimeout(function() {
									toastr.options = {
										closeButton: true,
										progressBar: true,
										showMethod: 'slideDown',
										timeOut: 4000
									};
                                    toastr.error('Enter field Name');
                               }, 1300);		
		      return false;
			}
			$('.loadings').show();
			dataString = $('form[name=edit_user]').serialize();
			$.ajax({
					type:'POST',
					data:dataString,
					dataType:'json',
					url:'<?php echo base_url();?>'+'index.php/custom_ajax/update_user',
					success:function(data) {
						  if (data.status=='success'){
							window.location.href = "<?php echo base_url();?>index.php/index/users";			    				  
						  }
						  else{							        	  
							    $('.loadings').hide();		
						  }
					}
				  });
				
	  });
	});
</script>            