<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @global $APPLICATION */
$APPLICATION->SetTitle('Врачи');
$APPLICATION->SetAdditionalCSS('/doctors/style.css');

// модели работающие с инфоблоками
use Models\Lists\DoctorsPropertyValuesTable as DoctorsTable;
use Models\Lists\ProcsPropertyValuesTable as ProcsTable;
use Models\Lists\SpecsPropertyValuesTable as SpecsTable;


// у элемента инфоблока Доктора с $docId мы получаем связанные с ним процедуры
$docId = 251; // идентификатор доктора из инфоблока Доктора
$doctors = \Bitrix\Iblock\Elements\ElementDoctorsTable::getList([
    'select' => ['ID', 'NAME', 'PROC_IDS_MULTI.ELEMENT'], // PROC_IDS_MULTI - множественное поле инфоблока Доктора
    'filter' => [
        'ID' => $docId,
        'ACTIVE' => 'Y'
    ],
])->fetchCollection();



// затем обходим коллекцию и получаем процедуры
$procedures = [];
foreach ($doctors as $doctor) {
    foreach($doctor->getProcIdsMulti()->getAll() as $prItem) {

        $procedure = \Bitrix\Iblock\Elements\ElementProceduresTable::getList([
            'select' => ['NAME'],
            'filter' => [
                'ID' => $prItem->getElement()->getId(),
                'ACTIVE' => 'Y'
            ],
        ])->fetchObject();

        $procedures[] = [
            'name'=> $procedure->getName(),
            'id' => $prItem->getElement()->getId()
        ];
    }
}
pr($procedures);
//вывод данных по списку записей из инфоблока Врачи

//echo '<div class="container">
//        <h2>Список врачей и процедур</h2> <!-- игровой отсыл -->
//      </div>';
//
//$doctors = DoctorsTable::getList([
//     'select'=>[
//         'LAST_NAME' =>'LAST_NAME',
//         'FIRST_NAME'=>'FIRST_NAME',
//         'MIDDLE_NAME'=>'MIDDLE_NAME',
//         'SPEC_IDS'=>'SPEC_IDS',
//		 'PROC_IDS_MULTI'=>'PROC_IDS_MULTI'
//     ]
// ])->fetchAll();
//pr($doctors);
//?>

<?php
////функция вывода процедур у доктора
//function procedures()
//{
//    $doctors = \Bitrix\Iblock\Elements\ElementDoctorsTable::getList([
//        'select' => [
//            'ID',
//            'NAME',
//            'PROC_IDS_MULTI.ELEMENT'
//        ],
//        'filter' => [
//            'ID' => '253'
//        ]
//    ])->fetchCollection();
//    foreach ($doctors as $doctor) {
//// получаем процедуры доктора
//        foreach ($doctor->getProcIdsMulti()->getAll() as $prItem) {
//            echo $prItem->getElement()->getName();// название процедуры
//        }
//    }
//
//    if (isset($_POST['procedures'])) {
//        procedures();
//    }
//}
//?>
    <!--<div class="city_list">-->
    <!--	--><?php //foreach($doctors as $n =>$row): ?>
    <!---->
    <!--	<div class="city_list-row"> --><?php // echo ($n + 1) . ' ' .$row['LAST_NAME'] . ' ' .$row['FIRST_NAME']. ' ' .$row['MIDDLE_NAME']; ?><!-- <form method="post"><input type="submit" name="procedures" id="procedures" value="Процедуры" /></form></div>-->
    <!---->
    <!--    --><?php //endforeach; ?>
    <!--</div>-->
    <!---->
    <!--<style>-->
    <!--.city_list {-->
    <!--	overflow: hidden;-->
    <!--}-->
    <!--.city_list-row {-->
    <!--	float: left;-->
    <!--	box-sizing: border-box;-->
    <!--	width: calc(25% - 2px);-->
    <!--	padding: 7px 10px;-->
    <!--	background: #a99f9f;-->
    <!--	margin: 1px;-->
    <!--}-->
    <!--</style>-->
<?php
//foreach($doctors as $doc) var_dump( $doc['LAST_NAME'] . ' ' . $doc['FIRST_NAME'] . ' ' . $doc['MIDDLE_NAME'] . "<br>\r\n" );
//foreach ($doctors as $n =>$row){
//    echo ($n + 1) . ' ' .$row['LAST_NAME'] . ' ' .$row['FIRST_NAME']. ' ' .$row['MIDDLE_NAME'];
//    if ($n < count($doctors) - 1) {
//        echo "<br>\r\n";
//    }
//}
//$doctors = \Bitrix\Iblock\Elements\ElementDoctorsTable::getList([
//    'select' => [
//        'ID',
//        'NAME',
//        'PROC_IDS_MULTI.ELEMENT'
//    ],
//    'filter' => [
//        'ID' => '252',
//    ],
//])->fetchCollection();
//
//foreach ($doctors as $doctor) {
//// получаем процедуры доктора
//    foreach($doctor->getProcIdsMulti()->getAll() as $prItem) {
//        echo $prItem->getElement()->getName(); // название процедуры
//    }
//}

?>