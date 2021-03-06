<?php
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	'View',
);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="247" valign="top">
 <?php $this->renderPartial('profileleft');?>
    
    </td>
    <td valign="top">
    <div class="cont_right formWrapper">
<h1 ><?php echo Yii::t('employees','Employee Profile : ');?><?php echo $model->first_name.'&nbsp;'.$model->last_name; ?><br /></h1>
<div class="edit_bttns">
    <ul>
    <li><?php echo CHtml::link(Yii::t('employees','<span>Edit</span>'), array('update', 'id'=>$_REQUEST['id']),array('class'=>'edit last')); ?><!--<a class=" edit last" href="">Edit</a>--></li>
     <li><?php echo CHtml::link(Yii::t('employees','<span>Employees</span>'), array('employees/manage'),array('class'=>'edit last')); ?><!--<a class=" edit last" href="">Edit</a>--></li>
    </ul>
    </div>
    
    <div class="emp_right_contner">
    <div class="emp_tabwrapper">
    <div class="emp_tab_nav">
    <ul style="width:698px;">
    <li><?php echo CHtml::link(Yii::t('employees','Profile'), array('view', 'id'=>$_REQUEST['id']),array('class'=>'active')); ?></li>
    </ul>
    </div>
    <div class="clear"></div>
 <div class="emp_cntntbx">
    <div class="table_listbx">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="listbxtop_hdng">
    <td><?php echo Yii::t('employees','General');?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('employees','Hire Date');?></td>
    <td class="subhdng_nrmal"><?php $settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
										if($settings!=NULL)
										{	
											$date1=date($settings->displaydate,strtotime($model->joining_date));
											echo $date1;
		
										}
										else
										echo $model->joining_date;  ?></td>
    <td class="listbx_subhdng"><?php //echo Yii::t('employees','Department');?></td>
    <td class="subhdng_nrmal"><?php /*$dep=EmployeeDepartments::model()->findByAttributes(array('id'=>$model->employee_department_id));
							  if($dep!=NULL)
							  {
							  echo $dep->name;	
							  }*/
							  ?></td>
  </tr>

  <tr>
	<td class="listbx_subhdng"><?php echo Yii::t('employees','Date of Birth');?></td>
    <td class="subhdng_nrmal"><?php 
										$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
										if($settings!=NULL)
										{	
											$dob = $model->date_of_birth;
											$date1 = is_null($dob) ? '-' : date($settings->displaydate,strtotime($model->date_of_birth));
											echo $date1;
		
										}
										else
										echo $model->date_of_birth; 
										?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('employees','Gender');?></td>
    <td class="subhdng_nrmal"><?php if($model->gender=='M')
										echo 'Male';
									else 
										echo 'Female';	 ?></td>
  </tr>
<?php
  if(strlen($model->status_description) > 0) { ?>
	<tr>
		<td class="listbx_subhdng">
			Notes:
		</td>
		<td colspan="3">
			<?= $model->status_description ?>
		</td>
	</tr>
<?php } ?>
  <tr class="listbxtop_hdng">
    <td><?php echo Yii::t('employees','Contact');?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('employees','Address Line 1');?></td>
    <td class="subhdng_nrmal"><?php echo $model->home_address_line1; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('employees','Address Line 2');?></td>
    <td class="subhdng_nrmal"><?php echo $model->home_address_line2; ?></td>
  </tr>
  <tr>    
	<td class="listbx_subhdng"><?php echo Yii::t('employees','City');?> </td>
    <td class="subhdng_nrmal"><?php echo $model->home_city; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('employees','State');?></td>
    <td class="subhdng_nrmal"><?php echo $model->home_state; ?></td>
  </tr>

  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('employees','ZIP Code');?></td>
    <td class="subhdng_nrmal"><?php echo $model->home_pin_code; ?></td>
	<td class="listbx_subhdng"><?php echo Yii::t('employees','Country');?></td>
    <td class="subhdng_nrmal"><?php 
	$count = Countries::model()->findByAttributes(array('id'=>$model->home_country_id));
	if(count($count)!=0)
	echo $count->name; ?></td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('employees','Phone 1');?></td>
    <td class="subhdng_nrmal"><?php echo $model->getPhone(1); ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('employees','Phone 2');?></td>
    <td class="subhdng_nrmal"><?php echo $model->getPhone(2); ?></td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('employees','Email');?></td>
    <td class="subhdng_nrmal"><?php echo $model->email; ?></td>
	<td>&nbsp;</td><td>&nbsp;</td>
  </tr>
  </table>
  <div class="ea_pdf" style="top:4px; right:6px;"><?php echo CHtml::link('<img src="images/pdf-but.png">', array('Employees/pdf','id'=>$_REQUEST['id']),array('target'=>'_blank')); ?></div>
   
 </div>
 
 </div>
</div>
</div>
</div>
    
    </td>
  </tr>
</table>