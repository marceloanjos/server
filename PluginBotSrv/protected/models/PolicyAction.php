<?php

/**
 * This is the model class for table "PolicyAction".
 *
 * The followings are the available columns in table 'PolicyAction':
 * @property string $idPolicyAction
 * @property string $Name
 * @property string $Description
 * @property string $Label1
 * @property string $Label2
 * @property integer $hasValue1
 * @property integer $hasValue2
 * @property string $ValueTypeID1
 * @property string $ValueTypeID2
 * @property string $Default1
 * @property string $Default2
 *
 * The followings are the available model relations:
 * @property Policy[] $policies
 * @property ValueType $valueTypeID1
 * @property ValueType $valueTypeID2
 */
class PolicyAction extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PolicyAction the static model class
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
		return 'PolicyAction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Name, Description, Label1, Label2, hasValue1, hasValue2, ValueTypeID1, ValueTypeID2, Default1, Default2', 'required'),
			array('hasValue1, hasValue2', 'numerical', 'integerOnly'=>true),
			array('Name, Description, Label1, Label2, Default1, Default2', 'length', 'max'=>255),
			array('ValueTypeID1, ValueTypeID2', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idPolicyAction, Name, Description, Label1, Label2, hasValue1, hasValue2, ValueTypeID1, ValueTypeID2, Default1, Default2', 'safe', 'on'=>'search'),
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
			'policies' => array(self::HAS_MANY, 'Policy', 'PolicyActionID'),
			'valueTypeID1' => array(self::BELONGS_TO, 'ValueType', 'ValueTypeID1'),
			'valueTypeID2' => array(self::BELONGS_TO, 'ValueType', 'ValueTypeID2'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idPolicyAction' => 'Id Policy Action',
			'Name' => 'Name',
			'Description' => 'Description',
			'Label1' => 'Label1',
			'Label2' => 'Label2',
			'hasValue1' => 'Has Value1',
			'hasValue2' => 'Has Value2',
			'ValueTypeID1' => 'Value Type Id1',
			'ValueTypeID2' => 'Value Type Id2',
			'Default1' => 'Default1',
			'Default2' => 'Default2',
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

		$criteria->compare('idPolicyAction',$this->idPolicyAction,true);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Description',$this->Description,true);
		$criteria->compare('Label1',$this->Label1,true);
		$criteria->compare('Label2',$this->Label2,true);
		$criteria->compare('hasValue1',$this->hasValue1,false);
		$criteria->compare('hasValue2',$this->hasValue2,false);
		$criteria->compare('ValueTypeID1',$this->ValueTypeID1,true);
		$criteria->compare('ValueTypeID2',$this->ValueTypeID2,true);
		$criteria->compare('Default1',$this->Default1,true);
		$criteria->compare('Default2',$this->Default2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}