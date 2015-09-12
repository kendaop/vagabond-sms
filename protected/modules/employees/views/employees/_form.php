<?php
Yii::app()->clientScript->registerScript('offeringButtons', '
	$("button#addBatch").click(function(event) {
		event.preventDefault();
		
		$("#offerings-available option:selected").each(function() {
			$("#offerings-teach").append($("<option/>", {
				value: $(this).val(),
				text:  $(this).text()
			}));
			
			value = $("#new-teachings").val();
			value = value ? (value + "," + $(this).val()) : $(this).val();
			$("#new-teachings").val(value);
			
			$(this).remove();
		});
	});
		$("button#removeBatch").click(function(event) {
		event.preventDefault();
		$("#offerings-teach option:selected").each(function() {
			$("#offerings-available").append($("<option/>", {
				value: $(this).val(),
				text:  $(this).text()
			}));
			
			value = $("#new-teachings").val();
			value = value.replace($(this).val(), "");
			value = value.replace(/^,|,,|,$/g, "");
			$("#new-teachings").val(value);
			
			$(this).remove();
		});
	});
', CClientScript::POS_READY);

if (Yii::app()->controller->action->id == 'create') {
	$config = Configurations::model()->findByPk(7);
	$adm_no = '';
	$adm_date = date('m/d/Y');
	$dob = '';
	if ($config->config_value == 1) {
		$adm_no = Employees::model()->findAll(array('order' => 'id DESC', 'limit' => 1));
	}
	?>
<div class="captionWrapper">
	<ul>
		<li><h2  class="cur">Teacher Details</h2></li>
	</ul>
</div>
	<?php
} else {
	echo '<br><br>';
	$adm_no = Employees::model()->findByAttributes(array('id' => $_REQUEST['id']));
	$adm_date = DateTime::createFromFormat('Y-m-d', $adm_no->joining_date);
	$adm_date = $adm_date->format('m/d/Y');
	$dob = DateTime::createFromFormat('Y-m-d', $adm_no->date_of_birth);
	$dob = $dob->format('m/d/Y');
}

$untaughtBatches = Batches::model()->getUntaughtBatches($adm_no->id);
$taughtBatches = Batches::model()->getTaughtBatches($adm_no->id);
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
	'id' => 'employees-form',
	'enableAjaxValidation' => false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
		));
?>

<?php
if ($form->errorSummary($model)) {
	;
	?>

	<div class="errorSummary">Input Error<br />
		<span>Please fix the following error(s).</span>
	</div>

<?php } ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>
<div class="formCon" style="background:#fcf1d4; width:100%; border:0px #fac94a solid; color:#000;background:url(images/yellow-pattern.png); width:100%; border:0p ">

	<div class="formConInner" style="padding:5px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					<?php
					$emp_id_1 = '';
					if (Yii::app()->controller->action->id == 'create') {
						$emp_id = Employees::model()->findAll(array('order' => 'id DESC', 'limit' => 1));
						$emp_id_1 = 'E' . ($emp_id[0]['id'] + 1);
					} else {
						$emp_id = Employees::model()->findByAttributes(array('id' => $_REQUEST['id']));
						$emp_id_1 = $emp_id->employee_number;
					}
					?>
					<?php echo $form->labelEx($model, Yii::t('employees', 'employee_number')); ?></td>
				<td><?php echo $form->textField($model, 'employee_number', array('readonly' => true, 'size' => 20, 'maxlength' => 255, 'value' => $emp_id_1)); ?>
					<?php echo $form->error($model, 'employee_number'); ?></td>

				<td><?php echo $form->labelEx($model, Yii::t('employees', 'joining_date')); ?></td>
				<td><?php
					$settings = UserSettings::model()->findByAttributes(array('user_id' => Yii::app()->user->id));
					if ($settings != NULL) {
						$date = $settings->dateformat;
					} else
						$date = 'mm-dd-yy';
					//echo $form->textField($model,'joining_date',array('size'=>30,'maxlength'=>255));
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						//'name'=>'Employees[joining_date]',
						'attribute' => 'joining_date',
						'model' => $model,
						// additional javascript options for the date picker plugin
						'options' => array(
							'showAnim' => 'fold',
							'dateFormat' => $date,
							'changeMonth' => true,
							'changeYear' => true,
							'yearRange' => '1970:',
							'defaultDate' => $adm_date
						),
						'htmlOptions' => array(
						'style'=>'height:16px;',
						'value' => $adm_date,
						),
					))
					?>
					<?php echo $form->error($model, 'joining_date'); ?></td>

			</tr>
		</table>
	</div>
