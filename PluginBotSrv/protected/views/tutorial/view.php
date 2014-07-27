<?php
/* @var $this TutorialController */
/* @var $model Tutorial */

$this->breadcrumbs=array(
	'Tutorials'=>array('index'),
	$model->Name,
);

$this->menu=array(
	array('label'=>'Tutorials Home', 'url'=>array('index')),
);
?>

<h1>View Tutorial: <?php echo $model->Name; ?></h1>


<?php if(isset($model->VideoURL)): ?>
<center>
    <?php 
    
    
//You really need MP4 and WEBM to cover all the files
$this->widget('application.extensions.videojs.EVideoJS', array(
    'options' => array(
        // Unique identifier, is autogenerated by default, useful for jQuery integrations.
        'id' => false,
        // Video and poster width in pixels
        'width' => Yii::app()->params->videowidth,
        // Video and poster height in pixels
        'height' => Yii::app()->params->videoheight,
        // Poster image absolute URL
        'poster' => false,
        // Absolute URL of the video in MP4 format
        'video_mp4' => Yii::app()->request->baseUrl . '/videos/'. $model->VideoURL .'.mp4',
        // Absolute URL of the video in OGV format
        'video_ogv' => false,
        // Absolute URL of the video in WebM format
        'video_webm' => Yii::app()->request->baseUrl . '/videos/'. $model->VideoURL .'.webm',
        // Use Flash fallback player ?
        'flash_fallback' => true,
        // Address of custom Flash player to use as fallback
        'flash_player' =>'/PluginService/protected/extensions/videojs/assets/flowplayer-3.2.1.swf',//'http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf',
        // Show controls ?
        'controls' => true,
        // Preload video content ?
        'preload' => true,
        // Autostart the playback ?
        'autoplay' => true,
        // Show VideoJS support link ?
        'support' => false,
        // Show video download links ?
        'download' => false,
    ),
));
    
    ?>
</center><br><br>
<?php endif; ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Name',
		array(
                'name' => 'Description',
                'value' => nl2br($model->Description),
                 'type' => 'raw',
              ),
	),
)); ?>
