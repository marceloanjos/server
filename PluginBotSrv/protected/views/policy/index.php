<?php
/* @var $this PolicyController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Policies',
);

$this->menu=array(
	array('label'=>'Create Policy', 'url'=>array('create')),
	array('label'=>'Manage Policies', 'url'=>array('admin')),
);
?>

<h1>Policies</h1>

Policies are the ultimate automation tool. Imagine being able to remotely secure information on an automated basis. Policies have a trigger and action functionality. For example you could create a policy that would check to see how long a device as gone without reporting back. If the device has gone longer then 30 days, then remove all data from the device.
<br><br>
Policies can be applied to groups and all the devices in the group will inherit the policy. Each time the device updates with the site it will download the new policy and begin enforcing it.
<br><br>