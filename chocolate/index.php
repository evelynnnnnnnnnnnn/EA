<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle('Datamanager в Битрикс');

use Bitrix\Main\Type;
use Models\ChocolateTable as Chocolate;

\Bitrix\Main\Loader::includeModule('iblock');
use \Models\Lists\FactoryTable as Factory;
// получем коллекцию шоколадок
$collection = Chocolate::getList([
    'select' => [
        'id',
        'name',
        'weight',
        'factory_id',
        'country_id',
        'FACTORY',
        'COUNTRY'
    ],
    'limit'=>2
])->fetchCollection();

foreach ($collection as $key => $chocolate) {
    pr('название '.$chocolate->getName(). ' вес:' .$chocolate->getWeight() .$chocolate->getFactory()->getName() );

};
//$collection = \Bitrix\Iblock\Elements\ElementFactoryTable::getList([
//    'select' => [
//        'id',
//        'name'
//        ],
//])->fetchCollection();
//    foreach ($collection as $key => $factory) {
//        pr('название '.$factory->getName());
//    }

