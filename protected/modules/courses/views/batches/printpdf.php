<style>
.listbxtop_hdng
{
	font-size:15px;	
	/*color:#1a7701;*/
	/*text-shadow: 0.1em 0.1em #FFFFFF;*/
	/*font-weight:bold;*/
	text-align:left;
}
.table_listbx tr td, tr th {
	border:1px solid #ccc;
}
td.listbx_subhdng
{
	color:#333333;
	font-size:14px;	
	font-weight:bold;
	/*width:33%;*/
}

.odd
{
	background-color:#DFDFDF;
}
td.subhdng_nrmal
{
	color:#333333;
	font-size:14px;
	width:450px;	
}
.table_listbx
{
	margin:0px;
	padding:0px;
	width:100%;
}
.table_listbx td
{
	padding: 8px 10px;
	margin:0px;
}

.table_listbx th {
	padding: 3px;
	text-align: center;
}

.table_listbxlast td
{
	border-bottom:none;
	
}

.last
{
	border-bottom:1px solid #ccc;
}
.first
{
	border:none;
}
</style>

<div class="atnd_Con" style="padding-left:20px; padding-top:30px;">
<?php
  if(isset($_REQUEST['id']))
  {
	  $students = $batch->students;
?>
	<!-- Header -->
	<div style="border-bottom:#666 1px; width:700px; padding-bottom:20px;">
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td class="first">
                           <?php $logo=Logo::model()->findAll();?>
                            <?php
                            if($logo!=NULL)
                            {
                                //Yii::app()->runController('Configurations/displayLogoImage/id/'.$logo[0]->primaryKey);
                                echo '<img src="uploadedfiles/school_logo/'.$logo[0]->photo_file_name.'" alt="'.$logo[0]->photo_file_name.'" class="imgbrder" width="100%" />';
                            }
                            ?>
                </td>
                <td align="center" valign="middle" class="first" style="width:300px;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
							<!-- School Name -->
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:22px; width:300px;  padding-left:10px;">
                                <?php $college=Configurations::model()->findAll(); ?>
                                <?php echo $college[0]->config_value; ?>
                            </td>
                        </tr>
                        <tr>
							<!-- School Address -->
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:14px; padding-left:10px;">
                                <?php echo $college[1]->config_value; ?>
                            </td>
                        </tr>
                        <tr>
							<!-- School Phone -->
                            <td class="listbxtop_hdng first" style="text-align:left; font-size:14px; padding-left:10px;">
							<?php 
								$phone = $college[2]->config_value;
								switch(strlen($phone)) {
									case 10:
										$phone = sprintf("(%d) %d-%d", substr($phone, 0, 3), substr($phone, 3, 3), substr($phone, 6, 4));
										break;
									case 7:
										$phone = sprintf("%d-%d", substr($phone, 0, 3), substr($phone, 3, 4));
										break;
									default:
										break;
								}
								echo "Phone: $phone"; 
							?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <!-- End Header -->
	
    <br /><br />
	
	<!-- Begin Class Info -->
	<table>
		<tr><td colspan="2" class="listbx_subhdng" style="padding: 4px 0"><?= $batch->getOfferingName() ?></td></tr>
		<tr><td>Start:</td><td><?= $batch->getDate('start') ?></td></tr>
		<tr><td>End:</td><td><?= $batch->getDate('end') ?></td></tr>
		<tr>
			<td>Teacher<?= count($batch->employees) > 1 ? 's' : '' ?>:</td>
			<?php 
			$firstEmployee = true;
			foreach($batch->employees as $employee) {
				$employeeCell = "<td>{$employee->getName()}</td>";
				echo ($firstEmployee ? "$employeeCell" : "<tr><td></td>$employeeCell") . '</tr>';
				$firstEmployee = false;
			}
			
			if($firstEmployee === true) {
				echo '</tr>';
			}
			?>
	</table>
	<!-- End Class Info -->
	
	<br /><br />
	
	<table class="table_listbx" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr><td colspan="4" class="listbx_subhdng" style="border: none; padding: 5px 0">Roster</td></tr>
		<tr>
			<th>Name</th>
			<th>Gender</th>
			<th>Email Address</th>
			<th>Phone</th>
		</tr>
		<?php
		for($index = 0; $index < count($students); $index++) { 
			$student = $students[$index];
		?>
		<tr class="<?php echo ($index % 2 === 0) ? 'odd' : 'even'; ?>">
			<td><?= $student->getStudentName() ?></td>
			<td><?php echo strtolower($student->gender) === 'm' ? 'Male' : (strtolower($student->gender) === 'f' ? 'Female' : 'Other'); ?></td>
			<td><?= $student->email ?></td>
			<td><?= $student->getPhone() ?></td>
		</tr>
		<?php
		}
		?>
		<tr></tr>
	</table>
<?php
  }
?>
</div>