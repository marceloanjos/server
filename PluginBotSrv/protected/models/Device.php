<?php

/**
 * This is the model class for table "Device".
 *
 * The followings are the available columns in table 'Device':
 * @property string $idDevice
 * @property string $OperatingSystemID
 * @property integer $Bits
 * @property string $Name
 * @property string $IPAddress
 * @property string $DateInstalled
 * @property string $DateUpdated
 * @property string $DateMissing
 * @property integer $UpdateInterval
 * @property integer $isMissing
 * @property string $Description
 *
 * The followings are the available model relations:
 * @property OperatingSystem $operatingSystem
 * @property GroupDevice[] $groupDevices
 * @property Log[] $logs
 */
class Device extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Device the static model class
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
		return 'Device';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('OperatingSystemID, Bits, Name', 'required'),
			array('Bits, UpdateInterval, isMissing', 'numerical', 'integerOnly'=>true),
			array('OperatingSystemID', 'length', 'max'=>20),
			array('Name, IPAddress', 'length', 'max'=>255),
			array('DateInstalled, DateUpdated, DateMissing, Description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idDevice, OperatingSystemID, Bits, Name, IPAddress, DateInstalled, DateUpdated, DateMissing, UpdateInterval, isMissing, Description', 'safe', 'on'=>'search'),
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
			'operatingSystem' => array(self::BELONGS_TO, 'OperatingSystem', 'OperatingSystemID'),
			'groupDevices' => array(self::HAS_MANY, 'GroupDevice', 'DeviceID'),
			'logs' => array(self::HAS_MANY, 'Log', 'DeviceID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idDevice' => 'Id Device',
			'OperatingSystemID' => 'Operating System',
			'Bits' => 'Bits',
			'Name' => 'Name',
			'IPAddress' => 'Ipaddress',
			'DateInstalled' => 'Date Installed',
			'DateUpdated' => 'Date Updated',
			'DateMissing' => 'Date Missing',
			'UpdateInterval' => 'Update Interval',
			'isMissing' => 'Is Missing',
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

		$criteria->compare('idDevice',$this->idDevice,true);
		$criteria->compare('OperatingSystemID',$this->OperatingSystemID,false);
		$criteria->compare('Bits',$this->Bits,false);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('IPAddress',$this->IPAddress,true);
		$criteria->compare('DateInstalled',$this->DateInstalled,true);
		$criteria->compare('DateUpdated',$this->DateUpdated,true);
		$criteria->compare('DateMissing',$this->DateMissing,true);
		$criteria->compare('UpdateInterval',$this->UpdateInterval,false);
		$criteria->compare('isMissing',$this->isMissing,false);
		$criteria->compare('Description',$this->Description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}