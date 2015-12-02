<?php

class FeesController extends RController 
{
	public function actionAdd() {
		$this->renderPartial('addFees',[
			'studentId'		=> $_POST['studentId'],
			'batchId'		=> $_POST['batchId'],
			'difference'	=> $_POST['difference']
		],false,true);
	}
	
	public function actionCreate() {
		$model = new FinanceFees;
		
		if(isset($_POST['FinanceFees'])) {
			$model->attributes = $_POST['FinanceFees'];
			$model->payment_type = $_POST['FinanceFees']['payment_type'];
			
			return $model->save();
		}
	}
}