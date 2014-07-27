<?php

/**
 * This is the model class for table "PolicyTrigger".
 *
 * The followings are the available columns in table 'PolicyTrigger':
 * @property string $idPolicyTrigger
 * @property string $Name
 * @property string $Description
 * @property string $Label1
 * @property integer $hasValue1
 * @property string $ValueTypeID1
 * @property string $Default1
 *
 * The followings are the available model relations:
 * @property Policy[] $policies
 * @property ValueType $valueTypeID1
 */
class PolicyTrigger extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PolicyTrigger the static model class
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
		return 'PolicyTrigger';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Name, Description, Label1, hasValue1, ValueTypeID1', 'required'),
			array('hasValue1', 'numerical', 'integerOnly'=>true),
			array('Name, Label1, Default1', 'length', 'max'=>255),
			array('ValueTypeID1', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idPolicyTrigger, Name, Description, Label1, hasValue1, ValueTypeID1, Default1', 'safe', 'on'=>'search'),
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
			'policies' => array(self::HAS_MANY, 'Policy', 'PolicyTriggerID'),
			'valueTypeID1' => array(self::BELONGS_TO, 'ValueType', 'ValueTypeID1'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idPolicyTrigger' => 'Id Policy Trigger',
			'Name' => 'Name',
			'Description' => 'Description',
			'Label1' => 'Label1',
			'hasValue1' => 'Has Value1',
			'ValueTypeID1' => 'Value Type Id1',
			'Default1' => 'Default1',
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

		$criteria->compare('idPolicyTrigger',$this->idPolicyTrigger,true);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Description',$this->Description,true);
		$criteria->compare('Label1',$this->Label1,true);
		$criteria->compare('hasValue1',$this->hasValue1,false);
		$criteria->compare('ValueTypeID1',$this->ValueTypeID1,true);
		$criteria->compare('Default1',$this->Default1,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}