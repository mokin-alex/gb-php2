<!----><h1><?= $orders_msg ?></h1>
<h1>Ваши заказы</h1>
<div class="order">
    <form action="/order/update" method="post" class="form">
        <?php foreach ($orders as $item): ?>
            <input type="checkbox" name="order_item[]" value="<?= $item->id ?>" id="<?= $item->id ?>">
            <label for="<?= $item->id ?>">ЗАКАЗ: <?= $item->id ?>
                от <?= $item->date ?>;
                Кол-во: <?= $item->product_quantity ?>
                (копий: <?= $item->copies ?> экз.);
                Сумма: $<?= $item->summa ?>;
                 <?= $item->status ?>
            </label>
            <br>
        <?php endforeach; ?>
        <div class="btn_block">
            <input class="btn-cart_invert" type=submit name="pay" value="Оплатить">
            <input class="btn-cart_invert" type=submit name="view" value="Просмотреть">
            <input class="btn-cart_invert" type=submit name="cancel" value="Отменить">
        </div>
    </form>
</div>

