   
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

    <div id="product-sidebar" class="product-page">
        <div class="sidebar-column">
            
            <?php if (Yii::app()->user->getState('role') === 'admin'): ?>
                <aside class="sidebar admin-side">
                    <div class="filter-section">
                        <h4>Actions</h4>
                        <ul class="menu-links">
                            <li>
                                <a href="<?php echo CHtml::normalizeUrl(array('product/create')); ?>">
                                    <i class="fa fa-plus-circle"></i> Add Product
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo CHtml::normalizeUrl(array('product/admin')); ?>">
                                    <i class="fa fa-cogs"></i> Manage Products
                                </a>
                            </li>
                        </ul>
                    </div>
                </aside>
            <?php endif; ?>

            <aside class="sidebar sidebar-filter">
                <div class="filter-section">
                    <h4>Availability</h4>
                    <label><input type="checkbox"> In stock / Pre-order</label><br>
                    <label><input type="checkbox"> Out of stock</label>
                </div>

                <div class="filter-section">
                    <h4>Categories</h4>
                    <div class="filter-scroll limited-height" id="category-filter">
                        <?php foreach ($categories as $category): ?>
                            <label>
                                <input type="checkbox" value="<?php echo CHtml::encode($category->id); ?>">
                                <?php echo CHtml::encode($category->name); ?>
                            </label><br>
                        <?php endforeach; ?>
                    </div>
                    <div class="toggle-btn-wrapper">
                        <button type="button" class="toggle-btn" data-target="#category-filter">Show More</button>
                    </div>
                </div>

                <!-- <div class="filter-section">
                    <h4>Brand</h4>
                    <div class="filter-scroll limited-height" id="brand-filter">
                        <?php //foreach ($brands as $brand): ?>
                            <label>
                                <input type="checkbox" value="<?php //echo CHtml::encode($brand); ?>">
                                <?php //echo CHtml::encode($brand); ?>
                            </label><br>
                        <?php //endforeach; ?>
                    </div>
                    <div class="toggle-btn-wrapper">
                        <button type="button" class="toggle-btn" data-target="#brand-filter">Show More</button>
                    </div>
                </div> -->
            </aside>
        </div>

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
