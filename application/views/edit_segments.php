<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Update Segment</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <?php if($segment_data){ ?>
                         <?php foreach($segment_data as $segment): ?>
                        <div class="ibox-content">
                            <form method="get" class="form-horizontal" name="update_segment" id="update_segment">
							    <input type="hidden" name="segment_id" id="segment_id" value="<?php echo $segment['id']; ?>" />
                                <div class="form-group"><label class="col-sm-2 control-label">Segment Name</label>

                                    <div class="col-sm-5"><input type="text" name="segment_name" id="segment_name" value="<?php echo $segment['name']; ?>" class="form-control">
                                     
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
                                        <option value="Normal" <?php if($segment['segment_type']=='Normal') echo 'selected="selected"'; ?>>Normal</option>
                                        <option value="Restaurant" <?php if($segment['segment_type']=='Restaurant') echo 'selected="selected"'; ?>>Restaurant</option>
                                        <option value="Source" <?php if($segment['segment_type']=='Source') echo 'selected="selected"'; ?>>Source</option>
                                      </select>
                                    </div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Listing</label>

                                    <div class="col-sm-10"><label class="checkbox-inline i-checks"> <input type="checkbox" value="1" name="listing" id="listing" <?php if($segment['listing']==1) echo 'checked="checked"'; ?> >Show in listing</label>
                                       </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a class="btn btn-white" type="button" href="<?php echo base_url(); ?>index.php/index/segments">Cancel</a>
                                        <button class="btn btn-primary" type="submit">Save Changes</button>
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
	  $('#update_segment').submit(function(e){
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
			dataString = $('form[name=update_segment]').serialize();
			$.ajax({
					type:'POST',
					data:dataString,
					dataType:'json',
					url:'<?php echo base_url();?>'+'index.php/custom_ajax/update_segment',
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