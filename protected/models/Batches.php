<?php

/**
 * This is the model class for table "batches".
 *
 * The followings are the available columns in table 'batches':
 * @property integer $id
 * @property string $name
 * @property integer $course_id
 * @property string $start_date
 * @property string $end_date
 * @property integer $is_active
 * @property integer $is_deleted
 * @property float $price
 */
class Batches extends CActiveRecord
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
		return 'batches';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_id, is_active, is_deleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>25),
			array('start_date, end_date', 'safe'),
			// The following rule is used by search().
			array('name, start_date, end_date, price', 'required'),
			array('name','CRegularExpressionValidator', 'pattern'=>'/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/','message'=>"{attribute} should not contain any special character(s)."),
			array('price','CRegularExpressionValidator', 'pattern'=>'/^[0-9]{1,5}(\.[0-9]{2})?$/','message'=>"{attribute} is not valid."),
			// Please remove those attributes that should not be searched.
			array('id, name, course_id, start_date, end_date, is_active, is_deleted', 'safe', 'on'=>'search'),
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
		 'course123' => array(self::BELONGS_TO, 'Courses', 'course_id'),
         'students' => array(self::MANY_MANY, 'Students', 'batch_students(batch_id, student_id)'),
		 'employees' => array(self::MANY_MANY, 'Employees', 'batch_employees(batch_id, employee_id)'),// ,mmm,  m'),
		 'attendance' => array(self::HAS_MANY, 'StudentAttentance', 'id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'course_id' => 'Course',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'is_active' => 'Is Active',
			'is_deleted' => 'Is Deleted',
			'price' => 'Price'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getval()
	{
		return '"123"';
	}
	
	 public function getCoursename()
	{
		$course=Courses::model()->findByAttributes(array('id'=>$this->course_id,'is_deleted'=>0));
			return $this->name.' ('.$course->course_name.')';
	}
	
	public function getOfferingName($separator = '-')
	{
		return "{$this->course123->course_name} $separator $this->name";
	}
	
	public function getUnenrolledBatches($studentId) 
	{
		try {
			$dbh = new PDO(DB_CONNECTION, DB_USER, DB_PWD);

			// Get array of batches that the student is not enrolled in.
			$pdo = $dbh->prepare('
				SELECT B.id as `id`, CONCAT(C.course_name, " - ", B.name) as `batch`
				FROM `batches` B
				LEFT JOIN `batch_students` BS
				  ON B.id = BS.batch_id
				  AND BS.student_id = :student
				LEFT JOIN `courses` C
				  ON B.course_id = C.id
				WHERE BS.student_id IS NULL
				  AND B.is_deleted = 0
				  AND B.is_active = 1;
			');

			$pdo->execute(array(
				':student' => $studentId
			));

			$results = $pdo->fetchAll(PDO::FETCH_KEY_PAIR);
			
			foreach($results as $key => $result) {
				$batch = Batches::model()->findByPk($key);
				
				if(!$batch->updateActiveStatus()) {
					unset($results[$key]);
				}
			}
			return $results;
		}
		catch (Exception $ex) {
			echo 'Failed to query database: ' . $ex->getMessage();
		}
	}
	
	public function getEnrolledBatches($studentID, $falseKey = false) 
	{
		$key = $falseKey ? -1 : 1;
		
		try {
			$dbh = new PDO(DB_CONNECTION, DB_USER, DB_PWD);
			
			// Get array of batches that the student is enrolled in.
			$pdo = $dbh->prepare("
				SELECT B.id * :key as `id`, CONCAT(C.course_name, ' - ', B.name) as `batch`
				FROM `batches` B
				JOIN `batch_students` BS
				  ON B.id = BS.batch_id
				  AND B.is_active = 1
				  AND B.is_deleted = 0
				  AND BS.student_id = :student
				  JOIN `courses` C
					ON B.course_id = C.id;
			");

			$pdo->execute(array(
				'key' => $key,
				'student' => $studentID
			));
			
			$results = $pdo->fetchAll(PDO::FETCH_KEY_PAIR);
			
			foreach($results as $key => $result) {
				$batch = Batches::model()->findByPk($key);
				
				if(!$batch->updateActiveStatus()) {
					unset($results[$key]);
				}
			}

			return $results;
		} catch (Exception $ex) {
			echo 'Failed to query database: ' . $ex->getMessage();
		}
	}
	
	public function getUntaughtBatches($employeeId) {
		try {
			$dbh = new PDO(DB_CONNECTION, DB_USER, DB_PWD);
			$pdo = $dbh->prepare("
				SELECT B.id, CONCAT(C.course_name, ' - ', B.name)
				FROM batches B
				LEFT JOIN batch_employees BE
				  ON BE.batch_id = B.id
				  AND BE.employee_id = :employee
				LEFT JOIN courses C
				  ON C.id = B.course_id
				WHERE B.is_active = 1
				  AND B.is_deleted = 0
				  AND ISNULL(BE.employee_id);
			");
			
			$pdo->execute(array(
				'employee' => $employeeId
			));
			
			$results = $pdo->fetchAll(PDO::FETCH_KEY_PAIR);
			
			foreach($results as $key => $result) {
				$batch = Batches::model()->findByPk($key);
				
				if(!$batch->updateActiveStatus()) {
					unset($results[$key]);
				}
			}
			
			return $results;
		} catch (Exception $ex) {
			echo 'Failed to query database: ' . $ex->getMessage();
		}
	}
	
	public function getTaughtBatches($employeeId) {
		try {
			$dbh = new PDO(DB_CONNECTION, DB_USER, DB_PWD);
			$pdo = $dbh->prepare("
				SELECT B.id, CONCAT(C.course_name, ' - ', B.name)
				FROM batches B
				JOIN batch_employees BE
				  ON BE.batch_id = B.id
				  AND BE.employee_id = :employee
				JOIN courses C
				  ON C.id = B.course_id;
			");
			
			$pdo->execute(array(
				'employee' => $employeeId
			));
			
			$results = $pdo->fetchAll(PDO::FETCH_KEY_PAIR);
			
			foreach($results as $key => $result) {
				$batch = Batches::model()->findByPk($key);
				
				if(!$batch->updateActiveStatus()) {
					unset($results[$key]);
				}
			}
			
			return $results;
		} catch (Exception $ex) {
			echo 'Failed to query database: ' . $ex->getMessage();
		}
	}
	
	public function updateActiveStatus($status = false)
	{
		if(!is_int($status)) {
			$status = $this->end_date >= date('Y-m-d') ? 1 : 0;
		}
		
		$this->is_active = $status;
		$this->save();
		return $status;
	}
	
	public function addEmployees(array $employeeIds) {		
		try {
			$count = count($employeeIds);
			$values = [];

			foreach($employeeIds as $id) {
				$values[] = $this->id;
				$values[] = $id;
			}
			$tuples = '(?,?)';

			foreach(array_slice($employeeIds, 1) as $id) {
				$tuples .= ', (?,?)';
			}
			$dbh = new PDO(DB_CONNECTION, DB_USER, DB_PWD);
			
			// Get array of batches that the student is enrolled in.
			$pdo = $dbh->prepare(
				"INSERT INTO `batch_employees` (`batch_id`, `employee_id`)
				VALUES $tuples;"
			);
			
			$pdo->execute($values);
		} catch (Exception $ex) {
			echo 'Failed to query database: ' . $ex->getMessage();
		}
	}
	
	public function removeEmployees(array $employeeIds) {
		$values = implode(', ', $employeeIds);
		
		try {
			$dbh = new PDO(DB_CONNECTION, DB_USER, DB_PWD);
			
			// Get array of batches that the student is enrolled in.
			$pdo = $dbh->prepare(
				"DELETE FROM `batch_employees`
				WHERE `batch_id` = :batch_id
				AND `employee_id` IN ($values)"				
			);
			
			return $pdo->execute(['batch_id' => $this->id]);
		} catch (Exception $ex) {
			echo 'Failed to query database: ' . $ex->getMessage();
		}
	}
	
	public function updateEmployees(array $employeeIds) {
		$currentEmployees = $this->employees;
		foreach($currentEmployees as &$emp) {
			$emp = $emp->id;
		}
		
		$delete = array_diff($currentEmployees, $employeeIds);
		$add = array_diff($employeeIds, $currentEmployees);
		
		if(!empty($delete)) {
			$removeResult = $this->removeEmployees($delete);
		}
		
		if(!empty($add)) {
			$addResult = $this->addEmployees($add);
		}
		return $this->employees;
	}
}