<div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Update Site Name</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <?php if($site_page){ ?>
                         <?php foreach($site_page as $site): ?>
                        <div class="ibox-content">
                            <form method="get" class="form-horizontal" name="update_site_page" id="update_site_page">
							    <input type="hidden" name="page_id" id="page_id" value="<?php echo $site['id']; ?>" />
                                <div class="form-group"><label class="col-sm-2 control-label">Page url</label>

                                    <div class="col-sm-5"><input type="text" disabled="" name="page_url" id="page_url" value="<?php echo $site['page_url']; ?>" class="form-control">
                                     
                                     </div>
                                </div>
                                <div class="hr-line-dashed"></div>
							    <div class="form-group"><label class="col-sm-2 control-label">Page Name</label>

                                    <div class="col-sm-5"><input type="text"  name="page_name" id="page_name" value="<?php echo $site['page_name']; ?>" class="form-control">
                                     
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
	  $('#update_site_page').submit(function(e){
	        e.preventDefault();
			$('.loadings').show();
			dataString = $('form[name=update_site_page]').serialize();
			$.ajax({
					type:'POST',
					data:dataString,
					dataType:'json',
					url:'<?php echo base_url();?>'+'index.php/custom_ajax/update_site_page',
					success:function(data) {
						  if (data.status=='success'){
							window.location.href = "<?php echo base_url();?>index.php/index/site_page_name";			    				  
						  }
						  else{							        	  
							    $('.loadings').hide();		
						  }
					}
				  });
				
	  });
	});
</script>            
