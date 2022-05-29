        </div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

<!-- BEGIN FOOTER -->
<div class="footer">
	<div class="footer-inner">
		 <?php echo date("Y"); ?> &copy; kasbook.com Time: {elapsed_time}. Memory: {memory_usage}
	</div>
	<div class="footer-tools">
		<span class="go-top">
		<i class="fa fa-angle-up"></i>
		</span>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<!-- BEGIN CORE PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script> -->
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!--
<script src="<?php echo base_url(); ?>assets/plugins/jquery.peity.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-knob/jquery.knob.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/flot/jquery.flot.resize.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/gritter/jquery.gritter.js" type="text/javascript"></script>

-->
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/js/additional-methods.min.js"></script>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>

<!-- DataTables JavaScript -->
<link href="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Buttons-1.5.1/css/buttons.bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.min.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Buttons-1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Buttons-1.5.1/js/buttons.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Buttons-1.5.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Buttons-1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Buttons-1.5.1/js/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Buttons-1.5.1/js/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Buttons-1.5.1/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/extensions/Buttons-1.5.1/js/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/datatables/extensions/dataTables.scroller.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>

<!--
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-editable/js/jquery.mockjax.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-editable/js/bootstrap-editable.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-editable/js/address.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-editable/js/wysihtml5.js"></script>
-->
<!-- END PAGE LEVEL PLUGINS -->
<script> var path = '<?php echo base_url(); ?>'; var lang = '<?php echo $langs; ?>';</script>


<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/custom.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/tasks.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/table-managed.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/table-advanced.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/products.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/customers.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/logs.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/transaction.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/reports.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/form-validation.js"></script>
<script src="<?php echo base_url(); ?>assets/scripts/calendar.js"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   var site_url = '<?php echo site_url($langs); ?>';
   var path = '<?php echo base_url(); ?>';
   var lang = '<?php echo $langs; ?>';
   
   // Display an info toast with no title
   //toastr.info('Are you the 6 fingered man?');

   App.init(); // initlayout and core plugins
   //Index.init();
   //FormEditable.init();
   Logs.init();
   Custom.init();
   FormValidation.init();
   TableAdvanced.init();
   Reports.init();
   Products.init();
   Transaction.init();
   Customers.init();
  
   Calendar.init();
   
});
</script>
<!-- END JAVASCRIPTS -->


<link href="<?php echo base_url(); ?>assets/css/print.css" rel="stylesheet" type="text/css" media="print"/>
<link href="<?php echo base_url(); ?>assets/css/pages/invoice.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/css/pages/profile.css" rel="stylesheet" type="text/css"/>

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css">
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">


<link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<!-- <link href="<?php echo base_url(); ?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"> -->

<link href="http://fonts.googleapis.com/earlyaccess/droidarabicnaskh.css" rel="stylesheet" type="text/css" />

<?php if($this->db->dbdriver !== 'sqlite3'){ ?>
<!-- BEGIN GLOBAL MANDATORY STYLES--> 
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="preload" rel="stylesheet" type="text/css">

<?php } ?>

<!-- END BODY -->
</body>
</html>