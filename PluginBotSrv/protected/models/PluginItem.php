<?php

/**
 * This is the model class for table "PluginItem".
 *
 * The followings are the available columns in table 'PluginItem':
 * @property string $idPluginItem
 * @property string $PluginID
 * @property string $PluginOptionID
 * @property string $Value
 *
 * The followings are the available model relations:
 * @property Plugin $plugin
 * @property PluginOption $pluginOption
 */
class PluginItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PluginItem the static model class
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
		return 'PluginItem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('PluginID, PluginOptionID, Value', 'required'),
			array('PluginID, PluginOptionID', 'length', 'max'=>20),
			array('Value', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idPluginItem, PluginID, PluginOptionID, Value', 'safe', 'on'=>'search'),
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
			'plugin' => array(self::BELONGS_TO, 'Plugin', 'PluginID'),
			'pluginOption' => array(self::BELONGS_TO, 'PluginOption', 'PluginOptionID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idPluginItem' => 'Id Plugin Item',
			'PluginID' => 'Plugin',
			'PluginOptionID' => 'Plugin Option',
			'Value' => 'Value',
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

		$criteria->compare('idPluginItem',$this->idPluginItem,true);
		$criteria->compare('PluginID',$this->PluginID,false);
		$criteria->compare('PluginOptionID',$this->PluginOptionID,false);
		$criteria->compare('Value',$this->Value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}