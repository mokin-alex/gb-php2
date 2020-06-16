<?php


namespace app\traits;


use app\models\RenderToLayout;

trait TController
{
    protected $defaultAction = 'index';
    protected $action;
    protected $resultMsg = "";

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

    private function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    private function get($name)
    {
        return htmlspecialchars(strip_tags($_GET[$name]));
    }

    private function post($name)
    {
        return $_POST[$name];
        //return htmlspecialchars(strip_tags($_POST[$name]));
    }
}