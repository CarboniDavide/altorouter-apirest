<div class="container">
    
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <h1>Products</h1>
        <a href="/"><button class="btn btn-primary">back</button></a>
    </div>

    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Created</th>
                <th scope="col">Modified</th>
                <th scope="col">Category</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product) { ?>
                <tr>
                    <td><?= htmlspecialchars(strip_tags($product['id'])) ?></td>
                    <td><?= htmlspecialchars(strip_tags($product['name'])) ?></td>
                    <td><?= htmlspecialchars(strip_tags($product['description'])) ?></td>
                    <td><?= htmlspecialchars(strip_tags($product['price'])) ?></td>
                    <td><?= htmlspecialchars(strip_tags($product['created'])) ?></td>
                    <td><?= htmlspecialchars(strip_tags($product['modified'])) ?></td>
                    <td><?= htmlspecialchars(strip_tags($product['category_id'])) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
