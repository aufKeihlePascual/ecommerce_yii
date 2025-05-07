<?php
/* @var $this OrderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Orders',
);

$this->menu=array(
	array('label'=>'Create Order', 'url'=>array('create')),
	array('label'=>'Manage Order', 'url'=>array('admin')),
);
?>

<section id="orders-page" class="section-p1 bg-dark text-light">
  <div class="section-header">
    <h2 class="mb-4">Your Orders</h2>
  </div>

	<<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'itemsCssClass'=>'orders-list row',
	'pagerCssClass'=>'custom-pagination',
	'template'=>'{items}{pager}',
	'pager'=>array(
		'class'=>'CLinkPager',
		'header'=>'',
		'selectedPageCssClass'=>'active-page',
		'htmlOptions'=>array('class'=>'pagination-wrapper'),
		'prevPageLabel'=>'<', 'nextPageLabel'=>'>',
		'firstPageLabel'=>'←', 'lastPageLabel'=>'→',
	),
	)); ?>
</section>

