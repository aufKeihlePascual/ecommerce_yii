<?php 

$this->pageTitle = 'Payment Canceled'; 

?>

<div class="payment-status-container">
    <h2 class="text-danger"><i class="fa-solid fa-times-circle"></i> Payment Canceled</h2>
    <p>Your payment was not completed. You can try again or return to your cart.</p>
    <a href="<?php echo CHtml::normalizeUrl(['cart/shoppingCart']); ?>" class="btn btn-secondary">Return to Cart</a>
</div>
