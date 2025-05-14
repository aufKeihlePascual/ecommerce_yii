<section id="manage-products" class="section-p1 bg-dark text-light">
    <div class="manage-container">

        <div class="header-row">
            <h1>Manage Products</h1>
            <!-- <p class="subtext">
                You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>,
                <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values.
            </p> -->
        </div>

        <div class="action-links">
            <?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn-light')); ?>
            <?php echo CHtml::link('Create Product', array('create'), array('class' => 'btn-primary')); ?>
        </div>

        <div class="search-form" style="display:none">
            <?php $this->renderPartial('_search',array('model'=>$model)); ?>
        </div>

        <!-- <div class="grid-wrapper">
            <?php //$this->widget('zii.widgets.grid.CGridView', array(
                // 'id'=>'product-grid',
                // 'dataProvider'=>$model->search(),
                // 'filter'=>$model,
                // 'itemsCssClass'=>'table table-bordered table-striped',
                // 'pagerCssClass'=>'pagination-wrapper',
                // 'htmlOptions' => ['class' => 'table-responsive'],
                // 'columns'=>array(
                //     'id',
                //     'brand',
                //     'name',
                //     'description',
                //     'price',
                //     'stock',
                //     array(
                //         'class'=>'CButtonColumn',
                //         'header'=>'Actions',
                //         'htmlOptions'=>['style'=>'width: 100px; text-align:center;'],
                //     ),
                // ),
            //)); ?>
        </div> -->

		<div class="grid-wrapper">
			<div class="table-responsive-wrapper">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'product-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'itemsCssClass'=>'table table-striped',
					'htmlOptions' => ['class' => 'table-wrapper'],
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
					'columns'=>array(
						// 'id',
						'brand',
						'name',
						'description',
						'price',
						'stock',
						array(
							'class'=>'CButtonColumn',
							'header'=>'Actions',
							'htmlOptions'=>['style'=>'width: 100px; text-align:center;'],
						),
					),
				)); ?>
			</div>
		</div>



    </div>
</section>
