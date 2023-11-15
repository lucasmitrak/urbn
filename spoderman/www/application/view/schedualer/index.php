<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link type="text/css" href='<?php echo Config::get('URL'); ?>css/fullcalendar.min.css' rel='stylesheet' />
<link type="text/css" href='<?php echo Config::get('URL'); ?>css/fullcalendar.print.css' rel='stylesheet' media='print' />
<link type="text/css" href='<?php echo Config::get('URL'); ?>css/scheduler.min.css' rel='stylesheet' />
<script type="text/javascript" src='<?php echo Config::get('URL'); ?>scripts/moment.min.js'></script>
<script type="text/javascript" src='<?php echo Config::get('URL'); ?>scripts/jquery.min.js'></script>
<script type="text/javascript" src='<?php echo Config::get('URL'); ?>scripts/fullcalendar.min.js'></script>
<script type="text/javascript" src='<?php echo Config::get('URL'); ?>scripts/scheduler.min.js'></script>
<script>

	$(function() { // document ready		
		$('#calendar').fullCalendar({
			schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
			timeFormat:'H(:mm)',
			editable: false,
			aspectRatio: 1.8,
			scrollTime: '00:00',
			header: {
				left: 'today prev,next',
				center: 'title',
				//larger timeline to smaller
				//right: 'timelineDay,timelineThreeDays,agendaWeek,month'
				right: 'month,agendaWeek,timelineDay'
			},
			//default to month
			defaultView: 'month',
			//do not need three days
			/*
			views: {
				timelineThreeDays: {
					type: 'timeline',
					duration: { days: 3 }
				}
	},
			 */
			resourceGroupField: 'building',
			resources: [
				{ id: 'a', building: 'DCC', title: 'Node 1', children: [
					{ id: 'a1', title: 'Macomb' },
					{ id: 'a2', title: 'Facebook' }, 
					{ id: 'a3', title: 'Crisnet' }, 
					{ id: 'a4', title: 'Oakland' }, 
					{ id: 'a5', title: 'Wayne' }, 
					{ id: 'a6', title: 'MIDC' }, 
				] },
				{ id: 'b', building: 'DCC', title: 'Node 2', children: [
					{ id: 'b1', title: 'Macomb' },
					{ id: 'b2', title: 'Facebook' }, 
					{ id: 'b3', title: 'Crisnet' }, 
					{ id: 'b4', title: 'Oakland' }, 
					{ id: 'b5', title: 'Wayne' }, 
					{ id: 'b6', title: 'MIDC' }, 
				] },
				{ id: 'c', building: 'DCC', title: 'Node 3', children: [
					{ id: 'c1', title: 'Macomb' },
					{ id: 'c2', title: 'Facebook' }, 
					{ id: 'c3', title: 'Crisnet' }, 
					{ id: 'c4', title: 'Oakland' }, 
					{ id: 'c5', title: 'Wayne' }, 
					{ id: 'c6', title: 'MIDC' }, 
				] },
				{ id: 'd', building: 'DCC', title: 'Node 4', children: [
					{ id: 'd1', title: 'Macomb' },
					{ id: 'd2', title: 'Facebook' }, 
					{ id: 'd3', title: 'Crisnet' }, 
					{ id: 'd4', title: 'Oakland' }, 
					{ id: 'd5', title: 'Wayne' }, 
					{ id: 'd6', title: 'MIDC' }, 
				] },
				{ id: 'e', building: 'DCC', title: 'Node 5', children: [
					{ id: 'e1', title: 'Macomb' },
					{ id: 'e2', title: 'Facebook' }, 
					{ id: 'e3', title: 'Crisnet' }, 
					{ id: 'e4', title: 'Oakland' }, 
					{ id: 'e5', title: 'Wayne' }, 
					{ id: 'e6', title: 'MIDC' }, 
				] },
				{ id: 'f', building: 'DCC', title: 'Node 6', children: [
					{ id: 'f1', title: 'Macomb' },
					{ id: 'f2', title: 'Facebook' }, 
					{ id: 'f3', title: 'Crisnet' }, 
					{ id: 'f4', title: 'Oakland' }, 
					{ id: 'f5', title: 'Wayne' }, 
					{ id: 'f6', title: 'MIDC' }, 
				] },
				{ id: 'g', building: 'DCC', title: 'Node 7', children: [
					{ id: 'g1', title: 'Macomb' },
					{ id: 'g2', title: 'Facebook' }, 
					{ id: 'g3', title: 'Crisnet' }, 
					{ id: 'g4', title: 'Oakland' }, 
					{ id: 'g5', title: 'Wayne' }, 
					{ id: 'g6', title: 'MIDC' }, 
				] },
				{ id: 'h', building: 'DCC', title: 'Node 8', children: [
					{ id: 'h1', title: 'Macomb' },
					{ id: 'h2', title: 'Facebook' }, 
					{ id: 'h3', title: 'Crisnet' }, 
					{ id: 'h4', title: 'Oakland' }, 
					{ id: 'h5', title: 'Wayne' }, 
					{ id: 'h6', title: 'MIDC' }, 
				] },
				{ id: 'i', building: 'DCC', title: 'Node 9', children: [
					{ id: 'i1', title: 'Macomb' },
					{ id: 'i2', title: 'Facebook' }, 
					{ id: 'i3', title: 'Crisnet' }, 
					{ id: 'i4', title: 'Oakland' }, 
					{ id: 'i5', title: 'Wayne' }, 
					{ id: 'i6', title: 'MIDC' }, 
				] },
				{ id: 'j', building: 'DCC', title: 'Node 10', children: [
					{ id: 'j1', title: 'Macomb' },
					{ id: 'j2', title: 'Facebook' }, 
					{ id: 'j3', title: 'Crisnet' }, 
					{ id: 'j4', title: 'Oakland' }, 
					{ id: 'j5', title: 'Wayne' }, 
					{ id: 'j6', title: 'MIDC' }, 
				] },
				{ id: 'k', building: 'DCC', title: 'Node 11', children: [
					{ id: 'k1', title: 'Macomb' },
					{ id: 'k2', title: 'Facebook' }, 
					{ id: 'k3', title: 'Crisnet' }, 
					{ id: 'k4', title: 'Oakland' }, 
					{ id: 'k5', title: 'Wayne' }, 
					{ id: 'k6', title: 'MIDC' }, 
				] },
				{ id: 'l', building: 'DCC', title: 'Node 12', children: [
					{ id: 'l1', title: 'Macomb' },
					{ id: 'l2', title: 'Facebook' }, 
					{ id: 'l3', title: 'Crisnet' }, 
					{ id: 'l4', title: 'Oakland' }, 
					{ id: 'l5', title: 'Wayne' }, 
					{ id: 'l6', title: 'MIDC' }, 
				] },
			],
			events: <?php echo json_encode($this->schedule, JSON_PRETTY_PRINT) ?>
		});
	
	});

</script>
<style>

	body {
		margin: 0;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {
		/*max-width: 900px;*/
		margin: 50px auto;
	}

</style>
</head>
<body>
	<div class="container-fluid">
		<div id='calendar'></div>
	</div>

</body>
</html>
