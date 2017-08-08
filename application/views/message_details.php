<?php if($clients) : ?>
           
       <?php foreach($clients as $client) :?>
	   <div class="ibox-content">
                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label for="start_date" class="control-label">Start Date</label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" 
                                                        value="<?php echo $this->input->post('start_date')?$this->input->post('start_date'):date('Y-m-01', strtotime("-30 days"));?>" class="form-control" id="start_date" name="start_date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label for="end_date" class="control-label">End Date</label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" value="<?php echo $this->input->post('end_date')?$this->input->post('end_date'):date('Y-m-t',strtotime("-30 days"));?>" class="form-control" id="end_date" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="pdt_25" style="margin-top:25px">
                                                <input type="button" class="btn btn-primary btnsearch" name="search_date" id="searchdate_<?php echo $client['id'] ?>" value="Search">
                                                
                                            </div>
                                        </div>
                                    </div>
                    <div id="ip_messages">
                    	
          
            <?php if(is_array($client['message'])) :?>
			<div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables" id="datatable_<?php $client['id']; ?>" >
            <thead>
				<tr>
                    <th><div  style="width:230px !important;">Subject</div></th>
                    <th><div  style="width:80px !important;">SendDate</div></th>
					<th>Sent</th>
					<th>Delivered</th>
					<th>Bounces </th>
					<th>Bounces % </th>
					<th>Removals</th>
					<th>Removals %</th>
					<th>Opens</th>
					<th>Opens %</th>
					<th>Reads</th>
					<th>Reads %</th>
					<th>Clicks</th>
					<th>Unique Clickers</th>
					<th>Unique Clickers %</th>
					<th>CTOR %</th>
				</tr>
			 </thead>
           
            <tbody id="search_data_<?php echo $client['id'] ?>">
	  		<?php foreach($client['message'] as $message_id=>$message) :?>
				<tr class="gradeX">
					<td ><?php echo $message['Subject'];?></td>
					<td><?php echo $message['SendDate'];?></td>
					<td><?php echo number_format($message['Sent']);?></td>
					<td align="right"><?php echo number_format($message['DeliverCount']);?></td>
					<td align="right"><?php echo number_format($message['BounceCount']);?></td>
					<td align="right"><?php echo (round($message['BouncePercent'],2));?>%</td>
					<td align="right"><?php echo number_format($message['RemoveCount']);?></td>
					<td align="right"><?php echo (round($message['RemovePercent'],2));?>%</td>
					<td align="right"><a class="clickOpenCount" href="javascript:void(0);" data-sendDate="<?php echo $message['SendDate']; ?>" data-client="<?php echo $client['id']; ?>" data-message="<?php echo $message['Subject'];?>" rel="<?php echo $message_id; ?>"><?php echo number_format($message['OpenCount']);?></a></td>
					<td align="right"><?php echo (round($message['OpenPercent'],2));?>%</td>
					<td align="right"><?php echo number_format($message['ReadCount']);?></td>
					<td align="right"><?php echo (round($message['ReadPercent'],2));?>%</td>
					<td align="right"><a class="clickCount" href="javascript:void(0);" data-client="<?php echo $client['id']; ?>" rel="<?php echo $message_id; ?>"><?php echo number_format($message['ClickCount']);?></a></td>
					<td align="right"><?php echo number_format($message['ClickerCount']);?></td>
					<td align="right"><?php echo (round($message['ClickerPercent'],2));?>%</td>
					<td align="right"><?php echo $message['Ctor'];?>%</td>
				</tr>
			<?php endforeach;?>
            </tbody>
           </table>
          </div>  	
	       <?php else: ?>
           <table class="table table-striped table-bordered table-hover" >
	     		<tr class="gradeX"><td colspan="7"><?php echo $client['message']?$client['message']:'No Data Found';?></td></tr>
           </table>
           <?php endif;?>
                        
                    </div>
                    
 

                   </div>
           
       
         
		
        
	    <?php endforeach;?>	

<?php endif;?>