<?php
/* @var $this OrderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array('Orders');
?>

<section id="index-orders" class="section-p1 bg-dark text-light">

    <div id="orders-page" class="section-header">
        <div class="breadcrumbs">
            <?php if (isset($this->breadcrumbs)): ?>
                <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                    'htmlOptions' => array('class' => 'breadcrumb-links'),
                )); ?>
            <?php endif; ?>
        </div>
        <h2>Orders</h2>
    </div>

    <div class="product-page">
        <!-- Sidebar for Order Actions -->
        <aside class="sidebar">
            <div class="filter-section">
                <h4>Actions</h4>
                <ul class="menu-links">
                    <li>
                        <a href="<?php echo CHtml::normalizeUrl(array('order/create')); ?>">
                            <i class="fa fa-plus-circle"></i> Create Order
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo CHtml::normalizeUrl(array('order/admin')); ?>">
                            <i class="fa fa-cogs"></i> Manage Orders
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

		<div class="order-list">
			<?php $this->widget('zii.widgets.CListView', array(
				'dataProvider' => $dataProvider,
				'itemView' => '_orderCard',
				'template' => "{items}\n{pager}",
				'itemsCssClass' => 'order-container',
				'pagerCssClass' => 'custom-pagination',
			)); ?>
		</div>
    </div>

</section>
