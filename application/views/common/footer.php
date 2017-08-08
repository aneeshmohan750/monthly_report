  <div class="footer">
            <div>
                <strong>Copyright</strong> Techmart Solutions &copy; <?php echo date('Y'); ?>
            </div>
        </div>

        </div>
       
        </div>

     

 
    

    <!-- Custom and plugin javascript -->
    <script src="<?php echo $this->config->item('assets_url')?>js/inspinia.js"></script>
    <script src="<?php echo $this->config->item('assets_url')?>js/plugins/pace/pace.min.js"></script>

    

    <!-- GITTER -->
    <script src="<?php echo $this->config->item('assets_url')?>js/plugins/gritter/jquery.gritter.min.js"></script>

    <!-- Sparkline -->
    <script src="<?php echo $this->config->item('assets_url')?>js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="<?php echo $this->config->item('assets_url')?>js/demo/sparkline-demo.js"></script>

    <!-- ChartJS-->
    <script src="<?php echo $this->config->item('assets_url')?>js/plugins/chartJs/Chart.min.js"></script>

    <!-- Toastr -->
    <script src="<?php echo $this->config->item('assets_url')?>js/plugins/toastr/toastr.min.js"></script>


    <script>
        $(document).ready(function() {
			
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                toastr.success('<?php echo $name;  ?>', 'Welcome');

            }, 1300);
		
		    $("#preloader").fakeLoader({
                    bgColor:"#000000",
                    spinner:"spinner2",
            });  	
			

        });
    </script>
  <div id="preloader"></div>  
</body>


</html>
