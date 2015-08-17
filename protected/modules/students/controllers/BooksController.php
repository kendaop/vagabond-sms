<?php

class BooksController extends RController 
{
	public function actionUpdate()
	{
		$id = (int)$_POST['hidden-book-id'];
		$status = $_POST['hidden-new-status'];		
		$book = Books::model()->findByAttributes(['id' => $id]);
		$studentId = $status === '0' ? $book->status : (int) $status;
		$student = Students::model()->findByAttributes(['id' => $studentId]);
		
		$book->status = $status;
		$book->save();
		
		$controller = new StudentsController('students');
		$this->redirect(['students/books', 
			'id' => $studentId
		]);
	}
}