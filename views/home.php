<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiny Room</title>
</head>

<body>
    <table border="1">
        <tr>
            <td>ID</td>
            <td>Tên</td>
            <td>Giá</td>
            <td>Ảnh</td>
            <td>Danh mục</td>
        </tr>

        <?php foreach ($listProducts as $product) {
        ?><tr>
                <td><?= $product["product_id"] ?></td>
                <td><?= $product["product_name"] ?></td>
                <td><?= $product["price"] ?></td>
                <td><?= $product["image"] ?></td>
                <td><?= $product["category_name"] ?></td>
            </tr>
        <?php  } ?>
    </table>
</body>

</html>