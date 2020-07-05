<?php
include "../vendor/autoload.php";
$fileName = "d:/openserver/userdata/php_upload/pricelist.csv";
$updatePrice = new \app\services\UpdatePrice($fileName);
$result = $updatePrice->loadFileToTmpTable();
if ($result) {
    $updatePrice->updatePrice();
}
$updatePrice->clearTmpTable();