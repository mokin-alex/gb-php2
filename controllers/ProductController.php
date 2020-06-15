<?php


namespace app\controllers;


use app\models\Product;
use app\models\RenderToLayout;
use app\traits\TController;

class ProductController
{
    use TController;

    public function actionIndex()
    {
        $modelCollection = (new Product())->getALl();
        $justRendered = new RenderToLayout('view_gallery', ['modelCollection' => $modelCollection]);
        echo $justRendered->getContent();
    }

    public function actionCard()
    {
        $id = $_GET['id'];
        $model = (new Product())->getById($id);
        $justRendered = new RenderToLayout('view_product', ['model' => $model]);
        echo $justRendered->getContent();
    }
}