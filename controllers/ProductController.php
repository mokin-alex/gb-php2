<?php


namespace app\controllers;

use app\models\Cart;
use app\models\Comment;
use app\models\Product;
use app\services\LoadImageFile;
use app\services\Request;

class ProductController extends Controller
{

    public function actionIndex()
    {
        $modelCollection = Product::getAll();
        echo $this->render('view_gallery', ['modelCollection' => $modelCollection]);
    }

    public function actionCard()
    {
        $id =(int) Request::cleanGet('id');
        $model = Product::getById($id);
        $listComments= $model->getComments();
        echo $this->render('view_product', ['model' => $model, 'listComments' => $listComments]);
    }

    public function actionBuy()
    {
        $id =(int) Request::cleanGet('id');
        if (Request::isPost()) {
            $quantity = Request::cleanPost('quantity');
            if ($quantity>0) {
                $cart = new Cart();
                $cart->add(['id' =>$id, 'quantity' => $quantity]);
            } else {
                $this->redirect("/?c=product&a=card&id=$id");
            }
        }
        $this->redirect("/?c=product");
    }

    public function actionComment()
    {
        $minCommentLength = 3;

        $id =(int) Request::cleanGet('id');
        if (Request::isPost()) {
            $comment = Request::cleanPost('comment');
            if (strlen($comment) > $minCommentLength) {
                $model = new Comment($id, $comment);
                $model->save();
            }
        }
        $this->redirect("/?c=product&a=card&id=$id");
    }

    public function actionAdd()
    {
        //добавление нового товара
        if (Request::isPost()) {
            $file = new LoadImageFile('my_file');
            if ($file->isReady) {
                    $product = new Product();
                    $product->setName(Request::cleanPost('name'));
                    $product->setDescription(Request::cleanPost('description'));
                    $product->setPrice(Request::dirtyPost('price'));
                    $product->setImageData($file->getImageData());
                    $product->setImageType($file->getImageType());
                    $product->save();
                }
            $this->redirect('/?c=product&a=add');
        }

        if ($this->currentUser && $this->currentUser->getIsAdm()) {
            echo $this->render('view_add_product');
        } else {
            $this->redirect('/?c=auth&a=login');
        }

    }
}