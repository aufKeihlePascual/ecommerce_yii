<?php
$image = $data->image ? $data->image : 'placeholder.jpg';
?>

<div id="prod" class="pro">
    <div class="image-wrapper">
        <img src="<?php echo Yii::app()->baseUrl . '/images/products/' . CHtml::encode($image); ?>" alt="<?php echo CHtml::encode($data->name); ?>">
    </div>
    <div id="prod-star" class="des">
        <span><?php echo CHtml::encode($data->brand); ?></span>
        <h5><?php echo CHtml::encode($data->name); ?></h5>
        <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
        </div>
        <h4>₱ <?php echo number_format($data->price, 2); ?></h4>
    </div>
    <a href="#" class="add-to-cart-link" data-id="<?php echo $data->id; ?>">
        <i class="fa-solid fa-cart-plus cart"></i>
    </a>
</div>
