<?php 
/**
 * Ajax Crud Administration
 * ClassTimings * index.php view file
 * InfoWebSphere {@link http://libkal.gr/infowebsphere}
 * @author  Spiros Kabasakalis <kabasakalis@gmail.com>
 * @link http://reverbnation.com/spiroskabasakalis/
 * @copyright Copyright &copy; 2011-2012 Spiros Kabasakalis
 * @since 1.0
 * @ver 1.3
 * @license The MIT License
 */

 $this->breadcrumbs=array(
	 'Manage Class Timings'
);
 
 Yii::app()->clientScript->registerScript('delete-timing', "
	$('.x').click(function() {
		var r = confirm('Do you want to delete all time entries for ' + $(this).attr('day') + '?');
		
		if(r == true) {
			$('#day').val($(this).attr('day'));
			$('#action').val('delete');
			$('#timings-form').submit();
		}
	});
");
 
Yii::app()->clientScript->registerScript('timings', "
	$('#create-timings').click(function() {
		
	});
");

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('class-timings-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

function buildTimeTable($timings) { 
	$days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']; 
	$odd = true;
	
	foreach($days as $day) {
		echo "<tr class='" . ($odd ? 'odd' : 'even') . "'><td>$day</td>";
		$odd = !$odd;
		
		echoTimings($timings, $day, 'start_time');
		$count = echoTimings($timings, $day, 'end_time');
		
		echo "<td>" . ($count ? "<span class='x' day='$day'>&times;</span>" : "-") . "</td>";
		
		echo "</tr>";
	}
}

function echoTimings($timings, $day, $prop) 
{
	echo "<td>";
	
	$first = true;
	$count = 0;
	
	foreach($timings as $timing) {
		if(strtolower($timing->weekday) === strtolower($day)) {
			echo ($first ? '' : '<br>') . $timing->$prop;
			$count++;
			$first = false;
		}
	}
	
	echo ($first ? "-" : "") . "</td>";
	return $count;
}

$batch = Batches::model()->findByAttributes(['id' => $_REQUEST['id']]);
$timings = ClassTimings::model()->findAllByAttributes(['batch_id' => $batch->id]);

?>
<div style="background:#FFF;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    
    <td valign="top">
    <div style="padding:20px;">    
    
    <div class="clear"></div>
    <div class="emp_right_contner">
    <div class="emp_tabwrapper">
     <?php $this->renderPartial('/batches/tab');?>
        
    <div class="clear"></div>
    <div class="emp_cntntbx" style="padding-top:10px;">
	<?php $this->renderPartial('../weekdays/setDay', ['model' => Weekdays::model()]); ?>
    <div  align="right" style="position:relative;" >
    <div class="edit_bttns" style="width:110px; top:10px;">
    <ul>
    <li>
    <?php echo CHtml::link('<span>'.Yii::t('Timing','Time Table').'</span>', array('/courses/weekdays/timetable','id'=>$_REQUEST['id']),array('class'=>'addbttn last'));?>
    </li>
   
    </ul>
    <div class="clear"></div>
    </div>
    </div>
<div style="width:100%">

<div>
<h3><?php echo Yii::t('Timing','Class Timings');?></h3>
<div class="pdtab_Con">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'timings-form',
		'action' => $this->createUrl('delete'),
		'enableAjaxValidation'=>false,
	)); ?>
		<table class="custom" id="timings-table">
			<tr class="pdtab-h">
				<td>Day</td>
				<td>Start Time</td>
				<td>End Time</td>
				<td>Actions</td>
			</tr>
			<?php 
				buildTimeTable($timings);
			?>
		</table>
		<input type="hidden" id="day" name="day">
		<input type="hidden" id="batch_id" name="batch_id" value="<?= $batch->id ?>">
		<input type="hidden" id="action" name="action">
	<?php $this->endWidget(); ?>
</div>
   </div>
    </div>
    </div></div></div></div>
    </td>
  </tr>
</table>
</div>

<script type="text/javascript">
//document ready
$(function() {

    //declaring the function that will bind behaviors to the gridview buttons,
    //also applied after an ajax update of the gridview.(see 'afterAjaxUpdate' attribute of gridview).
        $. bind_crud= function(){
            
 //VIEW
//
//    $('.fan_view').each(function(index) {
//        var id = $(this).attr('href');
//        $(this).bind('click', function() {
//            $.ajax({
//                type: "POST",
//                url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=courses/classTiming/returnView",
//                data:{"id":id,"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
//                beforeSend : function() {
//                    $("#class-timings-grid").addClass("ajax-sending");
//                },
//                complete : function() {
//                    $("#class-timings-grid").removeClass("ajax-sending");
//                },
//                success: function(data) {
//                    $.fancybox(data,
//                            {    "transitionIn" : "elastic",
//                                "transitionOut" :"elastic",
//                                "speedIn"              : 600,
//                                "speedOut"         : 200,
//                                "overlayShow"  : false,
//                                "hideOnContentClick": false
//                            });//fancybox
//                    //  console.log(data);
//                } //success
//            });//ajax
//            return false;
//        });
//    });

// DELETE

    var deletes = new Array();
    var dialogs = new Array();
    $('.fan_del').each(function(index) {
        var id = $(this).attr('href');
        deletes[id] = function() {
            $.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=courses/classTiming/ajax_delete",
                data:{"id":id,"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
                    beforeSend : function() {
                    $("#class-timings-grid").addClass("ajax-sending");
                },
                complete : function() {
                    $("#class-timings-grid").removeClass("ajax-sending");
                },
                success: function(data) {
                    var res = jQuery.parseJSON(data);
                     var page=$("li.selected  > a").text();
                    $.fn.yiiGridView.update('class-timings-grid', {url:'<?php echo Yii::app()->request->getUrl()?>',data:{"ClassTimings_page":page}});
                }//success
            });//ajax
        };//end of deletes

        dialogs[id] =
                        $('<div style="text-align:center;"></div>')
                        .html('<?php echo  $del_con; ?>')
                       .dialog(
                        {
                            autoOpen: false,
                            title: '<?php echo  $del_title; ?>',
                            modal:true,
                            resizable:false,
                            buttons: [
                                {
                                    text: "<?php echo  $del; ?>",
                                    click: function() {
                                                                      deletes[id]();
                                                                      $(this).dialog("close");
                                                                      }
                                },
                                {
                                   text: "<?php echo $cancel; ?>",
                                   click: function() {
                                                                     $(this).dialog("close");
                                                                     }
                                }
                            ]
                        }
                );

        $(this).bind('click', function() {
                                                                      dialogs[id].dialog('open');
                                                                       // prevent the default action, e.g., following a link
                                                                      return false;
                                                                     });
    });//each end

        }//bind_crud end

   //apply   $. bind_crud();
  $. bind_crud();


//CREATE 

////    $('#add_class-timings ').bind('click', function() {
//    $('#create-timings ').bind('click', function() {
//
//        $.ajax({
//            type: "POST",
//            url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=courses/classTiming/returnForm",
//            data:{"batch_id":<?php echo $_GET['id'];?>,"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
//                beforeSend : function() {
//                    $("#class-timings-grid").addClass("ajax-sending");
//                },
//                complete : function() {
//                    $("#class-timings-grid").removeClass("ajax-sending");
//                },
//            success: function(data) {
//                $.fancybox(data,
//                        {    "transitionIn"      : "elastic",
//                            "transitionOut"   : "elastic",
//                            "speedIn"                : 600,
//                            "speedOut"            : 200,
//                            "overlayShow"     : false,
//                            "hideOnContentClick": false,
//                            "afterClose":    function() {
//								window.location.reload();
//								} //onclosed function
//                        });//fancybox
//            } //success
//        });//ajax
//        return false;
//    });//bind


})//document ready
    
</script>
