<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?php
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Loader;
use Bitrix\Main\Entity\Query;
Loader::includeModule('highloadblock');
//get hl id
$arHl = [];
$dbHL = HL\HighloadBlockTable::getList(['filter' => ['NAME' => 'MusicAlbums']]);
if ($arItem = $dbHL->Fetch()) {
    $hlBlockId = $arItem['ID'];
}

echo '<pre>HL_ID: ';
print_r($hlBlockId);
echo '</pre>';


//initialize
//$hlBlockId = 2;
$objHlblock =HL\HighloadBlockTable::getById($hlBlockId)->fetch(); //определяем объект hl-блока
$entity = HL\HighloadBlockTable::compileEntity($objHlblock); //генерация класса
$strEntityDataClass = $entity->getDataClass();
$entityTabName = $strEntityDataClass::getTableName();
echo '<pre>CHAME: ';
print_r($strEntityDataClass);
echo '</pre>';
$entityName = $entity->getName();
echo '<pre>ENTITY_NAME: ';
print_r($entityName);
echo '</pre>';

//add
//$arElementFields = [
//    'UF_AUTHOR' => [],
//    'UF_TITLE' => 'Created from code',
//    'UF_YEAR' => '1992'
//];
//$obResult = $strEntityDataClass::add($arElementFields);
//$ID = $obResult->getID();
//$obResult = [];
//$bSuccess = $obResult->isSuccess();
//if ($bSuccess)
//    echo "HL element {$ID} was added!";
//else {
//    $arErrors = $obResult->getErrorMessages();
//    foreach ($arErrors as $error) {
//        echo "ERROR: " . $error . "<br>";
//    }
//}
//обновление элемента
//$obResult = $strEntityDataClass::update(4, ['UF_YEAR' => 1921]);
//удаление элемента
$obResult = $strEntityDataClass::delete(4);
//getList
//$arItems =[];
//$rsData = $strEntityDataClass::getList(array(
//    'filter' => ['ID' => [4,1]],
//    'select' => array('ID','UF_AUTHOR','UF_TITLE','UF_YEAR'),
////    'order' => array('ID' => 'ASC'),
////    'limit' => '50',
//));
//while ($arItem = $rsData->Fetch()) {
//    $arItems[] = $arItem;
//}
//echo '<pre>ENTITY_NAME: ';
//print_r($arItems);
//echo '</pre>';

//Query
$arRandItems = [];
$arFilter = ['ID'=> 2];

$q = new Query($entity);
$q->setSelect(array('*'));
$q->setFilter($arFilter);
$q->setLimit(1);
$q->registerRuntimeField(
    'RAND', array('data_type' => 'float', 'expression' => array('RAND()'))
);
$q->addOrder("RAND", "ASC");
$result = $q->exec();
while ($arItem = $result->Fetch()) {
    $arRandItems[] = $arItem;
}

echo '<pre>RAND_ITEMS: ';
print_r($arRandItems);
echo '</pre>';

?>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
