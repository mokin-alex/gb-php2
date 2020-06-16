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
        $modelCollection = (new Product())->getAll();
        $justRendered = new RenderToLayout('view_gallery', ['modelCollection' => $modelCollection]);
        echo $justRendered->getContent();
    }

    public function actionCard()
    {
        $id =(int) $_GET['id'];
        $model = (new Product())->getById($id);
        //var_dump($model);
        $listComments= []; //TODO: $model->getComments();
        $justRendered = new RenderToLayout('view_product', ['model' => $model, 'listComments' => $listComments]);
        echo $justRendered->getContent();
    }

    public function actionBuy()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_GET['id'];
            if ((strlen($this->post('buy')) >0) && $this->post('quantity')>0) {
                $this->addToCart(['id' =>$id, 'quantity' =>$this->post('quantity')]);
            }
        }
        $this->redirect("/?c=product");
    }

    public function actionComment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_GET['id'];

            if ((strlen($this->post('addComment')) > 0) && strlen($this->post('comment')) > 3) {
                //TODO: addComment($id, post('comment'));
            }
        }
        $this->redirect("/?c=product&a=card&id=$id");
    }

    public function actionAdd()
    {
        //TODO: добавление нового товара
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (isset($_FILES['my_file'])) {

                $pos = strpos($_FILES['my_file']['type'], 'image');
                if ($pos !== 0) {
                    $this->resultMsg = "Ошибка. Загружать можно только изображения";
                } elseif ($_FILES['my_file']['size'] > MAX_IMAGE_SIZE) {
                    $this->resultMsg = "Ошибка. Слишком большой файл для загрузки";
                } else {

                    $product = new Product();
                    $product->setName(post('name'));
                    $product->setDescription(post('description'));
                    $product->setPrice(post('price'));
                    //получаем данные файла для записи его в БД:
                    $product->setImageData(addslashes(file_get_contents($_FILES['my_file']['tmp_name'])));
                    $product->setImageType($_FILES['my_file']['type']);
                    $product->save();
                    $this->resultMsg = "Успешно загружено!";
                }
            }
            redirect('/?c=product&a=add');
        }
        $justRendered = new RenderToLayout('view_add_product', ['resultMsg' =>$this->resultMsg]);
        echo $justRendered->getContent();
    }

    private function addToCart (array $product)
    {
        session_start();
        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][] = $product;
    }
}