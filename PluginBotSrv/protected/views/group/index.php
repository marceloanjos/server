<?php
/* @var $this GroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Groups',
);

$this->menu=array(
	array('label'=>'Create Group', 'url'=>array('create')),
	array('label'=>'Manage Groups', 'url'=>array('admin')),
);
?>

<h1>Groups</h1>

Groups are an easy way to organize your devices. Typically groups would line up with business functions, for example, you would have a group for management, a group for sales, and one for marketing. 
<br><br>
Policies and Plugins can also be linked to groups, allowing you to manage large numbers of devices with little effort. Simply add a device to a group and then link the policies and configurations to the group, the device will automatically inherit the policies and plugins.
<br><br>