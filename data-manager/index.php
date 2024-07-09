<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle('Datamanager в Битрикс');

use Bitrix\Main\Type;

use Models\Lists\CarsPropertyValuesTable as CarsTable;
use Models\HospitalClientsTable as Clients;

use Models\BookTable as Books;
use Models\PublisherTable as Publishers;
use Models\AuthorTable as Authors;
use Models\WikiprofileTable as Wikiprofiles;



// кастомная таблица и стандартная сущность Битрикс
// получение данных из hospital_clients
// получаем контакты CRM привязанные к своей таблице
//$collection = Clients::getList([
//    'select' => [
//        'id',
//        'first_name',
//        'contact_id',
//        'CONTACT.*'
//    ],
//    'limit'=>3
//])->fetchCollection();
//
//foreach ($collection as $key => $record) {
//    pr($record->getId().' '.$record->getFirstName().' '.$record->getContactId());
//     pr($record->getContact()->getPost());
//     pr($record->getContact()->getCompanyId());
//}

// создание записи
/*$record = [
    'first_name'=>'123456',
    'last_name' =>'2323123',
    'age' =>2,
];
$res = Clients::add($record);

if(!$res->isSuccess()){
    var_dump($res->getErrorMessages());
}*/

//получем коллекцию книг
//$collection = Books::getList([
//    'select' => [
//        'id',
//        'name',
//        'publish_date'
//    ]
//])->fetchCollection();
//foreach ($collection as $key => $book) {
//    pr('название '.$book->getName(). ' дата выхода:' .$book->getPublishDate());
//}

// добавление записи в таблицу books
//$record = [
//    'name'=>'Зеленая миля',
//    'publish_date' => new Type\Date('1988-09-17', 'Y-m-d'),
//    'ISBN' =>'12345678901234'
//];
//$res = Books::add($record);
//if(!$res->isSuccess()){
//   var_dump($res->getErrorMessages());
//}


// отношение OneToOne
// выборка википрофиля со сороны книги
//$book = Books::getByPrimary(3, [
//    'select' => [
//        '*',
//        'WIKIPROFILE'
//    ]
//])
//->fetchObject();
//pr($book->getWikiprofile()->getWikiprofileRu());

//$wikiprofile = Wikiprofiles::getByPrimary(3, [
//    'select' => [
//        '*',
//        'BOOK'
//    ]
//])
//->fetchObject();
//pr($wikiprofile->getWikiprofileRu());
//pr($wikiprofile->getBook()->getName());
//pr($wikiprofile->getBook()->getPublishDate()->format("Y-m-d"));


// отношение OneToMany
// получем коллекцию книг
// выводим издателей
//$collection = Books::getList([
//    'select' => [
//        'id',
//        'name',
//        'publish_date',
//        'publisher_id',
//        'PUBLISHER'
//    ]
//])->fetchCollection();
//foreach ($collection as $key => $book) {
//    pr('название '.$book->getName(). ' дата выхода:' .$book->getPublishDate(). ' издатель:'.$book->getPublisher()->getName());
//}


// отношение ManyToMay
// выборка книг со стороны автора
//$author = Authors::getByPrimary(2, [
//    'select' => [
//        '*',
//        'BOOKS'
//    ]
//])->fetchObject();
//foreach ($author->getBooks() as $book){
//    echo $book->getName().'<br/>';
//}

// выборка авторов со сороны книги
//$book = Books::getByPrimary(2, [
//    'select' => [
//        '*',
//        'AUTHORS'
//    ]
//])
//->fetchObject();
//foreach ($book->getAuthors() as $author){
//    echo ' книга: '.$book->getName().' автор: '.$author->getName().'<br/>';
//}



