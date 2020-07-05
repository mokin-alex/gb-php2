<?php
include_once "..\public\index.php";

class ProductRepositoryTest extends \PHPUnit\Framework\TestCase
{
    public function testGetAll()
    {
        $rep = new \app\models\repositories\ProductRepository();
        $products = $rep->getAll();
        $this->assertIsArray($products);
        $this->assertTrue(count($products)>0);
        foreach ($products as $product){
            $this->assertTrue(
                is_a($product, \app\models\Product::class)
            );
        }
    }

    public function testGetById()
    {
        $rep = new \app\models\repositories\ProductRepository();
        $product = $rep->getById(8);
        $this->assertTrue(is_a($product, \app\models\Product::class));
    }
}