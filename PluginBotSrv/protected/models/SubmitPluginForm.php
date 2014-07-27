<?php

/**
 * This is the model class for table "PluginFile".
 */
class SubmitPluginForm extends PluginFile
{
    public $uploadfile;
    public $overwrite;
    
    /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('overwrite, OperatingSystemID,Bits, Name, URL, DateReleased, Version, Size, ShortDescription, Description', 'required'),
			array('Size', 'numerical', 'integerOnly'=>true),
			array('OperatingSystemID', 'length', 'max'=>20),
			array('Name, URL, Version, ShortDescription', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
                    array('uploadfile','file', 'types'=>'zip,ZIP','allowEmpty'=>false ,'maxSize'=>5242880, 'tooLarge'=>'File has to be smaller than 5MB','on'=>'create'),
                    array('uploadfile','file', 'types'=>'zip,ZIP','allowEmpty'=>true ,'maxSize'=>5242880, 'tooLarge'=>'File has to be smaller than 5MB','on'=>'update'),
                    
                    array('idPluginFile, uploadfile, OperatingSystemID, Bits, Name, URL, DateReleased, Version, Size, ShortDescription, Description,overwrite', 'safe', 'on'=>'search'),
		);
	}
}