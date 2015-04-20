<div class="captionWrapper">
	<ul>
		<li><h2  class="cur">Employee Details</h2></li>
	</ul>
</div>
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
				<td><?php echo $form->textField($model, 'employee_number', array('size' => 20, 'maxlength' => 255, 'value' => $emp_id_1)); ?>
					<?php echo $form->error($model, 'employee_number'); ?></td>

				<td><?php echo $form->labelEx($model, Yii::t('employees', 'joining_date')); ?></td>
				<td><?php
					$settings = UserSettings::model()->findByAttributes(array('user_id' => Yii::app()->user->id));
					if ($settings != NULL) {
						$date = $settings->dateformat;
					} else
						$date = 'dd-mm-yy';
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
							'yearRange' => '1970:'
						),
						'htmlOptions' => array(
						//'style'=>'height:20px;'
						//'value' => date('m-d-y'),
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
		<table width="75%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="bottom" style="padding-bottom:3px;"><?php echo $form->labelEx($model, Yii::t('employees', 'first_name')); ?></td>

				<td valign="bottom" style="padding-bottom:3px;"><?php echo $form->labelEx($model, Yii::t('employees', 'middle_name')); ?></td>

				<td valign="bottom" style="padding-bottom:3px;"><?php echo $form->labelEx($model, Yii::t('employees', 'last_name')); ?></td>
			</tr>
			<tr>
				<td valign="top" width="45%"><?php echo $form->textField($model, 'first_name', array('size' => 32, 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'first_name'); ?></td>

				<td valign="top" width="20%"><?php echo $form->textField($model, 'middle_name', array('size' => 10, 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'middle_name'); ?></td>

				<td valign="top"><?php echo $form->textField($model, 'last_name', array('size' => 30, 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'last_name'); ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">

			<tr>
				<td valign="middle"><?php echo $form->labelEx($model, Yii::t('employees', 'gender')); ?></td>
				<td><?php //echo $form->textField($model,'gender',array('size'=>30,'maxlength'=>255));       ?>
					<?php echo $form->dropDownList($model, 'gender', array('M' => 'Male', 'F' => 'Female'), array('empty' => 'Select Gender')); ?>
					<?php echo $form->error($model, 'gender'); ?></td>
				<td >&nbsp;</td>
				<td valign="middle"><?php echo $form->labelEx($model, Yii::t('employees', 'date_of_birth')); ?></td>
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
							'yearRange' => '1950:2050'
						),
						'htmlOptions' => array(
							'style' => 'width:100px;',
						),
					))
					?>
					<?php echo $form->error($model, 'date_of_birth'); ?></td>
				<td >&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td valign="middle"><?php echo $form->labelEx($model, Yii::t('employees', 'employee_department_id')); ?></td>
				<td><?php echo $form->dropDownList($model, 'employee_department_id', CHtml::listData(EmployeeDepartments::model()->findAll(), 'id', 'name'), array('empty' => 'Select Department')); ?>
					<?php echo $form->error($model, 'employee_department_id'); ?></td>
				<td valign="middle">&nbsp;</td>
				<td valign="middle"><?php echo $form->labelEx($model, Yii::t('employees', 'employee_position_id')); ?></td>
				<?php
				$criteria2 = new CDbCriteria;
				$criteria2->compare('status', 1);
				?>
				<td valign="middle"><?php echo $form->dropDownList($model, 'employee_position_id', CHtml::listData(EmployeePositions::model()->findAll($criteria2), 'id', 'name'), array('empty' => 'Select Position')); ?>
					<?php echo $form->error($model, 'employee_position_id'); ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td valign="middle"><?php echo $form->labelEx($model, Yii::t('employees', 'employee_category_id')); ?></td>
				<?php
				$criteria1 = new CDbCriteria;
				$criteria1->compare('status', 1);
				?>
				<td><?php echo $form->dropDownList($model, 'employee_category_id', CHtml::listData(EmployeeCategories::model()->findAll($criteria1), 'id', 'name'), array('empty' => 'Select Category')); ?>
					<?php echo $form->error($model, 'employee_category_id'); ?></td>
				<td valign="middle">&nbsp;</td>
				<td><?php echo $form->labelEx($model, Yii::t('employees', 'employee_grade_id')); ?></td>
				<?php
				$criteria = new CDbCriteria;
				$criteria->compare('status', 1);
				?>
				<td valign="middle"><?php echo $form->dropDownList($model, 'employee_grade_id', CHtml::listData(EmployeeGrades::model()->findAll($criteria), 'id', 'name'), array('empty' => 'Select Grade')); ?>
					<?php echo $form->error($model, 'employee_grade_id'); ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td valign="middle"><?php echo $form->labelEx($model, Yii::t('employees', 'job_title')); ?></td>
				<td><?php echo $form->textField($model, 'job_title', array('size' => 15, 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'job_title'); ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>  
		</table>

	</div>
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
				<td><?php echo $form->textField($model, 'home_city', array('size' => 25, 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'home_city'); ?></td>
				<td><?php echo $form->labelEx($model, Yii::t('employees', 'home_state')); ?>
				</td>
				<td><?php echo $form->textField($model, 'home_state', array('size' => 25, 'maxlength' => 255)); ?>
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
				<td><?php echo $form->textField($model, 'home_pin_code', array('size' => 25, 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'home_pin_code'); ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo $form->labelEx($model, Yii::t('employees', 'mobile_phone')); ?>
				</td>
				<td><?php echo $form->textField($model, 'mobile_phone', array('size' => 30, 'maxlength' => 255)); ?>
					<?php echo $form->error($model, 'mobile_phone'); ?></td>
				<td><?php echo $form->labelEx($model, Yii::t('employees', 'home_phone')); ?>
				</td>
				<td><?php echo $form->textField($model, 'home_phone', array('size' => 30, 'maxlength' => 255)); ?>
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
				<td><?php echo $form->textField($model, 'email', array('size' => 30, 'maxlength' => 255)); ?>
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

<div class="formCon" style=" background:#EDF1D1; border:0px #c4da9b solid; color:#393; background:#EDF1D1 url(images/green-bg.png); border:0px #c4da9b solid; color:#393;  ">

    <div class="formConInner" style="padding:10px;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">

			<tr>
				<td></td>
				<td> </td>
				<td><?php
					if ($model->photo_data == NULL) {
						echo $form->labelEx($model, 'upload_photo');
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
		</div>

    </div>
</div>
<div class="clear"></div>
<div style="padding:0px 0 0 0px; text-align:left">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create Employee' : 'Save', array('class' => 'formbut')); ?>
</div>


</div>
</div><!-- form -->
<?php $this->endWidget(); ?>