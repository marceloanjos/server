<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Legal';
$this->breadcrumbs=array(
	'Legal',
);

?>

<h1>Legal Information</h1>

            Personally we love to write software, and reading millions of pages of EULA, TOS, Policies, and Agreements is not the way anyone should have to spend an afternoon.
            <br><br>
            The sad truth is there are millions of frivolous law suits every day, these legal agreements are a necessary evil for your protection and ours.
            <br><br>
            
            <b>It's Free fro personal use</b><br>
            Feel free for personal use, install as many copies as you want, and give it to all your friends. We may however charge for advanced features or additional functionality for business and governments. You are not allowed to re-sell the software in any way.
            <br><br>
            
            <b>We won't sell your information</b><br>
            We are in the business of writing software, so don't worry we are not going to sell your information, we will not give it away, and we will not trade it. However we maybe be asked to give the information to law enforcement to aid in the recovery or a lost or stolen device. Recovering a device or data is your responsibility  and we will not help you.
            <br><br>
            
             <b>Legal disputes</b><br>
             The nature of this software is to secure, recover, and access remote devices and information, in the event that we can not recover the device or information, the software can be configured to destroy the information. For that very reason we will not be party to or subject of any legal dispute or legal action, the software comes "as is" and we accept no responsibility for any damages, or loss that may occur.
            <br><br>
            
            For those of you out there that just have to see the long winded details:<br>
            <?php echo CHtml::link('End User License Agreement', $this->createUrl('site/eula')); ?><br>
            <?php echo CHtml::link('Terms of Service', $this->createUrl('site/tos')); ?><br>
            <?php echo CHtml::link('Privacy Policy', $this->createUrl('site/privacy')); ?><br>