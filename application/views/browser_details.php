<?php if($clients) : ?>
           
       <?php foreach($clients as $client) :?>
            <div class="special-head"><h3>Browsers</h3></div>
          
            <?php if(is_array($client['browser_visitors'])) :?>
            <table class="table table-striped table-bordered table-hover" >
            	<thead>
						<tr><th colspan="<?php echo 12-(date('m')-2); ?>" class="prev_year center_align"><?php echo date('Y')-1; ?></th><th  class="current_year center_align" colspan="<?php echo date('m'); ?>"><?php echo date('Y'); ?></th></tr>
					
                    <tr>
                    <th>Browser</th>
                    <?php foreach($client['months'] as $dat=>$month):?>
					    <th class="center_align"><?php echo $month;?></th>
                   <?php endforeach;?>
                    </tr>
			 </thead>
           
            <tbody id="search_data">
				<?php if($client['browser_visitors']){ ?>
                  <?php foreach($client['browser_visitors'] as $browser ):?>
                    <tr class="gradeX">
					    <td><?php echo $browser;?></td>
                        <?php foreach($client['months'] as $dat=>$month):?>
                       <?php $CI =& get_instance(); $browser_visitors =  $CI->getBrowserVisitors($browser,$client['id'],$dat); ?>                     
                       <?php if($browser_visitors): ?>
                       <?php foreach($browser_visitors as $browsers ): ?>
                        <td align="right"><?php echo round($browsers->percent,2);?>%</td>
                        <?php endforeach;?> 
                       <?php endif;  ?> 
					   <?php if (!$browser_visitors): ?>
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
           
         <!--<div style="text-align:center;" id="chart_browser_container_<?php //echo $client['id'];?>"></div>-->
		<!-- <script>   
            FusionCharts.ready(function () {
    var revenueChart = new FusionCharts({
        type: 'doughnut2d',
        renderAt: 'chart_browser_container_<?php //echo $client['id'];?>',
        width: '450',
        height: '450',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "Browser Wise Visit",
                "subCaption": "Last Month",
                "numberPrefix": "%",
                "paletteColors": "#0075c2,#1aaf5d,#f2c500,#f45b00,#8e0000",
                "bgColor": "#ffffff",
                "showBorder": "0",
                "use3DLighting": "0",
                "showShadow": "0",
                "enableSmartLabels": "0",
                "startingAngle": "310",
                "showLabels": "0",
                "showPercentValues": "1",
                "showLegend": "1",
                "legendShadow": "0",
                "legendBorderAlpha": "0",
                "defaultCenterLabel": "",
                "centerLabel": "Visitors from $label: $value",
                "centerLabelBold": "1",
                "showTooltip": "0",
                "decimals": "0",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0"
            },
            "data": <?php //echo json_encode($client['last_month_browser_visitors']);?>
        }
    }).render();
});
        </script> -->
	    <?php endforeach;?>	

<?php endif;?>