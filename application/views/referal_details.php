<?php if($clients) : ?>
           
       <?php foreach($clients as $client) :?>
            <div class="special-head"><h3>Acquisition Share</h3></div>
          
            <?php if(is_array($client['referals'])) :?>
            <table class="table table-striped table-bordered table-hover" >
            	<thead>
						<tr><th colspan="<?php echo 12-(date('m')-2); ?>" class="prev_year center_align"><?php echo date('Y')-1; ?></th><th  class="current_year center_align" colspan="<?php echo date('m'); ?>"><?php echo date('Y'); ?></th></tr>
					
                    <tr>
                    <th>Acquisition</th>
                    <?php foreach($client['months'] as $dat=>$month):?>
					    <th class="center_align"><?php echo $month;?></th>
                   <?php endforeach;?>
                    </tr>
			 </thead>
           
            <tbody id="search_data">
				<?php if($client['referals']){ ?>
                  <?php foreach($client['referals'] as $refer ):?>
                    <tr class="gradeX">
					    <td><?php echo ucfirst($refer);?></td>
                        <?php foreach($client['months'] as $dat=>$month):?>
                       <?php $CI =& get_instance(); $referal_visitors =  $CI->getReferalVisitors($refer,$client['id'],$dat); ?>                      
                       <?php if($referal_visitors): ?>
                       <?php foreach($referal_visitors as $refers ): ?>
                        <td align="right"><?php echo round($refers->percent,2);?>%</td>
                        <?php endforeach;?> 
                       <?php endif;  ?> 
					   <?php if (!$referal_visitors): ?>
                         <td align="right">0</td>
                       <?php endif; ?>  
                       
                      <?php endforeach;?>  
				</tr>
                <?php endforeach;?>
                <?php } ?>   
                
                
            </tbody>
           </table>
            	
	       <?php else: ?>
           <table class="table table-striped table-bordered table-hover" >
	     		<tr class="gradeX"><td colspan="7"><?php echo 'No Data Found' ;?></td></tr>
           </table>
           <?php endif;?>
           
         <div id="chart_container_<?php echo $client['id'];?>"></div>
		 <script>   
            FusionCharts.ready(function () {
                var visitChart = new FusionCharts({
        
                type: 'line',        
                renderAt: 'chart_container_<?php echo $client['id'];?>',        
                width: '980',        
                height: '300',        
                dataFormat: 'json',        
                dataSource: {        
                    "chart": {        
                        "caption": "Visitors Chart",        
                        "subCaption": "",        
                        "xAxisName": "Month",        
                        "yAxisName": "Visitors",   
                        //Cosmetics
                        "lineThickness" : "2",        
                        "paletteColors" : "#0075c2",        
                        "baseFontColor" : "#333333",        
                        "baseFont" : "Helvetica Neue,Arial",        
                        "captionFontSize" : "14",        
                        "subcaptionFontSize" : "14",        
                        "subcaptionFontBold" : "0",        
                        "showBorder" : "0",        
                        "bgColor" : "#ffffff",        
                        "showShadow" : "0",        
                        "canvasBgColor" : "#ffffff",        
                        "canvasBorderAlpha" : "0",        
                        "divlineAlpha" : "100",        
                        "divlineColor" : "#999999",        
                        "divlineThickness" : "1",        
                        "divLineIsDashed" : "1",        
                        "divLineDashLen" : "1",        
                        "divLineGapLen" : "1",        
                        "showXAxisLine" : "1",        
                        "xAxisLineThickness" : "1",        
                        "xAxisLineColor" : "#999999",        
                        "showAlternateHGridColor" : "0",  
                    },        
                    "data": <?php echo json_encode($client['visitors']);?>,        
                    /*"trendlines": [        
                        {        
                            "line": [        
                                {        
                                    "startvalue": "18500",        
                                    "color": "#1aaf5d",        
                                    "displayvalue": "Average{br}visitors",        
                                    "valueOnRight" : "1",        
                                    "thickness" : "2"        
                                }        
                            ]        
                        }        
                    ]    */    
                }
        
            }); 
                visitChart.render();
            });	
        </script> 
	    <?php endforeach;?>	

<?php endif;?>