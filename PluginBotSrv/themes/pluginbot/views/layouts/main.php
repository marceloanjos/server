<?php
/* @var $this Controller */

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?>  Server Edition</title>
</head>

<body>
    <div class="darkarea">
        <div class="container">
            
            <div class="table">
                <div class="row">
                <div class="cell">
                    <div id="logo">
                        <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/pluginbot-ubuntu-48x48.png') ?>
                        <?php echo CHtml::encode(Yii::app()->name); ?>  Server
                    </div>
                </div>
                <div class="cell">
                    
                    <div id="logosmall">
                        <h2>
                          
                        <?php

                            $config = array(
                                'hideOnContentClick'=>true,
                                'hideOnOverlayClick'=>true,
                                'closeClick'=>false,
                                'type'=>'iframe',
                                'showCloseButton' => true,
                                'scrolling'=>'no',
                                'width'=>Yii::app()->params['videowidth'] + 10,
                                'height'=>Yii::app()->params['videoheight'] + 10,
                                );

                                  $this->widget('application.extensions.fancybox.EFancyBox', array(
                                    'target'=>'#tutorial',
                                    'config'=>$config,));

                                   echo CHtml::image(Yii::app()->request->baseUrl . '/images/whitevid.png');
                                    echo CHtml::link('&nbsp;Show me how!',array('tutorial/watch','path'=>$this->id . '/' . $this->action->id),array('id'=>'tutorial','class'=>'whitelink'));

                            ?>
                        </h2>
                        
                    </div>
                </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <div class="menuarea">
        <div class="container">
            <div id="mainmenu">
                    <?php 
                    if(Yii::app()->user->isGuest)
                    {
                        $armenu = array(
                            'items'=>array(
                                    array('label'=>'Login', 'url'=>array('/site/index')),
                                    array('label'=>'Tutorials', 'url'=>array('/tutorial/index'), 'active'=>($this->id == 'tutorial' ? true: false)),
                                    array('label'=>'Support', 'url'=>array('/site/support')),
                                
                            ),
                        );
                    }
                    else
                    {
                        $armenu = array(
                            'items'=>array(
                                    array('label'=>'Logins', 'url'=>array('/login/index'), 'active'=>($this->id == 'login' ? true: false)),
                                    array('label'=>'Groups', 'url'=>array('/group/index'), 'active'=>($this->id == 'group' ? true: false)),
                                    array('label'=>'Policies', 'url'=>array('/policy/index'), 'active'=>(stripos($this->id,'policy')!==false ? true: false)),
                                    array('label'=>'Plugins', 'url'=>array('/plugin/index'), 'active'=>($this->id == 'plugin' ? true: false)),
                                    array('label'=>'Devices', 'url'=>array('/device/index'), 'active'=>($this->id == 'device' ? true: false)),
                                    array('label'=>'Logs', 'url'=>array('/log/index'), 'active'=>($this->id == 'log' ? true: false)),
                                    array('label'=>'Tutorials', 'url'=>array('/tutorial/index'), 'active'=>($this->id == 'tutorial' ? true: false)),
                                    array('label'=>'Support', 'url'=>array('/site/support')),
                                    array('label'=>'Logout', 'url'=>array('/site/logout')),
                            ),
                        );
                    }
                    
                    
                    
                    $this->widget('zii.widgets.CMenu',$armenu); ?>
            </div><!-- mainmenu -->
        </div>
    </div>
    <div class="bodyarea">
        <div class="container" id="page">
            <?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>
        </div>
    </div>
    
        <div class="menuarea">
        <div class="container">
            
            <div class="table">
                <div class="row">
                <div class="footer cell footermenu" id="menuarea">
                    <?php echo CHtml::link('Support', Yii::app()->createURL('site/support'), array('class'=>'whitelink')); ?>
                    <br>
                     <?php echo CHtml::link('Watch Tutorials', Yii::app()->createURL('tutorial/index'), array('class'=>'whitelink')); ?>
                   
                    
                </div>
                <div class="footer cell footermenu"  id="menuarea">
                     <?php echo CHtml::link('Legal Information', Yii::app()->createURL('site/legal'), array('class'=>'whitelink')); ?>
                     <br>
                     <?php echo CHtml::link('Privacy Policy', Yii::app()->createURL('site/privacy'), array('class'=>'whitelink')); ?>
                    
                </div>
                <div class="footer cell footermenu" id="menuarea">
                    <?php echo CHtml::link('Terms of Service', Yii::app()->createURL('site/tos'), array('class'=>'whitelink')); ?>
                    <br>
                    <?php echo CHtml::link('End User Agreement', Yii::app()->createURL('site/eula'), array('class'=>'whitelink')); ?>
                    
                </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <div class="darkarea">
        <div class="container">
            <div class="footer">Copyright &copy; <?php echo date('Y'); ?> by <?php echo CHtml::encode(Yii::app()->name); ?> - Version: <?php echo Yii::app()->params->appversion; ?><br/></div>
            
            
        </div>
    </div>
    
    
</body>
</html>
