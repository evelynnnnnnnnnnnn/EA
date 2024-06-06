<?php
$trace = Bitrix\Main\Diag\Helper::getBackTrace();

Diag\Debug::dump($trace, "");
?>