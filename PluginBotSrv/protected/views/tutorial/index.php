<?php
/* @var $this TutorialController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tutorials',
);

?>

 <div class="cleartable">
    <div class="pagecell">
         <h1>Tutorials</h1>
      <p>
        You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
        or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
        </p>

        
    </div>  
    <div class="cell sideimage">
        <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/tutorial.jpg') ?>
    </div>
  </div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tutorial-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'Name',
		'Description',
       
        
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array
                        (
                            'view'=>array
                            (
                                'url'=>'Yii::app()->createUrl("tutorial/view", array("id"=>$data->idTutorial))',
                            ),
                            
                        )
		),
	),
)); ?>