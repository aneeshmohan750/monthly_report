  <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name"><img src="<?php echo $this->config->item('assets_url')?>img/pageLogo.png"></h1>

            </div>
            <h3></h3>
            <p>
                <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
            </p>
            <!--<p>Login in. To see it in action.</p>-->
            <form class="m-t" role="form" name="loginForm" id="loginform" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" required="" name="username" id="username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required="" name="password" id="password">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b" id="loginbtn">Login</button>

               <!-- <a href="#"><small>Forgot password?</small></a>-->
                 <label>
                                <input type="checkbox" name="remember_me"> Remember Me
                            </label>
                <!-- <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>-->
            </form>
            <p class="m-t"> <small>Techmart Solutions &copy; <?php echo date('Y'); ?> </small> </p>
        </div>
    </div>

 <!-- Ajax script login process -->

<script>
	$(document).ready(function(){
	   $("#username,#password").keyup(function(event){
          if(event.keyCode == 13){
            $("#loginform").submit();
          }
       }); 
	  $('#loginform').submit(function(e){
	        e.preventDefault();
			$('#loginbtn').text('Requesting......');
			dataString = $('form[name=loginForm]').serialize();
			$.ajax({
					type:'POST',
					data:dataString,
					dataType:'json',
					url:'<?php echo base_url();?>'+'index.php/custom_ajax/verifylogin',
					success:function(data) {
						  if (data.status=='success'){
							if(data.group_admin==1)  
							 window.location.href = "<?php echo base_url();?>index.php/index/segment_consolidation";
							else
							 window.location.href = "<?php echo base_url();?>"; 			    				  
						  }
						  else{							        	  
							    setTimeout(function() {
									toastr.options = {
										closeButton: true,
										progressBar: true,
										showMethod: 'slideDown',
										timeOut: 4000
									};
                                    toastr.error('Invalid Credentials');

                               }, 1300);	
							   $('#loginbtn').text('Login');					
						  }
					}
				  });
				
	  });
	});
</script>
  

