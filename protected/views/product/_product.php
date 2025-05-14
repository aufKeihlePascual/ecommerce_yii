<?php
$image = $data->image ? $data->image : 'placeholder.jpg';
?>

<div id="prod" class="pro">
        <div class="image-wrapper">
            <a href="<?php echo Yii::app()->createUrl('product/view', ['id' => $data->id]); ?>">
                <img src="<?php echo Yii::app()->baseUrl . '/images/products/' . CHtml::encode($image); ?>" alt="<?php echo CHtml::encode($data->name); ?>">
            </a>
        </div>
        <div id="prod-star" class="des">
            <span><?php echo CHtml::encode($data->brand); ?></span>
            <h5><?php echo CHtml::encode($data->name); ?></h5>
            <h4>₱ <?php echo number_format($data->price, 2); ?></h4>
        </div>
        <a href="#" class="add-to-cart-link" data-id="<?php echo $data->id; ?>">
            <i class="fa-solid fa-cart-plus cart"></i>
        </a>
</div>
