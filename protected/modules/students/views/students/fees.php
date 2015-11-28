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
    <h3>Outstanding Payments</h3>
    <div class="tableinnerlist"> 
        
    <?php 
	$studentBalances = $model->getOutstandingBalances();

	if(count($studentBalances)=='0')
	{
	 echo Yii::t('students','<i>No Pending Fees</i>');	
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
	?>
			<tr>
				<td><?= $batch->getOfferingName() ?></td>
				<td>$<?= $charged ?></td>
				<td>$<?= $paid ?></td>
				<td>$<?php echo $charged > $paid ? (number_format($charged - $paid, 2) . ' Outstanding') : (number_format($paid - $charged, 2) . ' Overpaid'); ?></td>
				<td> <?php //echo CHtml::link(Yii::t('students','Pay Now'), array('payfees', 'id'=>$studentBalance->id)); ?></td>
			</tr>
		<?php 
		}
	}
	echo '</table>';
	}?> 
        
       </div><br /> 
        <h3>Transaction History</h3>
          <div class="tableinnerlist"> 
        <table width="95%" cellpadding="0" cellspacing="0">
        <tr>
		<?php 
			$tableHeaders = [
				'Date',
				'Offering',
				'Description',
				'Amount Billed',
				'Amount Paid'
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
				<td><?php echo date('M. m, Y', strtotime($transaction->created_at)); ?></td>
				<td><?php echo $transaction->offering->getOfferingName('/'); ?></td>
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
		