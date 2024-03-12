<div class="row row-cols row-cols-md-5 mt-3">
    <div class="col-4 my-2">
        <div class="card">
            <div>
                <img src="<?= UPLOAD_PRODUCTS_IMG . $product->getPhoto() ?>" class="card-img-top"
                    alt="<?= $product->getTitle() ?>" style=" box-shadow: 0 0 10px 5px rgba(255,
                    255, 255, 0.04), 0 0 10px 5px rgba(255, 255, 255, 0.04); text-align: center;" />
            </div>
            <div class="card-body">
                <h6 class="card-title"><?= $product->getTitle() ?></h6>
                <p class="card-text"><?= $product->getPrice() ?></p>
            </div>
        </div>
        <div>
            <input name="qte" type="number" value="1" id="field<?= $product->getId() ?>">
            <button class="btn btn-warning" id="form<?= $product->getId() ?>">
                <i class="fa fa-cart-arrow-down"></i>
            </button>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between mt-5">
    <a href="<?= ROOT ?>" class="btn btn-secondary">
        <i class="fa fa-home"></i> Retour à l'accueil
    </a>
    <a href="<?= addLink('cart','buy', $product->getId()); ?>" class="btn btn-primary">
        <i class="fa fa-shopping-cart"></i> Passer la commande
    </a>
</div>


<script>
window.addEventListener("load", () => {
    var idProduct = "<?= $product->getId() ?>";
    addProductToCartAjax(idProduct)
});
</script>