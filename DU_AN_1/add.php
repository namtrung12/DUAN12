<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <a href="index.php?action=/" class="btn btn-warning">Quay lai</a>
    <form action="index.php?action=add-product" method="POST" enctype="multipart/form-data">
        <label for="">Ten</label>
        <input type="text" class="form-control mb3" name="name" id="" required>
        <label for="">Price</label>
        <input type="number" class="form-control mb3" name="price" id="" required>
        <label for="">Category</label>
        <select name="category_id" class="form-control mb-3" required>
            <option value="">Chon danh muc</option>
            <?php foreach($category as $key => $value) { ?>
                <option value="<?php echo $value['id']; ?>">
                    <?php echo $value['name']; ?>
                </option>
            <?php } ?>
        </select>
        <label for="">Image</label>
        <input type="file" class="form-control mb3" name="image" id="" required>
        <button type="submit" name="btn-add" class="btn btn-success">Them</button>
    </form>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</html>