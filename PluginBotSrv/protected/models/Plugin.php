<?php

/**
 * This is the model class for table "Plugin".
 *
 * The followings are the available columns in table 'Plugin':
 * @property string $idPlugin
 * @property string $PluginFileID
 * @property string $Name
 * @property string $Description
 *
 * The followings are the available model relations:
 * @property GroupPlugin[] $groupPlugins
 * @property PluginFile $pluginFile
 * @property PluginItem[] $pluginItems
 */
class Plugin extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Plugin the static model class
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
		return 'Plugin';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('PluginFileID, Name', 'required'),
			array('PluginFileID', 'length', 'max'=>20),
			array('Name', 'length', 'max'=>45),
			array('Description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idPlugin, PluginFileID, Name, Description', 'safe', 'on'=>'search'),
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
			'groupPlugins' => array(self::HAS_MANY, 'GroupPlugin', 'PluginID'),
			'pluginFile' => array(self::BELONGS_TO, 'PluginFile', 'PluginFileID'),
			'pluginItems' => array(self::HAS_MANY, 'PluginItem', 'PluginID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idPlugin' => 'Id Plugin',
			'PluginFileID' => 'Plugin File',
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

		$criteria->compare('idPlugin',$this->idPlugin,true);
		$criteria->compare('PluginFileID',$this->PluginFileID,false);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Description',$this->Description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}