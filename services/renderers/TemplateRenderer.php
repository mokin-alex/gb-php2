<?php

namespace app\services\renderers;

use app\interfaces\IRender;

class TemplateRenderer implements IRender
{
    public function getContent(string $template, array $params =[])
    {
         return $this->renderTemplate($template, $params);
    }

    private function renderTemplate($template, $params = [])
    {
        ob_start();
        $templatePath = VIEWS_DIR . $template . ".php";
        extract($params);
        include $templatePath;
        return ob_get_clean();
    }
}