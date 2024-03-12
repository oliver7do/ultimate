<div class="row">
    <?php foreach ($products as $product) : ?>
    <div class="col-4 mt-3">
        <div class="card  position-relative pb-3">
            <div>
                <img src="<?= UPLOAD_PRODUCTS_IMG . $product->getPhoto(); ?>" class="card-img-top"
                    alt="<?= substr($product->getTitle(), 0, 10); ?>" style=" box-shadow: 0 0 10px 5px rgba(255,
                    255, 255, 0.04), 0 0 10px 5px rgba(255, 255, 255, 0.04); text-align: center;" />
            </div>

            <div class="card-body">
                <h6 class="card-title"><?= substr($product->getTitle(), 0, 50) . " ..."; ?></h6>
                <p class="card-text"><?= $product->getPrice(); ?></p>

            </div>
            <div class="">
                <a href="<?= addLink('product', 'show', $product->getId()); ?>" class="btn btn-secondary">En savoir
                    plus
                </a>
                <div id="<?= $product->getId(); ?>" class="add_cart btn btn-primary">Ajouter
                    au
                    Panier</div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>


<script>
$(document).ready(function() {

    addToCartAjax();
});
</script>