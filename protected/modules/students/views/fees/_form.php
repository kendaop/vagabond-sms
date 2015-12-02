<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'fees-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); 

	$newFee = new FinanceFees();
	$batch = Batches::model()->findByPk($batchId);
	$student = Students::model()->findByPk($studentId);
?>

	<p style="padding-left:20px;">Fields with <span class="required">*</span> are required.</p>    
    <h3 style="padding-left:20px;">Add Payment</h3>
    <div style="padding:0 0 0 20px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th>Offering</th>
    <td width="3%">&nbsp;</td>
    <td><?= $batch->getOfferingName() ?></td>
  </tr>
  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
  </tr>
	<tr>
		<th>Student</th>
		<td>&nbsp;</td>
		<td><?= $student->getStudentName() ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
	  <th>Payment Amount</th>
	  <td>&nbsp;</td>
	  <td>
		<?php 
			echo $form->textField($newFee, 'charge_amount');
//			echo $form->hiddenField($newFee, 'charge_amount');
			echo $form->error($newFee, 'charge_amount');
		?>
	  
	  </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><?php //echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save',array('class'=>'formbut')); ?>
		<?php	
			echo CHtml::ajaxSubmitButton(
				'Add Payment',
				CHtml::normalizeUrl(array('fees/Create','render'=>false)),
				[
					'success'=>'js: function(data) {
						$("#feesDialog").dialog("close");  window.location.reload();
					}'
				],
				array('id'=>'closeFeeDialog','name'=>'Submit')
			); 
		?>
		</td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	</tr>
 <?php // $this->renderPartial('_flash',array('model'=>$model,'id'=>jobDialog)); ?>
</table>
</div>
	<div class="row">
		<?php //echo $form->labelEx($model,'is_deleted'); ?>
		<?php // echo $form->hiddenField($model,'is_deleted'); ?>
		<?php // echo $form->error($model,'is_deleted'); ?>
	</div>

	<div class="row">
   
		<?php //echo $form->labelEx($model,'created_at')
  
//		 echo $form->hiddenField($model,'created_at'); ?>
		<?php // echo $form->error($model,'created_at'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'updated_at'); ?>
		<?php // echo $form->hiddenField($model,'updated_at',array('value'=>date('d-m-Y'))); ?>
		<?php // echo $form->error($model,'updated_at'); ?>
	</div>

  
    
    <!-- Batch Form Ends -->
	<div style="padding:0px 0 0 0px; text-align:left">
		
	</div>

<?php $this->endWidget(); ?>
