<style>
.mailbox-link span{ width:0px !important;}
.mailbox-summary{ left:0px !important;}
.list-view .summary{text-align:left !important;}
tr.mailbox-item > td > div{padding:4px 4px 15px !important;}
.msg-new .mailbox-subject a{text-align:left;}

</style>

<?php

$this->breadcrumbs=array('News'); ?>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top" id="port-left">
    
     <?php $this->renderPartial('/default/left_side');?>
    
    </td>
    <td valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" width="75%">
         <div class="cont_right formWrapper" style="padding:0px; width:753px;">
      <div id="parent_rightSect">
      <div class="parentright_innercon">
     <div class="mail_head">News<span>Important news shown here</span></div>
    <?php 

$lookahead = 30;
$upcoming = Batches::model()->getUpcomingOfferings($lookahead);

if(count($upcoming) > 0) {
?>
	 <h1 style="margin: 10px 10px 0">Offerings Beginning in the Next <?= $lookahead ?> Days</h1>
	<div style="width: 600px; margin: 0 auto">
	<?php
		foreach($upcoming as $key => $offering) { ?> 
			<div id="container-gauge-<?= $key ?>" style="width: 300px; height: 200px; float: left"></div> 
		<?php }
	?>
	</div>
	 
	<script type="text/javascript">
		$(function () {
			Highcharts.setOptions({
				chart: {
					type: 'solidgauge'
				},

				title: 'Upcoming Offerings',

				pane: {
					center: ['50%', '85%'],
					size: '100%',
					startAngle: -90,
					endAngle: 90,
					background: {
						backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
						innerRadius: '60%',
						outerRadius: '100%',
						shape: 'arc'
					}
				},

				tooltip: {
					enabled: false
				},

				// the value axis
				yAxis: {
					stops: [
						[0.5, '#DF5353'], // red
						[0.75, '#DDDF0D'], // yellow
						[0.9, '#55BF3B'], // green
						[1.0, '#5FCCFF']
					],
					lineWidth: 0,
					tickWidth: 0,
					title: {
						y: -65
					},
					labels: {
						y: 16
					}
				},

				plotOptions: {
					solidgauge: {
						dataLabels: {
							y: 18,
							borderWidth: 0,
							useHTML: true
						}
					}
				}
			});
		<?php
			foreach($upcoming as $key => $offering) { 
				$gaugeMax = (int)$offering->num_slots === 0 ? $offering->students : (int)$offering->num_slots;
		?>
				var chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container-gauge-<?= $key ?>',
						type: 'solidgauge',
						plotBorderColor: 'Red'
					},
					yAxis: {
						min: 0,
						max: <?= $gaugeMax ?>,
						title: {
							text: '<?= $offering->name ?>'
						},
						minorTickInterval: <?php echo ($gaugeMax / 10); ?>,
						tickInterval: <?= $gaugeMax ?>
					},

					credits: {
						enabled: false
					},

					series: [{
						name: 'students',
						data: [<?= $offering->students ?>],
						dataLabels: {
							format: '<div style="text-align:center"><span style="font-size:25px;color:' +
								((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '"><?= (int) $offering->num_slots - $offering->students ?></span><br/>' +
								   '<span style="font-size:12px;color:silver">opening<?php echo ((int) $offering->num_slots - $offering->students) === 1 ? '' : 's'; ?></span></div>'
						},
						tooltip: {
							valueSuffix: ' openings'
						}
					}]

				});

				// Bring life to the dials
				setTimeout(function () {
					// Speed
					var chart = $('#container-gauge-<?= $key ?>').highcharts(),
						point,
						newVal,
						inc;

					if (chart) {
						point = chart.series[0].points[0];
						inc = Math.round((Math.random() - 0.5) * 100);
						newVal = point.y + inc;

						if (newVal < 0 || newVal > <?= $offering->num_slots ?>) {
							newVal = point.y - inc;
						}

						point.update(newVal);
					}
				}, 2000);
		<?php 
			}
		?>
		});
	</script>
<?php
}
else {
	echo '<div class="mailbox-empty">No upcoming offerings.</div>';
}

echo '</div>';

?>
 
    </div>
    </div>
    <div class="clear"></div>
    </div>
</td>
        
      </tr>
    </table>
   
    </td>
  </tr>
</table>
<script type="text/javascript">
	function del()
{
	 var chks	=	$("[type='checkbox']");
	 var checked	=	false;
	for(var i=0; i<chks.length; i++){
		if(chks[i].checked){checked=true;}
	}
	if(checked==false){
		alert('No item selected');return false;
	}
	else{
		if(confirm('Are you sure ?')){
			return true;
		}
		else{
			return false;
		}
	}
	return true;
	
}
</script>
<script type="text/javascript">
$(".chkbox").change(function() {
    var val = $(this).val();
  if( $(this).is(":checked") ) {

    $(":checkbox[value='"+val+"']").attr("checked", true);
  }
    else {
        $(":checkbox[value='"+val+"']").attr("checked", false);
    }
});
</script>

