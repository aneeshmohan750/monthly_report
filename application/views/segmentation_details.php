<?php if($clients) : ?>
           
       <?php foreach($clients as $client) :?>
         <?php if($client['type']=='hotel'): ?>
	      <?php if($client['common_segments']) :?>
            <div class="special-head"><h3>Database Segmentation</h3></div>
          
            <?php if(is_array($client['common_segments'])) :?>
            <table class="table table-striped table-bordered table-hover" >
            	<thead>
					<tr><th  colspan="1">Segments</th><th class="prev_year center_align" colspan="<?php  if($client['id']==20 or $client['id']==2) echo 12-(date('m')); else  echo 12-(date('m')-1) ?>"><?php echo date('Y')-1; ?></th><th class="current_year center_align" colspan="<?php if($client['id']==20 or $client['id']==2) echo date('m'); else echo date('m')-1; ?>"><?php echo date('Y'); ?></th></tr>
					
                    <tr>
                    	<th></th>
                    <?php foreach($client['months'] as $dat=>$month):?>
					    <th class="center_align"><?php echo $month;?></th>
                   <?php endforeach;?>
                    </tr>
			 </thead>
           
            <tbody id="search_data">
				
                 <?php foreach($client['common_segments'] as $seg):?>
                 <tr class="gradeX">
                 	<td><?php echo $seg['name']; ?></td>
                 	<?php foreach($client['months'] as $dat=>$month):?>
                  		<td align="right"><?php $CI =& get_instance(); echo number_format($CI->getSegmentation($seg['id'],$client['id'],$dat)); ?></td>
                   <?php endforeach;?>
                </tr>
                <?php endforeach;?>
				</tr>
            </tbody>
           </table>
            	
	       <?php else: ?>
           <table class="table table-striped table-bordered table-hover" >
	     		<tr class="gradeX"><td colspan="7"><?php echo 'No Data Found' ;?></td></tr>
           </table>
           <?php endif;?>
           <?php endif;?>
          <?php endif;?>
	    <?php endforeach;?>	

<?php endif;?>




<?php if($clients) : ?>
           
       <?php foreach($clients as $client) :?>
	      <?php if($client['segments']) :?>
            <div class="special-head"><h3>Property Segments</h3></div>
          
            <?php if(is_array($client['segments'])) :?>
            <table class="table table-striped table-bordered table-hover" >
            	<thead>
					<tr><th  colspan="1">Segments</th><th class="prev_year center_align" colspan="<?php  if($client['id']==20 or $client['id']==2) echo 12-(date('m')); else  echo 12-(date('m')-1) ?>"><?php echo date('Y')-1; ?></th><th class="current_year center_align" colspan="<?php if($client['id']==20 or $client['id']==2) echo date('m'); else echo date('m')-1; ?>"><?php echo date('Y'); ?></th></tr>
					
                    <tr>
                    	<th></th>
                    <?php foreach($client['months'] as $dat=>$month):?>
					    <th class="center_align"><?php echo $month;?></th>
                   <?php endforeach;?>
                    </tr>
			 </thead>
           
            <tbody id="search_data">
				
                 <?php foreach($client['segments'] as $seg):?>
                 <tr class="gradeX">
                 	<td><?php echo $seg['name']; ?></td>
                 	<?php foreach($client['months'] as $dat=>$month):?>
                  		<td align="right"><?php $CI =& get_instance(); echo number_format($CI->getSegmentation($seg['id'],$client['id'],$dat)); ?></td>
                   <?php endforeach;?>
                </tr>
                <?php endforeach;?>
				</tr>
            </tbody>
           </table>
            	
	       <?php else: ?>
           <table class="table table-striped table-bordered table-hover" >
	     		<tr class="gradeX"><td colspan="7"><?php echo 'No Data Found' ;?></td></tr>
           </table>
           <?php endif;?>
           
         <?php endif;?>
	    <?php endforeach;?>	

<?php endif;?>



<?php if($clients) : ?>
           
       <?php foreach($clients as $client) :?>
	   <?php if($client['res_segments']) :?>
            <div class="special-head"><h3>Distribution by restaurants</h3></div>
          
            <?php if(is_array($client['res_segments'])) :?>
            <table class="table table-striped table-bordered table-hover" >
            	<thead>
					<tr><th  colspan="1">Segments</th><th class="prev_year center_align" colspan="<?php  if($client['id']==20 or $client['id']==2) echo 12-(date('m')); else  echo 12-(date('m')-1) ?>"><?php echo date('Y')-1; ?></th><th class="current_year center_align" colspan="<?php if($client['id']==20 or $client['id']==2) echo date('m'); else echo date('m')-1; ?>"><?php echo date('Y'); ?></th></tr>
					
                    <tr>
                    	<th></th>
                    <?php foreach($client['months'] as $dat=>$month):?>
					    <th class="center_align"><?php echo $month;?></th>
                   <?php endforeach;?>
                    </tr>
			 </thead>
           
            <tbody id="search_data">
				
                 <?php foreach($client['res_segments'] as $seg):?>
                 <tr class="gradeX">
                 	<td><?php echo $seg['name']; ?></td>
                 	<?php foreach($client['months'] as $dat=>$month):?>
                  		<td align="right"><?php $CI =& get_instance(); echo number_format($CI->getSegmentation($seg['id'],$client['id'],$dat)); ?></td>
                   <?php endforeach;?>
                </tr>
                <?php endforeach;?>
				</tr>
            </tbody>
           </table>
            	
	       <?php else: ?>
           <table class="table table-striped table-bordered table-hover" >
	     		<tr class="gradeX"><td colspan="7"><?php echo 'No Data Found' ;?></td></tr>
           </table>
           <?php endif;?>
          <?php endif;?> 
         
	    <?php endforeach;?>	

