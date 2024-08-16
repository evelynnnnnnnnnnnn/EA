<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
/** @global $APPLICATION */
$APPLICATION->SetTitle('Шоколад');
$APPLICATION->SetAdditionalCSS('/chocolate/style.css');
use Bitrix\Main\Type;
use Models\ChocolateTable as Chocolate;
use \Models\Lists\CountryTable as Country;
use \Models\Lists\FactoryTable as Factory;
\Bitrix\Main\Loader::includeModule('iblock');

$chocolate = Chocolate::query()
    ->setSelect(['*'])
    ->fetchAll();
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
$collection = \Bitrix\Iblock\Elements\ElementFactoryTable::getList([
    'select' => [
        'id',
        'name'
        ],
])->fetchCollection();
    foreach ($collection as $key => $factory) {
        pr('название '.$factory->getName());
    }
//?>