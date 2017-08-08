<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Create Segment</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form method="get" class="form-horizontal" name="create_segment" id="create_segment">
                                <div class="form-group"><label class="col-sm-2 control-label">Segment Name</label>

                                    <div class="col-sm-5"><input type="text" name="segment_name" id="segment_name" class="form-control">
                                     
                                     </div>
                                </div>
 
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-lg-2 control-label">Client</label>

                                    <div class="col-lg-5"><input type="text" disabled="" name="client_id" id="client_id" class="form-control" value="<?php $CI =& get_instance(); echo $CI->get_entity_name('clients',$client_id); ?>"> <input type="hidden" name="client_id" id="client_id" value="<?php echo $client_id; ?>" /></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Type</label>
                                    <div class="col-sm-5">
                                      <select class="form-control m-b" name="segment_type" id="segment_type">
                                        <option value="Normal">Normal</option>
                                        <option value="Restaurant">Restaurant</option>
                                        <option value="Source">Source</option>
                                      </select>
                                    </div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Listing</label>

                                    <div class="col-sm-10"><label class="checkbox-inline i-checks"> <input type="checkbox" value="1" name="listing" id="listing">Show in listing</label>
                                       </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" type="button" href="<?php echo base_url(); ?>index.php/index/segments">Cancel</a>
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
	  $('#create_segment').submit(function(e){
	        e.preventDefault();
			var segment = $('#segment_name').val();
			if(segment==''){
			  setTimeout(function() {
									toastr.options = {
										closeButton: true,
										progressBar: true,
										showMethod: 'slideDown',
										timeOut: 4000
									};
                                    toastr.error('Enter Segment Name');
                               }, 1300);		
		      return false;
			}
			$('.loadings').show();
			dataString = $('form[name=create_segment]').serialize();
			$.ajax({
					type:'POST',
					data:dataString,
					dataType:'json',
					url:'<?php echo base_url();?>'+'index.php/custom_ajax/create_segment',
					success:function(data) {
						  if (data.status=='success'){
							window.location.href = "<?php echo base_url();?>index.php/index/segments";			    				  
						  }
						  else{							        	  
							    $('.loadings').hide();		
						  }
					}
				  });
				
	  });
	});
</script>            