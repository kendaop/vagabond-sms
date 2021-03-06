<?php
$this->breadcrumbs=array(
	'Students'=>array('index'),
	'Fees',
);


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
    <!--<div class="searchbx_area">
    <div class="searchbx_cntnt">
    	<ul>
        <li><a href="#"><img src="images/search_icon.png" width="46" height="43" /></a></li>
        <li><input class="textfieldcntnt"  name="" type="text" /></li>
        </ul>
    </div>
    
    </div>-->
    
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
    <div class="emp_cntntbx">
    <div>
     <div class="formCon">
    <div class="formConInner">
    <h3>Outstanding Fees</h3>
    <div class="tableinnerlist"> 
        
    <?php 
	$studentBalances = $model->getOutstandingBalances();

	if(count($studentBalances)=='0')
	{
	 echo Yii::t('students','<i>No Outstanding Fees</i>');	
	}
	else
	{
	?>
		<table width="95%" cellpadding="0" cellspacing="0">
			<tr>
			  <th>Offering</th>
			  <th>Amount Billed</th>
			  <th>Amount Paid</th>
			  <th>Payment Status</th>
			  <th><?php echo Yii::t('students','Action');?></th>
			</tr> 

		<?php
		foreach($studentBalances as $studentBalance)
		{
			$charged = number_format((float) $studentBalance->charge_sum, 2);
			$paid = number_format((float) $studentBalance->paid_sum, 2);

			if($charged !== $paid) {
				$batch = Batches::model()->findByPk((int) $studentBalance->batch_id);
				$difference = $charged > $paid ? number_format($charged - $paid, 2) : number_format($paid - $charged, 2);
				$status = $charged > $paid ? 'Outstanding' : 'Overpaid';
		?>
				<tr>
					<td><?= $batch->getOfferingName() ?></td>
					<td>$<?= $charged ?></td>
					<td>$<?= $paid ?></td>
					<td class="<?php 
						echo strtolower($status) === 'outstanding' ? 'red' : 'green'; 
					?>">$<?php echo "$difference $status"; ?></td>
					<td>
					<?php 
						if($charged > $paid) {
							echo CHtml::ajaxLink(
								'Add Payment',
								$this->createUrl('fees/Add'), 
								[
									'onclick' => '$("#feeDialog").dialog("open"); return false;',
									'update' => '#feeDialog',
									'type' => 'POST',
									'data' => [
										'studentId'		=> $model->id,
										'batchId'		=> $batch->id,
										'difference'	=> $difference
									],
									'dataType' => 'text'
								], 
								[
									'id' => 'showFeeDialog' . $batch->id
								]
							); 
						} else {
							echo '-';
						}
					?>
					</td>
				</tr>
		<?php 
			}
		}
		?>
		</table> 
		<?php
	}
	?> 
        
       </div><br /> 
        <h3>Transaction History</h3>
          <div class="tableinnerlist"> 
        <table width="95%" cellpadding="0" cellspacing="0">
        <tr>
		<?php 
			$tableHeaders = [
				'Date',
				'Offering',
				'Method',
				'Description',
				'Billed',
				'Paid'
			];
			foreach($tableHeaders as $th) { 
		?>
			<th><?=$th?></th>
		<?php
			}
		?>
        </tr>
         <?php 
	$transactionHistory=FinanceFees::model()->findAll(array('condition'=>'student_id=:id','params'=>array(':id'=>$_REQUEST['id'])));
	if(count($transactionHistory)==0)
	{
	?>
    	<tr>
          <td colspan="<?php echo count($tableHeaders); ?>"><?php echo Yii::t('students','No transaction details.');?></td>             
        </tr>
	<?php
	}
	else
	{
		foreach($transactionHistory as $transaction)
		{	?>
		  
			<tr>
				<td><?php echo date('M. j, Y', strtotime($transaction->created_at . ' UTC')); ?></td>
				<td><?php echo $transaction->offering->getOfferingName('/'); ?></td>
				<td><?php echo $transaction->payment_type; ?></td>
				<td><?php echo $transaction->description; ?></td>
				<td>$<?php echo $transaction->charge_amount; ?></td>
				<td>$<?php echo $transaction->paid_amount; ?></td>
			</tr>
		   
			<?php 
		}
	}
		 ?>
     </table>
        </div><br />
</div>
  </div>
    </div>
    </div>
    </div>
    
    </div>
    </div>
    <div class="cont_right" style="background:#FFF">

	</div>
    </td>
  </tr>
</table>
<div id="feeDialog"></div>