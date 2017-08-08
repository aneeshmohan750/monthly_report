<?php if($clients) : ?>
           
       <?php foreach($clients as $client) :?>

         <div  style="text-align:center;" id="chart_monthly_visitor_container_<?php echo $client['id'];?>"> </div>
		 <script>   
FusionCharts.ready(function () {
    var cpuGauge = new FusionCharts({
        type: 'hlineargauge',
        renderAt: 'chart_monthly_visitor_container_<?php echo $client['id'];?>',
        id: 'monthly-visitor-gauge',
        width: '400',
        height: '190',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "theme": "fint",
                "caption": "Current Month Site Visitors",
                "subcaption": "<?php echo date('M-Y'); ?>",
                "lowerLimit": "0",
                "upperLimit": "35000",
                "numberSuffix": "",
                "chartBottomMargin": "40",  
                "valueFontSize": "11",  
                "valueFontBold": "0",
				"bgColor": "#ffffff",
				"showborder":"0"                 
            },
            "colorRange": {
                "color": [
                    {
                        "minValue": "0",
                        "maxValue": "10000",
                        "label": "Low",
                    }, 
                    {
                        "minValue": "10000",
                        "maxValue": "25000",
                        "label": "Moderate",
                    }, 
                    {
                        "minValue": "25000",
                        "maxValue": "35000",
                        "label": "High",
                    }
                ]
            },
            "pointers": {
                "pointer": [
                    {
                        "value": "<?php echo $client['visitors_count']; ?>"
                    }
                ]
            }
            
        }
    })
    .render();
});
        </script> 
	   
 <?php endforeach;?>	

<?php endif;?>