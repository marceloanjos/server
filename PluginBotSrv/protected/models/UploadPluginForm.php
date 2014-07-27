<?php


/**
 * The UploadPluginForm class is used to upload plugins
 */
class UploadPluginForm extends CFormModel
{
    public $UploadFile;


        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('UploadFile', 'required'),
                    array('UploadFile','file', 'types'=>'zip,ZIP','allowEmpty'=>false ,'maxSize'=>5242880, 'tooLarge'=>'File has to be smaller than 5MB','on'=>'create'),
                    array('UploadFile', 'safe', 'on'=>'search'),
		);
	}
        
        /**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
                        'UploadFile'=>'Select a plugin',
		);
	}

}
?>