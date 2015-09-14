
<?php
$this->breadcrumbs=array(
	'Library'=>array('index'),
	'Create',
);


?>
<div style="background:#fff; min-height:800px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td valign="top">
		<div class="cont_right formWrapper">
			<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
		</td>
	  </tr>
	</table>
</div>