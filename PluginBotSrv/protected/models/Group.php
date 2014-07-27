<?php

/**
 * This is the model class for table "Group".
 *
 * The followings are the available columns in table 'Group':
 * @property string $idGroup
 * @property string $Name
 * @property string $Description
 *
 * The followings are the available model relations:
 * @property GroupDevice[] $groupDevices
 * @property GroupPlugin[] $groupPlugins
 * @property GroupPolicy[] $groupPolicies
 */
class Group extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Group the static model class
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
		return 'Group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Name', 'required'),
			array('Name', 'length', 'max'=>255),
			array('Description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idGroup, Name, Description', 'safe', 'on'=>'search'),
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
			'groupDevices' => array(self::HAS_MANY, 'GroupDevice', 'GroupID'),
			'groupPlugins' => array(self::HAS_MANY, 'GroupPlugin', 'GroupID'),
			'groupPolicies' => array(self::HAS_MANY, 'GroupPolicy', 'GroupID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idGroup' => 'Id Group',
			'Name' => 'Name',
			'Description' => 'Description',
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

		$criteria->compare('idGroup',$this->idGroup,true);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Description',$this->Description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}