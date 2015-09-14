<?php

$form = $this->beginWidget('CActiveForm', array(
	'id' => 'library-form',
	'enableAjaxValidation' => false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
		));
?>
<div style="padding:20px; position:relative;">
	<div class="formCon">
		<div class="formConInner">
			<h3>New Book</h3>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><?php echo $form->labelEx($model, 'Title'); ?></td>
				</tr>
				<tr>
					<td><?php echo $form->textField($model, 'title') ?></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td><?php echo CHtml::submitButton('Save', array('class' => 'formbut')); ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>