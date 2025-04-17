<!-- Hero Section -->
  <div class="jumbotron text-white p-5 mb-5 rounded" style="background-image: url('<?php echo Yii::app()->baseUrl; ?>/images/hero_keyboard.png'); background-size: cover; background-position: center;">
    <h1 class="display-4 fw-bold">Craft Your Perfect Typing Experience</h1>
    <p class="lead">Explore premium keyboards, switches, and keycaps for the ultimate setup.</p>
    <a class="btn btn-primary btn-lg" href="<?php echo Yii::app()->createUrl('product/index'); ?>">Shop Now</a>
  </div>
  
  <div class="container">
  <!-- Shop by Category -->
  <h2 class="mb-4">Shop by Category</h2>
  <div class="row">
    <?php $categories = Category::model()->findAll(); ?>
    <?php foreach ($categories as $category): ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="/images/categories/<?php echo strtolower($category->name); ?>.jpg" class="card-img-top" alt="<?php echo CHtml::encode($category->name); ?>">
          <div class="card-body text-center">
            <h5 class="card-title"><?php echo CHtml::encode($category->name); ?></h5>
            <a href="<?php echo Yii::app()->createUrl('product/index', ['category' => $category->id]); ?>" class="btn btn-outline-primary">Browse</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- New Arrivals -->
  <h2 class="mt-5 mb-4">New Arrivals</h2>
  <div class="row">
    <?php $newProducts = Product::model()->findAll(['order' => 'id DESC', 'limit' => 4]); ?>
    <?php foreach ($newProducts as $product): ?>
      <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="/images/products/<?php echo $product->image; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h6 class="card-title mb-2"><?php echo CHtml::encode($product->name); ?></h6>
            <p class="text-muted">₱<?php echo number_format($product->price, 2); ?></p>
            <a href="<?php echo Yii::app()->createUrl('product/view', ['id' => $product->id]); ?>" class="btn btn-sm btn-primary">View</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Signature Collection -->
  <div class="bg-dark text-white p-5 rounded mt-5">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h3 class="fw-bold">The Signature Collection</h3>
        <p>Top-tier craftsmanship. Minimalist beauty. Engineered for excellence.</p>
        <a href="#" class="btn btn-outline-light">Explore Collection</a>
      </div>
      <div class="col-md-6">
        <img src="/images/signature.jpg" class="img-fluid rounded" alt="Signature Collection">
      </div>
    </div>
  </div>

  <!-- Active Group Buys -->
  <h2 class="mt-5 mb-4">Active Group Buys</h2>
  <div class="row">
    <?php $groupBuys = Product::model()->findAll(['limit' => 4]); ?>
    <?php foreach ($groupBuys as $product): ?>
      <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="/images/products/<?php echo $product->image; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h6 class="card-title mb-2"><?php echo CHtml::encode($product->name); ?></h6>
            <p class="text-muted">₱<?php echo number_format($product->price, 2); ?></p>
            <a href="#" class="btn btn-success btn-sm">Join Group Buy</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div>
