<?php

namespace app\controllers;
use app\interfaces\IRender;
use app\services\Request;
use app\services\Session;

abstract class Controller
{
    protected $defaultAction = 'index';
    protected $action;
    protected $useLayout = true;
    protected $layout = 'layouts/main';
    /** @var IRender  */
    protected $renderer;
    protected $session;


    public function __construct(IRender $renderer)
    {
        $this->renderer = $renderer;
        $this->session = new Session();
    }

    public function runAction($action = null)
    {
        $this->action = (empty($action)) ? $this->defaultAction : $action;
        $method = "action" . ucfirst($this->action);
        if(method_exists($this, $method)) {
            $this->$method();
        } else {
            echo $this->render('view_404');
        }
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    protected function render(string $template, array $params = [])
    {
        $content = $this->renderer->getContent($template, $params);
        if($this->useLayout) {
            return $this->renderer->getContent( $this->layout, ['content' => $content]);
        }
        return $content;
    }
}