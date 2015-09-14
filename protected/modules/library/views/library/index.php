<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/promotions.css" />
<?php
$this->breadcrumbs=array(
	$this->module->id,
);

$allBooks = Books::model()->findAll("is_deleted = 0");
?>

<div class="container">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="247" valign="top">
			<?php $this->renderPartial('/default/left_side'); ?>
		</td>
		<td valign="top" width="75%">
			<div  class="cont_right formWrapper" style="padding:20px; position:relative;">
<!--				<div class="edit_bttns" style="width:350px; top:30px; right:-15px;">
					<ul>
						<li><?php echo CHtml::link(Yii::t('library','<span>New Book</span>'), array('create')); ?></li>
					</ul>
				</div> -->
				<div>
					<h1>Library</h1>
					<?php
						$this->widget('application.extensions.tablesorter.Sorter', array(
							'data' => $allBooks,
							'columns' => [
								[
									'header' => 'ID',
									'value'  => 'id'
								],
								'title',
								'author',
								[
									'header' => 'Category',
									'value'  => 'subject'
								],
								[
									'header' => 'Checked Out',
									'value'  => 'date'
								]
							]
						));
					?>
				</div>
			</div>
		</td>
	</tr>
</table>
</div>
