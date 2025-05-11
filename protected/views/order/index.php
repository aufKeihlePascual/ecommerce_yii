<?php
/* @var $this OrderController */
/* @var $dataProvider CArrayDataProvider */

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

    <div class="order-page d-flex">
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

        <div class="order-table-wrapper">

			<table class="order-table">
				<thead>
					<tr>
						<th>Order Summary</th>
						<th>Items</th>
						<th>Date</th>
						<th>Status</th>
						<th>Total</th>
						<th>Actions</th>
					</tr>
				</thead>

				<?php $this->widget('zii.widgets.CListView', array(
					'dataProvider' => $dataProvider,
					'itemView' => '_order',
					'template' => "{items}", // only items here
					'itemsTagName' => 'tbody',
				)); ?>
			</table>

			<div class="order-pagination-wrapper custom-pagination">
				<?php
				$this->widget('CLinkPager', array(
					'pages' => $dataProvider->pagination,
					'header' => '',
					'selectedPageCssClass' => 'active-page',
					'hiddenPageCssClass' => 'hidden',
					'firstPageLabel' => '←',
					'prevPageLabel' => '<',
					'nextPageLabel' => '>',
					'lastPageLabel' => '→',
					'htmlOptions' => array(
						'class' => 'pagination-wrapper',
						'tag' => 'ul'
					),
				));
				?>
			</div>

        </div>
    </div>

</section>
