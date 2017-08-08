<?php if($clients) : ?>
           
       <?php foreach($clients as $client) :?>
            <div class="special-head"><h3>Top Countries</h3></div>
          
            <?php if(is_array($client['country_visitors'])) :?>
            <table class="table table-striped table-bordered table-hover" >
            	<thead>
						<tr><th colspan="<?php echo 12-(date('m')-2); ?>" class="prev_year center_align"><?php echo date('Y')-1; ?></th><th  class="current_year center_align" colspan="<?php echo date('m'); ?>"><?php echo date('Y'); ?></th></tr>
					
                    <tr>
                    <th>Position</th>
                    <?php foreach($client['months'] as $dat=>$month):?>
					    <th class="center_align"><?php echo $month;?></th>
                   <?php endforeach;?>
                    </tr>
			 </thead>
           
            <tbody id="search_data">
				<?php if($client['country_visitors']){ ?>
                  <?php for($i=0;$i<6;$i++){ ?>
                    <tr class="gradeX">
                        <td align="right"><?php echo $i+1; ?>
					    <?php foreach($client['months'] as $dat=>$month):?>  
                        <?php $CI =&get_instance(); $country=$CI->getCountryVisitor($client['id'],$dat,$i); ?>                     
                         <td> <?php echo $country;  ?> </td>
                        <?php endforeach; ?>          
				    </tr>
                    <?php } ?>
                <?php } ?>   
                
               
            </tbody>
           </table>
            	
	       <?php else: ?>
           <table class="table table-striped table-bordered table-hover" >
	     		<tr class="gradeX"><td colspan="7"><?php echo 'No Data Found' ;?></td></tr>
           </table>
           <?php endif;?>
           
         <div id="chart_container_country_<?php echo $client['id'];?>"></div>
		 <script>   
           FusionCharts.ready(function () {
    var revenueChart = new FusionCharts({
        type: 'column3d',
       renderAt: 'chart_container_country_<?php echo $client['id'];?>',        
        width: '980',
        height: '300',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "Top Countries Visit From Last Month",
                "subCaption": "",
                "xAxisName": "Country",
                "yAxisName": "Visitors(%)",
                "paletteColors": "#0075c2",
                "valueFontColor": "#0000",
                "baseFont": "Helvetica Neue,Arial",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "placeValuesInside": "1",
                "rotateValues": "1",
                "showShadow": "0",
                "divlineColor": "#999999",               
                "divLineIsDashed": "1",
                "divlineThickness": "1",
                "divLineDashLen": "1",
                "divLineGapLen": "1",
                "canvasBgColor": "#ffffff"
            },

            "data": <?php echo json_encode($client['last_month_country_visitors']);?>,        
            
        }
    });
    revenueChart.render();
});
        </script> 
	    <?php endforeach;?>	

<?php endif;?>