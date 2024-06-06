<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
?>
<h1>Otus.Логирование</h1>
<?php
define("LOG_FILENAME", $_SERVER['DOCUMENT_ROOT']. "/otus/hw2/test.log");
$var = [
        "qwer"=> "qwegwer"
];
$var_name = date('Y-m-d');
echo LOG_FILENAME;
Bitrix\Main\Diag\Debug::dump($var, $var_name);
AddMessage2Log($var_name);

