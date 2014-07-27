<?php

/**
 * This is the model class for table "Policy".
 *
 * The followings are the available columns in table 'Policy':
 * @property string $idPolicy
 * @property string $Name
 * @property string $Description
 * @property string $PolicyTriggerID
 * @property string $PolicyActionID
 * @property string $TriggerValue1
 * @property string $ActionValue1
 * @property string $ActionValue2
 *
 * The followings are the available model relations:
 * @property GroupPolicy[] $groupPolicies
 * @property PolicyTrigger $policyTrigger
 * @property PolicyAction $policyAction
 */
class Policy extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Policy the static model class
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
		return 'Policy';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Name, PolicyTriggerID, PolicyActionID', 'required'),
			array('Name, TriggerValue1, ActionValue1, ActionValue2', 'length', 'max'=>255),
			array('PolicyTriggerID, PolicyActionID', 'length', 'max'=>20),
			array('Description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idPolicy, Name, Description, PolicyTriggerID, PolicyActionID, TriggerValue1, ActionValue1, ActionValue2', 'safe', 'on'=>'search'),
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
			'groupPolicies' => array(self::HAS_MANY, 'GroupPolicy', 'PolicyID'),
			'policyTrigger' => array(self::BELONGS_TO, 'PolicyTrigger', 'PolicyTriggerID'),
			'policyAction' => array(self::BELONGS_TO, 'PolicyAction', 'PolicyActionID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idPolicy' => 'Id Policy',
			'Name' => 'Name',
			'Description' => 'Description',
			'PolicyTriggerID' => 'Policy Trigger',
			'PolicyActionID' => 'Policy Action',
			'TriggerValue1' => 'Trigger Value1',
			'ActionValue1' => 'Action Value1',
			'ActionValue2' => 'Action Value2',
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

		$criteria->compare('idPolicy',$this->idPolicy,true);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Description',$this->Description,true);
		$criteria->compare('PolicyTriggerID',$this->PolicyTriggerID,false);
		$criteria->compare('PolicyActionID',$this->PolicyActionID,false);
		$criteria->compare('TriggerValue1',$this->TriggerValue1,true);
		$criteria->compare('ActionValue1',$this->ActionValue1,true);
		$criteria->compare('ActionValue2',$this->ActionValue2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}