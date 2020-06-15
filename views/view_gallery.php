<h1>Галерея репродукций</h1>
<div class="gallery">
    <?php foreach ($modelCollection as $model): ?>
        <div class="gallery_block">
            <p class="gallery_txt"><?= $model->name ?></p>
            <?php
            echo '<a href="?c=product&a=card&id=' . $model->id . '" target="_blank">
      <img width=300 src="data:' . $model->imageType . ';base64,' . base64_encode($model->imageData) . '"/></a>';
            ?>
            <p class="gallery_txt"><?= "viewers: " . $model->viewers ?> </p>
        </div>
    <?php endforeach; ?>
</div>
