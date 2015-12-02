<?php

/**
 * This is the model class for table "finance_fees".
 *
 * The followings are the available columns in table 'finance_fees':
 * @property integer $id
 * @property integer $batch_id
 * @property float $charge_amount
 * @property integer $student_id
 * @property integer $is_paid
 * @property float $paid_amount
 * @property string $payment_type
 * @property string $description
 */
class FinanceFees extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return FinanceFees the static model class
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
		return 'finance_fees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('batch_id, student_id, is_paid', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>255),
			array('charge_amount, paid_amount', 'numerical'),
			// The following rule is used by search().aw  
			// Please remove those attributes that should not be searched.
			array('id, batch_id, charge_amount, student_id, is_paid', 'safe', 'on'=>'search'),
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
			'student' => array(self::BELONGS_TO, 'Students', 'student_id'),
			'offering' => array(self::BELONGS_TO, 'Batches', 'batch_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'batch_id' => 'Offering ID',
			'charge_amount' => 'Charge',
			'student_id' => 'Student',
			'is_paid' => 'Is Paid',
			'paid_amount' => 'Amount Paid',
			'payment_type' => 'Payment Type',
			'description' => 'Description'
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
		$criteria->compare('batch_id',$this->fee_collection_id);
		$criteria->compare('charge_amount',$this->charge_amount,true);
		$criteria->compare('student_id',$this->student_id);
		$criteria->compare('is_paid',$this->is_paid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}