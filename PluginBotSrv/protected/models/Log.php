<?php

/**
 * This is the model class for table "Log".
 *
 * The followings are the available columns in table 'Log':
 * @property integer $idLog
 * @property string $DeviceID
 * @property string $EventDate
 * @property string $IPAddress
 * @property string $Name
 * @property string $Description
 *
 * The followings are the available model relations:
 * @property Device $device
 */
class Log extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Log the static model class
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
		return 'Log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('DeviceID, EventDate, IPAddress, Name, Description', 'required'),
			array('DeviceID', 'length', 'max'=>20),
			array('IPAddress, Name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idLog, DeviceID, EventDate, IPAddress, Name, Description', 'safe', 'on'=>'search'),
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
			'device' => array(self::BELONGS_TO, 'Device', 'DeviceID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idLog' => 'Id Log',
			'DeviceID' => 'Device',
			'EventDate' => 'Event Date',
			'IPAddress' => 'Ipaddress',
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

		$criteria->compare('idLog',$this->idLog,false);
		$criteria->compare('DeviceID',$this->DeviceID,false);
		$criteria->compare('EventDate',$this->EventDate,true);
		$criteria->compare('IPAddress',$this->IPAddress,true);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Description',$this->Description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}