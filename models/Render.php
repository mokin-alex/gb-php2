<?php

namespace app\models;

use app\interfaces\RenderInterface;

abstract class Render implements RenderInterface
{
    protected $content;
    public function __construct(string $template, array $params =[])
    {
        $this->content = $this->renderTemplate($template, $params);
    }
    public function getContent()
    {
        return $this->content;
    }

    protected function renderTemplate($template, $params = []) {
        ob_start();
        $templatePath = VIEWS_DIR . $template . ".php";
        extract($params);
        include $templatePath;
        return ob_get_clean();
    }
}