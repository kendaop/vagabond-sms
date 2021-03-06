<?php
$this->breadcrumbs=array(
	'Students'=>array('index'),
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
    <!--<div class="searchbx_area">
    <div class="searchbx_cntnt">
    	<ul>
        <li><a href="#"><img src="images/search_icon.png" width="46" height="43" /></a></li>
        <li><input class="textfieldcntnt"  name="" type="text" /></li>
        </ul>
    </div>
    
    </div>-->
    
    <h1 style="margin-top:.67em;"><?php echo Yii::t('students','Student Profile : ');?> <?php echo ucfirst($model->first_name).'&nbsp;'.ucfirst($model->middle_name).' '.ucfirst($model->last_name); ?><br /></h1>
        
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
    
    <div class="table_listbx">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="listbxtop_hdng">
    <td><?php echo Yii::t('students','General');?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Admission Date');?></td>
    <td class="subhdng_nrmal"><?php 
								$settings=UserSettings::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
								if($settings!=NULL)
								{	
									$date1=date($settings->displaydate,strtotime($model->admission_date));
									echo $date1;
		
								}
								else
								echo $model->admission_date; ?></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
	      <td class="listbx_subhdng"><?php echo Yii::t('students','Date of Birth');?></td>
    <td class="subhdng_nrmal"><?php 
									if($settings!=NULL)
								{	
									$dob = $model->date_of_birth;
									$date1 = is_null($dob) ? '-' : date($settings->displaydate,strtotime($dob));
									echo $date1;
		
								}
								else
								echo $model->date_of_birth; 
								 ?></td>
	    <td class="listbx_subhdng"><?php echo Yii::t('students','Gender');?></td>
    <td class="subhdng_nrmal">
	<?php if($model->gender=='M')
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
    <td><?php echo Yii::t('students','Contact');?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
	<tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Address Line1');?>  </td>
    <td class="subhdng_nrmal"><?php echo $model->address_line1; ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Address Line 2');?></td>
    <td class="subhdng_nrmal"><?php echo $model->address_line2; ?></td>
  </tr>
  <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','City');?></td>
    <td class="subhdng_nrmal"><?php echo $model->city; ?></td>
	<td class="listbx_subhdng"><?php echo Yii::t('students','State');?></td>
    <td class="subhdng_nrmal"><?php echo $model->state; ?></td>
  </tr>
  <tr>
	<td class="listbx_subhdng"><?php echo Yii::t('students','ZIP Code');?>  </td>
    <td class="subhdng_nrmal"><?php echo $model->pin_code; ?></td>
	<td class="listbx_subhdng"><?php echo Yii::t('students','Country');?></td>
    <td class="subhdng_nrmal"><?php 
	$count = Countries::model()->findByAttributes(array('id'=>$model->country_id));
	if(count($count)!=0)
	echo $count->name; ?></td>
  </tr>
 <tr>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Phone 1');?></td>
    <td class="subhdng_nrmal"><?php echo $model->getPhone(1); ?></td>
    <td class="listbx_subhdng"><?php echo Yii::t('students','Phone 2');?></td>
    <td class="subhdng_nrmal"><?php echo $model->getPhone(2); ?></td>
  </tr>
  <tr>
	<td class="listbx_subhdng"><?php echo Yii::t('students','Email');?></td>
    <td class="subhdng_nrmal"><?php echo $model->email; ?></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr class="listbxtop_hdng">
    <td><?php echo Yii::t('students','Courses &amp; Offerings');?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php 
	$current = Batches::model()->getEnrolledBatches($model->id);
  ?>
  <tr>
	<td class="listbx_subhdng">Currently Enrolled: </td>
	<td class="subhdng_nrmal">
	<?php 
		if($current) {
			foreach($current as $key => $batch) {
				if($key > 0) {
					echo '<br/>';
				}
				echo $batch;
			}
		} else {
			echo '-';
		}
	?>
	</td>
	<td></td>
	<td></td>
  </tr>
  <tr>
	<td class="listbx_subhdng"><?php echo Yii::t('students','Completed: ');?></td>
	<td class="subhdng_nrmal">
<?php
	if(count($completedOfferings) > 0) {
		$firstOffering = true;
		foreach($completedOfferings as $offering) {
			echo ($firstOffering ? '' : '<br />') . $offering;
			$firstOffering = false;
		}		
	} else {
		echo "Student has not completed any courses....yet!";
	}
?>
	</td>
	<td></td>
	<td></td>
  </tr>
<!--
  <tr class="listbxtop_hdng">
    <td><?php echo Yii::t('students','Emergeny Contact');?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td colspan="4" class="listbx_subhdng"><?php echo Yii::t('students','In case of emergencies,');?><br />
     <?php echo Yii::t('students',' contact : ');?><?php
	  $posts=Guardians::model()->findByAttributes(array('id'=>$model->parent_id));
	  if(count($posts)==0)
	  {
		  echo "No Guardians are added".'&nbsp;&nbsp;'.CHtml::link(Yii::t('students','Add new'), array('guardians/create&id='.$model->id)); 
	  }
	  else
	  {
		  echo ucfirst($posts->first_name).' '.ucfirst($posts->last_name).'&nbsp;&nbsp;'.CHtml::link(Yii::t('students','Edit'), array('/students/guardians/update', 'id'=>$posts->id,'std'=>$model->id));
	  }
	   ?></td>
  </tr>
  <tr class="listbxtop_hdng">
    <td><?php echo Yii::t('students','Student Previous Datas');?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <!--<tr class="table_listbxlast">
    
    <?php
    $previous=StudentPreviousDatas::model()->findAllByAttributes(array('student_id'=>$model->id));
	if(count($previous)==0)
	{
		echo '<tr class="table_listbxlast"><td colspan="4" class="listbx_subhdng"><span class="subhdng_nrmal">';
		echo Yii::t('students','No Previous Datas');
		echo '</span></td></tr>';
		echo '<td colspan="4" class="listbx_subhdng"><span class="subhdng_nrmal">'; 
		echo CHtml::link(Yii::t('students','Add another Previous Data'), array('studentPreviousDatas/create&id='.$model->id)); 
		echo '</span></td>';	
	}
	else {
	?>
    <?php
		foreach($previous as $prev){
			if($prev->institution!=NULL or $prev->year!=NULL or $prev->course!=NULL or $prev->total_mark!=NULL){
		?>
        	<tr>
        	<td class="listbx_subhdng"><?php echo Yii::t('students','Institution');?></td>
            <td class="subhdng_nrmal"><?php if($prev->institution!=NULL){echo $prev->institution;} else { echo '-';} ?></td> 
        	<td class="listbx_subhdng"><?php echo Yii::t('students','Year');?></td>
            <td class="subhdng_nrmal"><?php if($prev->year!=NULL){ echo $prev->year;} else { echo '-';} ?></td> 
			</tr>
            <tr>
        	<td class="listbx_subhdng"><?php echo Yii::t('students','Course');?></td>
            <td class="subhdng_nrmal"><?php if($prev->course!=NULL){echo $prev->course; } else { echo '-';}?></td> 
        	<td class="listbx_subhdng"><?php echo Yii::t('students','Total Mark');?></td>
            <td class="subhdng_nrmal"><?php if($prev->total_mark!=NULL){echo $prev->total_mark;} else { echo '-';} ?></td> 
			</tr>
            <tr>
            	<td class="listbx_subhdng"><?php echo CHtml::link(Yii::t('students','Edit'), array('studentPreviousDatas/update','id'=>$model->id,'pid'=>$prev->id)); ?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        
        <?php
			}
		}
		echo '<td colspan="4" class="listbx_subhdng"><span class="subhdng_nrmal">'; 
		echo CHtml::link(Yii::t('students','Add another Previous Data'), array('studentPreviousDatas/create&id='.$model->id)); 
		echo '</span></td>';
		?>
        
    <?php } ?>
    -->
  <!--</tr>-->
  </table>
 <div class="ea_pdf" style="top:4px; right:6px;">
 <?php echo CHtml::link('<img src="images/pdf-but.png">', array('Students/pdf','id'=>$_REQUEST['id']),array('target'=>'_blank')); ?>
	</div>
 
    </div>
    </div>
    </div>
    
    </div>
    </div>
   
    </td>
  </tr>
</table>