<?php


namespace app\interfaces;


use app\models\ProductQnt;

interface OrderInterface
{
    const TABLE_WITH_PRODUCTS_OF_ORDER = "order_products";
    public function getProductsInOrder(): array;
    public function addProductInOrder(ProductQnt $productQnt);
    public function removeProductInOrder(ProductQnt $productQnt);

}