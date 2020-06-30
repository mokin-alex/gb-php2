<?php
include "../vendor/autoload.php";
$config =  include  "../config/main.php";

\app\base\App::getInstance()->run($config);


