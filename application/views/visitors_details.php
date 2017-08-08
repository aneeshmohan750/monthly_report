<?php if($clients) : ?>
           
       <?php foreach($clients as $client) :?>
        
            <?php if(is_array($client['visitors'])) :?>
            <table class="table table-striped table-bordered table-hover" >
            	<thead>
					<tr><th colspan="<?php echo 12-(date('m')-2); ?>" class="prev_year center_align"><?php echo date('Y')-1; ?></th><th  class="current_year center_align" colspan="<?php echo date('m'); ?>"><?php echo date('Y'); ?></th></tr>
					
                    <tr>
                    <th>WEBSITE BASIC STATS</th>
                 
                    <?php foreach($client['months'] as $dat=>$month):?>
					    <th class="center_align"><?php echo $month;?></th>
                   <?php endforeach;?>
                        <th class="center_align"><?php echo date('M');?></th>
                    </tr>
			 </thead>
           
            <tbody id="search_data">
				<tr class="gradeX">
                <?php if($client['visitors']){ ?>
                <td>Visitors</td>
                 <?php foreach($client['visitors'] as $visitor):?>
					    <td align="right"><?php echo number_format($visitor->value);?></td>
                   <?php endforeach;?>
                <?php } ?>   
				</tr>
                <tr class="gradeX">
                 <?php if($client['visitors_per_day']){ ?>
                 <td>Visitors per day</td>
                 <?php foreach($client['visitors_per_day'] as $visitor_day):?>
					    <td align="right"><?php echo intval($visitor_day->value);?></td>
                   <?php endforeach;?>
                 <?php } ?>   
				</tr>
                <tr class="gradeX">
                 <?php if($client['page_views']){ ?>
                 <td>Page Views</td>
                 <?php foreach($client['page_views'] as $page_view):?>
					    <td align="right"><?php echo number_format(intval($page_view->value));?></td>
                   <?php endforeach;?>
                 <?php } ?>   
				</tr>
                 <tr class="gradeX">
                 <?php if($client['newVisit']){ ?>
                 <td>New Visitors(%)</td>
                 <?php foreach($client['newVisit'] as $page_view):?>
					    <td align="right"><?php echo intval($page_view->value);?></td>
                   <?php endforeach;?>
                 <?php } ?>   
				</tr>
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