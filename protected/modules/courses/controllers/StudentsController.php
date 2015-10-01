<?php

class StudentsController extends RController {
	public function actionView($id) {
		$x = 0;
	}
	
	public function actionDelete($student_id, $batch_id) {
		$student = Students::model()->findByPk($student_id);
		$result = $student->removeBatch($batch_id);
		
		$this->redirect(
			[
				'/courses/batches/batchstudents', 
				'id' => $batch_id
			]
		);
	}
}