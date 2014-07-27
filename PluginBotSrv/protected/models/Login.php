<?php

/**
 * This is the model class for table "Login".
 *
 * The followings are the available columns in table 'Login':
 * @property string $idLogin
 * @property string $FirstName
 * @property string $LastName
 * @property string $Email
 * @property string $Password
 * @property string $DateLogin
 * @property integer $isEnabled
 */
class Login extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Login the static model class
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
		return 'Login';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Email, Password', 'required'),
			array('isEnabled', 'numerical', 'integerOnly'=>true),
			array('FirstName, LastName, Email, Password', 'length', 'max'=>255),
			array('DateLogin', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idLogin, FirstName, LastName, Email, Password, DateLogin, isEnabled', 'safe', 'on'=>'search'),
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
			'idLogin' => 'Id Login',
			'FirstName' => 'First Name',
			'LastName' => 'Last Name',
			'Email' => 'Email',
			'Password' => 'Password',
			'DateLogin' => 'Date Login',
			'isEnabled' => 'Is Enabled',
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

		$criteria->compare('idLogin',$this->idLogin,true);
		$criteria->compare('FirstName',$this->FirstName,true);
		$criteria->compare('LastName',$this->LastName,true);
		$criteria->compare('Email',$this->Email,true);
		$criteria->compare('Password',$this->Password,true);
		$criteria->compare('DateLogin',$this->DateLogin,true);
		$criteria->compare('isEnabled',$this->isEnabled,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}