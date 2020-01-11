<div class="content">
    <h2>Products</h2>
    <table class="dudeTable">
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Created</th>
            <th>Modified</th>
            <th>Category</th>
        </tr>
        <?php foreach ($products as $product) { ?>
        <tr>
            <td><?= $product['id'] ?></td>
            <td><?= $product['name'] ?></td>
            <td><?= $product['description'] ?></td>
            <td><?= $product['price'] ?></td>
            <td><?= $product['created'] ?></td>
            <td><?= $product['modified'] ?></td>
            <td><?= $product['category_id'] ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
