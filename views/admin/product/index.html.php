<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <th>ID</th>
        <th>Titre</th>
        <th>Surname</th>
        <th>Prix</th>
        <th>Identité</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php foreach ($products as $product) : ?>
        <tr>
            <td>
                <?= $product->getId() ?>
            </td>
            <td>
                <?= $product->getTitle() ?>
            </td>
            <td>
                <?= $product->getPrice() ?>
            </td>
            <td>
                <?= $product->getCategory->get() ?>
            </td>


            <td>
                <a href="<?= addLink("product", "update", $product->getId()) ?>" class="btn btn-secondary">
                    <i class="fa fa-edit"></i>
                </a>
                <a href="<?= addLink("product", "delete", $product->getId()) ?>" class="btn btn-secondary">
                    <i class="fa fa-trash"></i>
                </a>
                <a href="<?= addLink("product", "show", $product->getId()) ?>" class="btn btn-secondary">
                    <i class="fa fa-eye"></i>
                </a>

            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>