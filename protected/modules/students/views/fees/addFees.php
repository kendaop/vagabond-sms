<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ui-style.css" />
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
					'id'=>'feesDialog',
					'options'=>array(
						'autoOpen'=>true,
						'modal'=>'true',
						'width'=>'400',
						'height'=>'auto',
						'resizable'=>false
                ),
                ));
				?>
                
<?php 
echo $this->renderPartial('_form', [
	'studentId'	=> $studentId,
	'batchId'	=> $batchId
	]); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');
