<?php
$this->breadcrumbs=array(
	'Students'=>array('index'),
	'Books',
);

$booksCheckedOut = Books::getCheckedOut($model->id);

$booksAvailable = Books::getAvailable();

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
    <div class="emp_cont_left">
    <?php $this->renderPartial('profileleft');?>
    
    </div>
    </td>
    <td valign="top">
    <div class="cont_right formWrapper">
    
    <h1 style="margin-top:.67em;"><?php echo Yii::t('students','Student Profile : ');?><?php echo $model->first_name.'&nbsp;'.$model->last_name; ?><br /></h1>
        
    <div class="edit_bttns last">
    <ul>
    <li>
    <?php echo CHtml::link(Yii::t('students','<span>Edit</span>'), array('update', 'id'=>$model->id),array('class'=>' edit ')); ?>
    </li>
     <li>
    <?php echo CHtml::link(Yii::t('students','<span>Students</span>'), array('students/manage'),array('class'=>'edit last'));?>
    </li>
    </ul>
    </div>
    
    
    <div class="clear"></div>
    <div class="emp_right_contner">
    <div class="emp_tabwrapper">
    <?php $this->renderPartial('tab');?>
    <div class="clear"></div>
    <div class="emp_cntntbx" >
	<div class="tablesorter-container" id="checked-out">
	<h1>Checked out:</h1>
		
	<?php 
		$this->widget('application.extensions.tablesorter.Sorter', array(
			'data' => $booksCheckedOut,
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
//				'users.username', // Relation value given in model
			],
			'filters' => [],
			'buttons' => [
				[
					'edit' => 'disable'
				]
			]
		));
	?>
	</div>
	<div class="tablesorter-container" id="available">
	<h1>Available:</h1>
		
	<?php
		$this->widget('application.extensions.tablesorter.Sorter', array(
			'data' => $booksAvailable,
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
				]
//				'users.username', // Relation value given in model
			],
			'filters' => [
				'',
				'',
				'',
				'filter-select'
			],
			'buttons' => [
				[
					'delete' => 'disable'
				]
			]
		));
	?>
	</div>
    </div>
    </div>
    </div>
    
    </div>
    </div>
   
    </td>
  </tr>
</table>

<?php
$form = $this->beginWidget('CActiveForm', array(
	'id' => 'hidden-form',
	'enableAjaxValidation' => false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
	'action' => $this->createUrl('Books/update')
		));

echo cHTML::hiddenField('hidden-new-status', '0');
echo cHTML::hiddenField('hidden-book-id', '0');

$this->endWidget();
?>
<script>
	// Script to add alert box before checking in/out a book.
	$(document).ready(function() {
		$('.tablesorter-container').each(function() {
			newClass = $(this).attr('id') == 'available' ? 'check-out' : 'check-in';
			
			$('a:last-child', this).each(function() {
				var url = (newClass == 'check-in' ? ($(this).attr('onclick').match(/del_data\(\"(.*)\"\)/)[1]) : false);
				$(this).addClass(newClass)
				.attr('onclick', null)
				.click({newClass: newClass}, function(e) {
					newClass = e.data.newClass;
					title = $(this).parent().parent().children().eq(1).html();
					id = $(this).parent().attr('class').match(/id-([0-9]+)/)[1];
					confirmed = confirm(newClass.charAt(0).toUpperCase() + newClass.slice(1).replace('-', ' ') + " '" + title + "' for <?=$model->first_name?> <?=$model->last_name?>?");
					
					if(confirmed) {
						e.preventDefault();
						$('#hidden-new-status').val(newClass === 'check-out' ? <?= $model->id ?> : 0);
						$('#hidden-book-id').val(id);
						$('#hidden-form').submit();
					} else {
						e.preventDefault();
					}
				});
					
			});
		});
		
		// Add 'id' class to each row of data.
		$('.tablesorter-container tr').filter(function() {
			return !($(this).hasClass('tablesorter-headerRow') || $(this).hasClass('tablesorter-filter-row'));
		}).each(function() {
			id = $(this).children().eq(0).html();
			$(this).children().attr('class', 'id-' + id);
		});
	});
</script>