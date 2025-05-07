<?php
/* @var $this ProductController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array('Products');
?>

<section id="index-category" class="section-p1 bg-dark text-light">

    <div id="products-page" class="section-header">
        <div class="breadcrumbs">
            <?php if (isset($this->breadcrumbs)): ?>
                <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                    'htmlOptions' => array('class' => 'breadcrumb-links'),
                )); ?>
            <?php endif; ?>
        </div>
        <h2>Products</h2>
    </div>

    <div class="product-page">
        <aside class="sidebar">
            <div class="filter-section">
                <h4>Availability</h4>
                <label><input type="checkbox"> In stock / Pre-order</label><br>
                <label><input type="checkbox"> Out of stock</label>
            </div>

            <div class="filter-section">
                <h4>Brand</h4>
                <label><input type="checkbox"> Akko</label><br>
                <label><input type="checkbox"> Ducky</label><br>
                <label><input type="checkbox"> Keychron</label>
            </div>
        </aside>

        <div class="main-content">
			<?php $this->widget('zii.widgets.CListView', array(
				'dataProvider' => $dataProvider,
				'itemView' => '_product',
				'template' => "{items}\n{pager}",
				'itemsCssClass' => 'pro-container',
				'pagerCssClass' => 'custom-pagination',
				'pager' => array(
					'class' => 'CLinkPager',
					'header' => '',
					'selectedPageCssClass' => 'active-page',
					'hiddenPageCssClass' => 'hidden',
					'firstPageLabel' => '←',
					'prevPageLabel' => '<',
					'nextPageLabel' => '>',
					'lastPageLabel' => '→',
					'htmlOptions' => array('class' => 'pagination-wrapper'),
				),
			)); ?>
		</div>
    </div>

</section>
