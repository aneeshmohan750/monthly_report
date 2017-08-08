     

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

                        <h5>Site Pages</h5>   
                       
                        <div class="ibox-content">
                    <div class="row"></div>
                    <div id="ip_messages">

          
            <table class="table table-striped table-bordered table-hover dataTables" id="datatable" >
            <thead>
				<tr>
                    <th>Site URL</th>
                    <th>Page Name</th>
				</tr>
		  </thead>
          <tbody>
          <?php if($page_map){ ?>
			  <?php foreach($page_map as $page) :?>
              <tr>
              <td><a href="<?php  echo base_url(); ?>index.php/index/edit_site_page?page_id=<?php echo $page['id']; ?>"><?php echo $page['page_url']; ?></a></td>
              <td><?php echo $page['page_name']; ?> </td>
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
						iDisplayLength: 50
			});       
		 
   
   
   });
   </script>