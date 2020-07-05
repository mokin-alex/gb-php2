<?php
include_once "..\public\index.php";

class CartTest extends \PHPUnit\Framework\TestCase
{
    public function testAdd()
    {
        $productQnt = ['id' => 333, 'quantity' =>3];
        $cart = new \app\models\Cart();
        $cart->add($productQnt);
        $productsFromCart = $cart->getCartContent();
        foreach ($productsFromCart as $productFromCart){
        $this->assertIsArray($productFromCart);
        $this->assertArrayHasKey('id', $productFromCart);
        $this->assertArrayHasKey('quantity', $productFromCart);
        $this->assertEquals(333, $productFromCart['id']);
        $this->assertEquals(3, $productFromCart['quantity']);
        }
    }

    public function testClear()
    {
        $cart = new \app\models\Cart();
        $cart->clear();
        $this->assertEmpty($cart->getCartContent());
    }

}