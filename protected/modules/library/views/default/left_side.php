<div id="othleft-sidebar">

	<h1><?php echo Yii::t('students', 'Manage Book Categories'); ?></h1>          
	<?php

	$this->widget('zii.widgets.CMenu', array(
		'encodeLabel' => false,
		'activateItems' => true,
		'activeCssClass' => 'list_active',
		'items' => array(
			array('label' => 'Books Categories List<span>' . Yii::t('students', 'All Students Details') . '</span>', 'url' => array('students/manage'), 'linkOptions' => array('class' => 'lbook_ico'),
				'active' => ((Yii::app()->controller->id == 'library') && (in_array(Yii::app()->controller->action->id, array('manage')))) ? true : false
			),
			array('label' => '' . Yii::t('students', 'Create New Book') . '<span>New Library Book</span>', 'url' => array('students/create'), 'linkOptions' => array('class' => 'sl_ico'), 'active' => (Yii::app()->controller->action->id == 'create' or Yii::app()->controller->id == 'studentPreviousDatas' or Yii::app()->controller->id == 'studentAdditionalFields'), 'itemOptions' => array('id' => 'menu_1')
			)
		)
	));
?>
</div>