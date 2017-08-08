        <div class="loadings" style="display:none;"> <img src="<?php echo $this->config->item('assets_url')?>img/preloader.gif"><span>Processing your request...</span></div>
       <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>File upload</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li class="active">
                            <strong>File upload</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>File Upload</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
					    <div class="form-group"><label class="col-sm-2 control-label">Report Date</label>

                                    <div class="col-sm-5"><input type="text"  name="report_date" id="report_date" class="form-control calendar" />
                                       </div>
                                </div>
                        <div class="btn-group">
                                    <label title="Upload image file" for="inputImage" class="btn btn-primary">
                                        <input type="file"  name="file" id="inputImage" class="hide" />
                                        Select File
                                    </label>
									<input type="button"  name="upload_excel" id="upload_excel" class="btn btn-primary" value="Upload" />
                                    <input type="hidden" name="uploaded_file" id="uploaded_file" />
						</div>
						<div id="upload_success_message"></div>
						<div>
						<button name="validate_btn" id="validate_btn" class="btn btn-secondary" >Validate</button>
						<button name="import_btn" id="import_btn" class="btn btn-secondary" style="display:none;">Import</button>
						</div>  
                    </div>
                </div>
            </div>

<script>
$(document).ready(function(){
	$('#upload_excel').click(function() {
		var file_data = $('#inputImage').prop('files')[0];
		var ext = $('#inputImage').val().split('.').pop().toLowerCase();
		var file_name=$('#inputImage').val();
		if(file_name==''){
	      alert('Please Select file');
	      return false;
		}
		if(ext!='xlsx' && ext!='xls') {
			 alert('Invalid file')
			 return false;
		 }
		$('.loadings').show();     
		var form_data = new FormData();                  
		form_data.append('file', file_data);                           
		$.ajax({
				    url:'<?php echo base_url();?>'+'index.php/custom_ajax/upload_excel', // point to server-side PHP script 
					dataType: 'text',  // what to expect back from the PHP script, if anything
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,                         
					type: 'post',
					success: function(php_script_response){
						$('#uploaded_file').val(php_script_response);
						$('.loadings').hide();
						$('#upload_success_message').html('File Uploaded Successfully');
						$('#upload_success_message').show();     
					}
		 });
});

$('#validate_btn').on('click', function() {
      
	  var uploaded_file  = $('#uploaded_file').val();
	  if(uploaded_file==''){
	     alert('Please upload the file');
			 return false; 
	  }
	  $('.loadings').show();
	  $('.error_list').html('');
	  $('#upload_success_message').hide();
	 $.ajax({   
							type:'POST',
							data:'uploaded_file='+uploaded_file+'&client_id=<?php echo $client_id; ?>',
							dataType:'json',
							url:'<?php echo base_url();?>'+'index.php/custom_ajax/validate_excel_file',
							success: function(data){
								if(data.status=="success"){				
									 
									$('.loadings').hide();
									swal("Validated Successfully!", "Import file has been validated successfully.", "success");
									
									$("#excel_file").attr("disabled", "disabled");
									$("#upload_excel").attr("disabled", "disabled");      									
									$('#validate_btn').hide();
									$('#import_btn').show();
								}
								
								else if(data.status=="not_readable"){
								    $('.loadings').hide();
								    swal("File Not readable!", "Uploaded file is not readable, copy-paste the content in another new file and try again", "error");
								}		
								
								else{
								   $('.loadings').hide();
								   swal("Validation Error!", "Excel Format is incorrect beacuse of fields mismatch.", "error");
								}
													
							},
						  error: function(jqXHR, textStatus, errorThrown) {
							   swal("Error!", "Some Error occured while validating the file try again.", "error");
							   $('.loadings').hide();
                              console.log(textStatus, errorThrown);
                          }
					}); 
	  

 });
 
 $('#import_btn').on('click', function() {
      
	  var uploaded_file  = $('#uploaded_file').val();
	  var file_name      = $('#inputImage').val().split('\\').pop();
	  var report_date    = $('#report_date').val();  
	  $('.loadings').show();
	  $.ajax({   
							type:'POST',
							data:'uploaded_file='+uploaded_file+'&file_name='+file_name+'&client_id=<?php echo $client_id; ?>'+'&report_date='+report_date,
							dataType:'json',
							url:'<?php echo base_url();?>'+'index.php/custom_ajax/import_excel_file',
							success: function(data){
								if(data.status=="success"){												 
									$('.loadings').hide();
									swal("Imported Successfully!", "Import file has been  successfully uploaded.", "success");
									
								}								
								else{
								   $('.loadings').hide();
								   swal("Validation Error!", "Excel Format is incorrect beacuse of fields mismatch.", "error");
								}
													
							},
						  error: function(jqXHR, textStatus, errorThrown) {
							   swal("Error!", "Some Error occured while validating the file try again.", "error");
							   $('.loadings').hide();
                              console.log(textStatus, errorThrown);
                          }
					}); 
	  

 });
 
 $('.calendar').datepicker( {
    format: "mm-yyyy",
    viewMode: "months", 
    minViewMode: "months"
  });
  

});
</script>
