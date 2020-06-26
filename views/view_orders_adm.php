<h1>Управление состоянием заказов</h1>
<div class="order">
    <form action="/order/update" method="post" class="form">
        <?php foreach ($orders as $item): ?>
            <input type="checkbox" name="order_item[]" value="<?= $item->id ?>" id="<?= $item->id ?>">
            <label for="<?= $item->id ?>" class="form_text">
                Покупатель ID:<?= $item->user_id ?>;
                ЗАКАЗ: <?= $item->id ?>
                от <?= $item->date ?>;
                Кол-во: <?= $item->product_quantity ?>
                (копий: <?= $item->copies ?> экз.);
                Сумма: $<?= $item->summa ?>;
                <?= $item->status ?>
            </label>
            <br>
        <?php endforeach; ?>
        <div class="btn_block">
            <input class="btn-cart_invert" type=submit name="close" value="Закрыть">
            <input class="btn-cart_invert" type=submit name="delivery" value="Доставлен">
            <input class="btn-cart_invert" type=submit name="cancel" value="Отменить">
        </div>
    </form>
</div>

