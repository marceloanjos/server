<?php

/**
 * This is the model class for table "PluginOption".
 *
 * The followings are the available columns in table 'PluginOption':
 * @property string $idPluginOption
 * @property string $PluginFileID
 * @property string $ValueTypeID
 * @property string $Name
 * @property string $Default
 * @property string $Description
 *
 * The followings are the available model relations:
 * @property PluginItem[] $pluginItems
 * @property PluginFile $pluginFile
 * @property ValueType $valueType
 */
class PluginOption extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PluginOption the static model class
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
		return 'PluginOption';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('PluginFileID, ValueTypeID, Name, Default, Description', 'required'),
			array('PluginFileID, ValueTypeID', 'length', 'max'=>20),
			array('Name, Default', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idPluginOption, PluginFileID, ValueTypeID, Name, Default, Description', 'safe', 'on'=>'search'),
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
			'pluginItems' => array(self::HAS_MANY, 'PluginItem', 'PluginOptionID'),
			'pluginFile' => array(self::BELONGS_TO, 'PluginFile', 'PluginFileID'),
			'valueType' => array(self::BELONGS_TO, 'ValueType', 'ValueTypeID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idPluginOption' => 'Id Plugin Option',
			'PluginFileID' => 'Plugin File',
			'ValueTypeID' => 'Value Type',
			'Name' => 'Name',
			'Default' => 'Default',
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

		$criteria->compare('idPluginOption',$this->idPluginOption,true);
		$criteria->compare('PluginFileID',$this->PluginFileID,false);
		$criteria->compare('ValueTypeID',$this->ValueTypeID,false);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Default',$this->Default,true);
		$criteria->compare('Description',$this->Description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}