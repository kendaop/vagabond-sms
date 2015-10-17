<?php
$formatNameAndGender = function($obj) {
	$obj->name = "$obj->first_name $obj->last_name";
	
	switch($obj->gender) {
		case 'M':
			$obj->gender = 'Male';
			break;
		case 'F':
			$obj->gender = 'Female';
			break;
		default:
			$obj->gender = '-';
			break;
	}
	return $obj;
};

$this->breadcrumbs=array(
	'Batches'=>array('/courses'),
	'Batches',
);
?>
<?php Yii::app()->clientScript->registerCoreScript('jquery');

         //IMPORTANT about Fancybox.You can use the newest 2.0 version or the old one
        //If you use the new one,as below,you can use it for free only for your personal non-commercial site.For more info see
		//If you decide to switch back to fancybox 1 you must do a search and replace in index view file for "beforeClose" and replace with 
		//"onClosed"
        // http://fancyapps.com/fancybox/#license
          // FancyBox2
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js_plugins/fancybox2/jquery.fancybox.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js_plugins/fancybox2/jquery.fancybox.css', 'screen');
         // FancyBox
         //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/fancybox/jquery.fancybox-1.3.4.js', CClientScript::POS_HEAD);
         // Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js_plugins/fancybox/jquery.fancybox-1.3.4.css','screen');
        //JQueryUI (for delete confirmation  dialog)
         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/jqui1812/js/jquery-ui-1.8.12.custom.min.js', CClientScript::POS_HEAD);
         Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js_plugins/jqui1812/css/dark-hive/jquery-ui-1.8.12.custom.css','screen');
          ///JSON2JS
         Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/json2/json2.js');
       

           //jqueryform js
               Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/ajaxform/jquery.form.js', CClientScript::POS_HEAD);
              Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js_plugins/ajaxform/form_ajax_binding.js', CClientScript::POS_HEAD);
              Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/js_plugins/ajaxform/client_val_form.css','screen');  ?>
              <?php
Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".info").animate({opacity: 1.0}, 3000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>


<?php $batch=Batches::model()->findByAttributes(array('id'=>$_REQUEST['id'])); ?>
          
<div style="background:#FFF;">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tbody><tr>
   
    <td valign="top">
	<?php if($batch!=NULL)
		   {
			   ?>
    <div style="padding:20px;">
    <div class="clear"></div>
    <div class="emp_right_contner">
    <div class="emp_tabwrapper">
     <?php $this->renderPartial('tab');?>
    
    <div class="clear"></div>
    <div class="emp_cntntbx" style="padding-top:10px;">
    <div class="c_subbutCon" align="right" style="width:100%; height:40px; position:relative">
    <div class="edit_bttns" style="top:0px; right:-6px">
    <div class="clear"></div>
    </div>
    </div>
    <?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="info" style="background-color:#C30; width:800px; height:30px">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
    <?php endif; ?>
	<div class="tablesorter-container" id="enrolled">
		<h4>Enrolled Students</h4>
     <?php
		if(isset($_REQUEST['id']))
		{
			$posts = $batch->students;
			
			if($posts!=NULL)
			{
				foreach($posts as $student) {
					$student = $formatNameAndGender($student);
					$student->name = "<a href='" . Yii::app()->createUrl('/students/students/view', ['id' => $student->id]) ."' class='tablesorter-link'>$student->name</a>";
					
					$student->actions = "<a class='unenroll no-decoration' href='" . $this->createUrl('students/delete', [
						'student_id'	=> $student->id,
						'batch_id'		=> $batch->id
					]) . "'><span class='red_x'></span></a>";
				}
				
				$this->widget('application.extensions.tablesorter.Sorter', array(
					'data' => $posts,
					'columns' => [
						[
							'header' => 'ID',
							'value'  => 'id'
						],
						'name',
						'gender',
						'actions'
					],
					'filters' => [
						'',
						'',
						'filter-select',
						'filter-false'
					],
					'buttons' => [
						[
							'action' => 'disable',
							'edit' => 'disable'
						]
					]
				));
 	
		}
		else
		{
			echo '<br><div class="notifications nt_red" style="padding-top:10px">'.'<i>'.Yii::t('Batch','No Active Students In This Batch').'</i></div>'; 

		}

		}
		?> 
    </div>
    <br />
    
    </div>
    </div>
	<div class="tablesorter-container" id="unenrolled">
    <h4>Add Students</h4>
<?php
	$unenrolledStudents = Students::model()->getUnenrolledStudents($batch->id);

	foreach($unenrolledStudents as $student) {
		$student = $formatNameAndGender($student);
		$student->name = "<a href='" . Yii::app()->createUrl('/students/students/view', ['id' => $student->id]) ."' class='tablesorter-link'>$student->name</a>";
		
		$student->actions = "<a class='enroll' href='" . Yii::app()->createUrl('students/students/enroll', [
			'student_id'	=> $student->id,
			'batch_id'		=> $batch->id
		]) . "'><div class='add_student_btn'></div></a>";
	}

	$this->widget('application.extensions.tablesorter.Sorter', array(
		'data' => $unenrolledStudents,
		'columns' => [
			[
				'header' => 'ID',
				'value'  => 'id'
			],
			'name',
			'gender',
			'actions'
		],
		'filters' => [
			'',
			'',
			'filter-select',
			'filter-false'
		],
		'buttons' => [
			[
				'action'	=> 'disable',
				'delete'	=> 'disable'
			]
		]
	));
?>
	</div>
    </div>
    </div>
     <?php    	
                }
				else
				{
					 echo '<div class="emp_right" style="padding-left:20px; padding-top:50px;">';
					 echo '<div class="notifications nt_red">'.'<i>'.Yii::t('Batch','Nothing Found!!').'</i></div>'; 
					 echo '</div>';
					
				}
                ?>
    </td>
  </tr>
</tbody></table>
</div>


<script>
	//CREATE 
    $('.addevnt').bind('click', function() {var id = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->request->baseUrl;?>/index.php?r=students/studentLeave/returnForm",
            data:{"id":id,"YII_CSRF_TOKEN":"<?php echo Yii::app()->request->csrfToken;?>"},
                beforeSend : function() {
                    $("#"+$(this).attr('name')).addClass("ajax-sending");
                },
                complete : function() {
                    $("#"+$(this).attr('name')).removeClass("ajax-sending");
                },
            success: function(data) {
                $.fancybox(data,
                        {    "transitionIn"      : "elastic",
                            "transitionOut"   : "elastic",
                            "speedIn"                : 600,
                            "speedOut"            : 200,
                            "overlayShow"     : false,
                            "hideOnContentClick": false,
                            "afterClose":    function() {window.location.reload();} //onclosed function
                        });//fancybox
            } //success
        });//ajax
        return false;
    });//bind

	$(document).ready(function() {
		$('a.unenroll').click(function(e) {
			var url = $(this).attr('href');
			var confirmed = confirm("Are you sure you want to unenroll this student?");
			
			if(!confirmed) {
				e.preventDefault();
			}
		});
	});
</script>
               



