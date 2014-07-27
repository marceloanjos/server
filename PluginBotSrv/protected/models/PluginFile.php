<?php

/**
 * This is the model class for table "PluginFile".
 *
 * The followings are the available columns in table 'PluginFile':
 * @property string $idPluginFile
 * @property string $OperatingSystemID
 * @property integer $Bits
 * @property string $Name
 * @property string $URL
 * @property string $DateReleased
 * @property string $Version
 * @property integer $Size
 * @property string $ShortDescription
 * @property string $Description
 *
 * The followings are the available model relations:
 * @property Plugin[] $plugins
 * @property OperatingSystem $operatingSystem
 * @property PluginOption[] $pluginOptions
 */
class PluginFile extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PluginFile the static model class
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
		return 'PluginFile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('OperatingSystemID, Bits, Name, URL, DateReleased, Version, Size, ShortDescription, Description', 'required'),
			array('Bits, Size', 'numerical', 'integerOnly'=>true),
			array('OperatingSystemID', 'length', 'max'=>20),
			array('Name, URL, Version, ShortDescription', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idPluginFile, OperatingSystemID, Bits, Name, URL, DateReleased, Version, Size, ShortDescription, Description', 'safe', 'on'=>'search'),
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
			'plugins' => array(self::HAS_MANY, 'Plugin', 'PluginFileID'),
			'operatingSystem' => array(self::BELONGS_TO, 'OperatingSystem', 'OperatingSystemID'),
			'pluginOptions' => array(self::HAS_MANY, 'PluginOption', 'PluginFileID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idPluginFile' => 'Id Plugin File',
			'OperatingSystemID' => 'Operating System',
			'Bits' => 'Bits',
			'Name' => 'Name',
			'URL' => 'Url',
			'DateReleased' => 'Date Released',
			'Version' => 'Version',
			'Size' => 'Size',
			'ShortDescription' => 'Short Description',
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

		$criteria->compare('idPluginFile',$this->idPluginFile,true);
		$criteria->compare('OperatingSystemID',$this->OperatingSystemID,false);
		$criteria->compare('Bits',$this->Bits,false);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('URL',$this->URL,true);
		$criteria->compare('DateReleased',$this->DateReleased,true);
		$criteria->compare('Version',$this->Version,true);
		$criteria->compare('Size',$this->Size,false);
		$criteria->compare('ShortDescription',$this->ShortDescription,true);
		$criteria->compare('Description',$this->Description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}