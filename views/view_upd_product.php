<?php
?>
<h2>Обновление товара </h2>
<div class="product_block">
    <?php
    echo '<img width="400" src="data:' . $model->imageType . ';base64,' . base64_encode($model->imageData) . '"/>';
    ?>
</div>
<form action="/product/update?id=<?= $model->id ?>" enctype="multipart/form-data" method="post" class="form">
    <input type="file" name = 'my_file'>
    <p>Укажите автора</p>
    <input type="text" name = 'name' size="38" value="<?= $model->name ?>">
    <p>Описание</p>
    <p><textarea name="description" cols="40" rows="4"><?= $model->description ?></textarea></p>
    <p>Цена</p>
    <input type="number" name = 'price' size="38" step="0.01" value="<?= $model->price ?>"">
    <input type="submit">
</form>
