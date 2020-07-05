<?php


namespace app\controllers;

use app\models\Cart;
use app\models\Comment;
use app\models\Product;
use app\models\repositories\CommentRepository;
use app\models\repositories\ProductRepository;
use app\services\LoadImageFile;

class ProductController extends Controller
{

    public function actionIndex()
    {
        $modelCollection = (new ProductRepository())->getAll();
        echo $this->render('view_gallery', ['modelCollection' => $modelCollection]);
    }

    public function actionCard()
    {
        $id = (int)$this->request->cleanGet('id');
        $model = (new ProductRepository())->getById($id);
        $listComments = (new CommentRepository())->getCommentsByProductId($model->getId());
        if ($this->currentUser && $this->currentUser->getIsAdm()) {
            echo $this->render('view_upd_product', ['model' => $model, 'listComments' => $listComments]);
        } else {
            echo $this->render('view_product', ['model' => $model, 'listComments' => $listComments]);
        }
    }

    public function actionBuy()
    {
        $id = (int)$this->request->cleanGet('id');
        if ($this->request->isPost()) {
            $quantity = $this->request->cleanPost('quantity');
            if ($quantity > 0) {
                $cart = new Cart();
                $cart->add(['id' => $id, 'quantity' => $quantity]);
            } else {
                $this->redirect("/product/card?id=$id");
            }
        }
        $this->redirect("/product");
    }

    public function actionComment()
    {
        $minCommentLength = 3;
        $id = (int)$this->request->cleanGet('id');
        if ($this->request->isPost()) {
            $comment = $this->request->cleanPost('comment');
            if (strlen($comment) > $minCommentLength) {
                $model = new Comment($id, $comment);
                (new CommentRepository())->save($model);
            }
        }
        $this->redirect("/product/card?id=$id");
    }

    public function actionAdd()
    {
        //добавление нового товара
        if ($this->request->isPost()) {
            $file = new LoadImageFile('my_file');
            if ($file->isReady) {
                $product = new Product();
                $product->setName($this->request->cleanPost('name'));
                $product->setDescription($this->request->cleanPost('description'));
                $product->setPrice($this->request->dirtyPost('price'));
                $product->setImageData($file->getImageData());
                $product->setImageType($file->getImageType());
                (new ProductRepository())->save($product);
            }
            $this->redirect('/product/add');
        }

        if ($this->currentUser && $this->currentUser->getIsAdm()) {
            echo $this->render('view_add_product');
        } else {
            $this->redirect('/auth/login');
        }
    }

    public function actionUpdate()
    {
        $id = (int)$this->request->cleanGet('id');
        $product = (new ProductRepository())->getById($id);
        if ($this->request->isPost()) {
            $product->setName($this->request->cleanPost('name'));
            $product->setDescription($this->request->cleanPost('description'));
            $product->setPrice($this->request->dirtyPost('price'));
            $file = new LoadImageFile('my_file');
            if ($file->isReady) {
                $product->setImageData($file->getImageData());
                $product->setImageType($file->getImageType());
            }
            (new ProductRepository())->save($product);
        }
        $this->redirect("/product/card?id=$id");
    }
}