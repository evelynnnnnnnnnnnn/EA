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

// массивы для сохранения полученных данных
$chocolate = [];
$country = [];
$factory= [];
$factory_name = '';
$country_name = '';
$chocolate_name = '';
$path = trim($_GET['path'],'/');
$choco = [];
if (!empty($path)) {
    $path_parts = explode('/',$path);
    if (sizeof($path_parts)<3) {
        if (sizeof($path_parts) == 2 && $path_parts[0] == 'edit') {
            $action = 'edit';
            $chocolate_name = $path_parts[1];
        } else if (sizeof($path_parts) == 1 && in_array($path_parts[0],['new','newproc'])) {
            $action = $path_parts[0];
        } else $chocolate_name = $path_parts[0];
    }
}

//if (empty($chocolate_name) && empty($action)) {
//    $chocolate = Chocolate::query()
//        ->setSelect(['*', "NAME", "ID"])
//        ->fetchCollection();
//}

////выводит одну шоколадку
if (!empty($chocolate_name)) {
    $collection = Chocolate::query()
        ->setSelect([
            '*',
            'id',
            'name',
            'weight',
            'factory_id',
            'country_id',
            'FACTORY',
            'COUNTRY'
        ])
        ->where("NAME", $chocolate_name)
        ->fetch();

    if (is_array($chocolate)) { //выводим одну шоколадку


        $factory = \Bitrix\Iblock\Elements\ElementFactoryTable::getList([
            'select' => [
                'id',
                'name'
            ],
        ])->fetchCollection();
        foreach ($factory as $key => $factory_name) {
           $factory_name->getName();
        }
        $country = \Bitrix\Iblock\Elements\ElementCountryTable::getList([
            'select' => [
                'id',
                'name'
            ],
        ])->fetchCollection();
        foreach ($country as $key => $country_name) {
            $country_name->getName();
        }
//
//        if($doctor['PROC_IDS_MULTI']){
//            $procs = ProcsTable::query()
//                ->setSelect(['NAME' => 'ELEMENT.NAME'])
//                ->where("ELEMENT.ID", "in", $doctor['PROC_IDS_MULTI'])
//                ->fetchAll();
//        }
    }
    else {
        header("Location: /chocolate");
        exit();
    }
}
// если не выбран доктор и его
// выводим всех докторов
if (empty($chocolate_name) && empty($action)) {
    $chocolate = Chocolate::query()
        ->setSelect(['*', "NAME", "ID"])
        ->fetchCollection();
}
?>
<section class="chocolate">
    <h1><a href="/chocolate">Шоколад</a></h1>


    <div class="cards-list">
        <?php foreach ($chocolate as $choc) { ?>
            <a class="card" href="/chocolate/<?=$choc["NAME"]?>">
                <div class="fio">
                    <?=$choc['name']?>
                </div>

            </a>
        <?php } ?>
    </div>

    <?php if (is_array($chocolate) && $action!='edit'):?>
        <div class="doctor-page">
            <h2><?=$chocolate_name?></h2>
            <h3>Страна: <?=$country_name->getName()?></h3>
            <h3>Завод: <?=$factory_name->getName()?></h3>

        </div>
    <?php endif; ?>
    <?php if (empty($action)):?>
        <div class="add-buttons">
            <?php if (!empty($chocolate_name)):?>
                <a href="/chocolate/index.php/<?=$chocolate_name?>"><button>Вернуться назад</button></a>
            <?php endif;?>
        </div>
    <?php endif;?>
</section>