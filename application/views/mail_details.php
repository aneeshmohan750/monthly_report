<?php if($clients) : ?>
           
       <?php foreach($clients as $client) :?>
           
            <?php if(is_array($client['mails'])) :?>
            <table class="table table-striped table-bordered table-hover" >
            	<thead>
					<tr><th colspan="<?php echo 12-(date('m')-1); ?>" class="prev_year center_align"><?php echo date('Y')-1; ?></th><th  class="current_year center_align" colspan="<?php echo date('m')-1; ?>"><?php echo date('Y'); ?></th></tr>
					
                    <tr>
                    <?php foreach($client['months'] as $month):?>
					    <th class="center_align"><?php echo $month;?></th>
                   <?php endforeach;?>
                    </tr>
			 </thead>
           
            <tbody id="search_data">
				<tr class="gradeX">
                 <?php foreach($client['mails'] as $mail):?>
					    <td align="right"><?php echo number_format($mail['value']);?></td>
                   <?php endforeach;?>
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
                        "caption": "Mail Listing Chart",        
                        "subCaption": "",        
                        "xAxisName": "Month",        
                        "yAxisName": "Subscribed Contacts",   
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
                    "data": <?php echo json_encode($client['mails']);?>,        
                    "trendlines": [        
                        {        
                            "line": [        
                                {        
                                    "startvalue": "18500",        
                                    "color": "#1aaf5d",        
                                    "displayvalue": "Average{br}subscribed{br}contacts",        
                                    "valueOnRight" : "1",        
                                    "thickness" : "2"        
                                }        
                            ]        
                        }        
                    ]        
                }
        
            }); 
                visitChart.render();
            });	
        </script> 
	    <?php endforeach;?>	

<?php endif;?>
