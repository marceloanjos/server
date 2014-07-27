<?php
/* @var $this DeviceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Devices',
);

$this->menu=array(
	array('label'=>'Create Device', 'url'=>array('create')),
	array('label'=>'Manage Devices', 'url'=>array('admin')),
);



?>

<h1>Devices</h1>

A device could be a cellphone, laptop, desktop, server, or any other device that runs a supported operating system such as Windows, Linux, IOS, and Android. Devices can be added to groups and managed through policies. 
<br><br>
Devices can be flagged as “missing” which will act as a trigger in a policy item. You can also pre-stage devices in the system so you will be able to perform planning and configuration before you install any software on on a single device.
<br><br>
Adding a device does not install the software, you will need to install the software on the device for the system to function.
<br><br>

<div class="flash-success">
If you want to install a large number of devices automatically, modify the global.ini file and set the following lines:
<br><br>
<b>
    code=<?php echo Security::getInstallCode(0, 0); ?><br>
    url=<?php echo Yii::app()->getBaseUrl(true); ?>/index.php?r=xml<br>
</b>
</div>