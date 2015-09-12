<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/promotions.css" />
<?php
$this->breadcrumbs=array(
	$this->module->id,
);

$allBooks = Books::model()->findAll("is_deleted = 0");
?>

<div style="background:#fff; min-height:800px;">  
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top" width="75%">
			<div style="padding:20px; position:relative;">
				<div class="edit_bttns" style="width:350px; top:30px; right:-15px;">
					<ul>
						<li>Button</li>
					</ul>
				</div> 
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
