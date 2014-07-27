<?php

/**
 * This is the model class for table "GroupDevice".
 *
 * The followings are the available columns in table 'GroupDevice':
 * @property string $idGroupDevice
 * @property string $GroupID
 * @property string $DeviceID
 *
 * The followings are the available model relations:
 * @property Group $group
 * @property Device $device
 */
class GroupDevice extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GroupDevice the static model class
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
		return 'GroupDevice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('GroupID, DeviceID', 'required'),
			array('GroupID, DeviceID', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idGroupDevice, GroupID, DeviceID', 'safe', 'on'=>'search'),
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
			'group' => array(self::BELONGS_TO, 'Group', 'GroupID'),
			'device' => array(self::BELONGS_TO, 'Device', 'DeviceID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idGroupDevice' => 'Id Group Device',
			'GroupID' => 'Group',
			'DeviceID' => 'Device',
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

		$criteria->compare('idGroupDevice',$this->idGroupDevice,true);
		$criteria->compare('GroupID',$this->GroupID,false);
		$criteria->compare('DeviceID',$this->DeviceID,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}