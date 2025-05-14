<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs = array(
    'Products' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'Add Product', 'url' => array('create'), 'icon' => 'fa-plus-circle'),
    array('label' => 'Manage Products', 'url' => array('admin'), 'icon' => 'fa-cogs'),
);
?>

<section id="create-product-page">
    <div class="section-container">
		
        <div class="form-layout-row">
            <aside class="sidebar admin-side">
                <div class="filter-section">
                    <h4>Actions</h4>
                    <ul class="menu-links">
                        <?php foreach ($this->menu as $item): ?>
                            <li>
                                <a href="<?php echo CHtml::normalizeUrl($item['url']); ?>">
                                    <i class="fa <?php echo $item['icon']; ?>"></i>
                                    <?php echo $item['label']; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>

            <div class="form-panel">
                <h2 class="form-title">Add Product</h2>
                <?php $this->renderPartial('_form', [
                    'model'        => $model,
                    'categoryList' => $categoryList,
                ]); ?>
            </div>

        </div>
    </div>
</section>