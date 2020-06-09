<?php


namespace interfaces;


use models\ProductQnt;

interface OrderInterface
{
    const ORDER_PRODUCT = "order_product";
    public function getProductsInOrder(): array;
    public function addProductInOrder(ProductQnt $productQnt);
    public function removeProductInOrder(ProductQnt $productQnt);

}