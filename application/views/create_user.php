<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Create Users</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form method="get" class="form-horizontal" name="create_user" id="create_user">
                                <div class="form-group"><label class="col-sm-2 control-label">First Name</label>

                                    <div class="col-sm-5"><input type="text" name="first_name" id="first_name" class="form-control">
                                     
                                     </div>
                                </div>
 
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Last Name</label>

                                    <div class="col-sm-5"><input type="text" name="last_name" id="last_name" class="form-control">
                                     
                                     </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Username</label>

                                    <div class="col-sm-5"><input type="text" name="username" id="username" class="form-control">
                                     
                                     </div>
                                </div>
                                 <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Password</label>

                                    <div class="col-sm-5"><input type="password" name="password" id="password" class="form-control">
                                     
                                     </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Confirm Password</label>

                                    <div class="col-sm-5"><input type="password" name="confirm_password" id="confirm_password" class="form-control">
                                     
                                     </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Email</label>

                                    <div class="col-sm-5"><input type="text" name="email" id="email" class="form-control">
                                     
                                     </div>
                                </div>
                                <div class="form-group"><label class="col-lg-2 control-label">Client</label>

                                    <div class="col-lg-5"><input type="text" disabled="" name="client_id" id="client_id" class="form-control" value="<?php $CI =& get_instance(); echo $CI->get_entity_name('clients',$client_id); ?>"> <input type="hidden" name="client_id" id="client_id" value="<?php echo $client_id; ?>" /></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Is Admin</label>

                                    <div class="col-sm-10"><label class="checkbox-inline i-checks"> <input type="checkbox" value="1" name="admin_access" id="admin_access">Yes</label>
                                       </div>
                                </div>
                                 <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Is Group admin</label>

                                    <div class="col-sm-10"><label class="checkbox-inline i-checks"> <input type="checkbox" value="1" name="group_admin_access" id="group_admin_access">Yes</label>
                                       </div>
                                </div>
                               <div class="hr-line-dashed"></div>
                                <div class="form-group" id="allow_clients" style="display:none;"><label class="col-sm-2 control-label">Allowed Client</label>

                                    <div class="col-sm-5">
                                    <select  style="width:350px" data-placeholder="Choose clients..." class="chosen-client" multiple  name="allowed_client_id[]" >                                     <option value='-1'></option>
                                    <?php foreach($clients as $client): ?>
                                     <option value="<?php echo $client['id']; ?>"><?php echo $client['name']; ?></option>
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
                        </div>
                    </div>
                </div>
            </div>
<script>
	$(document).ready(function(){
	  
	  $('#group_admin_access').click(function(){
		 
		 if($(this). prop("checked") == true){	 
		 
		    $('#allow_clients').show();
			$('.chosen-client').chosen({});
		 }
		 else{
			  $('#allow_clients').hide(); 
		 }
		  	 
		  
	  });
	  $('#create_user').submit(function(e){
	        e.preventDefault();
			var first_name = $('#first_name').val();
			var username = $('#username').val();
			var password = $('#password').val();
			var confirm_password = $('#confirm_password').val();
			if(first_name=='' || username =='' || password=='' || confirm_password==''){
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
			else if(password!=confirm_password){
			    setTimeout(function() {
									toastr.options = {
										closeButton: true,
										progressBar: true,
										showMethod: 'slideDown',
										timeOut: 4000
									};
                                    toastr.error('Password Mismatch');
                               }, 1300);		
		        return false;					
			}
			$('.loadings').show();
			dataString = $('form[name=create_user]').serialize();
			$.ajax({
					type:'POST',
					data:dataString,
					dataType:'json',
					url:'<?php echo base_url();?>'+'index.php/custom_ajax/create_user',
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