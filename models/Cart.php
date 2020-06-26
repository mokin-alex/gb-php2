<?php


namespace app\models;


use app\services\Session;

class Cart
{
    protected $cartContent;
    protected $session;

    public function __construct()
    {
        $this->session= new Session();
        if (!$this->session->isSet('cart')) $this->session->set('cart', []);
        $this->cartContent = $this->session->get('cart');
    }
    public function add(array $productQnt)
    {
        $this->cartContent[] = $productQnt;
        $this->session->set('cart', $this->cartContent);
    }

    public function remove(array $productQnt)
    {
        foreach ($productQnt as $product_line) {
            unset($this->cartContent[$product_line]);
        }
        $this->session->set('cart', $this->cartContent);
    }

    public function clear()
    {
        $this->cartContent = [];
        $this->session->set('cart', $this->cartContent);
    }

    /**
     * @return mixed
     */
    public function getCartContent()
    {
        return $this->cartContent;
    }
}