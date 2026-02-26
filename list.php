<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 bg-light min-vh-100 p-3 border-end">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="index.php?action=/" class="nav-link active mb-2">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?action=list-category" class="nav-link link-dark">Danh mục</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10 p-4">
            <h2 class="mb-4">Danh sach san pham</h2>
            <a href="index.php?action=add-product" class="btn btn-primary mb-3">Thêm san pham</a>
            <form action="index.php" method="GET" class="d-flex w-50">
                <input type="hidden" name="action" value="/"> <input type="text" name="keyword" class="form-control me-2" placeholder="Tìm tên sản phẩm..." value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                <button type="submit" class="btn btn-outline-primary">Tìm</button>
            </form><br>
                <table class="table table-hover border">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list as $key => $value) { ?>
                            <tr>
                                <td><?php echo $value['id'] ?></td>
                                <td><?php echo $value['name'] ?></td>
                                <td><?php echo $value['price'] ?></td>
                                <td><?php echo $value['category_name'] ?></td>
                                <td>
                                    <img src="uploads/<?php echo $value['image']; ?>" width="80px" class="img-thumbnail" alt="">
                                </td>
                                <td class="text-center">
                                    <a href="index.php?action=edit-product&id=<?php echo $value['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                                    <a href="index.php?action=delete-product&id=<?php echo $value['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa khôm')">Xóa</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>