<?php

class FeesController extends RController 
{
	public function actionAdd() {
		$this->renderPartial('addFees',array('val1'=>'Something'),false,true);
		
//	   	if(isset($_POST['Fee']))
//        {       $flag=false;
//		    	$model=$this->loadModel($_GET['val1']);
//				$model->attributes=$_POST['Courses'];
//				$model->save();
//		}
//		
//		if($flag) {
//			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
//			$this->renderPartial('addFees',array('model'=>$model,'val1'=>$_GET['val1']),false,true);
//		}
	}
}