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
		<th>Remaining Owed</th>
		<td>&nbsp;</td>
		<td>$<?= $difference ?></td>
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
			echo $form->textField($newFee, 'paid_amount');
//			echo $form->hiddenField($newFee, 'paid_amount');
			echo $form->error($newFee, 'paid_amount');
		?>
	  
	  </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<th>Payment Type</th>
		<td>&nbsp;</td>
		<td>
		<?php
			echo $form->dropDownList($newFee, 'payment_type', [
				'Cash'			=> 'Cash',
				'Check'			=> 'Check',
				'Credit Card'	=> 'Credit Card',
				'Voucher'		=> 'Voucher'
			]);
		?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<th>Description</th>
		<td>&nbsp;</td>
		<td>
		<?php
			echo $form->textField($newFee, 'description');
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
	  <td>
		<?php 
			echo $form->hiddenField($newFee, 'batch_id', ['value' => $batchId]);
			echo $form->hiddenField($newFee, 'student_id', ['value' => $studentId]);
			echo $form->hiddenField($newFee, 'charge_amount', ['value' => '0.00']);
		?>
	  </td>
	</tr>
 <?php // $this->renderPartial('_flash',array('model'=>$model,'id'=>jobDialog)); ?>
</table>
</div>  
    
    <!-- Batch Form Ends -->
	<div style="padding:0px 0 0 0px; text-align:left">
		
	</div>

<?php $this->endWidget(); ?>
