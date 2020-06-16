<?php


namespace app\models;


class RenderToLayout extends Render
{
    protected $layout = 'main';
    public function __construct(string $template, array $params = [])
    {
        parent::__construct($template, $params);
        $this->content = $this->renderTemplate("layouts/{$this->layout}", ['content'=>$this->content]);
    }
}