</div>
<div class="formCon" >
	<div class="formConInner">

		<h3>General Details</h3>
		<table width="85%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="bottom" style="padding-bottom:3px;"><?php echo $form->labelEx($model, Yii::t('employees', 'first_name')); ?></td>
				<td>&nbsp;</td>
				<td valign="bottom" style="padding-bottom:3px;"><?php echo $form->labelEx($model, Yii::t('employees', 'middle_name')); ?></td>
				<td>&nbsp;</td>
				<td valign="bottom" style="padding-bottom:3px;"><?php echo $form->labelEx($model, Yii::t('employees', 'last_name')); ?></td>
			</tr>
			<tr>
				<td valign="top" width="45%"><?php echo $form->textField($model, 'first_name', array('size' => 25, 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'first_name'); ?></td>
				<td>&nbsp;</td>
				<td valign="top" width="20%"><?php echo $form->textField($model, 'middle_name', array('size' => 10, 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'middle_name'); ?></td>
				<td>&nbsp;</td>
				<td valign="top"><?php echo $form->textField($model, 'last_name', array('size' => 25, 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'last_name'); ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td valign="middle"><?php echo $form->labelEx($model, Yii::t('employees', 'gender')); ?></td>
				<td>&nbsp;</td>
				<td valign="middle"><?php echo $form->labelEx($model, Yii::t('employees', 'date_of_birth')); ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><?php //echo $form->textField($model,'gender',array('size'=>30,'maxlength'=>255));       ?>
					<?php echo $form->dropDownList($model, 'gender', array('M' => 'Male', 'F' => 'Female'), array('empty' => 'Select Gender')); ?>
					<?php echo $form->error($model, 'gender'); ?></td>
				<td>&nbsp;</td>
				<td><?php
//echo $form->textField($model,'date_of_birth',array('size'=>30,'maxlength'=>255));
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
						//'name'=>'Employees[date_of_birth]',
						'attribute' => 'date_of_birth',
						'model' => $model,
						// additional javascript options for the date picker plugin
						'options' => array(
							'showAnim' => 'fold',
							'dateFormat' => $date,
							'changeMonth' => true,
							'changeYear' => true,
							'yearRange' => '1970:',
							'defaultValue' => $dob
						),
						'htmlOptions' => array(
							'size' => 10,
							'value' => $dob
						),
					))
					?>
					<?php echo $form->error($model, 'date_of_birth'); ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td valign="middle">Notes:</td>
			</tr>
			<tr>
				<td colspan="5">
					<?php 
					echo $form->textArea($model, 'status_description', [
						'maxlength' => 255,
						'rows' => 6,
						'style' => "width:500px !important;"
					]);
					?>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="formCon">
	<div class="formConInner">
		<h3>Contact Details</h3>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><?php echo $form->labelEx($model, Yii::t('employees', 'home_address_line1')); ?>
				</td>
				<td><?php echo $form->textField($model, 'home_address_line1', array('size' => 25, 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'home_address_line1'); ?></td>
				<td><?php echo $form->labelEx($model, Yii::t('employees', 'home_address_line2')); ?>
				</td>
				<td><?php echo $form->textField($model, 'home_address_line2', array('size' => 25, 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'home_address_line2'); ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo $form->labelEx($model, Yii::t('employees', 'home_city')); ?>
				</td>
				<td><?php echo $form->textField($model, 'home_city', array('size' => 25, 'maxlength' => 35)); ?>
					<?php echo $form->error($model, 'home_city'); ?></td>
				<td><?php echo $form->labelEx($model, Yii::t('employees', 'home_state'));?>
				</td>
				<td><?php echo $form->textField($model, 'home_state', array('size' => 15, 'maxlength' => 25)); ?>
					<?php echo $form->error($model, 'home_state'); ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo $form->labelEx($model, Yii::t('employees', 'home_country_id')); ?>
				</td>
				<td><?php echo $form->dropDownList($model, 'home_country_id', CHtml::listData(Countries::model()->findAll(), 'id', 'name'), array('empty' => 'Select Country')); ?>
					<?php echo $form->error($model, 'home_country_id'); ?></td>
				<td><?php echo $form->labelEx($model, Yii::t('employees', 'home_pin_code')); ?>
				</td>
				<td><?php echo $form->textField($model, 'home_pin_code', array('size' => 15, 'maxlength' => 15)); ?>
					<?php echo $form->error($model, 'home_pin_code'); ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo $form->labelEx($model, Yii::t('employees', 'mobile_phone')); ?>
				</td>
				<td><?php echo $form->textField($model, 'mobile_phone', array('size' => 15, 'maxlength' => 25)); ?>
					<?php echo $form->error($model, 'mobile_phone'); ?></td>
				<td><?php echo $form->labelEx($model, Yii::t('employees', 'home_phone')); ?>
				</td>
				<td><?php echo $form->textField($model, 'home_phone', array('size' => 15, 'maxlength' => 25)); ?>
					<?php echo $form->error($model, 'home_phone'); ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo $form->labelEx($model, Yii::t('employees', 'email')); ?>
				</td>
				<td><?php echo $form->textField($model, 'email', array('size' => 25, 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'email'); ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</div>

</div>

<div class="formCon add-remove-offerings">
	<div class="formConInner">
		<h3>Offerings</h3>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<th>Available Classes</th>
				<th>&nbsp;</th>
				<th>Classes to Teach</th>
				<th>Scheduled Classes</th>
			</tr>
			<tr>
				<td>
					<?php echo CHtml::listBox('offerings-available', [], $untaughtBatches, array(
							'multiple' => 'multiple'
						)); ?>
				</td>
				<td valign="top" class="batch-buttons">
					<button id="addBatch">&#x21E8;</button>
					<br/>
					<button id="removeBatch">&#x21E6;</button>
				</td>
				<td>
					<?php echo CHtml::listBox('offerings-teach', [], [], array(
							'multiple' => 'multiple'
						)); ?>
				</td>
				<td>
					<?php echo CHtml::listBox('offerings-scheduled', [], $taughtBatches, array()); ?>
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="formCon" style=" background:#EDF1D1; border:0px #c4da9b solid; color:#393; background:#EDF1D1 url(images/green-bg.png); border:0px #c4da9b solid; color:#393;  ">

    <div class="formConInner" style="padding:10px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td></td>
				<td> </td>
				<td><?php
					if ($model->photo_data == NULL) {
						echo $form->labelEx($model, Yii::t('employees', '<strong style="color:#000">Upload Photo</strong>'));
					} else {
						echo $form->labelEx($model, 'Photo');
					}
					?>
				</td>
				<td>
					<?php
					if ($model->isNewRecord) {
						echo $form->fileField($model, 'photo_data');
						echo $form->error($model, 'photo_data');
					} else {
						if ($model->photo_data == NULL) {
							echo $form->fileField($model, 'photo_data');
							echo $form->error($model, 'photo_data');
						} else {
							if (Yii::app()->controller->action->id == 'update') {
								echo CHtml::link(Yii::t('students', 'Remove'), array('Employees/remove', 'id' => $model->id), array('confirm' => 'Are you sure?'));
								echo '<img class="imgbrder" src="' . $this->createUrl('Employees/DisplaySavedImage&id=' . $model->primaryKey) . '" alt="' . $model->photo_file_name . '" width="100" height="100" />';
							} else if (Yii::app()->controller->action->id == 'create') {
								echo CHtml::hiddenField('photo_file_name', $model->photo_file_name);
								echo CHtml::hiddenField('photo_content_type', $model->photo_content_type);
								echo CHtml::hiddenField('photo_file_size', $model->photo_file_size);
								echo CHtml::hiddenField('photo_data', bin2hex($model->photo_data));
								echo '<img class="imgbrder" src="' . $this->createUrl('Employees/DisplaySavedImage&id=' . $model->primaryKey) . '" alt="' . $model->photo_file_name . '" width="100" height="100" />';
							}
						}
					}
					?>

				</td>
			</tr>

		</table>
		<div class="row">
			<?php //echo $form->labelEx($model,'photo_file_size');  ?>
			<?php echo $form->hiddenField($model, 'photo_file_size'); ?>
			<?php echo $form->error($model, 'photo_file_size'); ?>
			<?php echo CHtml::hiddenField('new-teachings'); ?>
		</div>

    </div>
</div>
<div class="clear"></div>
<div style="padding:0px 0 0 0px; text-align:left">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create Teacher' : 'Save', array('class' => 'formbut')); ?>
</div>


</div>
</div><!-- form -->
<?php $this->endWidget(); ?>