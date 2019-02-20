<?php rb_header(['header-allpages.php'], false) ?>
<div class="wrap-content">
  <div class="inner-content clear">
    <div class="products-category-title">
      <?php if(isset($CountResult)): ?>
        <h1><?= $CountResult ?> resultados encontrados</h1>
      <?php endif ?>
      <?php if(isset($category_info)): ?>
        <h1><?= $category_info['nombre'] ?></h1>
      <?php endif ?>
    </div>
    <div class="category-pagination">
			<ul>
        <li<?php if($CurrentPage==1) echo " class='page-disabled'" ?>>
					<a href="<?= $category_info['url'] ?>">«</a>
				</li>
				<li<?php if($PrevPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_category_page($product['categoria'], $PrevPage) ?>">‹</a>
				</li>
				<?php
				for ($i = 1; $i <= $TotalPage; $i++):
				?>
				<li>
					<a <?php if($CurrentPage==$i) echo " class='page-resalt'" ?>href="<?= url_category_page($product['categoria'], $i) ?>"><?= $i ?></a>
				</li>
				<?php
				endfor;
				?>
				<li<?php if($NextPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_category_page($product['categoria'], $NextPage) ?>">›</a>
				</li>
				<li<?php if($LastPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_category_page($product['categoria'], $LastPage) ?>">»</a>
				</li>
			</ul>
		</div>
    <div class="cols-container products">
        <?php
        foreach($products as $product){
        ?>
        <div class="cols-3-md">
          <div class="item_cat">
            <div class="product-item">
              <a href="<?= $product['url'] ?>">
                <?php if($product['descuento']>0): ?>
                <div class="product-discount">-<?= $product['descuento'] ?>%</div>
                <?php endif ?>
                <div class="product-item-cover-img" style="background-image:url('<?= $product['image_url'] ?>')">
                </div>
                <div class="product-item-desc">
                    <h3><?= $product['nombre'] ?></h3>
                    <div class="product-item-price">
                        <?php if($product['precio_oferta']>0): ?>
                          <span class="product-item-price-before">Normal: <?= G_COIN ?> <?= number_format($product['precio'], 2) ?></span>
                          <span class="product-item-price-now"><?= G_COIN ?> <?= number_format($product['precio_oferta'], 2) ?></span>
                        <?php else: ?>
                          <span class="product-item-price-before"></span>
                          <span class="product-item-price-now"><?= G_COIN ?> <?= number_format($product['precio'], 2) ?></span>
                        <?php endif ?>
                    </div>
                </div>
              </a>
            </div>
          </div>
        </div>
        <?php
        }
        ?>
    </div>
    <div class="category-pagination" style="margin-bottom:60px">
			<ul>
        <li<?php if($CurrentPage==1) echo " class='page-disabled'" ?>>
					<a href="<?= $category_info['url'] ?>">«</a>
				</li>
				<li<?php if($PrevPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_category_page($product['categoria'], $PrevPage) ?>">‹</a>
				</li>
				<?php
				for ($i = 1; $i <= $TotalPage; $i++):
				?>
				<li>
					<a <?php if($CurrentPage==$i) echo " class='page-resalt'" ?>href="<?= url_category_page($product['categoria'], $i) ?>"><?= $i ?></a>
				</li>
				<?php
				endfor;
				?>
				<li<?php if($NextPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_category_page($product['categoria'], $NextPage) ?>">›</a>
				</li>
				<li<?php if($LastPage==0) echo " class='page-disabled'" ?>>
					<a href="<?= url_category_page($product['categoria'], $LastPage) ?>">»</a>
				</li>
			</ul>
		</div>
  </div>
</div>
<?php rb_footer(['footer-allpages.php'], false) ?>
