<?php


namespace app\services;


class Request
{

    protected $requestString;
    protected $controllerName;
    protected $actionName;

    protected $pattern = "#(?P<controller>\w+)[/]?(?P<action>\w+)?[/]?[?]?(?P<params>.*)#ui";

    //controller/action?id = .........

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->requestString = $_SERVER['REQUEST_URI'];
        $this->parseRequest();
    }

    protected function parseRequest()
    {
        if (preg_match_all($this->pattern, $this->requestString, $matches)) {
            $this->controllerName = $matches['controller'][0];
            $this->actionName = $matches['action'][0];
        }
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }

    public function getActionName()
    {
        return $this->actionName;
    }

    public  function cleanGet($name):string
    {
        return htmlspecialchars(strip_tags($_GET[$name]));
    }

    public  function dirtyPost($name)
    {
        return $_POST[$name];
    }

    public  function cleanPost($name):string
    {
        return htmlspecialchars(strip_tags($_POST[$name]));
    }

    public  function isPost():bool
    {
       return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public  function isSet($name):bool
    {
        return isset($_POST[$name]);
    }

    public function isAjax(): bool
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            return true;
        } else {
            return false;
        }
    }
}