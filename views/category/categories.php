
<div class="container">
    
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <h1>Categories</h1>
        <a href="/"><button class="btn btn-primary">back</button></a>
    </div>
    
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Created</th>
                <th scope="col">Modified</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category) { ?>
                <tr>
                    <td><?= htmlspecialchars(strip_tags($category['id'])) ?></td>
                    <td><?= htmlspecialchars(strip_tags($category['name'])) ?></td>
                    <td><?= htmlspecialchars(strip_tags($category['description'])) ?></td>
                    <td><?= htmlspecialchars(strip_tags($category['created'])) ?></td>
                    <td><?= htmlspecialchars(strip_tags($category['modified'])) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>