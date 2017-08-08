  <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
           
            <p>
                <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
            </p>
            <!--<p>Login in. To see it in action.</p>-->
            <form class="m-t" role="form" name="changepasswordForm" id="changepasswordForm" method="post">
			   <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Current Password" required="" name="current_password" id="current_password">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="New Password" required="" name="new_password" id="new_password">
                </div>
				 <div class="form-group">
                    <input type="password" class="form-control" placeholder="Confirm Password" required="" name="confirm_password" id="confirm_password">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b" id="changepasswordbtn">Change Password</button>

               <!-- <a href="#"><small>Forgot password?</small></a>-->
               <!-- <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>-->
            </form>
        </div>
    </div>

 <!-- Ajax script login process -->

<script>
	$(document).ready(function(){
	   $("#current_password,#new_password,confirm_password").keyup(function(event){
          if(event.keyCode == 13){
            $("#changepasswordForm").submit();
          }
       });
	    
	   $('#changepasswordForm').submit(function(e){
	        e.preventDefault();
			var password = $('#current_password').val();
			var new_password = $('#new_password').val();
			var confirm_password = $('#confirm_password').val();
			if(password=='' || new_password =='' || confirm_password==''){
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
			else if(new_password!=confirm_password){
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
			$('#changepasswordbtn').text('Requesting......');
			dataString = $('form[name=changepasswordForm]').serialize();
			$.ajax({
					type:'POST',
					data:dataString,
					dataType:'json',
					url:'<?php echo base_url();?>'+'index.php/custom_ajax/change_password',
					success:function(data) {
						  if (data.status=='success'){
							window.location.href = "<?php echo base_url();?>index.php/index/logout";			    				  
						  }
						  else{							        	  
							    setTimeout(function() {
									toastr.options = {
										closeButton: true,
										progressBar: true,
										showMethod: 'slideDown',
										timeOut: 4000
									};
                                    toastr.error('Current Password entered is wrong');

                               }, 1300);	
							   $('#changepasswordbtn').text('Change Password');					
						  }
					}
				  });
				
	  });
	});
</script>
  

