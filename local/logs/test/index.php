 <?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
 ?>
 <h1>Otus.Логирование</h1>
<?php
define("LOG_FILENAME", $_SERVER['DOCUMENT_ROOT']. "/local/logs/test.log");
$var = [
        "qwer"=> "qwegwer"
];
$var_name = date('Y-m-d')." otus";
echo LOG_FILENAME;
Bitrix\Main\Diag\Debug::dump($var, $var_name);
AddMessage2Log($var, $var_name);

//$connection = Bitrix\Main\Application::getConnection();
//$tracker = $connection->startTracker();
//$query2 = Bitrix\Iblock\ElementTable::getList(array(
//    'select' => array('ID', 'Name'),
//    'filter' => array('IBLOCK_ID' => 2),
//));
//$query1 = Bitrix\Iblock\ElementTable::getList(array(
//    'select' => array('ID', 'Name'),
//    'filter' => array('IBLOCK_ID' => 3),
//));
//$query = Bitrix\Iblock\ElementTable::getList(array(
//        'select' => array('ID', 'Name'),
//        'filter' => array('IBLOCK_ID' => 4),
//));
//$connection->stopTracker();
////Bitrix\Main\Diag\Debug::dump($query->getTrackerQuery()->getSql(), "sql_dump");
//foreach ($tracker->getQueries() as $query){
//    Bitrix\Main\Diag\Debug::dump($query->getSql());
//    Bitrix\Main\Diag\Debug::dump($query->getTime());
//}
?>