<?php endif;?>

<?php if($clients) : ?>
           
       <?php foreach($clients as $client) :?>
         <?php if($client['type']=='hotel'): ?>
	      <?php if($client['common_source_segments']) :?>
            <div class="special-head"><h3>Automated Sources</h3></div>
          
            <?php if(is_array($client['common_source_segments'])) :?>
            <table class="table table-striped table-bordered table-hover" >
            	<thead>
					<tr><th  colspan="1">Segments</th><th class="prev_year center_align" colspan="<?php  if($client['id']==20 or $client['id']==2) echo 12-(date('m')); else  echo 12-(date('m')-1) ?>"><?php echo date('Y')-1; ?></th><th class="current_year center_align" colspan="<?php if($client['id']==20 or $client['id']==2) echo date('m'); else echo date('m')-1; ?>"><?php echo date('Y'); ?></th></tr>
					
                    <tr>
                    	<th></th>
                    <?php foreach($client['months'] as $dat=>$month):?>
					    <th class="center_align"><?php echo $month;?></th>
                   <?php endforeach;?>
                    </tr>
			 </thead>
           
            <tbody id="search_data">
				
                 <?php foreach($client['common_source_segments'] as $seg):?>
                 <tr class="gradeX">
                 	<td><?php echo $seg['name']; ?></td>
                 	<?php foreach($client['months'] as $dat=>$month):?>
                  		<td align="right"><?php $CI =& get_instance(); echo number_format($CI->getSegmentation($seg['id'],$client['id'],$dat)); ?></td>
                   <?php endforeach;?>
                </tr>
                <?php endforeach;?>
				</tr>
            </tbody>
           </table>
            	
	       <?php else: ?>
           <table class="table table-striped table-bordered table-hover" >
	     		<tr class="gradeX"><td colspan="7"><?php echo 'No Data Found' ;?></td></tr>
           </table>
           <?php endif;?>
           <?php endif;?>
          <?php endif;?>
           <?php if($client['type']=='non-hotel'): ?>
           
	     <?php if($client['non_hotel_common_source_segments']) :?>
            <div class="special-head"><h3>Automated Sources</h3></div>
          
            <?php if(is_array($client['non_hotel_common_source_segments'])) :?>
            <table class="table table-striped table-bordered table-hover" >
            	<thead>
					<tr><th  colspan="1">Segments</th><th class="prev_year center_align" colspan="<?php  if($client['id']==20 or $client['id']==2) echo 12-(date('m')); else  echo 12-(date('m')-1) ?>"><?php echo date('Y')-1; ?></th><th class="current_year center_align" colspan="<?php if($client['id']==20 or $client['id']==2) echo date('m'); else echo date('m')-1; ?>"><?php echo date('Y'); ?></th></tr>
					
                    <tr>
                    	<th></th>
                    <?php foreach($client['months'] as $dat=>$month):?>
					    <th class="center_align"><?php echo $month;?></th>
                   <?php endforeach;?>
                    </tr>
			 </thead>
           
            <tbody id="search_data">
				
                 <?php foreach($client['non_hotel_common_source_segments'] as $seg):?>
                 <tr class="gradeX">
                 	<td><?php echo $seg['name']; ?></td>
                 	<?php foreach($client['months'] as $dat=>$month):?>
                  		<td align="right"><?php $CI =& get_instance(); echo number_format($CI->getSegmentation($seg['id'],$client['id'],$dat)); ?></td>
                   <?php endforeach;?>
                </tr>
                <?php endforeach;?>
				</tr>
            </tbody>
           </table>
            	
	       <?php else: ?>
           <table class="table table-striped table-bordered table-hover" >
	     		<tr class="gradeX"><td colspan="7"><?php echo 'No Data Found' ;?></td></tr>
           </table>
           <?php endif;?>
           <?php endif;?>
          <?php endif;?>
	    <?php endforeach;?>	

<?php endif;?>

<?php if($clients) : ?>
           
       <?php foreach($clients as $client) :?>
	   <?php if($client['source_segments']) :?>
            <div class="special-head"><h3>Property Sources</h3></div>
          
            <?php if(is_array($client['source_segments'])) :?>
            <table class="table table-striped table-bordered table-hover" >
            	<thead>
					<tr><th  colspan="1">Segments</th><th class="prev_year center_align" colspan="<?php  if($client['id']==20 or $client['id']==2) echo 12-(date('m')); else  echo 12-(date('m')-1) ?>"><?php echo date('Y')-1; ?></th><th class="current_year center_align" colspan="<?php if($client['id']==20 or $client['id']==2) echo date('m'); else echo date('m')-1; ?>"><?php echo date('Y'); ?></th></tr>
					
                    <tr>
                    	<th></th>
                    <?php foreach($client['months'] as $dat=>$month):?>
					    <th class="center_align"><?php echo $month;?></th>
                   <?php endforeach;?>
                    </tr>
			 </thead>
           
            <tbody id="search_data">
				
                 <?php foreach($client['source_segments'] as $seg):?>
                 <tr class="gradeX">
                 	<td><?php echo $seg['name']; ?></td>
                 	<?php foreach($client['months'] as $dat=>$month):?>
                  		<td align="right"><?php $CI =& get_instance(); echo number_format($CI->getSegmentation($seg['id'],$client['id'],$dat)); ?></td>
                   <?php endforeach;?>
                </tr>
                <?php endforeach;?>
				</tr>
            </tbody>
           </table>
            	
	       <?php else: ?>
           <table class="table table-striped table-bordered table-hover" >
	     		<tr class="gradeX"><td colspan="7"><?php echo 'No Data Found' ;?></td></tr>
           </table>
           <?php endif;?>
          <?php endif;?> 
         
	    <?php endforeach;?>	

<?php endif;?>
