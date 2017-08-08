     

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

                        <h5>Segments</h5>
                        <a style="float:right;" href="<?php echo  base_url(); ?>index.php/index/create_segment">Create</a>
                       
                        <div class="ibox-content">
                    <div class="row"></div>
                    <div id="ip_messages">

          
            <table class="table table-striped table-bordered table-hover dataTables" id="datatable" >
            <thead>
				<tr>
                    <th>Segment</th>
                    <th>Client</th>
                    <th>Type</th>
                    <th>Listing Status</th>
				</tr>
		  </thead>
          <tbody>
          <?php if($segments){ ?>
			  <?php foreach($segments as $segment) :?>
              <tr>
              <td><a href="<?php  echo base_url(); ?>index.php/index/edit_segments?segment_id=<?php echo $segment['id'] ?>"><?php echo $segment['name']; ?></a></td>
              <td><?php $CI =& get_instance(); echo $CI->get_entity_name('clients',$segment['client_id']); ?> </td>
               <td><?php echo $segment['segment_type'] ?></td>
              <td><?php if($segment['listing']==1) echo "Listing"; else echo "Not Listing"; ?></td>
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
   </script>