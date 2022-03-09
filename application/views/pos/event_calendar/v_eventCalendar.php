<link href="<?php echo base_url(); ?>assets/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/plugins/fullcalendar/fullcalendar.print.min.css" media='print' rel="stylesheet" type="text/css">
<script src='<?php echo base_url(); ?>assets/plugins/fullcalendar/lib/moment.min.js'></script>
<script src='<?php echo base_url(); ?>assets/plugins/fullcalendar/lib/jquery-ui.min.js'></script>
<script src="<?php echo base_url(); ?>assets/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>

<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<div class="portlet calendar">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-reorder"></i>Event Planner
				</div>
			</div>
			<div class="portlet-body light-grey">
				<div class="row">
                <!--
					<div class="col-md-3 col-sm-12">
						
						<h3 class="event-form-title">Draggable Events</h3>
						<div id="external-events">
							<form class="inline-form">
								<input type="text" value="" class="form-control" placeholder="Event Title..." id="event_title"/><br/>
								<a href="javascript:;" id="event_add" class="btn btn-success">Add Event</a>
							</form>
							<hr/>
							<div id="event_box">
							</div>
							<label for="drop-remove">
							<input type="checkbox" id="drop-remove"/>remove after drop </label>
							<hr class="visible-xs"/>
						</div>
						
					</div>
                    -->
					<div class="col-md-12 col-sm-12">
						<div id="calendar" class="has-toolbar">
						</div>
					</div>
				</div>
				<!-- END CALENDAR PORTLET-->
			</div>
		</div>
	</div>
</div>
<!-- END PAGE CONTENT-->