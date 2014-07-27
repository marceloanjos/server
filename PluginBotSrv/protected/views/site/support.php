<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Support';
$this->breadcrumbs=array(
        'Support'
);

?>

 <div class="cleartable">
    <div class="pagecell">
         <h1>Support Information</h1>
<p>
    Created in 2013 by Bryan Cairns, this application is a cross-platform service that can be configured from a central location. The client application can automatically download, configure, and run plugins.
    <br><br>
    
    This software provided by <a href="http://www.pluginbot.net">pluginbot.net</a> comes "as is" without any expressed or implied support. But occasionally we will entertain offers for paid support, please <a href="http://pluginbot.net/index.php?r=site/contact">contact</a> us for more information.
</p>
        
    </div>  
    <div class="cell sideimage">
        <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/contact.jpg') ?>
    </div>
  </div>

