<?php

/**
 * This is the model class for table "Tutorial".
 *
 * The followings are the available columns in table 'Tutorial':
 * @property string $idTutorial
 * @property string $Name
 * @property string $Path
 * @property string $VideoURL
 * @property string $Description
 */
class Tutorial extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tutorial the static model class
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
		return 'Tutorial';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Name, Description', 'required'),
			array('Name, Path, VideoURL', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idTutorial, Name, Path, VideoURL, Description', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idTutorial' => 'Id Tutorial',
			'Name' => 'Name',
			'Path' => 'Path',
			'VideoURL' => 'Video Url',
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

		$criteria->compare('idTutorial',$this->idTutorial,true);
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Path',$this->Path,true);
		$criteria->compare('VideoURL',$this->VideoURL,true);
		$criteria->compare('Description',$this->Description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}