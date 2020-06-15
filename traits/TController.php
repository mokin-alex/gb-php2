<?php


namespace app\traits;


use app\models\RenderToLayout;

trait TController
{
    protected $defaultAction = 'index';
    protected $action;

    public function runAction($action = null)
    {
        $this->action = (empty($action)) ? $this->defaultAction : $action;
        $method = "action" . ucfirst($this->action);
        if(method_exists($this, $method)) {
            $this->$method();
        } else {
            $justRendered = new RenderToLayout('view_404');
            echo $justRendered->getContent();
        }
    }

}