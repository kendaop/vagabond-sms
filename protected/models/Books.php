<?php

/**
 * This is the model class for table "book"
 * 
 * The following are the available columns in table 'book':
 * @property integer $id
 * @property integer $isbn
 * @property string $title
 * @property string $author
 * @property string $copy
 * @property integer $status
 * @property integer $is_deleted
 * @property string $subject
 */

class Books extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Batches the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'book';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, isbn, status, is_deleted', 'numerical', 'integerOnly'=>true),
//			array('start_date, end_date', 'safe'),
			// The following rule is used by search().
			array('title', 'required'),
//			array('name','CRegularExpressionValidator', 'pattern'=>'/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/','message'=>"{attribute} should not contain any special character(s)."),
			// Please remove those attributes that should not be searched.
//			array('id, name, course_id, start_date, end_date, is_active, is_deleted', 'safe', 'on'=>'search'),
		);
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		 'student' => array(self::BELONGS_TO, 'Students', 'id')
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'isbn' => 'ISBN',
			'title' => 'Title',
			'subject' => 'Subject',
			'author' => 'Author',
			'edition' => 'Edition',
			'copy' => 'Copy',
			'date' => 'Checked Out',
			'status' => 'Borrower'
		);
	}
	
	public function getCheckedOut($studentId)
	{
		$books = self::model()->findAllByAttributes([
			'status' => $studentId,
			'is_deleted' => 0
		]);
		
		return self::replaceEmpty($books);
	}
	
	public function getAvailable()
	{
		$books = self::model()->findAllByAttributes([
			'status' => 0,
			'is_deleted' => 0
		]);
		
		return self::replaceEmpty($books);
	}
	
	private static function replaceEmpty($books)
	{
		$labels = self::attributeLabels();
		
		foreach($books as $book) {
			foreach($labels as $key => $label) {
				if(!$book->$key) {
					$book->$key = '-';
				}
			}
		}
		
		return $books;
	}
}