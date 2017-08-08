<?php if($clients) : ?>
           
       <?php foreach($clients as $client) :?>

         <div  style="text-align:center;" id="chart_monthly_mail_container_<?php $client['id']; ?>"> </div>
		 
		 <script>     
  FusionCharts.ready(function () {
                var visitChart = new FusionCharts({
        
                type: 'line',        
                renderAt: 'chart_monthly_mail_container_<?php echo $client['id'];?>',        
                width: '980',        
                height: '300',        
                dataFormat: 'json',        
                dataSource: {        
                    "chart": {        
                        "caption": "Mail Listing Chart ",        
                        "subCaption": "",        
                        "xAxisName": "Month",        
                        "yAxisName": "Subscribed Contacts",   
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

/*FusionCharts.ready(function () {
    var cSatScoreChart = new FusionCharts({
        type: 'angulargauge',
        renderAt: 'chart-container67',
        width: '400',
        height: '300',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "Customer Satisfaction Score",
                "subcaption": "Last week",
                "lowerLimit": "0",
                "upperLimit": "100",
                "showGaugeBorder": "0",
                "showValue": "1",
                "valueBelowPivot": "1",
                "theme": "fint"
            },
            "colorRange": {
                "color": [
                    {
                        "minValue": "0",
                        "maxValue": "50",
                        "code": "#e44a00"
                    },
                    {
                        "minValue": "50",
                        "maxValue": "75",
                        "code": "#f8bd19"
                    },
                    {
                        "minValue": "75",
                        "maxValue": "100",
                        "code": "#6baa01"
                    }
                ]
            },
            "dials": {
                "dial": [{
                    "value": "67"
                }]
            }
        }
    }).render();
});*/
        </script> 
	   
 <?php endforeach;?>	

<?php endif;?>