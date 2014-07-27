<?php
/* @var $this PluginController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Plugins',
);

$this->menu=array(

        array('label'=>'Browse Plugin Files', 'url'=>array('browse')),
        array('label'=>'Upload Plugin Files', 'url'=>array('submit')),
        array('label'=>'Manage Plugin Files', 'url'=>array('submitions')),
	array('label'=>'Create Plugin', 'url'=>array('create')),
	array('label'=>'Manage Plugins', 'url'=>array('admin')),

);
?>

<h1>Plugins</h1>

Plugins are an easy way to extend the functionality of the application. Because this is a plugin based system, it allows for unlimited possibilities and scalability. For example, a plugin could act as a key logger monitoring key strokes, or a web server, or even a real time script engine that allowed you to run scripts on your devices remotely. 
<br><br>
A plugin configuration is simply a means of remotely installing and configuring plugins on your devices automatically. Each time a device updates, it will check for any linked configurations and automatically download, install, and configure the plugins. Additinally, any plugins not linked will automatically be uninstalled.
<br><br>